@extends('layouts.app')
@section('title', 'Penilaian Tingkat Interaksi')
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-primary">
            <h4 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>Isi Hasil Interaksi</h4>
        </div>
        <div class="card-body p-0">
            @if($analitiks->isEmpty())
                <div class="alert alert-info text-center p-4">
                    <i class="bi bi-info-circle me-2"></i>Belum ada data Nilai Interaksi.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="py-3">Konten</th>
                                <th class="py-3 text-center">Likes</th>
                                <th class="py-3 text-center">Comments</th>
                                <th class="py-3 text-center">Shares</th>
                                <th class="py-3 text-center">Skor</th>
                                <th class="py-3 text-center">Grade</th>
                                <th class="py-3 text-center">Screenshot</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analitiks as $analitik)
                                <tr class="transition-all duration-300 hover:bg-gray-100">
                                    <td class="py-3">{{ $analitik->konten->judul ?? 'Tidak Ditemukan' }}</td>
                                    <td class="py-3 text-center">{{ $analitik->likes ?? '-' }}</td>
                                    <td class="py-3 text-center">{{ $analitik->comments ?? '-' }}</td>
                                    <td class="py-3 text-center">{{ $analitik->shares ?? '-' }}</td>
                                    <td class="py-3 text-center">{{ $analitik->engagement_rate ? number_format($analitik->engagement_rate, 2) : '-' }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge {{ $analitik->grade == 'A' ? 'bg-success' : ($analitik->grade == 'B' ? 'bg-info' : ($analitik->grade == 'C' ? 'bg-warning' : 'bg-danger')) }}">
                                            {{ $analitik->grade ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($analitik->screenshot)
                                            <a href="{{ Storage::url($analitik->screenshot) }}" target="_blank">
                                                <img src="{{ Storage::url($analitik->screenshot) }}" alt="Screenshot" class="screenshot-img rounded shadow-sm">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $sevenDaysPassed = $analitik->konten->created_at->addDays(7)->lte(now());
                                            $isFilled = $analitik->engagement_filled_at !== null;
                                        @endphp
                                        @if ($sevenDaysPassed && !$isFilled)
                                            <a href="{{ route('analitik.edit', $analitik->konten->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Isi Engagement
                                            </a>
                                        @elseif ($isFilled)
                                            <span class="badge bg-success">Sudah Diisi</span>
                                        @else
                                            <span class="badge bg-secondary">Tunggu 7 Hari</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .bg-gradient-primary {
                background: linear-gradient(90deg, #007bff, #0056b3);
            }
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
            .table th:nth-child(1), .table td:nth-child(1) { /* Konten */
                width: 25%;
            }
            .table th:nth-child(2), .table td:nth-child(2) { /* Likes */
                width: 8%;
            }
            .table th:nth-child(3), .table td:nth-child(3) { /* Comments */
                width: 8%;
            }
            .table th:nth-child(4), .table td:nth-child(4) { /* Shares */
                width: 8%;
            }
            .table th:nth-child(5), .table td:nth-child(5) { /* Engagement Rate */
                width: 10%;
            }
            .table th:nth-child(6), .table td:nth-child(6) { /* Grade */
                width: 8%;
            }
            .table th:nth-child(7), .table td:nth-child(7) { /* Screenshot */
                width: 15%;
            }
            .table th:nth-child(8), .table td:nth-child(8) { /* Aksi */
                width: 10%;
            }
            .screenshot-img {
                max-width: 80px;
                max-height: 80px;
                object-fit: cover;
                transition: transform 0.2s ease;
            }
            .screenshot-img:hover {
                transform: scale(1.1);
            }
            .badge {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
                border-radius: 0.25rem;
            }
            .btn-sm {
                padding: 0.25rem 0.75rem;
                font-size: 0.875rem;
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
            }
            .alert-dismissible .btn-close {
                padding: 0.75rem;
            }
            .transition-all {
                transition: all 0.3s ease;
            }
            .alert-info {
                background-color: #e9f0ff;
                border-color: #cce5ff;
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