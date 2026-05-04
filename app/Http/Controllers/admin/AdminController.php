<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\AccessLog;
use App\Models\GateDevice;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalVehicles' => Vehicle::count(),
            'pendingVehicles' => Vehicle::where('status','pending')->count(),
            'totalLogs' => AccessLog::count(),
            'activeGates' => GateDevice::where('status','active')->count(),
            'logs' => AccessLog::latest()->limit(10)->get(),
        ]);
    }

    public function users()
    {
        $search = request('q');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        })->get();

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('info', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function gates()
    {
        $search = request('q');

        $gates = GateDevice::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('device_ip', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        })->get();

        return view('admin.gates', compact('gates'));
    }
}