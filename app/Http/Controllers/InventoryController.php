<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Products;
use Illuminate\Http\Request;

class InventoryController extends Controller
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
            $columns = ['id', 'name', 'image_path', 'inventory.quantity']; // Adjusted for product attributes
        
            // Build the query from Product
            $query = Products::with('inventory'); // Load the inventory relationship
        
            // Apply search filter if applicable
            if ($searchValue) {
                $query->where('name', 'like', "%$searchValue%");
            }
        
            // Get total records after filtering
            $filteredCount = $query->count();
        
            // Apply sorting
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            }
        
            // Apply pagination
            $products = $query->skip($start)->take($length)->get();
        
            // Get total records before filtering
            $totalCount = Products::count();
        
            // Prepare the response in the format DataTables expects
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => intval($totalCount),
                'recordsFiltered' => intval($filteredCount),
                'data' => $products->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'image_path' => $item->image_path,
                        'quantity' => $item->inventory->quantity ?? '0', // Adjusted for inventory relationship
                    ];
                })
            ]);
        }
    
        return view('admin.inventory.inventory');
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            // Fetching parameters for DataTable
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir');
    
            // Define the columns for ordering
            $columns = ['stock_date', 'quantity']; // Adjust as necessary for inventory columns
    
            // Build the query for inventory related to the product
            $query = Inventory::where('product_id', $id);
    
            // Apply search filter if applicable
            if ($searchValue) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('stock_date', 'like', "%$searchValue%")
                      ->orWhere('quantity', 'like', "%$searchValue%");
                });
            }
    
            // Get total records after filtering
            $filteredCount = $query->count();
    
            // Apply sorting
            if (isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDir);
            }
    
            // Apply pagination
            $inventories = $query->limit($length)->offset($start)->get(); // Ensure correct pagination
    
            // Get total records before filtering
            $totalCount = Inventory::where('product_id', $id)->count();
    
            // Prepare the response in the format DataTables expects
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => intval($totalCount),
                'recordsFiltered' => intval($filteredCount),
                'data' => $inventories->map(function ($item) {
                    return [
                        'stock_date' => $item->stock_date,
                        'quantity' => $item->quantity,
                    ];
                })
            ]);
        }
    
        // Fetch the product with its associated inventory for display
        $product = Products::with('inventory')->findOrFail($id);
        return view('admin.inventory.productDetails', compact('product'));
    }
    
    
   
    
    
    
    public function store(Request $request)
    {
         // Validate the incoming request data
        $request->validate([
            'productId' => 'required|numeric',
            'quantity' => 'required|numeric',
            'stockDate' => 'required',
        ]);

        // Create a new inventory
        $inventory = Inventory::create([
            'product_id' => $request->productId,
            'quantity' => $request->quantity,
            'stock_date' => $request->stockDate,
 
        ]);

        // Optionally return a response
        return response()->json(['success' => true, 'inventory' => $inventory], 201);
    }




}
