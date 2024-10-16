<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Products;
use App\Models\Services;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
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

    return view('dashboard', compact(
      'totalServices',
      'totalUsers',
      'totalProducts',
      'totalMechanics',
      'totalTransactions',
      'totalPendingTransactions',
      'totalProcessingTransactions',
      'totalDoneTransactions',
    ));
  }
}
