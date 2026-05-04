@extends('admin.layouts.app')

@section('content')

<div class="card-box">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4>Users</h4>
            <p class="text-muted mb-0">Lihat dan kelola daftar pengguna aplikasi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>NIM</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nim ?? '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada user yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection