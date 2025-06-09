@extends('layouts.app')
@section('title', 'Detail Konten')
@section('content')
    <div class="container-fluid p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3">
                <h2 class="mb-4">Detail Konten</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $konten->judul }}</h5>
                        <p>{{ $konten->deskripsi }}</p>
                        <p><strong>Platform:</strong> {{ ucfirst($konten->platform) }}</p>
                        <p><strong>Tanggal Publish:</strong> {{ $konten->tanggal_publish }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($konten->status) }}</p>
                        @if ($konten->image)
                            <img src="{{ asset('storage/' . $konten->image) }}" alt="Konten Image" class="img-fluid rounded mb-2" style="max-width: 300px;">
                        @endif

                       @if ($konten->status === 'scheduled')
    <form action="{{ route('konten.markUploaded', $konten->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success mt-3">Tandai sebagai Dipublikasikan</button>
    </form>
@endif

                        <a href="{{ route('konten.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection