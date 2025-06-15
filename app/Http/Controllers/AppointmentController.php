<?php

namespace App\Http\Controllers;

use App\Mail\StatusUpdated;
use App\Models\Appointment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {

            // Fetch confirmed appointment dates
            $appointments = Appointment::where('status', 'confirmed')
                ->pluck('appointment_date')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                });

        return view('users.appointment.index', compact('appointments'));
    }


    // public function index()
    // {
    //     // Fetch all products and services
    //     $products = Products::all();
    //     $services = Services::all(); // Fetch all services

    //     // Fetch confirmed appointment dates
    //     $appointments = Appointment::where('status', 'confirmed')
    //         ->pluck('appointment_date')
    //         ->map(function ($date) {
    //             return \Carbon\Carbon::parse($date)->format('Y-m-d');
    //         });

    //     // Pass products, services, and appointments to the view
    //     return view('welcome', compact('products', 'services', 'appointments'));
    // }

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

        $confirmedCount = Appointment::where('status', 'confirmed')->count();
        $status = ($confirmedCount >= 5) ? 'pending' : 'confirmed';
        Log::info('Confirmed appointments count: ' . $confirmedCount);
        $transactionCode = $this->generateTransactionCode();

        // Validate the incoming request data
        $request->validate([
            'appointment_datetime' => 'required|date|after:now', // Ensure the date and time are not in the past
            'message' => 'required|string|max:1000', // Message is required
            'service' => 'required|exists:services,id', // Ensure the service ID exists in the services table
        ]);

        $transactionData = [
            'client_name' => auth()->user()->name,
            'user_id' => null,
            'unit' => ' ',
            'code' => $transactionCode,
            'plate_no' => ' ',
            'color' => ' ',
            'contact' => ' ',
            'email' => auth()->user()->email,
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
            'user_id' => auth()->id(), // Assuming the user is logged in
            'appointment_date' => $request->appointment_datetime,
            'message' => $request->message,
            'service_id' => $request->service, // Save the selected service ID
            'status' => $status, // Use the computed status// Set default status as 'pending' or modify this line as per your requirement
            'email' => auth()->user()->email, // Store the user's email
        ]);

        // $transaction->save();

        Log::info('Assigned status for new appointment: ' . $status);

        Mail::to(auth()->user()->email)->send(new StatusUpdated($appointment)); // Use user's emailDF

        // Return a response
        return response()->json(['message' => 'Appointment booked successfully!']);
    }


    public function history(Request $request)
    {
        if ($request->ajax()) {
            // Fetching parameters
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');

            // Get the column names for ordering
            $columns = ['appointment_date', 'message', 'status', 'user.name']; // Include user name for ordering

            // Build the query
            $query = Appointment::with('user', 'service')->where('user_id', auth()->id()); // Filter by the authenticated user's ID

            // Apply search filter if applicable
            if ($searchValue) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('appointment_date', 'like', "%$searchValue%")
                        ->orWhere('message', 'like', "%$searchValue%")
                        ->orWhere('status', 'like', "%$searchValue%")
                        ->orWhereHas('user', function ($q) use ($searchValue) { // Search in the user's name
                            $q->where('name', 'like', "%$searchValue%");
                        });
                });
            }

            // Get total records after filtering
            $filteredCount = $query->count();

            // Apply sorting
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            }

            // Apply pagination
            $appointments = $query->skip($start)->take($length)->get();

            // Get total records before filtering
            $totalCount = Appointment::count();

            // Prepare the response in the format DataTables expects
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => intval($totalCount),
                'recordsFiltered' => intval($filteredCount),
                'data' => $appointments
            ]);
        }

        // Send email based on the appointment details


        // If not an AJAX request, return the view
        return view('users.appointment.table'); // Your view for displaying appointment history
    }
}
