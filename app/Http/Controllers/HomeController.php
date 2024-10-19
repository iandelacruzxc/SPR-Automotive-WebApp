<?php

namespace App\Http\Controllers;

use App\Mail\StatusUpdated;
use App\Models\Appointment;
use App\Models\Products;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Fetch all products and services
        $products = Products::all();
        $services = Services::all(); // Fetch all services

        // Pass both products and services to the view
        return view('welcome', compact('products', 'services'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'appointment_datetime' => 'required|date|after:now', // Ensure the date and time are not in the past
            'message' => 'required|string|max:1000', // Message is required
            'service' => 'required|exists:services,id', // Ensure the service ID exists in the services table
        ]);

        // Store the appointment data
        $appointment = Appointment::create([
            'appointment_date' => $request->appointment_datetime,
            'message' => $request->message,
            'service_id' => $request->service, // Save the selected service ID
            'status' => 'pending', // Set default status as 'pending' or modify this line as per your requirement
            'email' => $request->email, // Store the user's email
            'user_id' => null, // Set user_id to null
        ]);
        

        Mail::to($request->email)->send(new StatusUpdated($appointment)); // Use user's emailDF

        // Return a response
        return response()->json(['message' => 'Appointment booked successfully!']);
    }
}
