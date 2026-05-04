@extends('user.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4><i class="bi bi-clock-history"></i> Access History</h4>

            @if($logs->isEmpty())
                <p class="mt-3">Belum ada riwayat akses untuk akun Anda.</p>
            @else
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <!-- <th>Gate</th> -->
                            <th>Time</th>
                            <th>Status</th>
                            <!-- <th>Foto Wajah</th> -->
                            <th>Capture</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <!-- <td>{{ $log->gate->name ?? '-' }}</td> -->
                            <td>{{ $log->created_at }}</td>
                            <td>
                                <span class="badge bg-{{ $log->status === 'allowed' ? 'success' : 'danger' }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <!-- <td>
                                @if($log->face_image)
                                    <img src="{{ asset('storage/' . $log->face_image) }}" alt="Face Image" class="img-fluid rounded" style="max-height: 100px;" />
                                @else
                                    -
                                @endif
                            </td> -->
                            <td>
                                @if($log->vehicle_image)
                                    <img src="{{ asset('storage/' . $log->vehicle_image) }}" alt="Vehicle Image" class="img-fluid rounded" style="max-height: 100px; cursor: pointer;" onclick="showImageModal('{{ asset('storage/' . $log->vehicle_image) }}', 'Capture Preview')" />
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="captureModal" tabindex="-1" aria-labelledby="captureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="captureModalLabel">Capture Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-3">
                <img id="captureModalImage" src="" alt="Capture Preview" class="img-fluid rounded" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

<script>
    function showImageModal(imageSrc, title) {
        document.getElementById('captureModalImage').src = imageSrc;
        document.getElementById('captureModalLabel').textContent = title;
        const myModal = new bootstrap.Modal(document.getElementById('captureModal'));
        myModal.show();
    }
</script>

@endsection
