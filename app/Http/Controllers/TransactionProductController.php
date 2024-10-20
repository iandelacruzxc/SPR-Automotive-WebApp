<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;

class TransactionProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */

  public function index(Request $request)
  {
    //
  }

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
      'p_price' => 'required|decimal:2', // Ensure p_price is required and valid
      'quantity' => 'required|integer',   // Ensure quantity is required and valid
      'transaction_id' => 'required|exists:transactions,id', // Ensure transaction_id exists
      'product_id' => 'required|exists:products,id',         // Ensure product_id exists
    ]);

    // Create the new service
    $transaction_product = TransactionProduct::create([
      'transaction_id' => $validated['transaction_id'],
      'product_id' => $validated['product_id'],
      'quantity' => $validated['quantity'],
      'price' => $validated['quantity'] * $validated['p_price'],
    ]);

    // Retrieve the associated transaction
    $transaction = Transaction::find($validated['transaction_id']);

    // Increment the amount column
    $transaction->amount += $transaction_product->price;

    // Save the updated transaction
    $transaction->save();

    return response()->json(['success' => true, 'amount' => $transaction->amount]);
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
      $columns = ['id', 'product.name', 'quantity', 'product.price',]; // Adjust as necessary for inventory columns

      // Build the query for services related to the transaction
      $query = TransactionProduct::where('transaction_id', $id)->with('product');

      // Apply search filter if applicable
      if ($searchValue) {
        $query->whereHas('service', function ($q) use ($searchValue) {
          $q->where('name', 'like', "%$searchValue%")
            ->orWhere('quantity', 'like', "%$searchValue%")
            ->orWhere('price', 'like', "%$searchValue%");
        });
      }

      // Get total records after filtering
      $filteredCount = $query->count();

      // Apply sorting
      if (isset($columns[$orderColumn])) {
        if ($columns[$orderColumn] === 'product.name' || $columns[$orderColumn] === 'quantity' || $columns[$orderColumn] === 'product.price') {
          $query->orderByService($columns[$orderColumn], $orderDir);  // Custom method for ordering by relation
        } else {
          $query->orderBy($columns[$orderColumn], $orderDir);
        }
      }

      // Apply pagination
      $products = $query->limit($length)->offset($start)->get();

      // Get total records before filtering
      $totalCount = TransactionProduct::where('transaction_id', $id)->count();

      // Prepare the response in the format DataTables expects
      return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => intval($totalCount),
        'recordsFiltered' => intval($filteredCount),
        'data' => $products->map(function ($item) {
          return [
            'id' => $item->id,
            'name' => $item->product->name,
            'quantity' => $item->quantity,  // Corrected here
            'price' => $item->product->price, // Corrected here
            'total' => $item->product->price * $item->quantity, // Corrected here
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
    // Find the transaction product or fail if not found
    $transaction_product = TransactionProduct::findOrFail($id);

    // Retrieve the associated transaction
    $transaction = Transaction::find($transaction_product->transaction_id);

    // Decrement the amount column
    $transaction->amount -= $transaction_product->price;

    // Save the updated transaction
    $transaction->save();

    // Delete the transaction product
    $transaction_product->delete();

    return response()->json(['success' => true, 'amount' => $transaction->amount]);
  }
}
