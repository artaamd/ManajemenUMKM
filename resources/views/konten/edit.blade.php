@extends('layouts.app')
@section('title', 'Edit Konten')
@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Konten</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('konten.update', $konten) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Konten</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $konten->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $konten->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="platform" class="form-label">Platform</label>
                            <select class="form-select @error('platform') is-invalid @enderror" id="platform" name="platform" required>
                                <option value="instagram" {{ old('platform', $konten->platform) == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="facebook" {{ old('platform', $konten->platform) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                            </select>
                            @error('platform')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
                            <input type="date" class="form-control @error('tanggal_publish') is-invalid @enderror" id="tanggal_publish" name="tanggal_publish" value="{{ old('tanggal_publish', \Carbon\Carbon::parse($konten->tanggal_publish)->format('Y-m-d')) }}" required>
                            @error('tanggal_publish')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                             @if($konten->image)
                                <div class="mt-2">
                                    <small>Gambar saat ini:</small><br>
                                    <img src="{{ Storage::url($konten->image) }}" alt="Gambar Konten" class="img-thumbnail" width="150">
                                </div>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('konten.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection