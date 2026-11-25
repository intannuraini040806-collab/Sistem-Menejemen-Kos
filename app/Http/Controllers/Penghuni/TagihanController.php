<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanController extends Controller
{
    /**
     * Menampilkan tagihan berdasarkan akun penghuni yang login.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil tagihan langsung berdasarkan ID penghuni yang login.
        $tagihans = DB::table('tagihans')
            ->join('bookings', 'tagihans.booking_id', '=', 'bookings.id')
            ->leftJoin('kamars', 'bookings.kamar_id', '=', 'kamars.id')
            ->where('bookings.user_id', $user->id)
            ->select(
                'tagihans.*',
                'bookings.user_id',
                'bookings.status as status_booking',
                'kamars.nomor_kamar'
            )
            ->orderByDesc('tagihans.tanggal_terbit')
            ->orderByDesc('tagihans.id')
            ->get();

        // Hitung status tampilan.
        $tagihans->each(function ($tagihan) {
            $status = $tagihan->status;

            if (
                $status === 'belum_dibayar'
                && $tagihan->tanggal_jatuh_tempo
                && Carbon::parse($tagihan->tanggal_jatuh_tempo)->lt(today())
            ) {
                $status = 'terlambat';
            }

            $tagihan->status_tampilan = $status;

            // Format nominal.
            $tagihan->jumlah_format = 'Rp ' . number_format(
                $tagihan->jumlah,
                0,
                ',',
                '.'
            );
        });

        // Ringkasan statistik.
        $ringkasan = [
            'total' => $tagihans->count(),

            'belum_dibayar' => $tagihans
                ->where('status_tampilan', 'belum_dibayar')
                ->count(),

            'menunggu_verifikasi' => $tagihans
                ->where('status_tampilan', 'menunggu_verifikasi')
                ->count(),

            'lunas' => $tagihans
                ->where('status_tampilan', 'lunas')
                ->count(),

            'terlambat' => $tagihans
                ->where('status_tampilan', 'terlambat')
                ->count(),

            'total_nominal' => $tagihans->sum('jumlah'),
        ];

        return view('penghuni.tagihan', compact(
            'tagihans',
            'ringkasan'
        ));
    }
}
