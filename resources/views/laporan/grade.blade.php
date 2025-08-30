@extends('layouts.app')
@section('title', 'Laporan Grade UMKM')
@section('content')
    <div class="container-fluid p-0">
        <div class="card shadow-sm border-0 w-100">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Ringkasan Grade Konten per UMKM</h4>
            </div>
            <div class="card-body p-3">
                @if ($umkms->isEmpty())
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>Belum ada data UMKM.
                    </div>
                @else
                    <!-- Panel Statistik -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="card bg-light text-center p-3 border">
                                        <h6 class="text-muted">Total UMKM</h6>
                                        <h4>{{ $umkms->count() }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light text-center p-3 border">
                                        <h6 class="text-muted">Total Konten</h6>
                                        <h4>{{ $umkms->sum(fn($umkm) => $umkm->kontens->count()) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light text-center p-3 border">
                                        <h6 class="text-muted">Rata-rata Engagement</h6>
                                        <h4>{{ number_format($umkms->sum(fn($umkm) => $umkm->kontens->sum(fn($konten) => $konten->analitik->engagement_rate ?? 0)) / max($umkms->sum(fn($umkm) => $umkm->kontens->count()), 1), 2) }}%</h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light text-center p-3 border">
                                        <h6 class="text-muted">Tanggal Laporan</h6>
                                        <h4>{{ now()->format('d-m-Y') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <!-- Kolom Kiri: Daftar UMKM -->
                        <div class="col-md-3">
                            <div class="card border-light shadow-sm h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Daftar UMKM</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group umkm-list">
                                        @foreach ($umkms as $umkm)
                                            <a href="{{ route('laporan.grade.show', $umkm->id) }}"
                                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ isset($selectedUmkm) && $selectedUmkm->id == $umkm->id ? 'active' : '' }}">
                                                <span>
                                                    <i class="bi bi-shop me-2"></i>
                                                    {{ $umkm->nama_usaha ?? $umkm->name ?? 'UMKM Tanpa Nama' }}<br>
                                                    <small class="text-muted">{{ $umkm->lokasi ?? 'Lokasi Tidak Diketahui' }} | {{ $umkm->created_at->format('d-m-Y') }}</small>
                                                </span>
                                                <div>
                                                    <span class="badge bg-secondary rounded-pill me-1">
                                                        {{ $umkm->kontens->count() }} Konten
                                                    </span>
                                                    <a href="{{ route('laporan.grade.cetak-per-umkm', $umkm->id) }}" class="btn btn-sm btn-danger no-print me-1" title="Unduh PDF">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </a>
                                                    <a href="{{ route('laporan.grade.cetak-excel-per-umkm', $umkm->id) }}" class="btn btn-sm btn-success no-print" title="Unduh Excel">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </a>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Detail Konten -->
                        <div class="col-md-9">
                            <div class="card border-light shadow-sm h-100">
                                <div class="card-header bg-light">
                                    @if (isset($kontens))
                                        <h5 class="mb-0">Konten dari {{ $selectedUmkm->nama_usaha ?? $selectedUmkm->name ?? 'UMKM Tanpa Nama' }}</h5>
                                    @else
                                        <h5 class="mb-0">Detail Konten</h5>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @if (isset($kontens))
                                        @if ($kontens->isEmpty())
                                            <div class="alert alert-info text-center">
                                                <i class="bi bi-info-circle me-2"></i>Belum ada konten untuk UMKM ini.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-full-width print-table">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Judul Konten</th>
                                                            <th>Platform</th>
                                                            <th>Likes</th>
                                                            <th>Comments</th>
                                                            <th>Shares</th>
                                                            <th>Engagement Rate (%)</th>
                                                            <th>Grade</th>
                                                            <th>Tanggal Publish</th>
                                                            <th>Durasi</th>
                                                            <th>Screenshot</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($kontens as $index => $konten)
                                                            <?php
                                                                $publishedAt = \Carbon\Carbon::parse($konten->tanggal_publish);
                                                                $duration = $publishedAt->diffForHumans();
                                                            ?>
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $konten->judul ?? 'Tidak Ditemukan' }}</td>
                                                                <td>
                                                                    <span class="badge {{ $konten->platform == 'Facebook' ? 'bg-primary' : 'bg-danger' }}">
                                                                        {{ $konten->platform ?? '-' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $konten->analitik->likes ?? '-' }}</td>
                                                                <td>{{ $konten->analitik->comments ?? '-' }}</td>
                                                                <td>{{ $konten->analitik->shares ?? '-' }}</td>
                                                                <td>{{ $konten->analitik->engagement_rate ? number_format($konten->analitik->engagement_rate, 2) : '-' }}</td>
                                                                <td>
                                                                    <span class="badge {{ $konten->analitik->grade == 'A' ? 'bg-success' : ($konten->analitik->grade == 'B' ? 'bg-info' : ($konten->analitik->grade == 'C' ? 'bg-warning' : 'bg-danger')) }}">
                                                                        {{ $konten->analitik->grade ?? '-' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $konten->tanggal_publish ?? '-' }}</td>
                                                                <td>{{ $duration }}</td>
                            
                                                                <td>
                                                                    @if ($konten->analitik->screenshot)
                                                                        <a href="{{ Storage::url($konten->analitik->screenshot) }}" target="_blank">
                                                                            <img src="{{ Storage::url($konten->analitik->screenshot) }}" alt="Screenshot" class="img-thumbnail screenshot-img">
                                                                        </a>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info text-center">
                                            <i class="bi bi-info-circle me-2"></i>Pilih UMKM untuk melihat detail konten.
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-light text-muted text-center">
                                    <small>© {{ date('Y') }} Manajemen Konten Digital UMKM Kota Gorontalo </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Print Styling */
            @media print {
                body * {
                    display: none !important;
                }
                .print-table {
                    display: table !important;
                    width: 100% !important;
                    border-collapse: collapse !important;
                }
                .print-table th, .print-table td {
                    border: 1px solid #000 !important;
                    padding: 5px !important;
                }
                .print-table {
                    page-break-inside: avoid;
                }
            }

            /* General Layout */
            .container-fluid {
                padding: 0 !important;
            }
            .card {
                border-radius: 10px;
                margin: 0 !important;
                width: 100% !important;
            }
            .card-header {
                border-bottom: 1px solid #dee2e6;
                padding: 10px 15px;
            }
            .card-body {
                padding: 15px !important;
            }
            .card-footer {
                border-top: 1px solid #dee2e6;
                padding: 8px;
            }

            /* Panel Statistik */
            .bg-light {
                border: 1px solid #e9ecef;
                border-radius: 5px;
            }
            .bg-light h4 {
                font-size: 1.25rem;
                font-weight: 600;
            }
            .bg-light h6 {
                font-size: 0.9rem;
            }

            /* Daftar UMKM */
            .umkm-list {
                max-height: 600px;
                overflow-y: auto;
                border: 1px solid #e9ecef;
                border-radius: 5px;
            }
            .umkm-list .list-group-item {
                border: none;
                border-bottom: 1px solid #e9ecef;
                padding: 12px 15px;
                transition: background-color 0.2s;
            }
            .umkm-list .list-group-item:hover {
                background-color: #f8f9fa;
            }
            .umkm-list .list-group-item.active {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }
            .umkm-list .badge {
                font-size: 0.75rem;
            }
            .umkm-list small {
                font-size: 0.75rem;
                display: block;
            }

            /* Tabel Konten */
            .table-full-width {
                width: 100% !important;
                margin: 0 !important;
            }
            .thead-dark th {
                background-color: #343a40;
                color: white;
                font-size: 0.9rem;
                padding: 8px;
            }
            .table td {
                vertical-align: middle;
                font-size: 0.85rem;
                padding: 8px;
            }
            .screenshot-img {
                max-width: 60px;
                max-height: 60px;
                object-fit: cover;
                border-radius: 5px;
            }
            .badge {
                font-size: 0.75rem;
                padding: 5px 8px;
            }

            /* Elemen Visual */
            h2, h4, h5 {
                font-weight: 600;
                color: #333;
            }
            .alert {
                margin: 0;
                padding: 10px;
                font-size: 0.9rem;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
            .btn i {
                font-size: 1rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection