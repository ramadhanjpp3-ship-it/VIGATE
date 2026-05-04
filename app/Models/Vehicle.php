<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'plate_number',
        'stnk_number',
        'stnk_photo',
        'vehicle_photo',
        'ktm_photo',
        'ktm_uid',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvals()
    {
        return $this->hasMany(VehicleApproval::class);
    }
}