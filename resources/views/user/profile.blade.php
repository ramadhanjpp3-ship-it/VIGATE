@extends('user.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        @if(session('status') === 'profile-updated')
            <div class="alert alert-success">Profil berhasil diperbarui.</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mb-3"><i class="bi bi-person-circle"></i> Profil User</h4>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim', auth()->user()->nim) }}" class="form-control @error('nim') is-invalid @enderror" required>
                    @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control @error('phone') is-invalid @enderror" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-save"></i> Simpan Profil
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
