<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarUmkmExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return User::where('role', 'umkm')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email',
            'Lokasi (Kecamatan)',
            'NIB',
            'Tanggal Dibuat',
            'Akun Sosial Media',
            'Total Pengikut',
        ];
    }

    public function map($umkm): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $socialMedia = [];
        if ($umkm->akun_facebook) {
            $socialMedia[] = "FB: " . $umkm->akun_facebook;
        }
        if ($umkm->akun_instagram) {
            $socialMedia[] = "IG: " . $umkm->akun_instagram;
        }
        $socialMediaText = !empty($socialMedia) ? implode(' | ', $socialMedia) : '-';

        $totalPengikut = "FB: " . ($umkm->total_pengikut_facebook ?? '0') . "\nIG: " . ($umkm->total_pengikut_instagram ?? '0');

        return [
            $rowNumber,
            $umkm->name,
            $umkm->email,
            $umkm->lokasi ?? '-',
            $umkm->nib ?? 'Belum ada NIB',
            $umkm->created_at->format('d-m-Y'),
            $socialMediaText,
            $totalPengikut,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling untuk header (baris 1)
            1    => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4A90E2']], // Warna biru profesional
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ],
            // Styling untuk semua data (baris 2 dan seterusnya)
            'A2:H' . $sheet->getHighestRow() => [
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']], // Latar belakang abu-abu muda
            ],
        ];
    }
}