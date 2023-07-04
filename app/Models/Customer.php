<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Capability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'active'
    ];

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function capabilities(){
        return $this->belongsToMany(Capability::class);
    }
}
