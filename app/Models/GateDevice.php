<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GateDevice extends Model
{
    protected $fillable = [
        'gate_code',
        'name',
        'device_ip',
        'status'
    ];

    public function logs()
    {
        return $this->hasMany(AccessLog::class);
    }
}