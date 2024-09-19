<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServices = Services::count(); // Fetch the total number of services
        $totalUsers =   User::count();  
        
        return view('dashboard', compact('totalServices','totalUsers'));
    }
}
