<?php

namespace App\Exports;

use App\Models\Konten;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UmkmKontenExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $umkmId;

    public function __construct($umkmId)
    {
        $this->umkmId = $umkmId;
    }

    public function collection()
    {
        return Konten::with('analitik')->where('user_id', $this->umkmId)->get();
    }

    public function title(): string
    {
        return 'Laporan Kinerja Konten';
    }

    public function headings(): array
    {
        return [
            'No', 'Judul Konten', 'Platform', 'Likes', 'Comments', 'Shares',
            'Engagement Rate (%)', 'Grade', 'Tanggal Publish'
        ];
    }

    public function map($konten): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $konten->judul ?? '-',
            $konten->platform ?? '-',
            $konten->analitik->likes ?? 0,
            $konten->analitik->comments ?? 0,
            $konten->analitik->shares ?? 0,
            $konten->analitik ? number_format($konten->analitik->engagement_rate, 2) : '0.00',
            $konten->analitik->grade ?? '-',
            $konten->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->format('d-m-Y') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style Header
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        $sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('007BFF');

        // Pewarnaan Kondisional berdasarkan Grade
        foreach ($sheet->getColumnIterator('H') as $column) {
            foreach ($column->getCellIterator() as $cell) {
                if ($cell->getRow() > 1) { // Mulai dari baris kedua
                    $grade = $cell->getValue();
                    $color = '';
                    switch ($grade) {
                        case 'A': $color = 'D4EDDA'; break; // Hijau
                        case 'B': $color = 'CCE5FF'; break; // Biru
                        case 'C': $color = 'FFF3CD'; break; // Kuning
                        case 'D': $color = 'F8D7DA'; break; // Merah
                    }
                    if ($color) {
                        $sheet->getStyle($cell->getCoordinate())->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
                    }
                }
            }
        }
    }
}