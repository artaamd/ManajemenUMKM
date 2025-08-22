<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarUmkmExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection()
    {
        return User::where('role', 'umkm')->get();
    }

    public function title(): string
    {
        return 'Daftar UMKM';
    }

    public function headings(): array
    {
        return [
            'No', 'Nama UMKM', 'Email', 'Lokasi (Kecamatan)', 'NIB', 'Tanggal Bergabung',
            'Akun Facebook', 'Pengikut Facebook', 'Akun Instagram', 'Pengikut Instagram'
        ];
    }

    public function map($umkm): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $umkm->name,
            $umkm->email,
            $umkm->lokasi ?? '-',
            $umkm->nib ?? '-',
            $umkm->created_at->format('d-m-Y'),
            $umkm->akun_facebook ?? '-',
            $umkm->total_pengikut_facebook ?? 0,
            $umkm->akun_instagram ?? '-',
            $umkm->total_pengikut_instagram ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('007BFF');
    }
}