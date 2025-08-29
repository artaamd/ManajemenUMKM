@extends('layouts.app')
@section('title', 'Tambah Pengguna UMKM Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Formulir Pendaftaran UMKM oleh Admin</h4>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            {{-- Nama UMKM --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama UMKM</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            {{-- Lokasi --}}
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select class="form-control" id="lokasi" name="lokasi" required>
                    <option value="">Pilih Kecamatan</option>
                    <option value="Kota Tengah">Kota Tengah</option>
                    <option value="Kota Selatan">Kota Selatan</option>
                    {{-- Tambahkan pilihan kecamatan lainnya --}}
                </select>
            </div>
            
            {{-- Kolom Opsional Lainnya --}}
            <hr>
            <p class="text-muted">Informasi Tambahan (Opsional)</p>
             <div class="mb-3">
                <label for="nib" class="form-label">NIB</label>
                <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib') }}">
            </div>
            <div class="mb-3">
                <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook') }}">
            </div>
            <div class="mb-3">
                <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="{{ old('total_pengikut_facebook', 0) }}" min="0">
            </div>
             <div class="mb-3">
                <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram') }}">
            </div>
             <div class="mb-3">
                <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="{{ old('total_pengikut_instagram', 0) }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            <a href="{{ route('laporan.umkm') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection