<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        | 2. MENENTUKAN RENTANG TANGGAL LAPORAN
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $bulan === 'all'
            ? Carbon::create($tahun, 1, 1)->startOfDay()
            : Carbon::create($tahun, (int) $bulan, 1)->startOfMonth();

        $tanggalAkhir = $bulan === 'all'
            ? Carbon::create($tahun, 12, 31)->endOfDay()
            : Carbon::create($tahun, (int) $bulan, 1)->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | 3. DATA TAGIHAN
        |--------------------------------------------------------------------------
        */

        $periodeQuery = DB::table('tagihans');

        if ($bulan === 'all') {
            $periodeQuery->where(
                'periode',
                'like',
                $tahun . '-%'
            );
        } else {
            $periodeQuery->where(
                'periode',
                $tahun . '-' . $bulan
            );
        }

        $totalTagihan = (clone $periodeQuery)->count();

        // Tagihan yang sudah lunas.
        $tagihanLunas = (clone $periodeQuery)
            ->where('status', 'lunas')
            ->count();

        // Tagihan yang belum dibayar atau menunggu verifikasi.
        $tagihanTertunda = (clone $periodeQuery)
            ->whereIn('status', [
                'belum_dibayar',
                'menunggu_verifikasi'
            ])
            ->count();

        // Tagihan yang terlambat.
        $tagihanTerlambat = (clone $periodeQuery)
            ->where('status', 'terlambat')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 4. DATA PEMBAYARAN
        |--------------------------------------------------------------------------
        |
        | Menggunakan nama kolom asli database:
        | - metode_pembayaran
        | - jumlah_bayar
        | - tanggal_pembayaran
        | - bukti_pembayaran
        |
        */

        $pembayaranQuery = DB::table('pembayarans')
            ->whereRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at)) BETWEEN ? AND ?',
                [
                    $tanggalMulai->toDateString(),
                    $tanggalAkhir->toDateString()
                ]
            );

        // Pendapatan hanya dihitung dari pembayaran yang disetujui.
        $totalPendapatan = (clone $pembayaranQuery)
            ->where('status', 'disetujui')
            ->sum('jumlah_bayar');

        // Total seluruh transaksi pembayaran.
        $totalPembayaran = (clone $pembayaranQuery)->count();

        // Pembayaran yang menunggu verifikasi.
        $pembayaranMenunggu = (clone $pembayaranQuery)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        // Pembayaran yang ditolak.
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
        */

        $totalPenghuniAktif = DB::table('bookings')
            ->where('status', 'disetujui')
            ->distinct()
            ->count('user_id');

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
                    $tanggalAkhir->toDateString()
                ]
            )
            ->select(
                'pembayarans.id',
                'users.name as nama_penghuni',
                'kamars.nomor_kamar',
                'pembayarans.metode_pembayaran',
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
            ->limit(200)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 9. DATA GRAFIK PENDAPATAN
        |--------------------------------------------------------------------------
        |
        | Grafik hanya menghitung pembayaran yang disetujui.
        | Jika tanggal_pembayaran kosong, created_at digunakan.
        |
        */

        $dataGrafik = DB::table('pembayarans')
            ->where('status', 'disetujui')
            ->whereRaw(
                'DATE(COALESCE(tanggal_pembayaran, created_at)) BETWEEN ? AND ?',
                [
                    $tanggalMulai->toDateString(),
                    $tanggalAkhir->toDateString()
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

            // Grafik pendapatan Januari sampai Desember.
            $namaBulan = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ];

            $chartLabels = $namaBulan;

            // Siapkan nilai awal setiap bulan.
            $pendapatanBulanan = array_fill(1, 12, 0);

            foreach ($dataGrafik as $item) {
                $tanggal = Carbon::parse($item->tanggal);

                $nomorBulan = (int) $tanggal->format('n');

                $pendapatanBulanan[$nomorBulan] += (int) $item->total;
            }

            foreach (range(1, 12) as $nomorBulan) {
                $chartData[] = $pendapatanBulanan[$nomorBulan];
            }

        } else {

            // Grafik pendapatan berdasarkan tanggal dalam satu bulan.
            $jumlahHari = $tanggalMulai->daysInMonth;

            $chartLabels = range(1, $jumlahHari);

            // Siapkan nilai awal setiap tanggal.
            $pendapatanHarian = array_fill(1, $jumlahHari, 0);

            foreach ($dataGrafik as $item) {
                $tanggal = Carbon::parse($item->tanggal);

                $nomorHari = (int) $tanggal->format('j');

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

            // Data tagihan.
            'totalTagihan',
            'tagihanLunas',
            'tagihanTertunda',
            'tagihanTerlambat',

            // Data pembayaran.
            'totalPendapatan',
            'totalPembayaran',
            'pembayaranMenunggu',
            'pembayaranDitolak',

            // Data kamar.
            'totalKamar',
            'kamarTerisi',
            'kamarTersedia',
            'kamarMaintenance',

            // Data penghuni.
            'totalPenghuniAktif',

            // Persentase.
            'persentaseLunas',
            'persentaseTertunda',
            'persentaseTerlambat',

            // Riwayat pembayaran.
            'pembayaran',

            // Grafik.
            'chartLabels',
            'chartData'
        ));
    }
}
