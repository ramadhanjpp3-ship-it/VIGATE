@extends('admin.layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-box">

    <h4><i class="bi bi-car-front"></i> Pending Vehicle Approval</h4>
    <p class="text-muted">Review and approve or reject vehicle registration requests</p>

    @if($vehicles->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th>User</th>
                <th>Plate Number</th>
                <th>Owner</th>
                <th>NFC UID</th>
                <th>STNK Photo</th>
                <th>Vehicle Photo</th>
                <th>Requested Date</th>
                <th>Action</th>
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
            <td>{{ $v->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
            <td>
                <form method="POST" action="/admin/vehicles/{{ $v->id }}/approve" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                </form>

                <form method="POST" action="/admin/vehicles/{{ $v->id }}/reject" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm ms-1">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
        <h5 class="mt-3">No Pending Approvals</h5>
        <p class="text-muted">All vehicle registration requests have been processed.</p>
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

<script>
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>