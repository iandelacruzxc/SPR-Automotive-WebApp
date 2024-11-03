<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            // Fetching parameters
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');

            // Get the column names for ordering
            $columns = ['name', 'email'];

            // Build the query, excluding users with the "admin" role
            $query = User::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'admin');
            });

            // Apply search filter if applicable
            if ($searchValue) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%$searchValue%")
                        ->orWhere('email', 'like', "%$searchValue%");
                });
            }

            // Get total records after filtering
            $filteredCount = $query->count();

            // Apply sorting
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            }

            // Apply pagination
            $customers = $query->skip($start)->take($length)->get();

            // Get total records before filtering
            $totalCount = User::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'admin');
            })->count();

            // Prepare the response in the format DataTables expects
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => intval($totalCount),
                'recordsFiltered' => intval($filteredCount),
                'data' => $customers
            ]);
        }

        return view('admin.customer.customer');
    }

    public function destroy($id)
    {
        $product = User::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }
}
