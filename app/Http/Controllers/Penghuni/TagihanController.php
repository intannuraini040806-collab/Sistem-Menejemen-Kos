<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pembayaran\StorePembayaranRequest;
use App\Models\BankAccount;
use App\Models\Setting;
use App\Models\Tagihan;
use App\Services\KosBusinessService;
use App\Services\PembayaranService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function __construct(
        protected KosBusinessService $kosService,
        protected PembayaranService $pembayaranService
    ) {}

    /**
     * Menampilkan tagihan berdasarkan akun penghuni yang login.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $tagihanModels = Tagihan::query()
            ->with([
                'booking.kamar',
                'pembayarans' => fn ($query) => $query->latest('tanggal_pembayaran')->latest('id'),
            ])
            ->whereHas('booking', fn ($query) => $query->where('user_id', $user->id))
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->get();

        $tagihans = $tagihanModels->map(function (Tagihan $tagihan) {
            $adaMenunggu = $tagihan->pembayarans->contains('status', 'menunggu_verifikasi');

            if (! in_array($tagihan->status, ['lunas', 'menunggu_verifikasi'], true) && ! $adaMenunggu) {
                $tagihan = $this->kosService->hitungDendaKeterlambatan($tagihan);
                $tagihan->loadMissing('booking.kamar', 'pembayarans');
            }

            $totalTagihan = (int) $tagihan->jumlah + (int) $tagihan->denda;
            $totalTerbayar = (int) $tagihan->pembayarans
                ->where('status', 'disetujui')
                ->sum('jumlah_bayar');
            $sisaTagihan = max(0, $totalTagihan - $totalTerbayar);

            $pembayaranTerakhir = $tagihan->pembayarans->first();

            if ($tagihan->status === 'lunas' || ($totalTerbayar >= $totalTagihan && $totalTagihan > 0)) {
                $statusTampilan = 'lunas';
            } elseif ($adaMenunggu) {
                $statusTampilan = 'menunggu_verifikasi';
            } elseif ($totalTerbayar > 0) {
                $statusTampilan = 'dibayar_sebagian';
            } elseif ($tagihan->tanggal_jatuh_tempo && $tagihan->tanggal_jatuh_tempo->lt(today())) {
                $statusTampilan = 'terlambat';
            } else {
                $statusTampilan = 'belum_dibayar';
            }

            $bulan = '-';
            $tahun = '';
            if ($tagihan->periode && preg_match('/^\d{4}-\d{2}$/', $tagihan->periode)) {
                $parsedPeriode = Carbon::createFromFormat('Y-m', $tagihan->periode)->locale('id');
                $bulan = $parsedPeriode->translatedFormat('F');
                $tahun = $parsedPeriode->format('Y');
            } elseif ($tagihan->tanggal_jatuh_tempo) {
                $bulan = $tagihan->tanggal_jatuh_tempo->locale('id')->translatedFormat('F');
                $tahun = $tagihan->tanggal_jatuh_tempo->format('Y');
            }

            $metodeMap = [
                'transfer' => 'Transfer Bank',
                'tunai' => 'Tunai',
            ];

            $rawMethod = strtolower((string) ($pembayaranTerakhir?->metode_pembayaran ?? ''));

            return [
                'id' => $tagihan->id,
                'kode' => $tagihan->nomor_invoice ?: ('KH-' . str_pad((string) $tagihan->id, 4, '0', STR_PAD_LEFT)),
                'periode' => $tagihan->periode,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'nomor_kamar' => $tagihan->booking?->kamar?->nomor_kamar ?? '-',
                'jumlah_pokok' => (int) $tagihan->jumlah,
                'denda' => (int) $tagihan->denda,
                'jumlah' => $totalTagihan,
                'terbayar' => $totalTerbayar,
                'sisa' => $sisaTagihan,
                'jatuh_tempo' => $tagihan->tanggal_jatuh_tempo?->toDateString(),
                'tanggal_bayar' => $pembayaranTerakhir?->tanggal_pembayaran?->toDateString(),
                'status' => $statusTampilan,
                'ada_menunggu' => $adaMenunggu,
                'bisa_bayar' => $sisaTagihan > 0 && ! $adaMenunggu && $statusTampilan !== 'lunas',
                'keterangan' => $tagihan->keterangan ?: '-',
                'metode' => $metodeMap[$rawMethod] ?? ($pembayaranTerakhir?->metode_pembayaran ? ucfirst($pembayaranTerakhir->metode_pembayaran) : '-'),
                'bukti_url' => $pembayaranTerakhir?->bukti_pembayaran
                    ? route('pembayaran.bukti', $pembayaranTerakhir)
                    : null,
                'bukti_nama' => $pembayaranTerakhir?->bukti_pembayaran
                    ? basename($pembayaranTerakhir->bukti_pembayaran)
                    : null,
                'alasan_tolak' => $pembayaranTerakhir?->status === 'ditolak'
                    ? ($pembayaranTerakhir->catatan ?? '')
                    : '',
                'bayar_url' => route('penghuni.tagihan.bayar', $tagihan),
            ];
        })->values();

        $ringkasan = [
            'total' => $tagihans->count(),
            'belum_dibayar' => $tagihans->whereIn('status', ['belum_dibayar', 'dibayar_sebagian'])->count(),
            'menunggu_verifikasi' => $tagihans->where('status', 'menunggu_verifikasi')->count(),
            'lunas' => $tagihans->where('status', 'lunas')->count(),
            'terlambat' => $tagihans->where('status', 'terlambat')->count(),
            'total_nominal' => $tagihans->sum('jumlah'),
            'total_terbayar' => $tagihans->sum('terbayar'),
            'total_sisa' => $tagihans->sum('sisa'),
        ];

        $bankAccounts = BankAccount::query()
            ->where('is_aktif', true)
            ->orderBy('nama_bank')
            ->get()
            ->map(fn (BankAccount $bank) => [
                'id' => $bank->id,
                'nama_bank' => $bank->nama_bank,
                'nomor_rekening' => $bank->nomor_rekening,
                'atas_nama' => $bank->atas_nama,
            ])
            ->values();

        $kosInfo = [
            'nama_kos' => Setting::getVal('nama_kos', 'KosHaven - Hunian Nyaman'),
            'slogan_kos' => Setting::getVal('slogan_kos', 'Hunian Nyaman, Hidup Lebih Tenang.'),
            'whatsapp' => Setting::getVal('whatsapp_pengelola', '628815693992'),
        ];

        return view('penghuni.tagihan', [
            'tagihans' => $tagihans,
            'ringkasan' => $ringkasan,
            'bankAccounts' => $bankAccounts,
            'kosInfo' => $kosInfo,
        ]);
    }

    /**
     * Memproses pengajuan pembayaran tagihan oleh penghuni.
     */
    public function bayar(StorePembayaranRequest $request, Tagihan $tagihan): JsonResponse|RedirectResponse
    {
        $hasil = $this->pembayaranService->ajukanPembayaranTagihan(
            $request->user(),
            $tagihan,
            $request->validated(),
            $request->file('bukti_pembayaran')
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $hasil['message'],
                'pembayaran_id' => $hasil['pembayaran']?->id ?? null,
                'status_tagihan' => $hasil['tagihan']?->status ?? null,
            ], $hasil['status']);
        }

        if (! $hasil['ok']) {
            return back()->with('error', $hasil['message']);
        }

        return back()->with('success', $hasil['message']);
    }
}
