@extends('admin.layouts.app')

@section('content')

<div class="card-box">

<h4>Access Logs</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ session('info') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form method="GET" action="{{ url()->current() }}" class="d-flex mb-3 gap-2">
    <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari log...">
    <button type="submit" class="btn btn-primary">Cari</button>
</form>

<form id="bulk-delete-form" method="POST" action="/admin/logs">
    @csrf
    @method('DELETE')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button type="submit" name="delete_selected" class="btn btn-danger btn-sm" onclick="return confirm('Hapus log terpilih?');">Hapus Terpilih</button>
            <button type="submit" name="delete_all" value="1" class="btn btn-outline-danger btn-sm ms-2" onclick="return confirm('Hapus semua log?');">Hapus Semua</button>
        </div>
        <div class="text-muted">Menampilkan {{ $logs->total() }} log</div>
    </div>

    <div class="table-responsive">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>User</th>
                    <th>NFC</th>
                    <!-- <th>Gate</th> -->
                    <th>Status</th>
                    <th>Time</th>
                    <th>Detail</th>
                </tr>
            </thead>
        <tbody>

@foreach($logs as $log)
<tr>
    <td><input type="checkbox" name="ids[]" value="{{ $log->id }}"></td>
    <td>{{ $log->user->name ?? '-' }}</td>
    <td>{{ $log->nfc_uid }}</td>
    <!-- <td>{{ $log->gate->name ?? '-' }}</td> -->
    <td>
        <span class="badge bg-{{ $log->status=='allowed' ? 'success':'danger' }}">
            {{ $log->status }}
        </span>
    </td>
    <td>{{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
    <td>
        <a href="/admin/logs/{{ $log->id }}" class="btn btn-primary btn-sm">
            View
        </a>
    </td>
</tr>
@endforeach
            </tbody>
        </table>
    </div>
</form>

<div class="mt-3">
    {{ $logs->withQueryString()->links() }}
</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                document.querySelectorAll('input[name="ids[]"]').forEach(function (checkbox) {
                    checkbox.checked = selectAll.checked;
                });
            });
        }
    });
</script>

@endsection