<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Pengingat tagihan berjalan otomatis setiap hari pukul 08.00 waktu server.
Schedule::command('koshaven:send-tagihan-reminders')->dailyAt('08:00');
