<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Mengambil booking aktif milik penghuni yang sedang login.
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

        // Mengambil seluruh tagihan milik penghuni.
        $tagihans = Tagihan::query()
            ->with(['booking.kamar', 'pembayarans'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('periode')
            ->get();

        // Mengambil tagihan bulan berjalan.
        $tagihanBulanIni = $tagihans->firstWhere(
            'periode',
            now()->format('Y-m')
        );

        // Jika belum ada tagihan bulan ini, gunakan tagihan terbaru.
        $tagihanUtama = $tagihanBulanIni ?? $tagihans->first();

        // Mengambil riwayat pembayaran milik penghuni.
        $riwayatPembayaran = $user->pembayarans()
            ->with(['tagihan.booking.kamar', 'verifikator'])
            ->latest('tanggal_pembayaran')
            ->latest('id')
            ->get();

        // Mengambil data kamar dari booking aktif.
        $kamar = $bookingAktif?->kamar;

        $fasilitasKamar = $kamar?->fasilitas ?? [];

        if (! is_array($fasilitasKamar)) {
            $fasilitasKamar = [];
        }

        return view('penghuni.dashboard', [
            'user' => $user,
            'bookingAktif' => $bookingAktif,
            'kamar' => $kamar,
            'tagihans' => $tagihans,
            'tagihanBulanIni' => $tagihanBulanIni,
            'tagihanUtama' => $tagihanUtama,
            'riwayatPembayaran' => $riwayatPembayaran,
            'fasilitasKamar' => $fasilitasKamar,
        ]);
    }
}
