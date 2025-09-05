@extends('layouts.guest')
@section('title', 'Reset Kata Sandi')
@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/logokota.png') }}" alt="Logo Kota" class="img-fluid mb-3 mx-auto" style="height: 40px; display: block;">
        <h3 class="fw-bold">Atur Ulang Kata Sandi</h3>
        <p class="text-muted">Buat kata sandi baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}"> {{-- Di Breeze, rutenya adalah password.store --}}
        @csrf

        <!-- Token reset password (wajib ada) -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autocomplete="email" readonly>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi Baru</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Reset Kata Sandi
            </button>
        </div>
    </form>
</div>
@endsection
