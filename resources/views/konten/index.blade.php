@extends('layouts.app')
@section('title', 'Manajemen Penjadwalan Konten')
@section('content')
    <div class="container-fluid p-0 m-0">
        <div class="row m-0">
            <div class="col-12 p-3">
                @if (!$user->lokasi && !$user->nib)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> Anda belum memiliki UMKM. Silakan buat UMKM terlebih dahulu.
                        <a href="{{ route('umkm.profil') }}" class="btn btn-primary btn-sm ms-3">Lengkapi Profil</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-primary fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Daftar Konten Anda</h4>
                        <a href="{{ route('konten.create') }}" class="btn btn-primary btn-lg shadow-sm">
                            <i class="bi bi-plus-lg me-2"></i>Tambah Konten
                        </a>
                    </div>

                    @if ($kontens->isEmpty())
                        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                            <i class="bi bi-info-circle me-2"></i>Belum ada konten.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @else
                        <div class="card border-0 shadow-sm">
                            
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle m-0">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="py-3">Judul</th>
                                                <th class="py-3">Deskripsi</th>
                                                <th class="py-3">Gambar</th>
                                                <th class="py-3">Platform</th>
                                                <th class="py-3">Tanggal Dibuat</th>
                                                <th class="py-3">Tanggal Publish</th>
                                                <th class="py-3">Status</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kontens as $konten)
                                                <tr class="transition-all duration-300 hover:bg-gray-100">
                                                    <td class="py-3">{{ $konten->judul }}</td>
                                                    <td class="py-3">{{ Str::limit($konten->deskripsi, 100) }}</td>
                                                    <td class="py-3">
                                                        @if ($konten->image)
                                                            <a href="{{ Storage::url($konten->image) }}" target="_blank">
                                                                <img src="{{ Storage::url($konten->image) }}" alt="Thumbnail" class="thumbnail-img rounded">
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3">
                                                        <span class="badge {{ $konten->platform == 'facebook' ? 'bg-primary' : 'bg-danger' }} text-white">
                                                            {{ $konten->platform }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3">{{ $konten->created_at->format('d/m/Y') }}</td>
                                                    <td class="py-3">{{ $konten->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->format('d/m/Y') : '-' }}</td>
                                                    <td class="py-3">
                                                        <span class="badge {{ now()->gte($konten->created_at) ? 'bg-success' : 'bg-warning' }} text-white">
                                                            {{ now()->gte($konten->created_at) ? 'Sudah Terunggah' : 'Draft' }}
                                                        </span>
                                                    </td>
                                                   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
                transition: background-color 0.3s ease;
            }
            .table-primary th {
                background-color: #007bff;
                color: white;
                font-weight: 600;
                border-bottom: 2px solid #0056b3;
            }
            .table {
                width: 100% !important;
                table-layout: auto !important;
            }
            .table th, .table td {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .table th:nth-child(1), .table td:nth-child(1) { /* Judul */
                width: 15%;
            }
            .table th:nth-child(2), .table td:nth-child(2) { /* Deskripsi */
                width: 30%;
            }
            .table th:nth-child(3), .table td:nth-child(3) { /* Gambar */
                width: 10%;
            }
            .table th:nth-child(4), .table td:nth-child(4) { /* Platform */
                width: 10%;
            }
            .table th:nth-child(5), .table td:nth-child(5) { /* Tanggal Dibuat */
                width: 10%;
            }
            .table th:nth-child(6), .table td:nth-child(6) { /* Tanggal Publish */
                width: 10%;
            }
            .table th:nth-child(7), .table td:nth-child(7) { /* Status */
                width: 10%;
            }
           
            .thumbnail-img {
                max-width: 60px;
                max-height: 60px;
                object-fit: cover;
                border: 1px solid #dee2e6;
                transition: transform 0.2s ease;
            }
            .thumbnail-img:hover {
                transform: scale(1.1);
            }
            .badge {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
                border-radius: 0.25rem;
            }
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                border-radius: 0.5rem;
            }
            .shadow-sm {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            }
            .card {
                border-radius: 0.75rem;
                overflow: hidden;
            }
            .card-header {
                padding: 1rem 1.5rem;
                background-color: #f8f9fa;
            }
            .alert-dismissible .btn-close {
                padding: 0.75rem;
            }
            .transition-all {
                transition: all 0.3s ease;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection