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
            'image' => 'sometimes|image',
            'nfc_uid' => 'nullable|string',
            'status' => 'nullable|string|in:allowed,denied'
        ]);

        if ($request->hasFile('image')) {
            // multipart/form-data upload
            $path = $request->file('image')->store('gate', 'public');
        } else {
            $contentType = strtolower($request->header('content-type', ''));
            $rawBody = $request->getContent();

            if (empty($rawBody) || !str_starts_with($contentType, 'image/')) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Image file is required as multipart/form-data or raw image body.'
                ], 422);
            }

            $path = 'gate/' . uniqid('img_', true) . '.jpg';
            Storage::disk('public')->put($path, $rawBody);
        }

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