<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'quantity',
        'stock_date',
    ];


     public function product()
     {
         return $this->belongsTo(Products::class, 'product_id'); // Assuming your Product model is named Product
     }
}
