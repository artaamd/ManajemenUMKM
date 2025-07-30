@extends('layouts.app')
@section('title', 'Registrasi UMKM')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title fw-bold text-primary">Selamat Datang</h2>
                        <p class="text-muted">Masuk atau daftar sebagai UMKM</p>
                    </div>

                    {{-- Form Awal --}}
                    <form action="{{ route('umkm.store') }}" method="POST">
                        @csrf
                        <div class="row">

                            {{-- =================== KOLOM KIRI =================== --}}
                            <div class="col-md-6">
                                <h5 class="mb-3 text-secondary">Informasi Bisnis</h5>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama UMKM</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nib" class="form-label">Nomor Induk Berusaha (NIB) <span class="text-muted">(Opsional)</span></label>
                                    <input type="text" class="form-control" id="nib" name="nib">
                                </div>

                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Pilih Kecamatan</label>
                                    <select class="form-select" id="kecamatan" name="kecamatan" required>
                                        {{-- Tambahkan pilihan kecamatan di sini --}}
                                        <option value="Dungingi">Dungingi</option>
                                        <option value="Dumbo Raya">Dumbo Raya</option>
                                        <option value="Hulonthalangi">Hulonthalangi</option>
                                        <option value="Kota Barat">Kota Barat</option>
                                        <option value="Kota Selatan">Kota Selatan</option>
                                        <option value="Kota Tengah">Kota Tengah</option>
                                        <option value="Kota Timur">Kota Timur</option>
                                        <option value="Kota Utara">Kota Utara</option>
                                        <option value="Sipatana">Sipatana</option>
                                    </select>
                                </div>
                            </div>

                            {{-- =================== KOLOM KANAN =================== --}}
                            <div class="col-md-6">
                                <h5 class="mb-3 text-secondary">Informasi Akun</h5>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        {{-- =================== BARIS BARU UNTUK SOSIAL MEDIA =================== --}}
                        <hr class="my-4">
                        <div class="row">
                            <h5 class="mb-3 text-secondary">Informasi Sosial Media</h5>
                            <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                                    <input type="url" class="form-control" id="akun_facebook" name="akun_facebook">
                                </div>
                                <div class="mb-3">
                                    <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                                    <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                                    <input type="url" class="form-control" id="akun_instagram" name="akun_instagram">
                                </div>
                                <div class="mb-3">
                                    <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                                    <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="0">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Daftar --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                         <a href="{{ route('login') }}">Sudah punya akun? Login</a> | <a href="{{ route('admin.login') }}">Login sebagai Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection