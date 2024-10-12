<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
      $columns = [
        'user_id',
        'mechanic_id',
        'code',
        'client_name',
        'unit',
        'plate_no',
        'color',
        'date_in',
        'date_out',
        'contact',
        'email',
        'address',
        'amount',
        'status'
      ];
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
      $transaction = $query->skip($start)->take($length)->get();
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
            'balance' =>  $transaction->amount - $transaction->downpayment,
            'amount' => $transaction->amount,
            'date_in' => $transaction->date_in,
            'date_out' => $transaction->date_out ? $transaction->date_out : "--",
            'status' => $transaction->status,
            'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
          ];
        })
      ]);
    }
    return view('admin.transaction.transactions');
  }
  public function store(Request $request)
  {
    // Validate the request
    $validated = $request->validate([
      'client_name' => 'required|string',
      'unit' => 'required|string',
      'plate_no' => 'required|string',
      'color' => 'required|string',
      'contact' => 'required|string',
      'email' => 'required|email',
      'address' => 'required|string',
      'mechanic_id' => 'required|numeric',
      'downpayment' => 'nullable|numeric',  // Validate downpayment as numeric
      'date_in' => 'date',
      'date_out' => 'date',
      'code' => 'required|string',
      'status' => 'required|string',
    ]);

    // Format the downpayment to two decimal places (if it's provided)
    $downpayment = $validated['downpayment'] !== null
      ? number_format($validated['downpayment'], 2, '.', '')
      : null;
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
      'code' => $validated['code'],
      'mechanic_id' => $validated['mechanic_id'],
      'downpayment' => $downpayment,  // Save downpayment with correct format
      'date_in' => $validated['date_in'],
      'date_out' => $validated['date_out'],
      'amount' => 0,                  // You can adjust this logic as needed
      'status' => $validated['status'],
    ]);
    return response()->json(['success' => true]);
  }
  public function update(Request $request, $id)
  {
    // Validate and update existing Transaction
    $validatedData = $request->validate([
      // 'user_id' => 'required|numeric',
      'client_name' => 'required|string',
      'unit' => 'required|string',
      'plate_no' => 'required|string',
      'color' => 'required|string',
      'contact' => 'required|string',
      'email' => 'required|string',
      'address' => 'required|string',

      'code' => 'required|string',
      'mechanic_id' => 'required|numeric',
      'downpayment' => 'decimal:2|nullable',
      'date_in' => 'date|nullable',
      'date_out' => 'date|nullable',
      // 'amount' => 'required',
      'status' => 'required',
    ]);
    $transaction = Transaction::findOrFail($id);
    $transaction->update($validatedData);
    return response()->json(['message' => 'Transaction updated successfully.']);
  }
  // app/Http/Controllers/TransactionController.php
  public function destroy($id)
  {
    $transaction = Transaction::findOrFail($id);
    $transaction->delete();
    return response()->json(['success' => true]);
  }
}
