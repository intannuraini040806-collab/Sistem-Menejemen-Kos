<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
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

        // Statistik keseluruhan, tidak terpengaruh filter tabel.
        $totalPembayaran = Pembayaran::count();

        $totalDiterima = Pembayaran::where('status', 'disetujui')
            ->sum('jumlah_bayar');

        $jumlahTerverifikasi = Pembayaran::where('status', 'disetujui')
            ->count();

        $jumlahMenunggu = Pembayaran::where(
            'status',
            'menunggu_verifikasi'
        )->count();

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
     * Memverifikasi pembayaran penghuni.
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
                    'pesan' => 'Tagihan ini sudah lunas.',
                ];
            }

            // Pembayaran harus sesuai dengan nominal tagihan.
            if ((int) $dataPembayaran->jumlah_bayar !== (int) $tagihan->jumlah) {
                return [
                    'berhasil' => false,
                    'pesan' => 'Nominal pembayaran tidak sesuai dengan jumlah tagihan.',
                ];
            }

            $sudahAdaPembayaranDisetujui = Pembayaran::where(
                'tagihan_id',
                $tagihan->id
            )->where('status', 'disetujui')
                ->where('id', '!=', $dataPembayaran->id)
                ->exists();

            if ($sudahAdaPembayaranDisetujui) {
                return [
                    'berhasil' => false,
                    'pesan' => 'Tagihan sudah memiliki pembayaran yang disetujui.',
                ];
            }

            $dataPembayaran->update([
                'status' => 'disetujui',
                'diverifikasi_oleh' => Auth::id(),
                'tanggal_verifikasi' => now(),
                'catatan' => 'Pembayaran berhasil diverifikasi oleh admin.',
            ]);

            $tagihan->update([
                'status' => 'lunas',
            ]);

            return [
                'berhasil' => true,
                'pesan' => 'Pembayaran berhasil diverifikasi dan tagihan telah ditandai lunas.',
            ];
        }, 3);

        if (!$hasil['berhasil']) {
            return back()->with('error', $hasil['pesan']);
        }

        return back()->with('success', $hasil['pesan']);
    }

    /**
     * Menolak pembayaran penghuni.
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

            $tagihan = Tagihan::whereKey($dataPembayaran->tagihan_id)
                ->lockForUpdate()
                ->first();

            $dataPembayaran->update([
                'status' => 'ditolak',
                'diverifikasi_oleh' => Auth::id(),
                'tanggal_verifikasi' => now(),
                'catatan' => trim($validated['catatan']),
            ]);

            if ($tagihan && $tagihan->status !== 'lunas') {
                // Jika masih ada pembayaran lain yang menunggu,
                // tagihan tetap menunggu verifikasi.
                $masihMenunggu = Pembayaran::where(
                    'tagihan_id',
                    $tagihan->id
                )->where('status', 'menunggu_verifikasi')
                    ->where('id', '!=', $dataPembayaran->id)
                    ->exists();

                if ($masihMenunggu) {
                    $statusTagihan = 'menunggu_verifikasi';
                } else {
                    $statusTagihan = $tagihan->tanggal_jatuh_tempo
                        && $tagihan->tanggal_jatuh_tempo->lt(today())
                            ? 'terlambat'
                            : 'belum_dibayar';
                }

                $tagihan->update([
                    'status' => $statusTagihan,
                ]);
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
