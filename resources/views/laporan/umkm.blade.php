@extends('layouts.app')
@section('title', 'Laporan Daftar UMKM')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                @if(!isset($umkms) || $umkms->isEmpty())
                    <p>Tidak ada data UMKM.</p>
                @else
                    <div class="mb-4 text-right no-print">
                        <a href="{{ route('laporan.umkm.cetak-pdf') }}" class="btn btn-danger">Unduh PDF</a>
                        <a href="{{ route('laporan.umkm.cetak-excel') }}" class="btn btn-success">Unduh Excel</a>
                    </div>
                    <table class="table table-bordered table-full-width print-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Lokasi (Kecamatan)</th>
                                <th>NIB</th>
                                <th>Tanggal Dibuat</th>
                                <th>Akun Sosial Media</th>
                                <th>Total Pengikut</th>
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
                                    <td>{{ $umkm->nib ?? 'Belum ada NIB' }}</td>
                                    <td>{{ $umkm->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if($umkm->akun_facebook || $umkm->akun_instagram)
                                            @if($umkm->akun_facebook)<a href="{{ $umkm->akun_facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif
                                            @if($umkm->akun_facebook && $umkm->akun_instagram) | @endif
                                            @if($umkm->akun_instagram)<a href="{{ $umkm->akun_instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>@endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        FB: {{ $umkm->total_pengikut_facebook ?? '0' }}<br>
                                        IG: {{ $umkm->total_pengikut_instagram ?? '0' }}
                                    </td>
                                    <td class="no-print">
                                        <a href="{{ route('umkm.edit', $umkm->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('umkm.destroy', $umkm->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?');">
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
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            @media print {
                /* Sembunyikan semua elemen kecuali tabel */
                body * {
                    display: none !important;
                }
                .print-table {
                    display: table !important; /* Pastikan tabel muncul */
                    width: 100% !important;
                    border-collapse: collapse !important;
                }
                .print-table th, .print-table td {
                    border: 1px solid #000 !important; /* Pastikan batas tabel terlihat */
                }
                /* Hindari pemisahan tabel antar halaman */
                .print-table {
                    page-break-inside: avoid;
                }
            }
            /* Gaya untuk layar */
            .table-full-width {
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .card {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .card-body {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
            .btn i {
                font-size: 1rem;
            }
            /* Gaya untuk ikon sosial media */
            .bi-facebook, .bi-instagram {
                font-size: 1.2rem; /* Sesuaikan ukuran ikon */
                margin-right: 5px; /* Jarak antar ikon */
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