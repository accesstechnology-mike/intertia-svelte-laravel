<?php

namespace App\Models;

use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'duration',
        'status',
        'approver_id',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
