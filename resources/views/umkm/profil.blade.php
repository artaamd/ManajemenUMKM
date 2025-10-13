@extends('layouts.app')
@section('title', 'Profil UMKM')
@section('content')

    <div class="container-fluid p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi UMKM</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- ======================================================= --}}
                        {{-- BLOK BARU YANG DITAMBAHKAN --}}
                        {{-- ======================================================= --}}
                        @if (session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- ======================================================= --}}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            
                        <form method="POST" action="{{ route('umkm.updateProfil') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="name" class="form-label">Nama UMKM</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    <div class="invalid-feedback">Nama UMKM wajib diisi.</div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    <div class="invalid-feedback">Email wajib diisi dan valid.</div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="password" class="form-label">Password Baru (opsional)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="invalid-feedback">Password minimal 8 karakter.</div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <select class="form-control" id="lokasi" name="lokasi" required>
                                        <option value="">Pilih Kecamatan</option>
                                        <option value="Kota Tengah" {{ old('lokasi', $user->lokasi) == 'Kota Tengah' ? 'selected' : '' }}>Kota Tengah</option>
                                        <option value="Kota Selatan" {{ old('lokasi', $user->lokasi) == 'Kota Selatan' ? 'selected' : '' }}>Kota Selatan</option>
                                        <option value="Kota Barat" {{ old('lokasi', $user->lokasi) == 'Kota Barat' ? 'selected' : '' }}>Kota Barat</option>
                                        <option value="Kota Timur" {{ old('lokasi', $user->lokasi) == 'Kota Timur' ? 'selected' : '' }}>Kota Timur</option>
                                        <option value="Hulonthalangi" {{ old('lokasi', $user->lokasi) == 'Hulonthalangi' ? 'selected' : '' }}>Hulonthalangi</option>
                                        <option value="Dungingi" {{ old('lokasi', $user->lokasi) == 'Dungingi' ? 'selected' : '' }}>Dungingi</option>
                                        <option value="Dumbo Raya" {{ old('lokasi', $user->lokasi) == 'Dumbo Raya' ? 'selected' : '' }}>Dumbo Raya</option>
                                        <option value="Kota Utara" {{ old('lokasi', $user->lokasi) == 'Kota Utara' ? 'selected' : '' }}>Kota Utara</option>
                                        <option value="Sipatana" {{ old('lokasi', $user->lokasi) == 'Sipatana' ? 'selected' : '' }}>Sipatana</option>
                                    </select>
                                    <div class="invalid-feedback">Lokasi wajib dipilih.</div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="nib" class="form-label">Nomor Induk Berusaha (NIB) (Opsional)</label>
                                    <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib', $user->nib) }}" maxlength="13">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                                    <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook', $user->akun_facebook) }}">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                                    <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram', $user->akun_instagram) }}">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                                    <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="{{ old('total_pengikut_facebook', $user->total_pengikut_facebook ?? 0) }}" min="0">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                                    <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="{{ old('total_pengikut_instagram', $user->total_pengikut_instagram ?? 0) }}" min="0">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="profile_image" class="form-label">Foto Profil/Logo UMKM</label>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                    @if ($user->profile_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto Profil UMKM" style="max-width: 100px; height: auto;" class="rounded">
                                        </div>
                                    @endif
                                    @error('profile_image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Bootstrap validation
            (function () {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        </script>
    @endpush
@endsection

