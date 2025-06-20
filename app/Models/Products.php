<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'image_path',
    ];

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }
}
