<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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

        // Menghitung booking aktif pada kamar yang sedang terisi.
        // Setiap booking aktif dihitung sebagai satu penghuni.
        $totalPenghuni = DB::table('bookings as b')
            ->join('kamars as k', 'k.id', '=', 'b.kamar_id')
            ->where('b.status', 'disetujui')
            ->where('k.status', 'terisi')
            ->whereDate('b.tanggal_masuk', '<=', $hariIni)
            ->where(function ($query) use ($hariIni) {
                $query->whereNull('b.tanggal_keluar')
                    ->orWhereDate('b.tanggal_keluar', '>=', $hariIni);
            })
            ->distinct()
            ->count('b.id');

        // Ambil seluruh tagihan beserta status aktualnya.
        $dataTagihan = $this->ambilDataTagihan();

        $totalTagihan = $dataTagihan->count();

        // Menghitung semua tagihan yang belum lunas.
        // Termasuk belum dibayar, terlambat,
        // menunggu verifikasi, dan dibayar sebagian.
        $totalTagihanBelumLunas = $dataTagihan
            ->where('status_tampilan', '!=', 'lunas')
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
        // TOTAL PENDAPATAN
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

        $chart6Bulan = $this->buatDataGrafik(6, $dataTagihan);
        $chart12Bulan = $this->buatDataGrafik(12, $dataTagihan);

        // ==========================================
        // KIRIM DATA KE DASHBOARD
        // ==========================================

        return view('admin.dashboard', compact(
            'totalKamar',
            'totalPenghuni',
            'totalTagihan',
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
     * Mengambil seluruh tagihan beserta total pembayaran
     * yang disetujui dan jumlah pembayaran yang menunggu verifikasi.
     */
    private function ambilDataTagihan(): Collection
    {
        $pembayaranDisetujui = DB::table('pembayarans')
            ->select('tagihan_id')
            ->selectRaw('SUM(jumlah_bayar) as total_terbayar')
            ->where('status', 'disetujui')
            ->groupBy('tagihan_id');

        $pembayaranMenunggu = DB::table('pembayarans')
            ->select('tagihan_id')
            ->selectRaw('COUNT(*) as jumlah_menunggu')
            ->where('status', 'menunggu_verifikasi')
            ->groupBy('tagihan_id');

        return DB::table('tagihans as t')
            ->leftJoinSub($pembayaranDisetujui, 'pd', function ($join) {
                $join->on('pd.tagihan_id', '=', 't.id');
            })
            ->leftJoinSub($pembayaranMenunggu, 'pm', function ($join) {
                $join->on('pm.tagihan_id', '=', 't.id');
            })
            ->select(
                't.id',
                't.jumlah',
                't.denda',
                't.status',
                't.tanggal_terbit',
                't.tanggal_jatuh_tempo'
            )
            ->selectRaw('COALESCE(pd.total_terbayar, 0) as total_terbayar')
            ->selectRaw('COALESCE(pm.jumlah_menunggu, 0) as jumlah_menunggu')
            ->get()
            ->map(function ($tagihan) {
                $tagihan->status_tampilan = $this->tentukanStatusTagihan($tagihan);

                return $tagihan;
            });
    }

    /**
     * Menentukan status tagihan berdasarkan kondisi pembayaran sebenarnya.
     *
     * Urutan:
     * 1. Lunas
     * 2. Menunggu verifikasi
     * 3. Terlambat
     * 4. Dibayar sebagian
     * 5. Belum dibayar
     */
    private function tentukanStatusTagihan(object $tagihan): string
    {
        $totalKewajiban = (int) $tagihan->jumlah + (int) $tagihan->denda;
        $totalTerbayar = (int) $tagihan->total_terbayar;

        $sisaTagihan = max(0, $totalKewajiban - $totalTerbayar);

        if (
            $totalKewajiban > 0 &&
            $totalTerbayar >= $totalKewajiban
        ) {
            return 'lunas';
        }

        if ((int) $tagihan->jumlah_menunggu > 0) {
            return 'menunggu_verifikasi';
        }

        if (
            $sisaTagihan > 0 &&
            !empty($tagihan->tanggal_jatuh_tempo) &&
            Carbon::parse($tagihan->tanggal_jatuh_tempo)
                ->startOfDay()
                ->lt(Carbon::today())
        ) {
            return 'terlambat';
        }

        if ($totalTerbayar > 0) {
            return 'dibayar_sebagian';
        }

        return 'belum_dibayar';
    }

    /**
     * Membuat data grafik pembayaran dan tagihan.
     */
    private function buatDataGrafik(
        int $jumlahBulan,
        Collection $dataTagihan
    ): array {
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

            $tagihanBelumLunas[] = $dataTagihan
                ->filter(function ($tagihan) use ($tanggal) {
                    if (
                        empty($tagihan->tanggal_terbit) ||
                        $tagihan->status_tampilan === 'lunas'
                    ) {
                        return false;
                    }

                    $tanggalTerbit = Carbon::parse($tagihan->tanggal_terbit);

                    return $tanggalTerbit->year === $tanggal->year
                        && $tanggalTerbit->month === $tanggal->month;
                })
                ->count();
        }

        return [
            'labels' => $labels,
            'pembayaran' => $pembayaranLunas,
            'tagihan' => $tagihanBelumLunas,
        ];
    }
}
