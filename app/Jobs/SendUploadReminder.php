<?php

namespace App\Jobs;

use App\Models\Konten;
use App\Notifications\UploadReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendUploadReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $now = Carbon::now();
        $kontens = Konten::where('status', 'scheduled')
            ->where('tanggal_publish', '<=', $now)
            ->get();

        foreach ($kontens as $konten) {
            $konten->user->notify(new UploadReminderNotification($konten));
        }
    }
}