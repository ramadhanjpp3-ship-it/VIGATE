<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicle = auth()->user()->vehicles()->first();

        return view('user.vehicles.index', compact('vehicle'));
    }

    public function create()
    {
        if (auth()->user()->vehicles()->exists()) {
            return redirect()->route('user.vehicles.index')
                ->with('info', 'Anda hanya dapat menambahkan satu kendaraan.');
        }

        return view('user.vehicles.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->vehicles()->exists()) {
            return redirect()->route('user.vehicles.index')
                ->with('info', 'Anda hanya dapat menambahkan satu kendaraan.');
        }

        $data = $request->validate([
            'plate_number' => 'required|string|max:255',
            'stnk_number' => 'required|string|max:255',
            'ktm_uid' => 'required|string|max:255|unique:vehicles,ktm_uid',
            'vehicle_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'stnk_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'ktm_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data['vehicle_photo'] = $request->file('vehicle_photo')->storeAs('vehicles', time() . '_vehicle_' . now()->timestamp . '.' . $request->file('vehicle_photo')->getClientOriginalExtension(), 'public');
        $data['stnk_photo'] = $request->file('stnk_photo')->storeAs('vehicles', time() . '_stnk_' . now()->timestamp . '.' . $request->file('stnk_photo')->getClientOriginalExtension(), 'public');
        $data['ktm_photo'] = $request->file('ktm_photo')->storeAs('vehicles', time() . '_ktm_' . now()->timestamp . '.' . $request->file('ktm_photo')->getClientOriginalExtension(), 'public');

        auth()->user()->vehicles()->create(array_merge($data, ['status' => 'pending']));

        return redirect()->route('user.vehicles.index')->with('success', 'Kendaraan berhasil diajukan.');
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicle = auth()->user()->vehicles()->findOrFail($vehicle->id);

        return view('user.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle = auth()->user()->vehicles()->findOrFail($vehicle->id);

        $data = $request->validate([
            'plate_number' => 'required|string|max:255',
            'stnk_number' => 'required|string|max:255',
            'ktm_uid' => 'required|string|max:255|unique:vehicles,ktm_uid,' . $vehicle->id,
            'vehicle_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'stnk_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ktm_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('vehicle_photo')) {
            if ($vehicle->vehicle_photo && Storage::disk('public')->exists($vehicle->vehicle_photo)) {
                Storage::disk('public')->delete($vehicle->vehicle_photo);
            }
            $data['vehicle_photo'] = $request->file('vehicle_photo')->storeAs('vehicles', time() . '_vehicle_' . now()->timestamp . '.' . $request->file('vehicle_photo')->getClientOriginalExtension(), 'public');
        }

        if ($request->hasFile('stnk_photo')) {
            if ($vehicle->stnk_photo && Storage::disk('public')->exists($vehicle->stnk_photo)) {
                Storage::disk('public')->delete($vehicle->stnk_photo);
            }
            $data['stnk_photo'] = $request->file('stnk_photo')->storeAs('vehicles', time() . '_stnk_' . now()->timestamp . '.' . $request->file('stnk_photo')->getClientOriginalExtension(), 'public');
        }

        if ($request->hasFile('ktm_photo')) {
            if ($vehicle->ktm_photo && Storage::disk('public')->exists($vehicle->ktm_photo)) {
                Storage::disk('public')->delete($vehicle->ktm_photo);
            }
            $data['ktm_photo'] = $request->file('ktm_photo')->storeAs('vehicles', time() . '_ktm_' . now()->timestamp . '.' . $request->file('ktm_photo')->getClientOriginalExtension(), 'public');
        }

        $data['status'] = 'pending';
        $vehicle->update($data);

        return redirect()->route('user.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui dan dikirim ulang untuk verifikasi.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle = auth()->user()->vehicles()->findOrFail($vehicle->id);

        foreach (['vehicle_photo', 'stnk_photo', 'ktm_photo'] as $attribute) {
            if ($vehicle->$attribute && Storage::disk('public')->exists($vehicle->$attribute)) {
                Storage::disk('public')->delete($vehicle->$attribute);
            }
        }

        $vehicle->delete();

        return redirect()->route('user.vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
