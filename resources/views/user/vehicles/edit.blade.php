@extends('user.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-pencil-square"></i> Ubah Kendaraan</h4>

            <form method="POST" action="{{ route('user.vehicles.update', $vehicle) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Plat Nomor</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" class="form-control @error('plate_number') is-invalid @enderror" required>
                    @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Owner STNK</label>
                    <input type="text" name="stnk_number" value="{{ old('stnk_number', $vehicle->stnk_number) }}" class="form-control @error('stnk_number') is-invalid @enderror" required>
                    @error('stnk_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">UID NFC (KTM)</label>
                    <input type="text" name="ktm_uid" value="{{ old('ktm_uid', $vehicle->ktm_uid) }}" class="form-control @error('ktm_uid') is-invalid @enderror" required>
                    @error('ktm_uid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Plat / Kendaraan (opsional)</label>
                    <input type="file" name="vehicle_photo" class="form-control @error('vehicle_photo') is-invalid @enderror">
                    @error('vehicle_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto STNK (opsional)</label>
                    <input type="file" name="stnk_photo" class="form-control @error('stnk_photo') is-invalid @enderror">
                    @error('stnk_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto KTM (opsional)</label>
                    <input type="file" name="ktm_photo" class="form-control @error('ktm_photo') is-invalid @enderror">
                    @error('ktm_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
