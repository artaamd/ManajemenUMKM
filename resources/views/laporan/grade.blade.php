@extends('layouts.app')
@section('title', 'Laporan Grade UMKM')
@section('content')
    <div class="container-fluid p-0">
        <div class="card shadow-sm border-0 w-100">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Ringkasan Grade Konten per UMKM</h4>
            </div>
            <div class="card-body p-3">
                @if ($umkms->isEmpty() && !isset($searchTerm) && !isset($selectedLokasi) && !isset($selectedNibStatus))
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>Belum ada data UMKM.
                    </div>
                @else
                    <!-- FORM PENCARIAN DAN FILTER -->
                    <div class="mb-4 p-3 border rounded bg-light no-print">
                        <form action="{{ route('laporan.grade') }}" method="GET" id="filterForm" class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="search" class="visually-hidden">Cari UMKM</label>
                                <input type="text" class="form-control" id="search" name="search" placeholder="Cari nama, email, atau NIB..." value="{{ $searchTerm ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label for="lokasi" class="visually-hidden">Filter Lokasi</label>
                                <select class="form-select" id="lokasi" name="lokasi">
                                    <option value="">Semua Lokasi</option>
                                    @foreach($lokasiOptions as $lokasi)
                                        <option value="{{ $lokasi }}" {{ ($selectedLokasi ?? '') == $lokasi ? 'selected' : '' }}>
                                            {{ $lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status_nib" class="visually-hidden">Filter Status NIB</label>
                                <select class="form-select" id="status_nib" name="status_nib">
                                    <option value="">Semua Status NIB</option>
                                    <option value="ber-nib" {{ ($selectedNibStatus ?? '') == 'ber-nib' ? 'selected' : '' }}>Memiliki NIB</option>
                                    <option value="tidak-ber-nib" {{ ($selectedNibStatus ?? '') == 'tidak-ber-nib' ? 'selected' : '' }}>Tidak Memiliki NIB</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="row g-3">
                        <!-- Kolom Kiri: Daftar UMKM -->
                        <div class="col-md-3">
                            <div class="card border-light shadow-sm h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Daftar UMKM</h5>
                                </div>
                                <div class="card-body p-0">
                                    @if($umkms->isEmpty())
                                        <div class="p-3 text-center text-muted">
                                            Tidak ada UMKM yang cocok dengan filter.
                                        </div>
                                    @else
                                        <div class="list-group list-group-flush umkm-list">
                                            @foreach ($umkms as $umkm)
                                                <a href="{{ route('laporan.grade.show', $umkm->id) }}"
                                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ isset($selectedUmkm) && $selectedUmkm->id == $umkm->id ? 'active' : '' }}">
                                                    <span>
                                                        <i class="bi bi-shop me-2"></i>
                                                        {{ $umkm->name ?? 'UMKM Tanpa Nama' }}<br>
                                                        <small class="text-muted">{{ $umkm->lokasi ?? 'Lokasi T/A' }}</small>
                                                    </span>
                                                    <span class="badge bg-primary rounded-pill">
                                                        {{ $umkm->kontens->count() }} Konten
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Detail Konten -->
                        <div class="col-md-9">
                            <div class="card border-light shadow-sm h-100">
                                <div class="card-header bg-light">
                                    @if (isset($selectedUmkm))
                                        <h5 class="mb-0">Konten dari: {{ $selectedUmkm->name }}</h5>
                                    @else
                                        <h5 class="mb-0">Detail Konten</h5>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @if (isset($selectedUmkm) && isset($kontens))
                                        @if ($kontens->isEmpty())
                                            <div class="alert alert-info text-center">
                                                <i class="bi bi-info-circle me-2"></i>UMKM ini belum memiliki konten.
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Judul Konten</th>
                                                            <th>Foto Postingan</th>
                                                            <th>Platform</th>
                                                            <th>Rate (%)</th>
                                                            <th>Grade</th>
                                                            <th>Tgl Publish</th>
                                                            <th>Screenshot</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($kontens as $index => $konten)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $konten->judul ?? '-' }}</td>
                                                                <td>
                                                                    @if($konten->image)
                                                                        <a href="{{ Storage::url($konten->image) }}" target="_blank">
                                                                            <img src="{{ Storage::url($konten->image) }}" alt="Foto Postingan" class="screenshot-thumbnail">
                                                                        </a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="badge {{ optional($konten)->platform == 'Facebook' ? 'bg-primary' : 'bg-danger' }}">
                                                                        {{ $konten->platform ?? '-' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ optional($konten->analitik)->engagement_rate ? number_format($konten->analitik->engagement_rate, 2) : '-' }}</td>
                                                                <td>
                                                                    <span class="badge {{ optional($konten->analitik)->grade == 'A' ? 'bg-success' : (optional($konten->analitik)->grade == 'B' ? 'bg-info' : (optional($konten->analitik)->grade == 'C' ? 'bg-warning' : 'bg-danger')) }}">
                                                                        {{ $konten->analitik->grade ?? '-' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ optional($konten)->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->format('d-m-Y') : '-' }}</td>
                                                              
                                                                <td>
                                                                    @if(optional($konten->analitik)->screenshot)
                                                                        <a href="{{ Storage::url($konten->analitik->screenshot) }}" target="_blank">
                                                                            <img src="{{ Storage::url($konten->analitik->screenshot) }}" alt="Screenshot" class="screenshot-thumbnail">
                                                                        </a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div class="text-center text-muted">
                                                <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
                                                <p class="mt-2">Pilih UMKM dari daftar di sebelah kiri untuk melihat detail grade konten.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .umkm-list {
            max-height: 600px; /* Atur tinggi maksimal daftar UMKM */
            overflow-y: auto;
        }
        .screenshot-thumbnail {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: transform 0.2s ease;
        }
        .screenshot-thumbnail:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('search');
        const lokasiSelect = document.getElementById('lokasi');
        const nibSelect = document.getElementById('status_nib');

        // Fungsi submit hanya untuk filter, bukan saat klik link UMKM
        const submitForm = () => {
            filterForm.action = "{{ route('laporan.grade') }}";
            filterForm.submit();
        };

        // Pasang event listener hanya pada elemen form
        if(lokasiSelect) lokasiSelect.addEventListener('change', submitForm);
        if(nibSelect) nibSelect.addEventListener('change', submitForm);
        
        let debounceTimeout;
        if(searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    submitForm();
                }, 500); 
            });
        }
    });
</script>
@endpush

