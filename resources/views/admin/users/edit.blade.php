@extends('admin.layout')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-user-edit"></i> Edit Pelanggan</h1>
</div>

<div class="card p-4">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Kota</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control">
        </div>

        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>

@endsection
