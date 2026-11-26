<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Services\KosBusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function __construct(
        protected KosBusinessService $kosService
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
    public function verifikasi(Pembayaran $pembayaran)
    {
        $hasil = DB::transaction(function () use ($pembayaran) {
            $dataPembayaran = Pembayaran::whereKey($pembayaran->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($dataPembayaran->status !== 'menunggu_verifikasi') {
                return [
                    'berhasil' => false,
                    'pesan' => 'Pembayaran ini sudah pernah diproses.',
                ];
            }

            // Kasus 1: Pembayaran DP Booking
            if ($dataPembayaran->jenis_pembayaran === 'dp_booking') {
                $booking = Booking::whereKey($dataPembayaran->booking_id)
                    ->lockForUpdate()
                    ->first();

                if (!$booking) {
                    return [
                        'berhasil' => false,
                        'pesan' => 'Data booking terkait tidak ditemukan.',
                    ];
                }

                if ((int) $dataPembayaran->jumlah_bayar < (int) $booking->nominal_dp) {
                    return [
                        'berhasil' => false,
                        'pesan' => 'Nominal transfer DP kurang dari ketentuan minimum DP.',
                    ];
                }

                $dataPembayaran->update([
                    'status' => 'disetujui',
                    'diverifikasi_oleh' => Auth::id(),
                    'tanggal_verifikasi' => now(),
                    'catatan' => 'Pembayaran DP booking berhasil diverifikasi oleh admin.',
                ]);

                return [
                    'berhasil' => true,
                    'pesan' => 'Pembayaran DP booking berhasil diverifikasi. Silakan setujui booking untuk check-in penghuni.',
                ];
            }

            // Kasus 2: Pembayaran Tagihan (mendukung cicilan bertahap maupun pelunasan penuh)
            $tagihan = Tagihan::whereKey($dataPembayaran->tagihan_id)
                ->lockForUpdate()
                ->first();

            if (!$tagihan) {
                return [
                    'berhasil' => false,
                    'pesan' => 'Tagihan yang terkait tidak ditemukan.',
                ];
            }

            if ($tagihan->status === 'lunas') {
                return [
                    'berhasil' => false,
                    'pesan' => 'Tagihan ini sudah berstatus lunas.',
                ];
            }

            $sisaTagihan = $tagihan->sisa_tagihan;

            if ((int) $dataPembayaran->jumlah_bayar <= 0) {
                return [
                    'berhasil' => false,
                    'pesan' => 'Nominal pembayaran harus lebih dari 0.',
                ];
            }

            if ((int) $dataPembayaran->jumlah_bayar > $sisaTagihan) {
                return [
                    'berhasil' => false,
                    'pesan' => 'Nominal pembayaran melebihi sisa tagihan yang harus dibayar.',
                ];
            }

            $dataPembayaran->update([
                'status' => 'disetujui',
                'diverifikasi_oleh' => Auth::id(),
                'tanggal_verifikasi' => now(),
                'catatan' => 'Pembayaran berhasil diverifikasi oleh admin.',
            ]);

            $tagihanTerbaru = $this->kosService->hitungUlangSaldoTagihan($tagihan);

            $pesanStatus = $tagihanTerbaru->status === 'lunas'
                ? 'Pembayaran berhasil diverifikasi dan tagihan telah lunas.'
                : 'Cicilan pembayaran berhasil diverifikasi. Status tagihan diperbarui menjadi dibayar sebagian.';

            return [
                'berhasil' => true,
                'pesan' => $pesanStatus,
            ];
        }, 3);

        if (!$hasil['berhasil']) {
            return back()->with('error', $hasil['pesan']);
        }

        return back()->with('success', $hasil['pesan']);
    }

    /**
     * Menolak pembayaran penghuni dan menghitung ulang saldo tagihan.
     */
    public function tolak(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'catatan' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.min' => 'Alasan penolakan minimal 5 karakter.',
            'catatan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $hasil = DB::transaction(function () use ($pembayaran, $validated) {
            $dataPembayaran = Pembayaran::whereKey($pembayaran->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($dataPembayaran->status !== 'menunggu_verifikasi') {
                return [
                    'berhasil' => false,
                    'pesan' => 'Pembayaran ini sudah pernah diproses.',
                ];
            }

            $dataPembayaran->update([
                'status' => 'ditolak',
                'diverifikasi_oleh' => Auth::id(),
                'tanggal_verifikasi' => now(),
                'catatan' => trim($validated['catatan']),
            ]);

            if ($dataPembayaran->tagihan_id) {
                $tagihan = Tagihan::whereKey($dataPembayaran->tagihan_id)
                    ->lockForUpdate()
                    ->first();

                if ($tagihan) {
                    $this->kosService->hitungUlangSaldoTagihan($tagihan);
                }
            }

            return [
                'berhasil' => true,
                'pesan' => 'Pembayaran berhasil ditolak. Status tagihan telah diperbarui.',
            ];
        }, 3);

        if (!$hasil['berhasil']) {
            return back()->with('error', $hasil['pesan']);
        }

        return back()->with('success', $hasil['pesan']);
    }
}