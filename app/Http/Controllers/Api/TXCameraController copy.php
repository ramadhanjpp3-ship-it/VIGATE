<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessLog;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class CameraController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image',
            'nfc_uid' => 'nullable|string',
            'status' => 'nullable|string|in:allowed,denied'
        ]);

        // simpan image dari ESP32-CAM
        $path = $request->file('image')->store('gate', 'public');

        $nfcUid = $data['nfc_uid'] ?? null;
        $status = $data['status'] ?? 'denied';
        $userId = null;

        if ($nfcUid) {
            $vehicle = Vehicle::where('ktm_uid', $nfcUid)
                ->where('status', 'approved')
                ->first();

            $userId = $vehicle?->user_id;
        }

        AccessLog::create([
            'user_id' => $userId,
            'nfc_uid' => $nfcUid,
            'face_image' => null,
            'vehicle_image' => $path,
            'status' => $status
        ]);

        return response()->json([
            'ok' => true,
            'path' => $path
        ], 201);
    }
}