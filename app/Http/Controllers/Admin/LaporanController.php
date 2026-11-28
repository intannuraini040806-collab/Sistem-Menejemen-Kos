<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. VALIDASI FILTER BULAN DAN TAHUN
        |--------------------------------------------------------------------------
        */

        $tahunInput = $request->input('tahun', now()->year);
        $bulanInput = $request->input('bulan', now()->format('m'));

        $tahun = filter_var($tahunInput, FILTER_VALIDATE_INT);

        if ($tahun === false || $tahun < 2000 || $tahun > 2100) {
            $tahun = now()->year;
        }

        $bulan = is_string($bulanInput)
            ? trim($bulanInput)
            : now()->format('m');

        if ($bulan !== 'all') {
            if (!ctype_digit($bulan)) {
                $bulan = now()->format('m');
            } else {
                $bulan = str_pad(
                    (string) (int) $bulan,
                    2,
                    '0',
                    STR_PAD_LEFT
                );

                if ((int) $bulan < 1 || (int) $bulan > 12) {
                    $bulan = now()->format('m');
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. RENTANG TANGGAL LAPORAN
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $bulan === 'all'
            ? Carbon::create($tahun, 1, 1)->startOfDay()
            : Carbon::create($tahun, (int) $bulan, 1)->startOfMonth();

        $tanggalAkhir = $bulan === 'all'
            ? Carbon::create($tahun, 12, 31)->endOfDay()
            : Carbon::create($tahun, (int) $bulan, 1)->endOfMonth();

        $hariIni = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | 3. RINGKASAN TAGIHAN - MENGIKUTI DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        |
        | Seluruh tagihan dihitung tanpa filter bulan atau tahun,
        | sama seperti AdminDashboardController.
        |
        | Status ditentukan dari:
        | - Total pembayaran yang disetujui.
        | - Total pembayaran yang menunggu verifikasi.
        | - Jumlah tagihan dan denda.
        | - Tanggal jatuh tempo.
        |
        */

        $semuaTagihan = $this->ambilDataTagihan();

        $totalTagihan = $semuaTagihan->count();

        $tagihanLunas = $semuaTagihan
            ->where('status_tampilan', 'lunas')
            ->count();

        $tagihanTerlambat = $semuaTagihan
            ->where('status_tampilan', 'terlambat')
            ->count();

        $tagihanTertunda = $semuaTagihan
            ->whereIn('status_tampilan', [
                'belum_dibayar',
                'menunggu_verifikasi',
                'dibayar_sebagian',
            ])
            ->count();

        // Total tagihan belum lunas harus sama dengan Dashboard Admin.
        // Termasuk tagihan tertunda dan tagihan terlambat.
        $totalTagihanBelumLunas = $semuaTagihan
            ->where('status_tampilan', '!=', 'lunas')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 4. DATA PEMBAYARAN
        |--------------------------------------------------------------------------
        |
        | Total pendapatan mengikuti Dashboard Admin:
        | seluruh pembayaran dengan status disetujui.
        |
        | Statistik jumlah transaksi lainnya tetap mengikuti
        | filter bulan dan tahun yang dipilih.
        |
        */

        $pembayaranQuery = DB::table('pembayarans')
            ->whereRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at)) BETWEEN ? AND ?',
                [
                    $tanggalMulai->toDateString(),
                    $tanggalAkhir->toDateString(),
                ]
            );

        // Sama persis dengan perhitungan pendapatan Dashboard Admin.
        $totalPendapatan = DB::table('pembayarans')
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');

        $totalPembayaran = (clone $pembayaranQuery)->count();

        $jumlahTerverifikasi = (clone $pembayaranQuery)
            ->where('status', 'disetujui')
            ->count();

        $pembayaranMenunggu = (clone $pembayaranQuery)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        $pembayaranDitolak = (clone $pembayaranQuery)
            ->where('status', 'ditolak')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 5. DATA KAMAR
        |--------------------------------------------------------------------------
        */

        $totalKamar = DB::table('kamars')->count();

        $kamarTerisi = DB::table('kamars')
            ->where('status', 'terisi')
            ->count();

        $kamarTersedia = DB::table('kamars')
            ->where('status', 'tersedia')
            ->count();

        $kamarMaintenance = DB::table('kamars')
            ->where('status', 'maintenance')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 6. DATA PENGHUNI AKTIF
        |--------------------------------------------------------------------------
        |
        | Mengikuti perhitungan Dashboard Admin:
        | - Booking disetujui.
        | - Kamar berstatus terisi.
        | - Tanggal masuk sudah berlaku.
        | - Tanggal keluar belum lewat.
        | - Menghitung berdasarkan ID booking.
        |
        */

        $totalPenghuniAktif = DB::table('bookings as b')
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

        /*
        |--------------------------------------------------------------------------
        | 7. PERSENTASE STATUS TAGIHAN
        |--------------------------------------------------------------------------
        */

        $persentaseLunas = $totalTagihan > 0
            ? round(($tagihanLunas / $totalTagihan) * 100)
            : 0;

        $persentaseTertunda = $totalTagihan > 0
            ? round(($tagihanTertunda / $totalTagihan) * 100)
            : 0;

        $persentaseTerlambat = $totalTagihan > 0
            ? round(($tagihanTerlambat / $totalTagihan) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | 8. RIWAYAT TRANSAKSI PEMBAYARAN
        |--------------------------------------------------------------------------
        |
        | Riwayat tetap mengikuti filter bulan dan tahun.
        |
        */

        $pembayaran = DB::table('pembayarans')
            ->leftJoin(
                'users',
                'users.id',
                '=',
                'pembayarans.user_id'
            )
            ->leftJoin(
                'tagihans',
                'tagihans.id',
                '=',
                'pembayarans.tagihan_id'
            )
            ->leftJoin(
                'bookings',
                'bookings.id',
                '=',
                'tagihans.booking_id'
            )
            ->leftJoin(
                'kamars',
                'kamars.id',
                '=',
                'bookings.kamar_id'
            )
            ->whereRaw(
                'DATE(COALESCE(pembayarans.tanggal_pembayaran, pembayarans.created_at)) BETWEEN ? AND ?',
                [
                    $tanggalMulai->toDateString(),
                    $tanggalAkhir->toDateString(),
                ]
            )
            ->select(
                'pembayarans.id',
                'users.name as nama_penghuni',
                'kamars.nomor_kamar',
                'pembayarans.metode_pembayaran as metode',
                'pembayarans.jumlah_bayar',
                'pembayarans.status',
                'pembayarans.tanggal_pembayaran',
                'pembayarans.bukti_pembayaran',
                'pembayarans.created_at'
            )
            ->selectRaw(
                'DATE(COALESCE(pembayarans.tanggal_pembayaran, pembayarans.created_at)) as tanggal_laporan'
            )
            ->orderByRaw(
                'COALESCE(pembayarans.tanggal_pembayaran, pembayarans.created_at) DESC'
            )
            ->orderByDesc('pembayarans.id')
            ->limit(200)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 9. DATA GRAFIK PENDAPATAN
        |--------------------------------------------------------------------------
        |
        | Grafik tetap mengikuti periode yang dipilih.
        | Hanya pembayaran disetujui yang dihitung.
        |
        */

        $dataGrafik = DB::table('pembayarans')
            ->where('status', 'disetujui')
            ->whereRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at)) BETWEEN ? AND ?',
                [
                    $tanggalMulai->toDateString(),
                    $tanggalAkhir->toDateString(),
                ]
            )
            ->selectRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at)) as tanggal'
            )
            ->selectRaw('SUM(jumlah_bayar) as total')
            ->groupByRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at))'
            )
            ->get();

        $chartData = [];

        if ($bulan === 'all') {
            $namaBulan = [
                'Jan', 'Feb', 'Mar', 'Apr',
                'Mei', 'Jun', 'Jul', 'Agu',
                'Sep', 'Okt', 'Nov', 'Des',
            ];

            $chartLabels = $namaBulan;
            $pendapatanBulanan = array_fill(1, 12, 0);

            foreach ($dataGrafik as $item) {
                $nomorBulan = (int) Carbon::parse($item->tanggal)
                    ->format('n');

                $pendapatanBulanan[$nomorBulan] += (int) $item->total;
            }

            foreach (range(1, 12) as $nomorBulan) {
                $chartData[] = $pendapatanBulanan[$nomorBulan];
            }
        } else {
            $jumlahHari = $tanggalMulai->daysInMonth;

            $chartLabels = range(1, $jumlahHari);
            $pendapatanHarian = array_fill(1, $jumlahHari, 0);

            foreach ($dataGrafik as $item) {
                $nomorHari = (int) Carbon::parse($item->tanggal)
                    ->format('j');

                $pendapatanHarian[$nomorHari] += (int) $item->total;
            }

            foreach ($chartLabels as $hari) {
                $chartData[] = $pendapatanHarian[$hari];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 10. LABEL PERIODE LAPORAN
        |--------------------------------------------------------------------------
        */

        $periodeLabel = $bulan === 'all'
            ? 'Tahun ' . $tahun
            : Carbon::create($tahun, (int) $bulan, 1)
                ->translatedFormat('F Y');

        /*
        |--------------------------------------------------------------------------
        | 11. KIRIM DATA KE HALAMAN LAPORAN
        |--------------------------------------------------------------------------
        */

        return view('admin.laporan.index', compact(
            'tahun',
            'bulan',
            'periodeLabel',

            'totalTagihan',
            'totalTagihanBelumLunas',
            'tagihanLunas',
            'tagihanTertunda',
            'tagihanTerlambat',

            'totalPendapatan',
            'totalPembayaran',
            'jumlahTerverifikasi',
            'pembayaranMenunggu',
            'pembayaranDitolak',

            'totalKamar',
            'kamarTerisi',
            'kamarTersedia',
            'kamarMaintenance',

            'totalPenghuniAktif',

            'persentaseLunas',
            'persentaseTertunda',
            'persentaseTerlambat',

            'pembayaran',

            'chartLabels',
            'chartData'
        ));
    }

    /**
     * Mengambil seluruh tagihan dengan aturan yang sama
     * seperti AdminDashboardController.
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
                $tagihan->status_tampilan = $this->tentukanStatusTagihan(
                    $tagihan
                );

                return $tagihan;
            });
    }

    /**
     * Menentukan status tagihan dengan aturan yang sama
     * seperti AdminDashboardController.
     */
    private function tentukanStatusTagihan(object $tagihan): string
    {
        $totalKewajiban = (int) $tagihan->jumlah
            + (int) $tagihan->denda;

        $totalTerbayar = (int) $tagihan->total_terbayar;

        $sisaTagihan = max(0, $totalKewajiban - $totalTerbayar);

        // 1. Lunas jika pembayaran disetujui sudah mencukupi kewajiban.
        if (
            $totalKewajiban > 0 &&
            $totalTerbayar >= $totalKewajiban
        ) {
            return 'lunas';
        }

        // 2. Menunggu verifikasi jika ada pembayaran yang menunggu.
        if ((int) $tagihan->jumlah_menunggu > 0) {
            return 'menunggu_verifikasi';
        }

        // 3. Terlambat jika masih ada kewajiban dan jatuh tempo lewat.
        if (
            $sisaTagihan > 0 &&
            !empty($tagihan->tanggal_jatuh_tempo) &&
            Carbon::parse($tagihan->tanggal_jatuh_tempo)
                ->startOfDay()
                ->lt(Carbon::today())
        ) {
            return 'terlambat';
        }

        // 4. Dibayar sebagian jika sudah ada pembayaran disetujui.
        if ($totalTerbayar > 0) {
            return 'dibayar_sebagian';
        }

        // 5. Belum dibayar.
        return 'belum_dibayar';
    }
}
