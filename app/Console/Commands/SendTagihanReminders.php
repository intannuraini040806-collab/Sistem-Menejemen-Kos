<?php

namespace App\Console\Commands;

use App\Models\Tagihan;
use App\Notifications\UserActivityNotification;
use Illuminate\Console\Command;

class SendTagihanReminders extends Command
{
    protected $signature = 'koshaven:send-tagihan-reminders';
    protected $description = 'Mengirim pengingat tagihan kepada penghuni sebelum dan setelah jatuh tempo.';

    public function handle(): int
    {
        $tagihans = Tagihan::query()
            ->with('booking.user')
            ->whereNotIn('status', ['lunas', 'dibatalkan'])
            ->whereNotNull('tanggal_jatuh_tempo')
            ->whereDate('tanggal_jatuh_tempo', '<=', today()->addDays(3))
            ->get();

        $sent = 0;

        foreach ($tagihans as $tagihan) {
            $user = $tagihan->booking?->user;
            if (! $user || ! $user->isPenghuni()) {
                continue;
            }

            $jatuhTempo = $tagihan->tanggal_jatuh_tempo;
            $terlambat = $jatuhTempo->lt(today());
            $key = 'tagihan-reminder-' . $tagihan->id . '-' . today()->toDateString();

            if ($user->notifications()
                ->where('type', UserActivityNotification::class)
                ->where('data->key', $key)
                ->exists()) {
                continue;
            }

            $periode = $tagihan->periode ?: $jatuhTempo->translatedFormat('F Y');
            $pesan = $terlambat
                ? "Tagihan periode {$periode} sudah melewati tanggal jatuh tempo. Silakan periksa tagihan dan lakukan pembayaran."
                : "Tagihan periode {$periode} akan jatuh tempo pada " . $jatuhTempo->translatedFormat('d F Y') . '. Silakan lakukan pembayaran tepat waktu.';

            $user->notify(new UserActivityNotification([
                'key' => $key,
                'title' => $terlambat ? 'Tagihan Melewati Jatuh Tempo' : 'Pengingat Tagihan Kos',
                'message' => $pesan,
                'type' => $terlambat ? 'warning' : 'reminder',
                'icon' => $terlambat ? 'bi-exclamation-triangle' : 'bi-calendar-event',
                'url' => route('penghuni.tagihan.index'),
                'tagihan_id' => $tagihan->id,
            ]));
            $sent++;
        }

        $this->info("{$sent} pengingat tagihan berhasil dikirim.");
        return self::SUCCESS;
    }
}
