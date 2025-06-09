@extends('layouts.app')
@section('title', 'Tambah Konten')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Konten</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}">
                    @error('judul')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Konten</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="platform" class="form-label">Platform</label>
                    <select class="form-select" id="platform" name="platform">
                        <option value="instagram" {{ old('platform') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="facebook" {{ old('platform') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                    </select>
                    @error('platform')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                 <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                 <input type="date" class="form-control" id="tanggal_publish" name="tanggal_publish" value="{{ old('tanggal_publish') }}" required>
                     @error('tanggal_publish')
               <div class="text-danger small">{{ $message }}</div>
                     @enderror
                </div>
<input type="hidden" name="status" value="scheduled">
                <button type="submit" class="btn btn-primary">Simpan Konten</button>
                <a href="{{ route('konten.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection