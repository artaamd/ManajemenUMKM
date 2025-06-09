<?php

namespace App\Console\Commands;

use App\Models\Konten;
use App\Models\Analitik;
use Illuminate\Console\Command;

class CreateMissingAnalitiks extends Command
{
    protected $signature = 'analitiks:fill-missing';
    protected $description = 'Create Analitik entries for Konten that do not have them';

    public function handle()
    {
        $kontens = Konten::doesntHave('analitik')->get();

        if ($kontens->isEmpty()) {
            $this->info('Tidak ada konten yang membutuhkan entri Analitik.');
            return;
        }

        foreach ($kontens as $konten) {
            Analitik::create([
                'konten_id' => $konten->id,
                'platform' => $konten->platform,
            ]);
            $this->info("Created Analitik for Konten ID: {$konten->id}");
        }

        $this->info('Selesai membuat entri Analitik yang hilang.');
    }
}