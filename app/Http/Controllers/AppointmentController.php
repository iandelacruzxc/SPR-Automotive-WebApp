<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {

        return view('users.appointment.index');
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
        Appointment::create([
            'user_id' => auth()->id(), // Assuming the user is logged in
            'appointment_date' => $request->appointment_datetime,
            'message' => $request->message,
            'service_id' => $request->service, // Save the selected service ID
        ]);
        
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
            $query = Appointment::with('user','service')->where('user_id', auth()->id()); // Filter by the authenticated user's ID

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

        // If not an AJAX request, return the view
        return view('users.appointment.table'); // Your view for displaying appointment history
    }
}
