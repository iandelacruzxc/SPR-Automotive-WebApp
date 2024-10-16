<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
class ServiceManagementController extends Controller
{
    public function index()
    {

        // if (!auth()->user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }
        
        return view('admin.service-management.service-management');
    }

    public function getData(Request $request)
    {
        // Fetching parameters
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
        
        // Get the column names for ordering
        $columns = ['name', 'description', 'price', 'status'];
        
        // Build the query
        $query = Services::query();
        
        // Apply search filter if applicable
        if ($searchValue) {
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', "%$searchValue%")
                  ->orWhere('description', 'like', "%$searchValue%")
                  ->orWhere('price', 'like', "%$searchValue%");
            });
        }
        
        // Get total records after filtering
        $filteredCount = $query->count();
        
        // Apply sorting
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }
        
        // Apply pagination
        $services = $query->skip($start)->take($length)->get();
        
        // Get total records before filtering
        $totalCount = Services::count();
        
        // Prepare the response in the format DataTables expects
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalCount),
            'recordsFiltered' => intval($filteredCount),
            'data' => $services
        ]);
    }
    
    

public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'status' => 'required|in:1,2',
    ]);

    // Create the new service
    $service = Services::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'status' => $validated['status'] == '1' ? true : false, // Convert to boolean
    ]);

    return response()->json(['success' => true]);
}

public function update(Request $request, $id)
{
    // Validate and update existing service
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'status' => 'required|integer'
    ]);

    $service = Services::findOrFail($id);
    $service->update($validatedData);

    return response()->json(['message' => 'Service updated successfully.']);
}

// app/Http/Controllers/ServiceController.php
public function destroy($id)
{
    $service = Services::findOrFail($id);
    $service->delete();
    
    return response()->json(['success' => true]);
}


    
}
