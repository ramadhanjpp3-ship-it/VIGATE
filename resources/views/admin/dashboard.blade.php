@extends('admin.layouts.app')

@section('content')

<div class="dashboard-summary">

    <div class="dashboard-card">
        <div class="card-box">
            <h6>Total Pengguna</h6>
            <h3>{{ $totalUsers }}</h3>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-box">
            <h6>Total Kendaraan</h6>
            <h3>{{ $totalVehicles }}</h3>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-box">
            <h6>Request Approval</h6>
            <h3>{{ $pendingVehicles }}</h3>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-box">
            <h6>Total Log</h6>
            <h3>{{ $totalLogs }}</h3>
        </div>
    </div>

    <!-- <div class="col-md-3">
        <div class="card-box">
            <h6>Gate Active</h6>
            <h3>{{ $activeGates }}</h3>
        </div>
    </div> -->

</div>

<!-- RECENT ACTIVITY -->
<div class="card-box mt-4">

    <h5>Log Akses Terbaru</h5>

    <div class="table-responsive">
        <table class="table table-sm table-hover mt-3">
        <tr>
            <th>User</th>
            <th>NFC</th>
            <th>Status</th>
            <th>Time</th>
        </tr>

        @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->name ?? '-' }}</td>
            <td>{{ $log->nfc_uid }}</td>
            <td>
                @if($log->status=='allowed')
                    <span class="badge bg-success">Allowed</span>
                @else
                    <span class="badge bg-danger">Rejected</span>
                @endif
            </td>
            <td>{{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
        </tr>
        @endforeach
        </table>
    </div>

</div>

@endsection