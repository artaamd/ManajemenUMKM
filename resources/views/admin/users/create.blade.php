@extends('layouts.app')
@section('title', 'Tambah Pengguna UMKM Baru')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0"><i class="bi bi-person-plus-fill me-2"></i>Formulir Pendaftaran UMKM oleh Admin</h4>
    </div>
    <div class="card-body p-4">
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
            
            {{-- Bagian Informasi Wajib --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-bold">Nama UMKM</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-bold">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="lokasi" class="form-label fw-bold">Lokasi (Kecamatan)</label>
                    {{-- Menambahkan semua opsi kecamatan --}}
                    <select class="form-select" id="lokasi" name="lokasi" required>
                        <option value="" disabled selected>Pilih Kecamatan...</option>
                        <option value="Kota Tengah">Kota Tengah</option>
                        <option value="Kota Selatan">Kota Selatan</option>
                        <option value="Kota Barat">Kota Barat</option>
                        <option value="Kota Timur">Kota Timur</option>
                        <option value="Hulonthalangi">Hulonthalangi</option>
                        <option value="Dungingi">Dungingi</option>
                        <option value="Dumbo Raya">Dumbo Raya</option>
                        <option value="Kota Utara">Kota Utara</option>
                        <option value="Sipatana">Sipatana</option>
                    </select>
                </div>
            </div>
            
            {{-- Bagian Informasi Opsional --}}
            <hr class="my-4">
            <h5 class="text-muted mb-3">Informasi Tambahan (Opsional)</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nib" class="form-label">NIB</label>
                    <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                    <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook') }}">
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                    <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram') }}">
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('laporan.umkm') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Perbaikan untuk dropdown yang terpotong */
    .card-body {
        overflow: visible !important;
    }
</style>
@endpush
