<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capability extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
    ];

    public function customer()
    {
        return $this->belongsToMany(Customer::class);
    }
}
