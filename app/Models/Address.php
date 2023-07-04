<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'barangay',
        'city',
        'primary',
        'user_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
