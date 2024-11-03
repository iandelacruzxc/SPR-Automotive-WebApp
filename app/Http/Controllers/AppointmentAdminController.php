<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\StatusUpdated; // Import your Mailable
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;

class AppointmentAdminController extends Controller
{
    public function index(Request $request)
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
            $columns = ['appointment_date', 'message', 'status', 'user.name', 'email', 'user.email']; // Include user name for ordering

            // Build the query
            $query = Appointment::with('user', 'service'); // Eager load the user relationship

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
        return view('admin.appointment.appointment'); // Your view for displaying appointment history
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id); // Find the appointment by ID
        $transactionCode = $this->generateTransactionCode();

        // Update the status
        $appointment->status = $request->input('status');
        $appointment->save();


        // Send email notification based on user_id
        if ($appointment->user_id) {
            // If user_id is not null, use the user's email
            $client_name = auth()->user()->name;
            Mail::to($appointment->user->email)->send(new StatusUpdated($appointment));
        } else {
            // If user_id is null, use the appointment's email
            $client_name = " ";
            Mail::to($appointment->email)->send(new StatusUpdated($appointment));
        }

        $transactionData = [
            'client_name' => $client_name,
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

        // Save the transaction data only if the status is confirmed
        if ($appointment->status === 'confirmed') {
            Transaction::create($transactionData);
        }

        return response()->json(['message' => 'Status updated successfully!']);
    }
}
