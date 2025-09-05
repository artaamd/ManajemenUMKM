@extends('layouts.guest')
@section('title', 'Lupa Kata Sandi')
@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/logokota.png') }}" alt="Logo Kota" class="img-fluid mb-3 mx-auto" style="height: 40px; display: block;">
        <h3 class="fw-bold">Lupa Kata Sandi</h3>
        <p class="text-muted">Masukkan email Anda. Kami akan mengirimkan link untuk mengatur ulang kata sandi Anda.</p>
    </div>

    <!-- Menampilkan pesan status setelah email dikirim -->
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                Kirim Link Reset Kata Sandi
            </button>
        </div>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-primary">Kembali ke Halaman Masuk</a>
    </div>
</div>
@endsection
