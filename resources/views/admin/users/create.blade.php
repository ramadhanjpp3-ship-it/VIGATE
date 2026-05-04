@extends('admin.layouts.app')

@section('content')

<div class="card-box">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div>
            <h4><i class="bi bi-person-plus"></i> Add New User</h4>
            <p class="text-muted">Create a new user account for the application.</p>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection
