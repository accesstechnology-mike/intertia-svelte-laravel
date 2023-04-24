<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ASP extends Model
{
    use HasFactory;

    protected $table = 'asps';

    protected $fillable = [
        'client_id',
        'user_id',
        'amount',
        'type',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
