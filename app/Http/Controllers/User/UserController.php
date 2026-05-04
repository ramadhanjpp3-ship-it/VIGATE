<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $vehicle = auth()->user()->vehicles()->first();
        $historyCount = auth()->user()->logs()->count();

        return view('user.dashboard', compact('vehicle', 'historyCount'));
    }

    public function history()
    {
        $logs = auth()->user()->logs()->with('gate')->latest()->get();

        return view('user.history', compact('logs'));
    }
}