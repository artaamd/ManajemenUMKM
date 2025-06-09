@extends('layouts.guest')
@section('title', 'Login Admin')
@section('content')
    <div class="auth-card">
        <!-- Judul -->
        <div class="text-center mb-4">
            <h3 class="fw-bold">Login Admin</h3>
            <p class="text-muted">Masuk ke dashboard admin</p>
        </div>

        <!-- Form Login -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
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
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Kembali ke Login UMKM -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-outline-secondary">Kembali ke Login UMKM</a>
        </div>
    </div>
@endsection