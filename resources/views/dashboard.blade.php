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

        <!-- ================================================================= -->
        <!-- Grafik Rata-Rata Engagement Rate (Doughnut Chart) -->
        <!-- ================================================================= -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Rata-Rata Tingkat Interaksi (Engangement Rate)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <div class="chart-pie pt-4 pb-2" style="position: relative; height:250px; width:100%">
                                    <canvas id="averageEngagementChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h2 class="display-4 fw-bold text-success">{{ number_format($averageEngagementRate, 2) }}%</h2>
                                <p class="text-muted">Ini adalah rata-rata tingkat interaksi dari seluruh konten yang telah dinilai di dalam sistem. Semakin tinggi persentasenya, semakin baik performa konten secara keseluruhan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ================================================================= -->
        <!-- AKHIR KODE BARU -->
        <!-- ================================================================= -->

    @elseif ($user->role === 'umkm')
        <!-- Dashboard UMKM (tidak diubah) -->
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
        <p>Role pengguna tidak dikenali.</p>
    @endif

    @push('styles')
        <style>
            .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
            .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
            .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
            .shadow { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important; }
        </style>
    @endpush

    @push('scripts')
        {{-- Skrip untuk grafik UMKM (tidak diubah) --}}
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
                            }
                        }
                    });
                });
            </script>
        @endif

        {{-- Skrip baru untuk Grafik Doughnut Admin --}}
        @if ($user->role === 'admin')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const engagementCtx = document.getElementById('averageEngagementChart').getContext('2d');
                    const engagementRate = {{ number_format($averageEngagementRate, 2) }};

                    new Chart(engagementCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Engagement Rate', 'Sisa'],
                            datasets: [{
                                data: [engagementRate, 100 - engagementRate],
                                backgroundColor: [
                                    'rgba(28, 200, 138, 1)',  // Warna Hijau (Success)
                                    'rgba(234, 236, 244, 1)'  // Warna Abu-abu muda
                                ],
                                hoverBackgroundColor: [
                                    'rgba(22, 160, 110, 1)',
                                    'rgba(210, 214, 224, 1)'
                                ],
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            cutout: '80%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                }
                            }
                        },
                    });
                });
            </script>
        @endif
    @endpush
@endsection

