@extends('layouts.app')
@section('title', 'Laporan Daftar UMKM')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- FORM PENCARIAN DAN FILTER -->
                <div class="mb-4 p-3 border rounded bg-light no-print">
                    <form action="{{ route('laporan.umkm') }}" method="GET" id="filterForm" class="row g-3 align-items-center">
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

                @if($umkms->isEmpty())
                    <div class="alert alert-info text-center">
                        Tidak ada data UMKM yang cocok dengan kriteria Anda.
                    </div>
                @else
                    <div class="mb-4 text-right no-print">
                        <a href="{{ route('laporan.umkm.cetak-pdf') }}" class="btn btn-danger">Unduh PDF</a>
                        <a href="{{ route('laporan.umkm.cetak-excel') }}" class="btn btn-success">Unduh Excel</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Lokasi</th>
                                    <th>NIB</th>
                                    {{-- Mengubah Header Kolom --}}
                                    <th>Profil Terakhir Diperbarui</th>
                                    <th>Akun Sosial</th>
                                    <th>Pengikut</th>
                                    <th class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($umkms as $index => $umkm)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $umkm->name }}</td>
                                        <td>{{ $umkm->email }}</td>
                                        <td>{{ $umkm->lokasi ?? '-' }}</td>
                                        <td>{{ $umkm->nib ?? 'Belum ada' }}</td>
                                        
                                        <td>
                                            @if($umkm->profile_updated_at)
                                                @php
                                                    $isOutdated = now()->subDays(7)->gt($umkm->profile_updated_at);
                                                @endphp
                                                <span data-bs-toggle="tooltip" data-bs-title="Tanggal: {{ $umkm->profile_updated_at->format('d M Y, H:i') }}">
                                                    {{-- Mengubah output waktu ke Bahasa Indonesia --}}
                                                    {{ $umkm->profile_updated_at->locale('id')->diffForHumans() }}
                                                </span>
                                                @if($isOutdated)
                                                    <span class="badge bg-danger rounded-pill ms-1" data-bs-toggle="tooltip" data-bs-title="Perlu update! Sudah lebih dari 7 hari.">!</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Belum Pernah</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($umkm->akun_facebook)<a href="{{ $umkm->akun_facebook }}" target="_blank" data-bs-toggle="tooltip" data-bs-title="Facebook"><i class="bi bi-facebook"></i></a>@endif
                                            @if($umkm->akun_instagram)<a href="{{ $umkm->akun_instagram }}" target="_blank" data-bs-toggle="tooltip" data-bs-title="Instagram"><i class="bi bi-instagram ms-2"></i></a>@endif
                                        </td>
                                        <td>
                                            <small>FB: {{ $umkm->total_pengikut_facebook ?? '0' }}<br>
                                            IG: {{ $umkm->total_pengikut_instagram ?? '0' }}</small>
                                        </td>
                                        <td class="no-print">
                                            <a href="{{ route('umkm.edit', $umkm->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Logika untuk auto-submit form filter
        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('search');
        const lokasiSelect = document.getElementById('lokasi');
        const nibSelect = document.getElementById('status_nib');

        const submitForm = () => {
            filterForm.submit();
        };

        lokasiSelect.addEventListener('change', submitForm);
        nibSelect.addEventListener('change', submitForm);

        let debounceTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                submitForm();
            }, 500); 
        });
    });
</script>
@endpush

