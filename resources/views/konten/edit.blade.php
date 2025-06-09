@extends('layouts.app')
@section('title', 'Edit Konten')
@section('content')
    <h1>Edit Konten</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('konten.update', $konten->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="umkm_id">UMKM</label>
                    <select name="umkm_id" class="form-control" required>
                        <option value="">Pilih UMKM</option>
                        @foreach($umkms as $umkm)
                            <option value="{{ $umkm->id }}" {{ $konten->umkm_id == $umkm->id ? 'selected' : '' }}>{{ $umkm->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $konten->judul }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required>{{ $konten->deskripsi }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_posting">Tanggal Posting</label>
                    <input type="datetime-local" name="tanggal_posting" class="form-control" value="{{ $konten->jadwal->tanggal_posting }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $konten->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $konten->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection