@extends('layouts.app')
@section('title', 'Edit UMKM')
@section('content')
    <div class="">
        <div class="card">
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
                <form method="POST" action="{{ route('umkm.update', $umkm->id) }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama UMKM</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $umkm->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $umkm->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <select class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="Kota Tengah" {{ old('lokasi', $umkm->lokasi) == 'Kota Tengah' ? 'selected' : '' }}>Kota Tengah</option>
                            <option value="Kota Selatan" {{ old('lokasi', $umkm->lokasi) == 'Kota Selatan' ? 'selected' : '' }}>Kota Selatan</option>
                            <option value="Kota Barat" {{ old('lokasi', $umkm->lokasi) == 'Kota Barat' ? 'selected' : '' }}>Kota Barat</option>
                            <option value="Kota Timur" {{ old('lokasi', $umkm->lokasi) == 'Kota Timur' ? 'selected' : '' }}>Kota Timur</option>
                            <option value="Hulonthalangi" {{ old('lokasi', $umkm->lokasi) == 'Hulonthalangi' ? 'selected' : '' }}>Hulonthalangi</option>
                            <option value="Dungingi" {{ old('lokasi', $umkm->lokasi) == 'Dungingi' ? 'selected' : '' }}>Dungingi</option>
                            <option value="Dumbo Raya" {{ old('lokasi', $umkm->lokasi) == 'Dumbo Raya' ? 'selected' : '' }}>Dumbo Raya</option>
                            <option value="Kota Utara" {{ old('lokasi', $umkm->lokasi) == 'Kota Utara' ? 'selected' : '' }}>Kota Utara</option>
                            <option value="Sipatana" {{ old('lokasi', $umkm->lokasi) == 'Sipatana' ? 'selected' : '' }}>Sipatana</option>
                        </select>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nib" class="form-label">Nomor Induk Berusaha (NIB) (Opsional)</label>
                        <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib', $umkm->nib) }}" maxlength="13">
                    </div>
                    <div class="mb-3">
                        <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                        <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook', $umkm->akun_facebook) }}">
                    </div>
                    <div class="mb-3">
                        <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                        <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram', $umkm->akun_instagram) }}">
                    </div>
                    <div class="mb-3">
                        <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                        <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="{{ old('total_pengikut_facebook', $umkm->total_pengikut_facebook) }}" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                        <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="{{ old('total_pengikut_instagram', $umkm->total_pengikut_instagram) }}" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('laporan.umkm') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection