<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\ServiceManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.submit');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/services-management', [ServiceManagementController::class, 'index'])->name('admin.service-management');
    Route::get('/services/data', [ServiceManagementController::class, 'getData']);
    Route::resource('services', ServiceManagementController::class)->except(['create', 'edit']);

    Route::get('/products-management', [ProductManagementController::class, 'index'])->name('admin.product-management');
    Route::get('/products/data', [ProductManagementController::class, 'getData']);
    Route::resource('products', ProductManagementController::class)->except(['create', 'edit']);
    
});

