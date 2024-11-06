<?php

use App\Http\Controllers\AppointmentAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServiceManagementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionProductController;
use App\Http\Controllers\TransactionServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::post('guest/appointment', [HomeController::class, 'store']);
// Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('signed');
// Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [AuthenticatedSessionController::class, 'verifyEmail'])->name('email.verify');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.submit');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/admin/register', [RegisterController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'registerAdmin']);


Route::get('/staff/register', [RegisterController::class, 'regformStaff'])->name('staff.register');
Route::post('/staff/register', [RegisterController::class, 'registerstaff']);

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/dashboard/data', [DashboardController::class, 'fetchChartData'])->name('dashboard.data');

  Route::get('/services-management', [ServiceManagementController::class, 'index'])->name('admin.service-management');
  Route::get('/services/data', [ServiceManagementController::class, 'getData']);
  Route::resource('services', ServiceManagementController::class)->except(['create', 'edit']);
  Route::resource('customer-profile', CustomerController::class)->except(['create', 'edit']);
  Route::resource('products', ProductManagementController::class)->except(['create', 'edit']);
  Route::resource('inventory', InventoryController::class)->except(['create', 'edit']);
  Route::resource('transactions', TransactionController::class)->except(['create', 'edit']);
  Route::resource('transaction-services', TransactionServiceController::class)->except(['create', 'edit']);
  Route::resource('transaction-products', TransactionProductController::class)->except(['create', 'edit']);
  Route::get('/options', [OptionController::class, 'getOptions']);
  Route::get('/mechanics', [MechanicController::class, 'index'])->name('admin.mechanics');
  Route::get('/mechanics/data', [MechanicController::class, 'getData']);
  Route::post('/mechanics/create', [MechanicController::class, 'store'])->name('mechanics.store');
  Route::put('/mechanics/update/{id}', [MechanicController::class, 'update']);
  Route::delete('/mechanics/delete/{id}', [MechanicController::class, 'destroy']);


  Route::get('/invoice/{id}', [InvoiceController::class, 'generateInvoice']);

  Route::get('/test-invoice', function () {
    $transaction = \App\Models\Transaction::with(['products', 'services'])->first();
    return view('invoice.invoice', compact('transaction'));
  });



  Route::resource('admin-appointment', AppointmentAdminController::class)->except(['create', 'edit']);
  // Route::get('/admin/transaction/details', function () {
  //   return view('admin.transaction.transaction-details');
  // });
});

Route::middleware(['auth'])->group(function () {
  Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
  Route::get('/user/profile-management', [UserController::class, 'userProfile'])->name('user.userProfile');
  Route::get('/user/products', [UserController::class, 'products'])->name('user.products');
  Route::get('/user/services', [UserController::class, 'services'])->name('user.services');
  Route::post('/cart/add/{productId}', [UserController::class, 'addToCart'])->name('cart.add');
  Route::post('/user/cart/update/{id}', [UserController::class, 'updateQuantity'])->name('cart.update');
  Route::get('/cart', [UserController::class, 'viewCart'])->name('cart.index');

  // Resource route for appointments
  Route::resource('user/appointment', AppointmentController::class)->except(['create', 'edit']);
  Route::get('/user/appointment-history', [AppointmentController::class, 'history'])->name('user.history');
  Route::get('/check-appointment', [AppointmentController::class, 'checkAppointment']);
});
