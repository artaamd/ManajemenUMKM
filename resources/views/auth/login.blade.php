@extends('layouts.guest')
@section('title', 'Login UMKM')
@section('content')
    <div class="auth-card">
         <!-- Judul dan Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logokota.png') }}" alt="Logo Kota" class="img-fluid mb-3 mx-auto" style="height: 40px; display: block;">
            <h3 class="fw-bold">Selamat Datang</h3>
            <p class="text-muted">Masuk atau daftar sebagai UMKM</p>
        </div>
        <!-- Tab Navigasi -->
        <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Masuk</button>
            </li>
            <li class="nav-item" role="tabpanel">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Registrasi</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="authTabContent">
            <!-- Form Login -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->has('email'))
                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
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
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
                <div class="text-center mt-3">
                   <!-- <a href="{{ route('password.request') }}" class="text-primary">Lupa Kata Sandi?</a> -->
                </div>
            </div>

            <!-- Form Registrasi -->
            <div class="tab-pane fade" id="register" role="tabpanel">
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

            <!-- Tombol Login sebagai Admin -->
            <div class="text-center mt-4">
                <a href="{{ route('admin.login') }}" class="btn btn-outline-primary">Masuk sebagai Admin</a>
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

            // Hapus script toggle NIB yang sudah tidak diperlukan
        </script>
    @endpush
@endsection