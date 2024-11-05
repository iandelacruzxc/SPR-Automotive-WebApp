<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Products;
use App\Models\Services;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
  {

    if (!auth()->user()->hasRole('admin')) {
      abort(403, 'Unauthorized action.');
    }

    $totalServices = Services::count(); // Fetch the total number of services
    $totalUsers =   User::count();
    $totalProducts = Products::count();
    $totalMechanics = Mechanic::count();
    $totalTransactions = Transaction::count();
    $totalPendingTransactions = Transaction::where('status', 'Pending')->count();
    $totalProcessingTransactions = Transaction::where('status', 'Processing')->count();
    $totalDoneTransactions = Transaction::where('status', 'Done')->count();

    $year = $request->input('year', date('Y'));
    $month = $request->input('month', date('n'));

    $salesData = TransactionProduct::selectRaw('product_id, SUM(quantity) as total_quantity')
      ->whereYear('created_at', $year)
      ->whereMonth('created_at', $month)
      ->groupBy('product_id')
      ->orderBy('total_quantity', 'desc')
      ->get()
      ->map(function ($item) {
        $product = Products::find($item->product_id);
        return [
          'name' => $product ? $product->name : 'Unknown',
          'quantity' => $item->total_quantity
        ];
      });

    // Check if the request is AJAX
    if ($request->ajax()) {
      return response()->json(['salesData' => $salesData]);
    }

    return view('dashboard', compact(
      'totalServices',
      'totalUsers',
      'totalProducts',
      'totalMechanics',
      'totalTransactions',
      'totalPendingTransactions',
      'totalProcessingTransactions',
      'totalDoneTransactions',
      'salesData'
    ));
  }
}
