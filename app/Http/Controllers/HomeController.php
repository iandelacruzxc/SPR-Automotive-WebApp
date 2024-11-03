<?php

namespace App\Http\Controllers;

use App\Mail\StatusUpdated;
use App\Models\Appointment;
use App\Models\Products;
use App\Models\Services;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    public function index()
    {
        // Fetch all products and services
        $products = Products::all();
        $services = Services::all(); // Fetch all services

        // Fetch confirmed appointment dates
        $appointments = Appointment::where('status', 'confirmed')
            ->pluck('appointment_date')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            });

        // Pass products, services, and appointments to the view
        return view('welcome', compact('products', 'services', 'appointments'));
    }





    public function generateTransactionCode()
    {
        // Get current date in 'YYYYMMDD' format
        $datePrefix = Carbon::now()->format('Ymd');

        // Get the last transaction code for today, if it exists
        $lastTransaction = Transaction::where('code', 'like', $datePrefix . '%')
            ->orderBy('code', 'desc')
            ->first();

        // Determine the next sequence number
        if ($lastTransaction) {
            $lastSequence = (int)substr($lastTransaction->code, -3); // Get last 'xxx'
            $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeroes
        } else {
            $nextSequence = '001'; // Start with '001' if no transactions for today
        }

        // Combine the date prefix and sequence number
        return $datePrefix . $nextSequence;
    }

    public function store(Request $request)
    {
        // Count confirmed appointments
        $confirmedCount = Appointment::where('status', 'confirmed')->count();
        $status = ($confirmedCount >= 5) ? 'pending' : 'confirmed';
        Log::info('Confirmed appointments count: ' . $confirmedCount);
        $transactionCode = $this->generateTransactionCode();
        // Determine the status based on the confirmed count
        // Validate the incoming request data
        $request->validate([
            'appointment_datetime' => 'required|date|after:now', // Ensure the date and time are not in the past
            'message' => 'required|string|max:1000', // Message is required
            'service' => 'required|exists:services,id', // Ensure the service ID exists in the services table
        ]);

        $transactionData = [
            'client_name' => ' ',
            'user_id' => null,
            'unit' => ' ',
            'code' => $transactionCode,
            'plate_no' => ' ',
            'color' => ' ',
            'contact' => ' ',
            'email' => $request->email,
            'address' => ' ',
            // 'mechanic_id' => 'required|numeric',
            // 'downpayment' => 'nullable|numeric',  // Validate downpayment as numeric
            'date_in' =>  $request->appointment_datetime,
            // 'date_out' => 'date',
            // 'code' => ' ',
            'status' => 'Pending',
        ];


        if ($status === 'confirmed') {
            $transaction = Transaction::create($transactionData);
        }

        // Store the appointment data
        $appointment = Appointment::create([
            'appointment_date' => $request->appointment_datetime,
            'message' => $request->message,
            'service_id' => $request->service, // Save the selected service ID
            'status' => $status, // Use the computed status
            'email' => $request->email, // Store the user's email
            'user_id' => null, // Set user_id to null
        ]);

        // Send email logic...
        // Send email notification about the appointment status
        Mail::to($request->email)->send(new StatusUpdated($appointment)); // Use user's emailDF

        // Return a response
        return response()->json(['message' => 'Appointment booked successfully!']);
    }
}
