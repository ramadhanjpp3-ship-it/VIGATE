<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\VehicleApproval;
use App\Models\User;

class VehicleController extends Controller
{
    // Pending Approval - untuk approve/reject kendaraan pending
    public function pending()
    {
        $search = request('q');

        $vehicles = Vehicle::with('user')
            ->where('status', 'pending')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('plate_number', 'like', "%{$search}%")
                        ->orWhere('stnk_number', 'like', "%{$search}%")
                        ->orWhere('ktm_uid', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        return view('admin.pending-approval', compact('vehicles'));
    }

    // Vehicle Approval - menampilkan semua kendaraan yang sudah approved
    public function index()
    {
        $search = request('q');

        $vehicles = Vehicle::with('user')
            ->where('status', 'approved')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('plate_number', 'like', "%{$search}%")
                        ->orWhere('stnk_number', 'like', "%{$search}%")
                        ->orWhere('ktm_uid', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    // Form untuk tambah kendaraan manual
    public function create()
    {
        $users = User::all();
        return view('admin.vehicles.create', compact('users'));
    }

    // Simpan kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plate_number' => 'required|string|max:20',
            'stnk_number' => 'required|string|max:50',
            'stnk_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktm_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktm_uid' => 'required|string|max:50',
        ]);

        $data = $request->only(['user_id', 'plate_number', 'stnk_number', 'ktm_uid']);
        $data['status'] = 'approved';

        // Handle STNK photo upload
        if ($request->hasFile('stnk_photo')) {
            $stnkPhoto = $request->file('stnk_photo');
            $stnkPhotoName = time() . '_stnk_' . $request->plate_number . '.' . $stnkPhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $stnkPhoto, $stnkPhotoName);
            $data['stnk_photo'] = 'vehicles/' . $stnkPhotoName;
        }

        // Handle vehicle photo upload
        if ($request->hasFile('vehicle_photo')) {
            $vehiclePhoto = $request->file('vehicle_photo');
            $vehiclePhotoName = time() . '_vehicle_' . $request->plate_number . '.' . $vehiclePhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $vehiclePhoto, $vehiclePhotoName);
            $data['vehicle_photo'] = 'vehicles/' . $vehiclePhotoName;
        }

        if ($request->hasFile('ktm_photo')) {
            $ktmPhoto = $request->file('ktm_photo');
            $ktmPhotoName = time() . '_ktm_' . $request->plate_number . '.' . $ktmPhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $ktmPhoto, $ktmPhotoName);
            $data['ktm_photo'] = 'vehicles/' . $ktmPhotoName;
        }

        Vehicle::create($data);

        return redirect('/admin/vehicles')->with('success', 'Vehicle added successfully');
    }

    // Show vehicle details
    public function show($id)
    {
        $vehicle = Vehicle::with('user')->findOrFail($id);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    // Edit vehicle form
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $users = User::all();
        return view('admin.vehicles.edit', compact('vehicle', 'users'));
    }

    // Update vehicle
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plate_number' => 'required|string|max:20',
            'stnk_number' => 'required|string|max:50',
            'stnk_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktm_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktm_uid' => 'required|string|max:50',
        ]);

        $data = $request->only(['user_id', 'plate_number', 'stnk_number', 'ktm_uid']);

        // Handle STNK photo upload
        if ($request->hasFile('stnk_photo')) {
            // Delete old photo if exists
            if ($vehicle->stnk_photo && Storage::disk('public')->exists($vehicle->stnk_photo)) {
                Storage::disk('public')->delete($vehicle->stnk_photo);
            }

            $stnkPhoto = $request->file('stnk_photo');
            $stnkPhotoName = time() . '_stnk_' . $request->plate_number . '.' . $stnkPhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $stnkPhoto, $stnkPhotoName);
            $data['stnk_photo'] = 'vehicles/' . $stnkPhotoName;
        }

        // Handle vehicle photo upload
        if ($request->hasFile('vehicle_photo')) {
            // Delete old photo if exists
            if ($vehicle->vehicle_photo && Storage::disk('public')->exists($vehicle->vehicle_photo)) {
                Storage::disk('public')->delete($vehicle->vehicle_photo);
            }

            $vehiclePhoto = $request->file('vehicle_photo');
            $vehiclePhotoName = time() . '_vehicle_' . $request->plate_number . '.' . $vehiclePhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $vehiclePhoto, $vehiclePhotoName);
            $data['vehicle_photo'] = 'vehicles/' . $vehiclePhotoName;
        }

        if ($request->hasFile('ktm_photo')) {
            if ($vehicle->ktm_photo && Storage::disk('public')->exists($vehicle->ktm_photo)) {
                Storage::disk('public')->delete($vehicle->ktm_photo);
            }

            $ktmPhoto = $request->file('ktm_photo');
            $ktmPhotoName = time() . '_ktm_' . $request->plate_number . '.' . $ktmPhoto->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('vehicles', $ktmPhoto, $ktmPhotoName);
            $data['ktm_photo'] = 'vehicles/' . $ktmPhotoName;
        }

        $vehicle->update($data);

        return redirect('/admin/vehicles')->with('success', 'Vehicle updated successfully');
    }

    // Delete vehicle
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        // Delete photos if exist
        if ($vehicle->stnk_photo && Storage::disk('public')->exists($vehicle->stnk_photo)) {
            Storage::disk('public')->delete($vehicle->stnk_photo);
        }
        if ($vehicle->vehicle_photo && Storage::disk('public')->exists($vehicle->vehicle_photo)) {
            Storage::disk('public')->delete($vehicle->vehicle_photo);
        }
        if ($vehicle->ktm_photo && Storage::disk('public')->exists($vehicle->ktm_photo)) {
            Storage::disk('public')->delete($vehicle->ktm_photo);
        }

        $vehicle->delete();

        return redirect('/admin/vehicles')->with('success', 'Vehicle deleted successfully');
    }

    public function approve($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update(['status' => 'approved']);

        VehicleApproval::create([
            'vehicle_id' => $id,
            'admin_id' => auth()->id(),
            'status' => 'approved'
        ]);

        return back()->with('success', 'Vehicle approved successfully');
    }

    public function reject($id)
    {
        Vehicle::findOrFail($id)->update(['status' => 'rejected']);

        VehicleApproval::create([
            'vehicle_id' => $id,
            'admin_id' => auth()->id(),
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Vehicle rejected successfully');
    }
}