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
    <div class="col-md-8">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-car-front-fill"></i> Manajemen Kendaraan</h4>

            @if($vehicle)
                <div class="mb-4">
                    <h5>Status Kendaraan</h5>
                    <p class="mb-1"><strong>Plat Nomor:</strong> {{ $vehicle->plate_number }}</p>
                    <p class="mb-1"><strong>Owner STNK:</strong> {{ $vehicle->stnk_number }}</p>
                    <p class="mb-1"><strong>UID NFC (KTM):</strong> {{ $vehicle->ktm_uid }}</p>
                    <p class="mb-1">Status: 
                        <span class="badge bg-{{ $vehicle->status === 'approved' ? 'success' : ($vehicle->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card-box">
                            <h6>Foto Kendaraan</h6>
                            @if($vehicle->vehicle_photo)
                                <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}" alt="Foto Kendaraan" class="img-fluid rounded" style="cursor:pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->vehicle_photo) }}', 'Foto Kendaraan')" />
                            @else
                                <p class="text-muted">Belum tersedia</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-box">
                            <h6>Foto STNK</h6>
                            @if($vehicle->stnk_photo)
                                <img src="{{ asset('storage/' . $vehicle->stnk_photo) }}" alt="Foto STNK" class="img-fluid rounded" style="cursor:pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->stnk_photo) }}', 'Foto STNK')" />
                            @else
                                <p class="text-muted">Belum tersedia</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card-box">
                            <h6>Foto KTM</h6>
                            @if($vehicle->ktm_photo)
                                <img src="{{ asset('storage/' . $vehicle->ktm_photo) }}" alt="Foto KTM" class="img-fluid rounded" style="cursor:pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->ktm_photo) }}', 'Foto KTM')" />
                            @else
                                <p class="text-muted">Belum tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('user.vehicles.edit', $vehicle) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit kendaraan
                    </a>
                    <form action="{{ route('user.vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus kendaraan
                        </button>
                    </form>
                </div>
            @else
                <p>Anda belum memiliki kendaraan terdaftar.</p>
                <a href="{{ route('user.vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kendaraan
                </a>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h5>Petunjuk</h5>
            <p>Lengkapi data kendaraan Anda untuk diajukan ke admin. Hanya 1 kendaraan per pengguna yang dapat ditambahkan.</p>
            <p>Setelah dikirim, status akan berubah menjadi <strong>pending</strong> sampai admin memverifikasi.</p>
        </div>
        <!-- <div class="card-box">
            <h5>Langkah Cepat</h5>
            <ul class="list-unstyled">
                <li><i class="bi bi-check-circle-fill text-success"></i> Ajukan kendaraan</li>
                <li><i class="bi bi-clock-history text-warning"></i> Tunggu verifikasi admin</li>
                <li><i class="bi bi-person-circle text-primary"></i> Lengkapi profil</li>
            </ul>
        </div> -->
    </div>
</div>
<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 500px;" />
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(src, title) {
    document.getElementById('previewImage').src = src;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection
