@extends('layouts.app')
@section('title', 'Isi Engagement')
@section('content')

{{-- Menghapus div pembungkus yang tidak perlu agar card mengisi seluruh ruang --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Isi Engagement untuk Konten: "{{ $analitik->konten->judul }}"</h4>
    </div>
    <div class="card-body p-4">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('analitik.update', $analitik->konten->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="likes" class="form-label fw-bold">Likes</label>
                    <input type="number" class="form-control @error('likes') is-invalid @enderror" id="likes" name="likes" required min="0" value="{{ old('likes') }}" placeholder="Contoh: 150">
                    @error('likes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="comments" class="form-label fw-bold">Comments</label>
                    <input type="number" class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" required min="0" value="{{ old('comments') }}" placeholder="Contoh: 25">
                    @error('comments')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="shares" class="form-label fw-bold">Shares</label>
                    <input type="number" class="form-control @error('shares') is-invalid @enderror" id="shares" name="shares" required min="0" value="{{ old('shares') }}" placeholder="Contoh: 10">
                    @error('shares')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="link_postingan" class="form-label fw-bold">Link Postingan</label>
                <input type="url" class="form-control @error('link_postingan') is-invalid @enderror" id="link_postingan" name="link_postingan" required value="{{ old('link_postingan') }}" placeholder="https://www.instagram.com/p/...">
                <small class="text-muted">Salin dan tempel URL lengkap dari postingan {{ $analitik->konten->platform }} Anda.</small>
                @error('link_postingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="screenshot" class="form-label fw-bold">Screenshot Engagement Rate</label>
                <input type="file" class="form-control @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot" accept="image/*" required>
                <small class="text-muted">Unggah screenshot yang menunjukkan jumlah likes, comments, dan shares dari postingan.</small>
                @error('screenshot')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="d-flex justify-content-end">
                <a href="{{ route('analitik.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

