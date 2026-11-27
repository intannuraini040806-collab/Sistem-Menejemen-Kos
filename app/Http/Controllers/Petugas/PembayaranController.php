<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pembayaran\TolakPembayaranRequest;
use App\Models\Pembayaran;
use App\Services\PembayaranService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function __construct(
        protected PembayaranService $pembayaranService
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

        $statusMap = [
            'menunggu_verifikasi' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        $methodMap = [
            'transfer' => 'Transfer Bank',
            'tunai' => 'Tunai',
        ];

        $payments = Pembayaran::query()
            ->with(['user', 'booking.kamar', 'tagihan.booking.kamar', 'verifikator'])
            ->latest('tanggal_pembayaran')
            ->latest('id')
            ->get()
            ->map(function (Pembayaran $pembayaran) use ($statusMap, $methodMap) {
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

                $room = $pembayaran->tagihan?->booking?->kamar?->nomor_kamar
                    ?? $pembayaran->booking?->kamar?->nomor_kamar
                    ?? '-';

                $rawMethod = strtolower((string) $pembayaran->metode_pembayaran);

                return [
                    'id' => $pembayaran->id,
                    'name' => $pembayaran->user?->name ?? 'Penghuni',
                    'room' => $room,
                    'period' => $periodLabel,
                    'amount' => (int) $pembayaran->jumlah_bayar,
                    'date' => $pembayaran->tanggal_pembayaran?->toDateString() ?? '',
                    'method' => $methodMap[$rawMethod] ?? ucfirst((string) $pembayaran->metode_pembayaran),
                    'reference' => $pembayaran->referensi_gateway
                        ?: ($pembayaran->tagihan?->nomor_invoice
                            ?: ('PAY-' . str_pad((string) $pembayaran->id, 4, '0', STR_PAD_LEFT))),
                    'status' => $statusMap[$pembayaran->status] ?? 'Menunggu',
                    'reason' => $pembayaran->status === 'ditolak'
                        ? ($pembayaran->catatan ?? '')
                        : '',
                    'note' => $pembayaran->catatan ?? '',
                    'receiptNumber' => $pembayaran->status === 'disetujui' ? $pembayaran->terbitkanKuitansi() : '',
                    'receiptUrl' => $pembayaran->status === 'disetujui'
                        ? route('kuitansi.show', $pembayaran)
                        : '',
                    'proofName' => $pembayaran->bukti_pembayaran
                        ? basename($pembayaran->bukti_pembayaran)
                        : '',
                    'proofUrl' => $pembayaran->bukti_pembayaran
                        ? route('pembayaran.bukti', $pembayaran)
                        : '',
                    'verifikator' => $pembayaran->verifikator?->name ?? '',
                ];
            })
            ->values();

        return view('petugas.pembayaran', [
            'petugasInfo' => $petugasInfo,
            'payments' => $payments,
        ]);
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran): JsonResponse
    {
        $hasil = $this->pembayaranService->verifikasiPembayaran($pembayaran, $request->user());

        if (! $hasil['ok']) {
            return response()->json(['message' => $hasil['message']], 422);
        }

        return response()->json([
            'message' => $hasil['message'],
            'status' => 'Disetujui',
        ]);
    }

    public function tolak(TolakPembayaranRequest $request, Pembayaran $pembayaran): JsonResponse
    {
        $hasil = $this->pembayaranService->tolakPembayaran(
            $pembayaran,
            $request->user(),
            $request->validated('catatan')
        );

        if (! $hasil['ok']) {
            return response()->json(['message' => $hasil['message']], 422);
        }

        return response()->json([
            'message' => $hasil['message'],
            'status' => 'Ditolak',
            'reason' => $hasil['reason'],
        ]);
    }
}

