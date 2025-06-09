@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    @if ($user->role === 'admin')
        <!-- Dashboard Admin -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar UMKM</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama UMKM</th>
                                    <th>Email</th>
                                    <th>Lokasi</th>
                                    <th>NIB</th>
                                    <th>Akun Instagram</th>
                                    <th>Total Pengikut Instagram</th>
                                    <th>Akun Facebook</th>
                                    <th>Total Pengikut Facebook</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($umkms as $index => $umkm)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $umkm->name }}</td>
                                        <td>{{ $umkm->email }}</td>
                                        <td>{{ $umkm->lokasi ?? '-' }}</td>
                                        <td>{{ $umkm->nib ?? '-' }}</td>
                                        <td>{{ $umkm->akun_instagram ?? '-' }}</td>
                                        <td>{{ $umkm->total_pengikut_instagram ?? 0 }}</td>
                                        <td>{{ $umkm->akun_facebook ?? '-' }}</td>
                                        <td>{{ $umkm->total_pengikut_facebook ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada UMKM terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Dashboard UMKM -->
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Konten Instagram</h5>
                        <h3 class="text-primary">{{ $content_counts['instagram'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Konten Facebook</h5>
                        <h3 class="text-primary">{{ $content_counts['facebook'] }}</h3>
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
    @endif

    @push('scripts')
        <script>
            window.chartData = {
                labels: @json($content_trends['labels'] ?? []),
                instagram: @json($content_trends['instagram'] ?? []),
                facebook: @json($content_trends['facebook'] ?? []),
            };
        </script>
    @endpush
@endsection