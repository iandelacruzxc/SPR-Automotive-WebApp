<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionService;
use Illuminate\Http\Request;

class TransactionServiceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {}


  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate the request
    $validated = $request->validate([
      'price' => 'required|numeric|decimal:2', // Ensure price is required and valid
      'transaction_id' => 'required|exists:transactions,id', // Ensure transaction_id exists
      'service_id' => 'required|exists:services,id',         // Ensure service_id exists
    ]);

    // Create the new transaction service
    $transaction_service = TransactionService::create([
      'transaction_id' => $validated['transaction_id'],
      'service_id' => $validated['service_id'],
      'price' => round($validated['price'], 2), // Store price with two decimal places
    ]);

    // Retrieve the associated transaction
    $transaction = Transaction::find($validated['transaction_id']);

    // Increment the amount column with two decimal places
    $transaction->amount = round($transaction->amount + $transaction_service->price, 2);
    $transaction->downpayment = round($transaction->amount * 0.20, 2);

    // Save the updated transaction
    $transaction->save();

    return response()->json([
      'success' => true,
      'amount' => number_format($transaction->amount, 2, '.', ''),
      'downpayment' => number_format($transaction->downpayment, 2, '.', '')
    ]);
  }

  /**
   * Display the specified resource.
   */

  public function show(Request $request, $id)
  {
    if ($request->ajax()) {
      // Fetching parameters for DataTable
      $draw = $request->input('draw');
      $start = $request->input('start');
      $length = $request->input('length');
      $searchValue = $request->input('search.value');
      $orderColumn = $request->input('order.0.column');
      $orderDir = $request->input('order.0.dir');

      // Define the columns for ordering
      $columns = ['id', 'service.name', 'service.price']; // Adjust as necessary for inventory columns

      // Build the query for services related to the transaction
      $query = TransactionService::where('transaction_id', $id)->with('service');

      // Apply search filter if applicable
      if ($searchValue) {
        $query->whereHas('service', function ($q) use ($searchValue) {
          $q->where('name', 'like', "%$searchValue%")
            ->orWhere('price', 'like', "%$searchValue%");
        });
      }

      // Get total records after filtering
      $filteredCount = $query->count();

      // Apply sorting
      if (isset($columns[$orderColumn])) {
        if ($columns[$orderColumn] === 'service.name' || $columns[$orderColumn] === 'service.price') {
          $query->orderByService($columns[$orderColumn], $orderDir);  // Custom method for ordering by relation
        } else {
          $query->orderBy($columns[$orderColumn], $orderDir);
        }
      }

      // Apply pagination
      $services = $query->limit($length)->offset($start)->get();

      // Get total records before filtering
      $totalCount = TransactionService::where('transaction_id', $id)->count();

      // Prepare the response in the format DataTables expects
      return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => intval($totalCount),
        'recordsFiltered' => intval($filteredCount),
        'data' => $services->map(function ($item) {
          return [
            'id' => $item->id,
            'name' => $item->service->name,  // Corrected here
            'price' => $item->service->price, // Corrected here
          ];
        })
      ]);
    }

    // Fetch the transaction with associated products and services for display
    // $transaction = Transaction::with(['products', 'services'])->findOrFail($id);
    // return view('admin.transaction.transaction-details', compact('transaction'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // Find the transaction service or fail if not found
    $transaction_service = TransactionService::findOrFail($id);

    // Retrieve the associated transaction
    $transaction = Transaction::find($transaction_service->transaction_id);

    // Decrement the amount column with two decimal places
    $transaction->amount = round($transaction->amount - $transaction_service->price, 2);
    $transaction->downpayment = round($transaction->amount * 0.20, 2);

    // Save the updated transaction
    $transaction->save();

    // Delete the transaction service
    $transaction_service->delete();

    return response()->json([
      'success' => true,
      'amount' => number_format($transaction->amount, 2, '.', ''),
      'downpayment' => number_format($transaction->downpayment, 2, '.', ''),
    ]);
  }
}
