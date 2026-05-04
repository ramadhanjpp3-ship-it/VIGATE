@extends('admin.layouts.app')

@section('content')

<div class="card-box">

    <div class="d-flex align-items-center mb-4">
        <a href="/admin/vehicles/{{ $vehicle->id }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back to Details
        </a>
        <div>
            <h4><i class="bi bi-pencil"></i> Edit Vehicle</h4>
            <p class="text-muted">Update information for {{ $vehicle->plate_number }}</p>
        </div>
    </div>

    <form action="/admin/vehicles/{{ $vehicle->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Vehicle Owner <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $vehicle->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="plate_number" class="form-label">Plate Number <span class="text-danger">*</span></label>
                    <input type="text" name="plate_number" id="plate_number" class="form-control"
                           placeholder="e.g., B 1234 ABC" value="{{ $vehicle->plate_number }}" required>
                    <div class="form-text">Enter the vehicle license plate number</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stnk_number" class="form-label">Owner STNK <span class="text-danger">*</span></label>
                    <input type="text" name="stnk_number" id="stnk_number" class="form-control"
                           placeholder="e.g., John Doe" value="{{ $vehicle->stnk_number }}" required>
                    <div class="form-text">Enter the vehicle owner's name as per STNK</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ktm_uid" class="form-label">NFC UID <span class="text-danger">*</span></label>
                    <input type="text" name="ktm_uid" id="ktm_uid" class="form-control"
                           placeholder="e.g., ABC123DEF456" value="{{ $vehicle->ktm_uid }}" required>
                    <div class="form-text">Enter the NFC card UID for access control</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stnk_photo" class="form-label">STNK Photo</label>
                    <input type="file" name="stnk_photo" id="stnk_photo" class="form-control" accept="image/*">
                    <div class="form-text">
                        Upload new STNK photo (JPEG, PNG, JPG, GIF - Max 2MB)
                        @if($vehicle->stnk_photo)
                            <br><small class="text-muted">Leave empty to keep current photo</small>
                        @endif
                    </div>
                    @if($vehicle->stnk_photo)
                        <div class="mt-2">
                            <small>Current:</small><br>
                            <img src="{{ asset('storage/' . $vehicle->stnk_photo) }}" alt="Current STNK" class="img-thumbnail mt-1" style="width: 100px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vehicle_photo" class="form-label">Vehicle Photo</label>
                    <input type="file" name="vehicle_photo" id="vehicle_photo" class="form-control" accept="image/*">
                    <div class="form-text">
                        Upload new vehicle photo (JPEG, PNG, JPG, GIF - Max 2MB)
                        @if($vehicle->vehicle_photo)
                            <br><small class="text-muted">Leave empty to keep current photo</small>
                        @endif
                    </div>
                    @if($vehicle->vehicle_photo)
                        <div class="mt-2">
                            <small>Current:</small><br>
                            <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}" alt="Current Vehicle" class="img-thumbnail mt-1" style="width: 100px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ktm_photo" class="form-label">KTM Photo</label>
                    <input type="file" name="ktm_photo" id="ktm_photo" class="form-control" accept="image/*">
                    <div class="form-text">
                        Upload new KTM photo (JPEG, PNG, JPG, GIF - Max 2MB)
                        @if($vehicle->ktm_photo)
                            <br><small class="text-muted">Leave empty to keep current photo</small>
                        @endif
                    </div>
                    @if($vehicle->ktm_photo)
                        <div class="mt-2">
                            <small>Current:</small><br>
                            <img src="{{ asset('storage/' . $vehicle->ktm_photo) }}" alt="Current KTM" class="img-thumbnail mt-1" style="width: 100px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Vehicle
            </button>
            <a href="/admin/vehicles/{{ $vehicle->id }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>

</div>

@endsection