<?php

namespace App\Console\Commands;

use App\Jobs\SendUploadReminder;
use Illuminate\Console\Command;

class SendUploadReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send upload reminders for scheduled content';

    public function handle()
    {
        $this->info('Sending upload reminders...');
        SendUploadReminder::dispatch();
        $this->info('Upload reminders sent successfully.');
    }
}