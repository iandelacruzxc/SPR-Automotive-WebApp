<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
  public function index()
  {

    if (!auth()->user()->hasRole('admin')) {
      abort(403, 'Unauthorized action.');
    }

    
    return view('admin.mechanics');
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
    $columns = ['firstname', 'middlename', 'lastname', 'status', 'position', 'rate', 'delete_flag'];

    // Build the query
    $query = Mechanic::query();

    // Apply search filter if applicable
    if ($searchValue) {
      $query->where(function ($q) use ($searchValue) {
        $q->where('firstname', 'like', "%$searchValue%")
          ->orWhere('middlename', 'like', "%$searchValue%")
          ->orWhere('lastname', 'like', "%$searchValue%")
          ->orWhere('position', 'like', "%$searchValue%")
          ->orWhere('rate', 'like', "%$searchValue%")
          ->orWhere('status', 'like', "%$searchValue%");
      });
    }

    // Get total records after filtering
    $filteredCount = $query->count();

    // Apply sorting
    if (isset($columns[$orderColumn])) {
      $query->orderBy($columns[$orderColumn], $orderDir);
    }

    // Apply pagination
    $mechanics = $query->skip($start)->take($length)->get();

    // Get total records before filtering
    $totalCount = Mechanic::count();

    // Prepare the response in the format DataTables expects
    return response()->json([
      'draw' => intval($draw),
      'recordsTotal' => intval($totalCount),
      'recordsFiltered' => intval($filteredCount),
      'data' => $mechanics
    ]);
  }

  public function store(Request $request)
  {
    // Validate the request
    $validated = $request->validate([
      'firstname' => 'required|string|max:255',
      'middlename' => 'string|max:255|nullable',
      'lastname' => 'required|string|max:255',
      'position' => 'required|string|max:100',
      'rate' => 'required',
      'status' => 'required|in:1,2',
      // 'delete_flag' => 'required|in:1,2',
    ]);

    // Create the new mechanic
    $mechanic = Mechanic::create([
      'firstname' => $validated['firstname'],
      'middlename' => $validated['middlename'],
      'lastname' => $validated['lastname'],
      'position' => $validated['position'],
      'rate' => $validated['rate'],
      'status' => $validated['status'] == '1' ? true : false, // Convert to boolean
      'delete_flag' => false, // Convert to boolean
    ]);

    return response()->json(['success' => true]);
  }

  public function update(Request $request, $id)
  {
    // Validate and update existing mechanic
    $validatedData = $request->validate([
      'firstname' => 'required|string|max:255',
      'middlename' => 'string|max:255|nullable',
      'lastname' => 'required|string|max:255',
      'position' => 'required|string|max:100',
      'rate' => 'required',
      'status' => 'required|in:1,2',
      // 'delete_flag' => 'required|in:1,2',
    ]);

    $mechanic = Mechanic::findOrFail($id);
    $mechanic->update($validatedData);

    return response()->json(['message' => 'Mechanic updated successfully.']);
  }

  // app/Http/Controllers/ServiceController.php
  public function destroy($id)
  {
    $mechanic = Mechanic::findOrFail($id);
    $mechanic->delete();

    return response()->json(['success' => true]);
  }
}
