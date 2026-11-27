<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatPembayaranController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $bookingAktif = Booking::query()
            ->with('kamar')
            ->where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where(function ($query) {
                $query->whereNull('tanggal_keluar')
                    ->orWhereDate('tanggal_keluar', '>=', today());
            })
            ->latest('tanggal_masuk')
            ->first();

        $kamarAktif = $bookingAktif?->kamar;

        $inisial = collect(preg_split('/\s+/', trim($user->name ?: 'P')))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('') ?: 'P';

        $akunInfo = [
            'nama' => $user->name ?? 'Penghuni',
            'inisial' => $inisial,
            'nomor_kamar' => $kamarAktif?->nomor_kamar ?? 'Belum ada kamar',
            'biaya_sewa' => (int) ($kamarAktif?->harga ?? 0),
        ];

        $pembayarans = Pembayaran::query()
            ->with(['tagihan.booking.kamar', 'booking.kamar', 'verifikator'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('tagihan.booking', function ($bookingQuery) use ($user) {
                        $bookingQuery->where('user_id', $user->id);
                    })
                    ->orWhereHas('booking', function ($bookingQuery) use ($user) {
                        $bookingQuery->where('user_id', $user->id);
                    });
            })
            ->orderByDesc('tanggal_pembayaran')
            ->orderByDesc('id')
            ->get();

        $statusMap = [
            'disetujui' => 'Lunas',
            'menunggu_verifikasi' => 'Menunggu Konfirmasi',
            'ditolak' => 'Ditolak',
        ];

        $methodMap = [
            'transfer' => 'Transfer Bank',
            'tunai' => 'Tunai',
        ];

        $transactions = $pembayarans->map(function (Pembayaran $pembayaran) use ($statusMap, $methodMap, $akunInfo) {
            $monthKey = $pembayaran->tagihan?->periode
                ?: ($pembayaran->tanggal_pembayaran?->format('Y-m') ?? '');

            $periodLabel = '-';
            if ($monthKey && preg_match('/^\d{4}-\d{2}$/', $monthKey)) {
                $periodLabel = Carbon::createFromFormat('Y-m', $monthKey)
                    ->locale('id')
                    ->translatedFormat('F Y');
            } elseif ($pembayaran->tanggal_pembayaran) {
                $periodLabel = $pembayaran->tanggal_pembayaran
                    ->locale('id')
                    ->translatedFormat('F Y');
            }

            $roomNumber = $pembayaran->tagihan?->booking?->kamar?->nomor_kamar
                ?? $pembayaran->booking?->kamar?->nomor_kamar
                ?? $akunInfo['nomor_kamar'];

            $rawMethod = strtolower((string) $pembayaran->metode_pembayaran);
            $methodLabel = $methodMap[$rawMethod]
                ?? ($pembayaran->metode_pembayaran ? ucfirst($pembayaran->metode_pembayaran) : '-');

            return [
                'id' => $pembayaran->id,
                'invoiceNumber' => $pembayaran->tagihan?->nomor_invoice
                    ?: ('KH-' . str_pad((string) $pembayaran->id, 5, '0', STR_PAD_LEFT)),
                'period' => $periodLabel,
                'month' => $monthKey,
                'room' => $roomNumber,
                'amount' => (int) $pembayaran->jumlah_bayar,
                'paymentDate' => $pembayaran->tanggal_pembayaran?->toDateString() ?? '',
                'paymentMethod' => $methodLabel,
                'status' => $statusMap[$pembayaran->status] ?? 'Menunggu Konfirmasi',
                'proofName' => $pembayaran->bukti_pembayaran
                    ? basename($pembayaran->bukti_pembayaran)
                    : '',
                'proofUrl' => $pembayaran->bukti_pembayaran
                    ? route('pembayaran.bukti', $pembayaran)
                    : '',
                'note' => $pembayaran->catatan ?? '',
                'receiptNumber' => $pembayaran->status === 'disetujui' ? $pembayaran->terbitkanKuitansi() : '',
                'receiptUrl' => $pembayaran->status === 'disetujui'
                    ? route('kuitansi.show', $pembayaran)
                    : '',
                'rejectionReason' => $pembayaran->status === 'ditolak'
                    ? ($pembayaran->catatan ?? '')
                    : '',
                'verifikator' => $pembayaran->verifikator?->name ?? '',
                'verifiedAt' => $pembayaran->tanggal_verifikasi
                    ? $pembayaran->tanggal_verifikasi->locale('id')->translatedFormat('d F Y H:i')
                    : '',
            ];
        })->values();

        $monthOptions = $transactions
            ->filter(fn (array $item) => ! empty($item['month']))
            ->unique('month')
            ->sortByDesc('month')
            ->mapWithKeys(fn (array $item) => [$item['month'] => $item['period']])
            ->all();

        return view('penghuni.riwayat', [
            'akunInfo' => $akunInfo,
            'transactions' => $transactions,
            'monthOptions' => $monthOptions,
        ]);
    }
}

