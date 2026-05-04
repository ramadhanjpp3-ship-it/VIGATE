@extends('admin.layouts.app')

@section('content')

<div class="card-box">

    <div class="d-flex align-items-center mb-4">
        <a href="/admin/vehicles" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div>
            <h4><i class="bi bi-plus-circle"></i> Add New Vehicle</h4>
            <p class="text-muted">Manually add a vehicle to the approved list</p>
        </div>
    </div>

    <form action="/admin/vehicles" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Vehicle Owner <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="plate_number" class="form-label">Plate Number <span class="text-danger">*</span></label>
                    <input type="text" name="plate_number" id="plate_number" class="form-control"
                           placeholder="e.g., B 1234 ABC" required>
                    <div class="form-text">Enter the vehicle license plate number</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stnk_number" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                    <input type="text" name="stnk_number" id="stnk_number" class="form-control"
                           placeholder="e.g., John Doe" required>
                    <div class="form-text">Enter the vehicle owner's name as per STNK</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ktm_uid" class="form-label">NFC UID <span class="text-danger">*</span></label>
                    <input type="text" name="ktm_uid" id="ktm_uid" class="form-control"
                           placeholder="e.g., ABC123DEF456" required>
                    <div class="form-text">Enter the NFC card UID for access control</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stnk_photo" class="form-label">STNK Photo</label>
                    <input type="file" name="stnk_photo" id="stnk_photo" class="form-control" accept="image/*">
                    <div class="form-text">Upload STNK photo (JPEG, PNG, JPG, GIF - Max 2MB)</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vehicle_photo" class="form-label">Vehicle Photo</label>
                    <input type="file" name="vehicle_photo" id="vehicle_photo" class="form-control" accept="image/*">
                    <div class="form-text">Upload vehicle photo (JPEG, PNG, JPG, GIF - Max 2MB)</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ktm_photo" class="form-label">KTM Photo</label>
                    <input type="file" name="ktm_photo" id="ktm_photo" class="form-control" accept="image/*">
                    <div class="form-text">Upload KTM photo (JPEG, PNG, JPG, GIF - Max 2MB)</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note:</strong> This vehicle will be automatically approved and added to the access control system.
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Add Vehicle
            </button>
            <a href="/admin/vehicles" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>

</div>

@endsection