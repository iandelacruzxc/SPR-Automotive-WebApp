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
      'p_price' => 'decimal:2',
      'quantity' => 'integer',
    ]);

    // Create the new service
    $transaction_product = TransactionProduct::create([
      'transaction_id' => $request['transaction_id'],
      'product_id' => $request['product_id'],
      'quantity' => $validated['quantity'],
      'price' => $validated['quantity'] * $validated['p_price'],
    ]);

    return response()->json(['success' => true]);
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
    $transaction_service = TransactionProduct::findOrFail($id);
    $transaction_service->delete();

    return response()->json(['success' => true]);
  }
}
