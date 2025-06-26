@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
  

    @if ($user->role === 'admin')
        <!-- Dashboard Admin -->
        <div class="row">
            <!-- Kartu Total UMKM per Kecamatan -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    UMKM per Kecamatan
                                </div>
                                <div class="mb-0">
                                    @forelse ($umkms_per_kecamatan as $kecamatan => $jumlah)
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>{{ $kecamatan }}</span>
                                            <span class="font-weight-bold">{{ $jumlah }}</span>
                                        </div>
                                    @empty
                                        <div class="text-muted">Belum ada data UMKM.</div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Total Konten Instagram -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Konten Instagram
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $content_counts['instagram'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-instagram fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Total Konten Facebook -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Konten Facebook
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $content_counts['facebook'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-facebook fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($user->role === 'umkm')
        <!-- Dashboard UMKM -->
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Konten Instagram</h5>
                        <h3 class="text-primary">{{ $content_counts['instagram'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Konten Facebook</h5>
                        <h3 class="text-primary">{{ $content_counts['facebook'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart untuk Tren Konten -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tren Konten per Bulan (Line Chart)</h5>
                        <canvas id="contentChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Fallback jika role tidak dikenali -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Error</h5>
                        <p>Role pengguna tidak dikenali. Silakan hubungi administrator.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
        <style>
            .border-left-primary {
                border-left: 0.25rem solid #4e73df !important;
            }
            .border-left-success {
                border-left: 0.25rem solid #1cc88a !important;
            }
            .border-left-info {
                border-left: 0.25rem solid #36b9cc !important;
            }
            .shadow {
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
            }
        </style>
    @endpush

    @push('scripts')
        @if ($user->role === 'umkm')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('contentChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($content_trends['labels'] ?? []),
                            datasets: [
                                {
                                    label: 'Instagram',
                                    data: @json($content_trends['instagram'] ?? []),
                                    borderColor: 'rgba(28, 200, 138, 1)',
                                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                                    fill: true,
                                },
                                {
                                    label: 'Facebook',
                                    data: @json($content_trends['facebook'] ?? []),
                                    borderColor: 'rgba(54, 185, 204, 1)',
                                    backgroundColor: 'rgba(54, 185, 204, 0.1)',
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Konten'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Bulan'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    @endpush
@endsection