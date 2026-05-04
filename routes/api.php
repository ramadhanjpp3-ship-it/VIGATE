<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NfcController;
use App\Http\Controllers\Api\CameraController;
use App\Http\Controllers\Api\GateController;

Route::post('/check-access', [NfcController::class,'check']);
Route::post('/upload-image', [CameraController::class,'upload']);
Route::post('/gate-event', [GateController::class,'event']);