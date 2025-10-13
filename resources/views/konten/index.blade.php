@extends('layouts.app')
@section('title', 'Manajemen Penjadwalan Konten')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="m-0"><i class="bi bi-file-earmark-text me-2"></i>Daftar Konten Anda</h4>
        <a href="{{ route('konten.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Konten
        </a>
    </div>

    <!-- Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('konten.index') }}" method="GET" id="searchForm">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari konten berdasarkan judul..." value="{{ $searchTerm ?? '' }}">
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($kontens->isEmpty())
                <div class="alert alert-info text-center m-4" role="alert">
                    @if(isset($searchTerm) && $searchTerm)
                        <i class="bi bi-search me-2"></i>Tidak ada konten yang cocok dengan pencarian "{{ $searchTerm }}".
                    @else
                        <i class="bi bi-info-circle me-2"></i>Anda belum memiliki konten. Silakan klik "Tambah Konten" untuk memulai.
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 20%;">Judul</th>
                                <th style="width: 30%;">Deskripsi</th>
                                <th style="width: 10%;" class="text-center">Gambar</th>
                                <th style="width: 10%;" class="text-center">Platform</th>
                                <th style="width: 10%;" class="text-center">Publish</th>
                                <th style="width: 10%;" class="text-center">Status</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontens as $konten)
                                <tr>
                                    <td>{{ $konten->judul }}</td>
                                    <td>{{ $konten->deskripsi }}</td>
                                    <td class="text-center">
                                        @if ($konten->image)
                                            <a href="{{ Storage::url($konten->image) }}" target="_blank">
                                                <img src="{{ Storage::url($konten->image) }}" alt="Thumbnail" class="thumbnail-img rounded shadow-sm">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $konten->platform == 'facebook' ? 'bg-primary' : 'bg-danger' }}">
                                            {{ ucfirst($konten->platform) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $konten->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ now()->gte(\Carbon\Carbon::parse($konten->tanggal_publish)) ? 'bg-success' : 'bg-warning' }}">
                                            {{ now()->gte(\Carbon\Carbon::parse($konten->tanggal_publish)) ? 'Terpublish' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('konten.edit', $konten) }}" class="btn btn-warning btn-sm me-2" data-bs-toggle="tooltip" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('konten.destroy', $konten) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus konten ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table {
            table-layout: fixed;
            width: 100%;
        }
        .table th, .table td {
            vertical-align: middle;
            white-space: normal;
            overflow-wrap: break-word;
        }
        .table-primary th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        .thumbnail-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #dee2e6;
            transition: transform 0.2s ease;
        }
        .thumbnail-img:hover {
            transform: scale(1.1);
        }
        .badge {
            font-size: 0.8rem;
            padding: 0.4em 0.7em;
        }
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 0.5rem;
        }
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        let debounceTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500); // Kirim form setelah 0.5 detik berhenti mengetik
        });
    });
</script>
@endpush

