@extends('layouts.app')
@section('title', 'Isi Engagement')
@section('content')
    <h1>Isi Engagement untuk {{ $analitik->konten->judul }}</h1>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('analitik.update', $analitik->konten->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="likes" class="form-label">Likes</label>
                    <input type="number" class="form-control" id="likes" name="likes" required min="0" value="{{ old('likes') }}">
                </div>
                <div class="mb-3">
                    <label for="comments" class="form-label">Comments</label>
                    <input type="number" class="form-control" id="comments" name="comments" required min="0" value="{{ old('comments') }}">
                </div>
                <div class="mb-3">
                    <label for="shares" class="form-label">Shares</label>
                    <input type="number" class="form-control" id="shares" name="shares" required min="0" value="{{ old('shares') }}">
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Link Postingan</label>
                    <input type="url" class="form-control" id="link" name="link" required value="{{ old('link') }}">
                    <small class="text-muted">Masukkan link dari {{ $analitik->konten->platform }} untuk validasi.</small>
                </div>
                <div class="mb-3">
                    <label for="screenshot" class="form-label">Screenshot Jumlah Likes, Comments, Shares</label>
                    <input type="file" class="form-control" id="screenshot" name="screenshot" accept="image/*" required>
                    <small class="text-muted">Unggah screenshot yang menunjukkan jumlah likes, comments, dan shares.</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('analitik.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection