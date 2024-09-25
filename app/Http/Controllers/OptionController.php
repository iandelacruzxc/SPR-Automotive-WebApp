<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    // $totalUsers =   User::count(); 
    public function getOptions(Request $request)
    {
        $model = $request->input('model');
        $data = [];
    
        switch ($model) {
            case 'products':
                $data = Products::select('id', 'name')->get();
                break;
    
            case 'services':
                // Assuming you have a Services model
                // $data = Services::select('id', 'name')->get();
                break;
    
            default:
                return response()->json(['error' => 'Invalid model'], 400);
        }
    
        // Return data as JSON
        return response()->json($data);
    }
}
