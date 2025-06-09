<!DOCTYPE html>
<html>
<head>
    <title>Laporan Grade UMKM - {{ $umkm->nama_usaha ?? $umkm->name ?? 'UMKM Tanpa Nama' }}</title>
    <style>
        @page {
            margin: 2cm 2cm 2cm 2cm; /* Margin atas, kanan, bawah, kiri untuk A4 */
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #343a40;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18pt;
            color: #343a40;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
            color: #666;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            max-width: 100%; /* Pastikan tidak melebihi lebar halaman */
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: fixed; /* Mengatur lebar kolom tetap */
        }
        .table th, .table td {
            border: 1px solid #666;
            padding: 6px 8px; /* Mengurangi padding untuk menghemat ruang */
            text-align: left;
            font-size: 9pt; /* Mengurangi ukuran font */
            vertical-align: middle;
        }
        .table th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }
        .table td {
            background-color: #f9f9f9;
        }
        .table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }
        .table th, .table td {
            word-wrap: break-word; /* Memungkinkan teks panjang dipotong */
        }
        .badge {
            padding: 3px 6px; /* Mengurangi padding badge */
            font-size: 8pt;
            border-radius: 3px;
            color: white;
        }
        .badge.bg-primary { background-color: #007bff; }
        .badge.bg-danger { background-color: #dc3545; }
        .badge.bg-success { background-color: #28a745; }
        .badge.bg-info { background-color: #17a2b8; }
        .badge.bg-warning { background-color: #ffc107; }
        .badge.bg-secondary { background-color: #6c757d; }
        .screenshot-img {
            max-width: 60px; /* Mengurangi ukuran gambar */
            max-height: 60px;
            object-fit: cover;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 20px;
            font-size: 9pt;
            color: #666;
            position: fixed;
            bottom: 1cm; /* Mengatur jarak dari bawah halaman */
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Grade UMKM</h2>
        <p>{{ $umkm->nama_usaha ?? $umkm->name ?? 'UMKM Tanpa Nama' }}</p>
        <p>Tanggal Laporan: {{ date('d-m-Y') }}</p>
    </div>

    @if ($kontens->isEmpty())
        <p class="no-data">Tidak ada konten untuk UMKM ini.</p>
    @else
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 8%;">No</th>
                        <th style="width: 15%;">Judul Konten</th>
                        <th style="width: 15%;">Platform</th>
                        <th style="width: 10%;">Like</th>
                        <th style="width: 16%;">Comment</th>
                        <th style="width: 12%;">Share</th>
                        <th style="width: 15%;">Engagement Rate (%)</th>
                        <th style="width: 12%;">Grade</th>
                        <th style="width: 15%;">Tanggal Publish</th>
                        <th style="width: 12%;">Durasi</th>
                        <th style="width: 12%;">Status</th>
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
                                <span class="badge {{ $konten->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $konten->status ?? 'Tidak Diketahui' }}
                                </span>
                            </td>
                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="footer">
        <p>© {{ date('Y') }} Manajemen UMKM - Dibuat dengan xAI</p>
    </div>
</body>
</html>