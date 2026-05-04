@extends('admin.layouts.app')

@section('content')

<div class="card-box">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div>
            <h4><i class="bi bi-person-lines-fill"></i> User Details</h4>
            <p class="text-muted">Detail informasi untuk {{ $user->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Account Information</h5>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>NIM:</strong> {{ $user->nim ?? '-' }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Created at:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Last updated:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list-check"></i> Back to User List
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
