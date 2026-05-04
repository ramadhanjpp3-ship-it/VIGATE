@extends('admin.layouts.app')

@section('content')

<div class="card-box">

<h4>Log Detail</h4>

<p><b>NFC:</b> {{ $log->nfc_uid }}</p>
<p><b>Status:</b> {{ $log->status }}</p>

<div class="row mt-3">
    <div class="col-12">
        <h6>Capture</h6>
        @if($log->vehicle_image || $log->face_image)
            <img src="{{ asset('storage/' . ($log->vehicle_image ?? $log->face_image)) }}"
                class="img-fluid rounded shadow-sm"
                style="cursor: pointer; max-height: 360px;"
                onclick="showImageModal('{{ asset('storage/' . ($log->vehicle_image ?? $log->face_image)) }}', 'Capture Preview')"
                alt="Capture Image">
        @else
            <span class="text-muted">Tidak ada capture tersedia.</span>
        @endif
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