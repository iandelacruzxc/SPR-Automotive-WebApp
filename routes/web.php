<?php

use App\Http\Controllers\AppointmentAdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServiceManagementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::post('guest/appointment', [HomeController::class, 'store']);


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

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/services-management', [ServiceManagementController::class, 'index'])->name('admin.service-management');
  Route::get('/services/data', [ServiceManagementController::class, 'getData']);
  Route::resource('services', ServiceManagementController::class)->except(['create', 'edit']);
  Route::resource('products', ProductManagementController::class)->except(['create', 'edit']);
  Route::resource('inventory', InventoryController::class)->except(['create', 'edit']);
  Route::resource('transactions', TransactionController::class)->except(['create', 'edit']);
  Route::get('/options', [OptionController::class, 'getOptions']);
  Route::get('/mechanics', [MechanicController::class, 'index'])->name('admin.mechanics');
  Route::get('/mechanics/data', [MechanicController::class, 'getData']);
  Route::post('/mechanics/create', [MechanicController::class, 'store'])->name('mechanics.store');
  Route::put('/mechanics/update/{id}', [MechanicController::class, 'update']);
  Route::delete('/mechanics/delete/{id}', [MechanicController::class, 'destroy']);

  Route::resource('admin-appointment', AppointmentAdminController::class)->except(['create', 'edit']);

});

Route::middleware(['auth'])->group(function () {
  Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
  Route::get('/user/products', [UserController::class, 'products'])->name('user.products');
  Route::post('/cart/add/{productId}', [UserController::class, 'addToCart'])->name('cart.add');
  Route::post('/user/cart/update/{id}', [UserController::class, 'updateQuantity'])->name('cart.update');
  Route::get('/cart', [UserController::class, 'viewCart'])->name('cart.index');

// Resource route for appointments
Route::resource('user/appointment', AppointmentController::class)->except(['create', 'edit']);
Route::get('/user/appointment-history', [AppointmentController::class, 'history'])->name('user.history');

});
