<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pembayaran\TolakPembayaranRequest;
use App\Models\Pembayaran;
use App\Services\PembayaranService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(
        protected PembayaranService $pembayaranService
    ) {}

    /**
     * Menampilkan daftar pembayaran dan statistik.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                'in:menunggu_verifikasi,disetujui,ditolak',
            ],
            'bulan' => [
                'nullable',
                'regex:/^\d{4}-(0[1-9]|1[0-2])$/',
            ],
        ]);

        $query = Pembayaran::with([
            'user',
            'booking.kamar',
            'tagihan.booking.kamar',
            'verifikator',
        ])->latest();

        if (!empty($validated['search'])) {
            $keyword = trim($validated['search']);

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                })->orWhereHas(
                    'tagihan.booking.kamar',
                    function ($kamarQuery) use ($keyword) {
                        $kamarQuery->where(
                            'nomor_kamar',
                            'like',
                            "%{$keyword}%"
                        );
                    }
                )->orWhereHas(
                    'booking.kamar',
                    function ($kamarQuery) use ($keyword) {
                        $kamarQuery->where(
                            'nomor_kamar',
                            'like',
                            "%{$keyword}%"
                        );
                    }
                );
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['bulan'])) {
            $query->whereHas('tagihan', function ($tagihanQuery) use ($validated) {
                $tagihanQuery->where('periode', $validated['bulan']);
            });
        }

        $totalPembayaran = Pembayaran::count();
        $totalDiterima = Pembayaran::where('status', 'disetujui')
            ->sum('jumlah_bayar');
        $jumlahTerverifikasi = Pembayaran::where('status', 'disetujui')
            ->count();
        $jumlahMenunggu = Pembayaran::where('status', 'menunggu_verifikasi')
            ->count();
        $jumlahDitolak = Pembayaran::where('status', 'ditolak')
            ->count();

        $pembayarans = $query->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact(
            'pembayarans',
            'totalPembayaran',
            'totalDiterima',
            'jumlahTerverifikasi',
            'jumlahMenunggu',
            'jumlahDitolak'
        ));
    }

    /**
     * Memverifikasi pembayaran penghuni (mendukung DP Booking maupun Cicilan Tagihan).
     */
    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $hasil = $this->pembayaranService->verifikasiPembayaran($pembayaran, $request->user());

        if (! $hasil['ok']) {
            return back()->with('error', $hasil['message']);
        }

        return back()->with('success', $hasil['message']);
    }

    /**
     * Menolak pembayaran penghuni dan menghitung ulang saldo tagihan.
     */
    public function tolak(TolakPembayaranRequest $request, Pembayaran $pembayaran)
    {
        $hasil = $this->pembayaranService->tolakPembayaran(
            $pembayaran,
            $request->user(),
            $request->validated('catatan')
        );

        if (! $hasil['ok']) {
            return back()->with('error', $hasil['message']);
        }

        return back()->with('success', $hasil['message']);
    }
}