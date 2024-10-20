<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Products;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
  public function getOptions(Request $request)
  {
      // Get the input models, which can now be an array
      $models = $request->input('models', []); // Default to an empty array if no input
      $data = [];
  
      // Loop through each model provided in the request
      foreach ($models as $model) {
          switch ($model) {
              case 'products':
                  // Fetch products data and add to $data array
                  $data['products'] = Products::select('id', 'name', 'price')->get();
                  break;
  
              case 'mechanics':
                  // Fetch mechanics data with concatenated name
                  $data['mechanics'] = Mechanic::select(
                      'id',
                      DB::raw("CONCAT(firstname, ' ', IFNULL(middlename, ''), ' ', lastname) AS fullname")
                  )
                  ->where('status', 0)
                  ->get();
                  break;
  
              case 'services':
                  // Fetch services data
                  $data['services'] = Services::select('id', 'name', 'price')->get();
                  break;
  
              default:
                  // If an invalid model is provided, skip this iteration
                  continue 2;
          }
      }
  
      // If no valid models were found, return an error
      if (empty($data)) {
          return response()->json(['error' => 'No valid models provided or data not found'], 400);
      }
  
      // Return the combined data as JSON
      return response()->json($data);
  }
}
