<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class NfcController extends Controller
{
    public function check(Request $request)
    {
        $data = $request->validate([
            'nfc_uid' => 'required|string'
        ]);

        $vehicle = Vehicle::where('ktm_uid', $data['nfc_uid'])
            ->where('status', 'approved')
            ->first();

        if ($vehicle) {
            return response()->json([
                'status' => 'allowed',
                'user_id' => $vehicle->user_id
            ], 200);
        }

        return response()->json([
            'status' => 'denied'
        ], 200);
    }
}