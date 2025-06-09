<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UploadReminderNotification extends Notification
{
    use Queueable;

    protected $konten;

    public function __construct($konten)
    {
        $this->konten = $konten;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Ingat! Anda perlu mengunggah konten '{$this->konten->judul}' di {$this->konten->platform} yang dijadwalkan pada {$this->konten->tanggal_publish}.",
            'konten_id' => $this->konten->id,
            'platform' => $this->konten->platform,
            'judul' => $this->konten->judul,
        ];
    }
}