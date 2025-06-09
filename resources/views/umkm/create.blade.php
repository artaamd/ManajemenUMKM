@extends('layouts.guest')
@section('title', 'Registrasi UMKM')
@section('content')
    <div class="auth-card">
        <h3 class="fw-bold text-center mb-4">Daftar UMKM</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('umkm.store') }}" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama UMKM</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select class="form-control" id="lokasi" name="lokasi" required>
                    <option value="">Pilih Kecamatan</option>
                    <option value="Kota Tengah" {{ old('lokasi') == 'Kota Tengah' ? 'selected' : '' }}>Kota Tengah</option>
                    <option value="Kota Selatan" {{ old('lokasi') == 'Kota Selatan' ? 'selected' : '' }}>Kota Selatan</option>
                    <option value="Kota Barat" {{ old('lokasi') == 'Kota Barat' ? 'selected' : '' }}>Kota Barat</option>
                    <option value="Kota Timur" {{ old('lokasi') == 'Kota Timur' ? 'selected' : '' }}>Kota Timur</option>
                    <option value="Hulonthalangi" {{ old('lokasi') == 'Hulonthalangi' ? 'selected' : '' }}>Hulonthalangi</option>
                    <option value="Dungingi" {{ old('lokasi') == 'Dungingi' ? 'selected' : '' }}>Dungingi</option>
                    <option value="Dumbo Raya" {{ old('lokasi') == 'Dumbo Raya' ? 'selected' : '' }}>Dumbo Raya</option>
                    <option value="Kota Utara" {{ old('lokasi') == 'Kota Utara' ? 'selected' : '' }}>Kota Utara</option>
                    <option value="Sipatana" {{ old('lokasi') == 'Sipatana' ? 'selected' : '' }}>Sipatana</option>
                </select>
                <div class="invalid-feedback">Lokasi wajib dipilih.</div>
            </div>
            <div class="mb-3">
                <label for="nib" class="form-label">Nomor Induk Berusaha (NIB) (Opsional)</label>
                <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib') }}" maxlength="13">
            </div>
            <div class="mb-3">
                <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook') }}">
            </div>
            <div class="mb-3">
                <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram') }}">
            </div>
            <div class="mb-3">
                <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="{{ old('total_pengikut_facebook', 0) }}" min="0">
            </div>
            <div class="mb-3">
                <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="{{ old('total_pengikut_instagram', 0) }}" min="0">
            </div>
            <input type="hidden" name="role" value="umkm">
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
    </div>
@endsection