@extends('user.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-plus-circle"></i> Tambah Kendaraan</h4>

            <form method="POST" action="{{ route('user.vehicles.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Plat Nomor</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}" class="form-control @error('plate_number') is-invalid @enderror" required>
                    @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Owner STNK</label>
                    <input type="text" name="stnk_number" value="{{ old('stnk_number') }}" class="form-control @error('stnk_number') is-invalid @enderror" required>
                    @error('stnk_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">UID NFC (KTM)</label>
                    <input type="text" name="ktm_uid" value="{{ old('ktm_uid') }}" class="form-control @error('ktm_uid') is-invalid @enderror" required>
                    @error('ktm_uid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Plat / Kendaraan</label>
                    <input type="file" name="vehicle_photo" class="form-control @error('vehicle_photo') is-invalid @enderror" required>
                    @error('vehicle_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto STNK</label>
                    <input type="file" name="stnk_photo" class="form-control @error('stnk_photo') is-invalid @enderror" required>
                    @error('stnk_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto KTM</label>
                    <input type="file" name="ktm_photo" class="form-control @error('ktm_photo') is-invalid @enderror" required>
                    @error('ktm_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-send"></i> Kirim Kendaraan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
