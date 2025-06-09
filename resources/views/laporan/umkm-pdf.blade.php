<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar UMKM</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Laporan Daftar UMKM</h1>
    <p style="text-align: center;">Tanggal: {{ date('d/m/Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Nama UMKM</th>
                <th>Lokasi</th>
                <th>NIB</th>
                <th>Akun Sosial</th>
                <th>Total Pengikut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($umkms as $umkm)
                <tr>
                    <td>{{ $umkm->name }}</td>
                    <td>{{ $umkm->lokasi ?? '-' }}</td>
                    <td>{{ $umkm->nib ?? '-' }}</td>
                    <td>
                        @if($umkm->akun_facebook || $umkm->akun_instagram)
                            @if($umkm->akun_facebook)<a href="{{ $umkm->akun_facebook }}" target="_blank">FB</a>@endif
                            @if($umkm->akun_facebook && $umkm->akun_instagram) | @endif
                            @if($umkm->akun_instagram)<a href="{{ $umkm->akun_instagram }}" target="_blank">IG</a>@endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        FB: {{ $umkm->total_pengikut_facebook ?? '0' }}<br>
                        IG: {{ $umkm->total_pengikut_instagram ?? '0' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>