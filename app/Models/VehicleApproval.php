<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleApproval extends Model
{
    protected $fillable = [
        'vehicle_id',
        'admin_id',
        'status',
        'notes'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}