@extends('admin.layouts.app')

@section('content')

<div class="card-box">

<h4>Gate Devices</h4>

<div class="table-responsive">
    <table class="table">
        <tr>
            <th>Gate</th>
            <th>IP</th>
            <th>Status</th>
        </tr>

@foreach($gates as $g)
<tr>
    <td>{{ $g->name }}</td>
    <td>{{ $g->device_ip }}</td>
    <td>
        <span class="badge bg-{{ $g->status=='active'?'success':'secondary' }}">
            {{ $g->status }}
        </span>
    </td>
</tr>
@endforeach
        </table>
    </div>

</div>

@endsection