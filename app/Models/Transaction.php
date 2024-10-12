<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
      'user_id',
      'mechanic_id',
      'code',
      'client_name',
      'unit',
      'plate_no',
      'color',
      'contact',
      'email',
      'address',
      'amount',
      'downpayment',
      'date_in',
      'date_out',
      'status',
    ];
    
    // Define relationship to User (for the user who created the transaction)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Define relationship to Mechanic (assuming you have a separate Mechanic model)
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'mechanic_id');
    }
}