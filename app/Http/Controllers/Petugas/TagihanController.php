<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Services\KosBusinessService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function __construct(
        protected KosBusinessService $kosService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        $inisial = collect(preg_split('/\s+/', trim($user->name ?: 'PT')))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('') ?: 'PT';

        $petugasInfo = [
            'nama' => $user->name ?? 'Petugas Kos',
            'inisial' => $inisial,
        ];

        $bills = Tagihan::query()
            ->with(['booking.user', 'booking.kamar', 'pembayarans'])
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->get()
            ->map(function (Tagihan $tagihan) {
                $adaMenunggu = $tagihan->pembayarans->contains('status', 'menunggu_verifikasi');

                if (! in_array($tagihan->status, ['lunas', 'menunggu_verifikasi'], true) && ! $adaMenunggu) {
                    $tagihan = $this->kosService->hitungDendaKeterlambatan($tagihan);
                    $tagihan->loadMissing('booking.user', 'booking.kamar', 'pembayarans');
                }

                $monthKey = preg_match('/^\d{4}-\d{2}$/', (string) $tagihan->periode)
                    ? $tagihan->periode
                    : ($tagihan->tanggal_terbit?->format('Y-m') ?? now()->format('Y-m'));

                $periodLabel = Carbon::createFromFormat('Y-m', $monthKey)
                    ->locale('id')
                    ->translatedFormat('F Y');

                $totalTagihan = (int) $tagihan->jumlah + (int) $tagihan->denda;
                $totalTerbayar = (int) $tagihan->pembayarans
                    ->where('status', 'disetujui')
                    ->sum('jumlah_bayar');

                if ($tagihan->status === 'lunas' || ($totalTerbayar >= $totalTagihan && $totalTagihan > 0)) {
                    $statusLabel = 'Lunas';
                } elseif ($adaMenunggu) {
                    $statusLabel = 'Menunggu Verifikasi';
                } elseif ($totalTerbayar > 0) {
                    $statusLabel = 'Dibayar Sebagian';
                } elseif ($tagihan->tanggal_jatuh_tempo && $tagihan->tanggal_jatuh_tempo->lt(today())) {
                    $statusLabel = 'Terlambat';
                } else {
                    $statusLabel = 'Belum Dibayar';
                }

                return [
                    'id' => $tagihan->id,
                    'kode' => $tagihan->nomor_invoice ?: ('TG-' . str_pad((string) $tagihan->id, 3, '0', STR_PAD_LEFT)),
                    'name' => $tagihan->booking?->user?->name ?? 'Penghuni',
                    'room' => $tagihan->booking?->kamar?->nomor_kamar ?? '-',
                    'period' => $periodLabel,
                    'month' => $monthKey,
                    'amount' => $totalTagihan,
                    'denda' => (int) $tagihan->denda,
                    'terbayar' => $totalTerbayar,
                    'sisa' => max(0, $totalTagihan - $totalTerbayar),
                    'dueDate' => $tagihan->tanggal_jatuh_tempo?->toDateString() ?? '',
                    'status' => $statusLabel,
                ];
            })
            ->values();

        return view('petugas.tagihan', [
            'petugasInfo' => $petugasInfo,
            'bills' => $bills,
        ]);
    }
}

