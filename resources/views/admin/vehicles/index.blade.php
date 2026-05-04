@extends('admin.layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4><i class="bi bi-car-front"></i> Vehicle Management</h4>
            <p class="text-muted">Manage approved vehicles and add new ones manually</p>
        </div>
        <a href="/admin/vehicles/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Vehicle
        </a>
    </div>

    @if($vehicles->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>User</th>
                <th>Plate Number</th>
                <th>Owner STNK</th>
                <th>NFC UID</th>
                <th>STNK Photo</th>
                <th>Vehicle Photo</th>
                <th>KTM Photo</th>
                <th>Status</th>
                <th>Approved Date</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach($vehicles as $v)
            <tr>
                <td>
                    <strong>{{ $v->user->name }}</strong><br>
                    <small class="text-muted">{{ $v->user->email }}</small>
                </td>
                <td><code>{{ $v->plate_number }}</code></td>
                <td>{{ $v->stnk_number }}</td>
                <td><code>{{ $v->ktm_uid }}</code></td>
                <td>
                    @if($v->stnk_photo)
                        <img src="{{ asset('storage/' . $v->stnk_photo) }}" alt="STNK" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $v->stnk_photo) }}', 'STNK - {{ $v->plate_number }}')">
                    @else
                        <span class="text-muted">No photo</span>
                    @endif
                </td>
                <td>
                    @if($v->vehicle_photo)
                        <img src="{{ asset('storage/' . $v->vehicle_photo) }}" alt="Vehicle" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $v->vehicle_photo) }}', 'Vehicle - {{ $v->plate_number }}')">
                    @else
                        <span class="text-muted">No photo</span>
                    @endif
                </td>
                <td>
                    @if($v->ktm_photo)
                        <img src="{{ asset('storage/' . $v->ktm_photo) }}" alt="KTM" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $v->ktm_photo) }}', 'KTM - {{ $v->plate_number }}')">
                    @else
                        <span class="text-muted">No photo</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle"></i> Approved
                    </span>
                </td>
                <td>{{ $v->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                <td>
                    <a href="/admin/vehicles/{{ $v->id }}" class="btn btn-outline-primary btn-sm" title="View Details">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/vehicles/{{ $v->id }}/edit" class="btn btn-outline-warning btn-sm ms-1" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-outline-danger btn-sm ms-1" title="Delete" onclick="confirmDelete({{ $v->id }}, '{{ $v->plate_number }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <small class="text-muted">Total: {{ $vehicles->count() }} approved vehicles</small>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
        <h5 class="mt-3">No Approved Vehicles</h5>
        <p class="text-muted">No vehicles have been approved yet. Add your first vehicle manually.</p>
        <a href="/admin/vehicles/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add First Vehicle
        </a>
    </div>
    @endif

</div>

@endsection

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