<?php

namespace App\Console\Commands;

use App\Services\TagihanBulananService;
use Illuminate\Console\Command;

class TerbitkanTagihanBulanan extends Command
{
    protected $signature = 'tagihan:terbitkan';

    protected $description =
        'Menerbitkan tagihan sewa kamar bulanan KosHaven';

    public function handle(
        TagihanBulananService $service
    ): int {
        try {
            $hasil = $service->terbitkanSemua();

            $this->info('Penerbitan tagihan selesai.');

            $this->table(
                ['Keterangan', 'Jumlah'],
                [
                    ['Booking diperiksa', $hasil['diperiksa']],
                    ['Tagihan baru dibuat', $hasil['dibuat']],
                    ['Tagihan menjadi terlambat', $hasil['terlambat']],
                ]
            );

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);

            $this->error(
                'Gagal menerbitkan tagihan: ' . $e->getMessage()
            );

            return self::FAILURE;
        }
    }
}
