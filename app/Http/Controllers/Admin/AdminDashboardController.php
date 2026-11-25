<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // ==========================================
        // STATISTIK UTAMA
        // ==========================================

        $totalKamar = DB::table('kamars')->count();

        $totalPenghuni = DB::table('bookings')
            ->where('status', 'disetujui')
            ->whereDate('tanggal_masuk', '<=', $hariIni)
            ->where(function ($query) use ($hariIni) {
                $query->whereNull('tanggal_keluar')
                    ->orWhereDate('tanggal_keluar', '>=', $hariIni);
            })
            ->distinct('user_id')
            ->count('user_id');

        $totalTagihanBelumLunas = DB::table('tagihans')
            ->whereIn('status', [
                'belum_dibayar',
                'menunggu_verifikasi',
                'terlambat',
            ])
            ->count();

        $totalPembayaranDiterima = DB::table('pembayarans')
            ->where('status', 'disetujui')
            ->count();

        // ==========================================
        // RINGKASAN STATUS KAMAR
        // ==========================================

        $kamarTerisi = DB::table('kamars')
            ->where('status', 'terisi')
            ->count();

        $kamarTersedia = DB::table('kamars')
            ->where('status', 'tersedia')
            ->count();

        $kamarMaintenance = DB::table('kamars')
            ->where('status', 'maintenance')
            ->count();

        // ==========================================
        // TOTAL PENDAPATAN DARI PEMBAYARAN DISETUJUI
        // ==========================================

        $totalPendapatan = DB::table('pembayarans')
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');

        // ==========================================
        // PEMBAYARAN TERBARU
        // ==========================================

        $pembayaranTerbaru = DB::table('pembayarans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('tagihans as t', 't.id', '=', 'p.tagihan_id')
            ->join('bookings as b', 'b.id', '=', 't.booking_id')
            ->join('kamars as k', 'k.id', '=', 'b.kamar_id')
            ->select(
                'p.id',
                'u.name as nama_penghuni',
                'k.nomor_kamar',
                't.periode',
                'p.jumlah_bayar',
                'p.tanggal_pembayaran',
                'p.status'
            )
            ->orderByDesc('p.tanggal_pembayaran')
            ->orderByDesc('p.created_at')
            ->limit(5)
            ->get();

        // ==========================================
        // AKTIVITAS TERBARU DARI BOOKING
        // DAN PEMBAYARAN
        // ==========================================

        $aktivitasBooking = DB::table('bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->join('kamars as k', 'k.id', '=', 'b.kamar_id')
            ->select(
                'b.id',
                'u.name as nama_pengguna',
                'k.nomor_kamar',
                'b.status',
                'b.created_at'
            )
            ->orderByDesc('b.created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'booking',
                    'nama' => $item->nama_pengguna,
                    'keterangan' => 'mengajukan booking kamar ' . $item->nomor_kamar,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            });

        $aktivitasPembayaran = DB::table('pembayarans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->select(
                'p.id',
                'u.name as nama_pengguna',
                'p.jumlah_bayar',
                'p.status',
                'p.created_at'
            )
            ->orderByDesc('p.created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => 'pembayaran',
                    'nama' => $item->nama_pengguna,
                    'keterangan' => 'mengirim pembayaran sebesar Rp' .
                        number_format($item->jumlah_bayar, 0, ',', '.'),
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            });

        $aktivitasTerbaru = $aktivitasBooking
            ->concat($aktivitasPembayaran)
            ->sortByDesc(function ($item) {
                return $item['created_at'];
            })
            ->take(5)
            ->values();

        // ==========================================
        // DATA GRAFIK 6 DAN 12 BULAN
        // ==========================================

        $chart6Bulan = $this->buatDataGrafik(6);
        $chart12Bulan = $this->buatDataGrafik(12);

        return view('admin.dashboard', compact(
            'totalKamar',
            'totalPenghuni',
            'totalTagihanBelumLunas',
            'totalPembayaranDiterima',
            'kamarTerisi',
            'kamarTersedia',
            'kamarMaintenance',
            'totalPendapatan',
            'pembayaranTerbaru',
            'aktivitasTerbaru',
            'chart6Bulan',
            'chart12Bulan'
        ));
    }

    /**
     * Membuat data grafik pembayaran dan tagihan.
     */
    private function buatDataGrafik(int $jumlahBulan): array
    {
        $labels = [];
        $pembayaranLunas = [];
        $tagihanBelumLunas = [];

        $tanggalAwal = Carbon::now()
            ->startOfMonth()
            ->subMonths($jumlahBulan - 1);

        for ($i = 0; $i < $jumlahBulan; $i++) {
            $tanggal = $tanggalAwal->copy()->addMonths($i);

            $labels[] = $tanggal->format('m/Y');

            $pembayaranLunas[] = DB::table('pembayarans')
                ->where('status', 'disetujui')
                ->whereYear('tanggal_pembayaran', $tanggal->year)
                ->whereMonth('tanggal_pembayaran', $tanggal->month)
                ->count();

            $tagihanBelumLunas[] = DB::table('tagihans')
                ->whereIn('status', [
                    'belum_dibayar',
                    'menunggu_verifikasi',
                    'terlambat',
                ])
                ->whereYear('tanggal_terbit', $tanggal->year)
                ->whereMonth('tanggal_terbit', $tanggal->month)
                ->count();
        }

        return [
            'labels' => $labels,
            'pembayaran' => $pembayaranLunas,
            'tagihan' => $tagihanBelumLunas,
        ];
    }
}
