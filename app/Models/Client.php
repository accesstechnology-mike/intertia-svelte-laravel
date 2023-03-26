<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    public function address()
    {
        return $this->hasMany(\App\Models\Address::class);
    }

    public function contact()
    {
        return $this->belongsToMany(\App\Models\Contact::class);
    }

    public function clientNote()
    {
        return $this->hasMany(\App\Models\ClientNote::class);
    }

    public function log()
    {
        return $this->hasMany(\App\Models\Log::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function expense()
    {
        return $this->hasMany(\App\Models\Expense::class);
    }

}
