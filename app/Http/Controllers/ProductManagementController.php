<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
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
        $columns = ['name', 'description', 'price', 'status', 'image_path'];

        // Build the query
        $query = Products::query();

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
        $totalCount = Products::count();

        // Prepare the response in the format DataTables expects
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalCount),
            'recordsFiltered' => intval($filteredCount),
            'data' => $services
        ]);
    }

    // If not an AJAX request, return the view
    return view('admin.product-management.product-management');
}



    // public function getData(Request $request)
    // {
    //     // Fetching parameters
    //     $draw = $request->input('draw');
    //     $start = $request->input('start');
    //     $length = $request->input('length');
    //     $searchValue = $request->input('search.value');
    //     $orderColumn = $request->input('order.0.column');
    //     $orderDir = $request->input('order.0.dir');
        
    //     // Get the column names for ordering
    //     $columns = ['name', 'description', 'price', 'status', 'image_path'];
        
    //     // Build the query
    //     $query = Products::query();
        
    //     // Apply search filter if applicable
    //     if ($searchValue) {
    //         $query->where(function($q) use ($searchValue) {
    //             $q->where('name', 'like', "%$searchValue%")
    //               ->orWhere('description', 'like', "%$searchValue%")
    //               ->orWhere('price', 'like', "%$searchValue%");
    //         });
    //     }
        
    //     // Get total records after filtering
    //     $filteredCount = $query->count();
        
    //     // Apply sorting
    //     if (isset($columns[$orderColumn])) {
    //         $query->orderBy($columns[$orderColumn], $orderDir);
    //     }
        
    //     // Apply pagination
    //     $services = $query->skip($start)->take($length)->get();
        
    //     // Get total records before filtering
    //     $totalCount = Products::count();
        
    //     // Prepare the response in the format DataTables expects
    //     return response()->json([
    //         'draw' => intval($draw),
    //         'recordsTotal' => intval($totalCount),
    //         'recordsFiltered' => intval($filteredCount),
    //         'data' => $services
    //     ]);
    // }


    public function store(Request $request)
    {
         // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:1,2', // Assuming 1 is Active and 2 is Inactive
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Handle image upload if a file is provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Store the image in the 'products' folder
        }

        // Create a new product
        $product = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'image_path' => $imagePath, // Save the path to the image
        ]);

        // Optionally return a response
        return response()->json(['success' => true, 'product' => $product], 201);
    }
    
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'status' => 'required|in:1,2', // Assuming 1 is Active and 2 is Inactive
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
    ]);

    // Find the existing product by ID
    $product = Products::findOrFail($id);

    // Handle image upload if a file is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        
        // Store the new image
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image_path = $imagePath; // Update the image path
    }

    // Update the product details
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->status = $request->status;

    // Save the changes
    $product->save();

    // Optionally return a response
    return response()->json(['success' => true, 'product' => $product], 200);
}

public function destroy($id)
{
    $product = Products::find($id);
    if ($product) {
        $product->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Product not found'], 404);
}


    
    
    





}
