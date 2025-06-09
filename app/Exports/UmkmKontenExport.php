<?php

namespace App\Exports;

use App\Models\Konten;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

class UmkmKontenExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $umkmId;

    public function __construct($umkmId)
    {
        $this->umkmId = $umkmId;
    }

    public function collection()
    {
        return Konten::with('analitik')
            ->where('user_id', $this->umkmId)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Konten',
            'Platform',
            'Likes',
            'Comments',
            'Shares',
            'Engagement Rate (%)',
            'Grade',
            'Tanggal Publish',
            'Durasi',
            'Status',
        ];
    }

    public function map($konten): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        $publishedAt = \Carbon\Carbon::parse($konten->tanggal_publish);
        $duration = $publishedAt->diffForHumans();

        return [
            $rowNumber,
            $konten->judul ?? 'Tidak Ditemukan',
            $konten->platform ?? '-',
            $konten->analitik->likes ?? '-',
            $konten->analitik->comments ?? '-',
            $konten->analitik->shares ?? '-',
            $konten->analitik->engagement_rate ? number_format($konten->analitik->engagement_rate, 2) : '-',
            $konten->analitik->grade ?? '-',
            $konten->tanggal_publish ?? '-',
            $duration,
            $konten->status ?? 'Tidak Diketahui',
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
            'A2:K' . $sheet->getHighestRow() => [
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']], // Latar belakang abu-abu muda
            ],
        ];
    }
}