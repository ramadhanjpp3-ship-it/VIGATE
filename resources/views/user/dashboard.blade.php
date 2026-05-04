@extends('user.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
</div>

<div class="row g-3 dashboard-summary">
    <div class="col-12 col-md-6">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-person-circle"></i> Profil Anda</h4>
            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p><strong>NIM:</strong> {{ auth()->user()->nim }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Telepon:</strong> {{ auth()->user()->phone }}</p>
            <a href="/user/profile" class="btn btn-outline-primary mt-3">
                <i class="bi bi-pencil"></i> Perbarui Profil
            </a>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-car-front-fill"></i> Kendaraan Anda</h4>

            @if($vehicle)
                <p><strong>Plat Nomor:</strong> {{ $vehicle->plate_number }}</p>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $vehicle->status === 'approved' ? 'success' : ($vehicle->status === 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($vehicle->status) }}
                    </span>
                </p>
                <a href="/user/vehicles" class="btn btn-primary mt-2">
                    <i class="bi bi-eye"></i> Lihat Kendaraan
                </a>
            @else
                <p>Belum ada kendaraan yang terdaftar.</p>
                <a href="/user/vehicles/create" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Tambah Kendaraan
                </a>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-clock-history"></i> Riwayat Akses</h4>
            <p>Anda memiliki <strong>{{ $historyCount }}</strong> entri akses palang.</p>
            <a href="/user/history" class="btn btn-outline-primary">
                <i class="bi bi-arrow-right"></i> Lihat History Akses
            </a>
        </div>
    </div>
</div>

@endsection