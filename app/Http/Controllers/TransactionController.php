<?php

namespace App\Http\Controllers;

use App\Mail\StatusUpdateMail;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      // Fetching parameters
      $draw = $request->input('draw');
      $start = $request->input('start');
      $length = $request->input('length');
      $searchValue = $request->input('search.value');
      $orderColumn = $request->input('order.0.column');
      $orderDir = $request->input('order.0.dir');
      // Get the column names for ordering
      $columns = ["code", "client_name", "unit_color", "plate_no", "balance", "amount", "date_in", "date_out", "status"];
      // Build the query and eager load user and mechanic
      $query = Transaction::with(['user', 'mechanic']);
      // Apply search filter if applicable
      if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
          $q->whereHas('user', function ($q) use ($searchValue) {
            $q->where('name', 'like', "%$searchValue%"); // Search by user name
          })->orWhereHas('mechanic', function ($q) use ($searchValue) {
            $q->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%$searchValue%"]); // Search by full name of mechanic
          })
            ->orWhere('client_name', 'like', "%$searchValue%")
            ->orWhere('unit', 'like', "%$searchValue%")
            ->orWhere('plate_no', 'like', "%$searchValue%")
            ->orWhereRaw("CONCAT(unit, ' - ', color) LIKE ?", ["%$searchValue%"]) // Search by unit_color (unit - color)
            ->orWhere('downpayment', 'like', "%$searchValue%")
            ->orWhere('amount', 'like', "%$searchValue%")
            ->orWhereRaw("(amount - downpayment) LIKE ?", ["%$searchValue%"]) // Search by calculated balance
            ->orWhere('status', 'like', "%$searchValue%");
        });
      }
      // Get total records after filtering
      $filteredCount = $query->count();
      // Apply sorting
      if (isset($columns[$orderColumn])) {
        $query->orderBy($columns[$orderColumn], $orderDir);
      }

      // Apply pagination
      $transaction = $query->skip($start)->take($length)
        // ->where('status', 'Pending')
        ->get();
      // Get total records before filtering
      $totalCount = Transaction::count();
      // Prepare the response in the format DataTables expects, with related data
      return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => intval($totalCount),
        'recordsFiltered' => intval($filteredCount),
        'data' => $transaction->map(function ($transaction) {
          // Concatenate mechanic's first, middle, and last name
          $mechanicFullName = $transaction->mechanic
            ? trim("{$transaction->mechanic->firstname} " . "{$transaction->mechanic->lastname}")
            : 'N/A';
          return [
            'id' => $transaction->id,
            'client_name' => $transaction->client_name,
            'unit' => $transaction->unit,
            'plate_no' => $transaction->plate_no,
            'color' => $transaction->color,
            'contact' => $transaction->contact,
            'email' => $transaction->email,
            'address' => $transaction->address,
            'unit_color' => "{$transaction->unit} - {$transaction->color}",
            'code' => $transaction->code,
            'processed_by' => $transaction->user->name ?? 'N/A',
            'mechanic' => $mechanicFullName,
            'mechanic_id' => $transaction->mechanic_id,
            'downpayment' => $transaction->downpayment,
            'balance' =>  $transaction->payment_status == 'Paid' ? 0 : $transaction->amount - $transaction->downpayment,
            'amount' => $transaction->amount,
            'date_in' => $transaction->date_in,
            'date_out' => $transaction->date_out ? $transaction->date_out : "--",
            'estimated_completion_date' => $transaction->estimated_completion_date,
            'status' => $transaction->status,
            'payment_status' => $transaction->payment_status,
            'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
          ];
        })
      ]);
    }
    return view('admin.transaction.transactions');
  }

  public function show(Request $request, $id)
  {
    $transaction = Transaction::with(['products', 'services'])->findOrFail($id);
    return view('admin.transaction.transaction-details', compact('transaction'));
  }

  public function store(Request $request)
  {
    $transactionCode = $this->generateTransactionCode();
    // Validate the request
    $validated = $request->validate([
      'client_name' => 'required|string',
      'unit' => 'required|string',
      'plate_no' => 'required|string',
      'color' => 'required|string',
      'contact' => 'required|string',
      'email' => 'required|email',
      'address' => 'required|string',
      'date_in' => 'date',
      // 'status' => 'required|string',
    ]);
    
    // Create the new Transaction
    $transaction = Transaction::create([
      'user_id' => Auth::user()->id,
      'client_name' => $validated['client_name'],
      'unit' => $validated['unit'],
      'plate_no' => $validated['plate_no'],
      'color' => $validated['color'],
      'contact' => $validated['contact'],
      'email' => $validated['email'],
      'address' => $validated['address'],
      'code' => $transactionCode,
      'downpayment' => 0,  // Save downpayment with correct format
      'date_in' => $validated['date_in'],
      'amount' => 0,                  // You can adjust this logic as needed
      // 'status' => $validated['status'],
    ]);
    return response()->json(['success' => true]);
  }

  public function update(Request $request, $id)
  {
    // Fetch the transaction to update
    $transaction = Transaction::findOrFail($id);
    $oldStatus = $transaction->status; // Store the old status

    // Define the minimum and maximum downpayment requirements
    $minDownpayment = $transaction->amount * 0.2; // Minimum downpayment is 20%
    $maxDownpayment = $transaction->amount; // Maximum downpayment is the total amount

    // Custom validation rule for mechanic status
    $mechanicStatusRule = function ($attribute, $value, $fail) {
      if ($value) {
        $mechanic = Mechanic::find($value);
        if ($mechanic && $mechanic->status === 1) {
          return $fail('The selected mechanic must be Available.');
        }
      }
    };

    // Check if the form is submitted to update the transaction
    if ($request['submittal'] == true) {
      // Validate the request for submitting the transaction
      $validatedData = $request->validate([
        'mechanic_id' => ['nullable', 'numeric', 'exists:mechanics,id', $mechanicStatusRule],
        'downpayment' => ['nullable', 'numeric', "min:$minDownpayment", "max:$maxDownpayment"], // Ensure downpayment is at least 20% and at most the total amount
        'date_out' => 'date|nullable',
        'estimated_completion_date' => 'date|required',
        'payment_status' => 'required|string',
        'status' => 'required|string',
        // Make all other fields optional for this request
      ]);

      // Fill only the fields that were validated
      $transaction->fill($validatedData);
    } else {
      // Validate the request for all required fields when not submitting
      $validatedData = $request->validate([
        'client_name' => 'required|string',
        'unit' => 'required|string',
        'plate_no' => 'required|string',
        'color' => 'required|string',
        'contact' => 'required|string',
        'email' => 'required|string',
        'address' => 'required|string',
        'date_in' => 'date|nullable',
      ]);

      // Fill the transaction with validated data
      $transaction->fill($validatedData);
    }

    // Save the changes to the transaction
    $transaction->save();

    // Check if the status has changed
    if ($oldStatus !== $transaction->status) {
      // Send email notification
      Mail::to($transaction->email)->send(new StatusUpdateMail($transaction));
    }

    // Return the response
    return response()->json([
      'transaction' => $transaction,
      'message' => $request['submittal'] == true ? 'Transaction submitted successfully.' : 'Transaction updated successfully.'
    ]);
  }


  public function destroy($id)
  {
    $transaction = Transaction::findOrFail($id);
    $transaction->delete();
    return response()->json(['success' => true]);
  }

  public function generateTransactionCode()
  {
    // Get current date in 'YYYYMMDD' format
    $datePrefix = Carbon::now()->format('Ymd');

    // Get the last transaction code for today, if it exists
    $lastTransaction = Transaction::where('code', 'like', $datePrefix . '%')
      ->orderBy('code', 'desc')
      ->first();

    // Determine the next sequence number
    if ($lastTransaction) {
      $lastSequence = (int)substr($lastTransaction->code, -3); // Get last 'xxx'
      $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeroes
    } else {
      $nextSequence = '001'; // Start with '001' if no transactions for today
    }

    // Combine the date prefix and sequence number
    return $datePrefix . $nextSequence;
  }
}
