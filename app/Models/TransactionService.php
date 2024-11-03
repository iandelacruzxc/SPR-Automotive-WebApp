<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionService extends Model
{
  use HasFactory;

  protected $fillable = [
    'transaction_id',
    'service_id',
    'price',
    
  ];

  public function service()
  {
    return $this->belongsTo(Services::class);
  }

  public function transaction()
  {
    return $this->belongsTo(Transaction::class);
  }
}
