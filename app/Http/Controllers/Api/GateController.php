<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function event(Request $request)
    {
        $data = $request->validate([
            'gate_code' => 'nullable|string',
            'event_type' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        return response()->json([
            'status' => 'received',
            'event' => $data
        ], 200);
    }
}
