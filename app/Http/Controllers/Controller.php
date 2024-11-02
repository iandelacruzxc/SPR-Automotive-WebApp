<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Services;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

abstract class Controller
{

    
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
    
}
