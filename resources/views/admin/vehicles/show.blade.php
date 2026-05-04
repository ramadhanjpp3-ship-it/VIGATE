@extends('admin.layouts.app')

@section('content')

<div class="card-box">

    <div class="d-flex align-items-center mb-4">
        <a href="/admin/vehicles" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back to Vehicles
        </a>
        <div>
            <h4><i class="bi bi-car-front"></i> Vehicle Details</h4>
            <p class="text-muted">Complete information for {{ $vehicle->plate_number }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Owner:</strong> {{ $vehicle->user->name }}</p>
                            <p><strong>Email:</strong> {{ $vehicle->user->email }}</p>
                            <p><strong>Plate Number:</strong> <code>{{ $vehicle->plate_number }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Owner STNK:</strong> {{ $vehicle->stnk_number }}</p>
                            <p><strong>NFC UID:</strong> <code>{{ $vehicle->ktm_uid }}</code></p>
                            <p><strong>Status:</strong>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> {{ ucfirst($vehicle->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $vehicle->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Last Updated:</strong> {{ $vehicle->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <a href="/admin/vehicles/{{ $vehicle->id }}/edit" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-pencil"></i> Edit Vehicle
                    </a>
                    <button class="btn btn-danger w-100" onclick="confirmDelete({{ $vehicle->id }}, '{{ $vehicle->plate_number }}')">
                        <i class="bi bi-trash"></i> Delete Vehicle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">STNK Photo</h5>
                </div>
                <div class="card-body text-center">
                    @if($vehicle->stnk_photo)
                        <img src="{{ asset('storage/' . $vehicle->stnk_photo) }}" alt="STNK Photo" class="img-fluid rounded" style="max-height: 300px; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->stnk_photo) }}', 'STNK - {{ $vehicle->plate_number }}')">
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No STNK photo available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">KTM Photo</h5>
                </div>
                <div class="card-body text-center">
                    @if($vehicle->ktm_photo)
                        <img src="{{ asset('storage/' . $vehicle->ktm_photo) }}" alt="KTM Photo" class="img-fluid rounded" style="max-height: 300px; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->ktm_photo) }}', 'KTM - {{ $vehicle->plate_number }}')">
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No KTM photo available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vehicle Photo</h5>
                </div>
                <div class="card-body text-center">
                    @if($vehicle->vehicle_photo)
                        <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}" alt="Vehicle Photo" class="img-fluid rounded" style="max-height: 300px; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $vehicle->vehicle_photo) }}', 'Vehicle - {{ $vehicle->plate_number }}')">
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No vehicle photo available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete vehicle with plate number <strong id="deletePlateNumber"></strong>?
                <br><small class="text-muted">This action cannot be undone.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Vehicle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function confirmDelete(vehicleId, plateNumber) {
    document.getElementById('deletePlateNumber').textContent = plateNumber;
    document.getElementById('deleteForm').action = '/admin/vehicles/' + vehicleId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

@endsection