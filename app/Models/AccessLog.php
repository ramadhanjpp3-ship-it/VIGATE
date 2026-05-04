<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = [
        'user_id',
        'nfc_uid',
        'plate_number',
        'face_image',
        'vehicle_image',
        'status',
        'gate_device_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gate()
    {
        return $this->belongsTo(GateDevice::class);
    }
}