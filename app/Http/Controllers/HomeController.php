<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Ambil kamar dengan tipe Single dan Double saja.
        $kamars = Kamar::query()
            ->whereIn('tipe', ['single', 'double'])
            ->orderByRaw("CASE WHEN tipe = 'single' THEN 1 ELSE 2 END")
            ->orderBy('nomor_kamar')
            ->get();

        // Kamar tersedia harus berstatus tersedia dan belum penuh.
        $kamarTersedia = $kamars->filter(function ($kamar) {
            return $kamar->status === 'tersedia'
                && $kamar->jumlah_penghuni < $kamar->kapasitas;
        });

        // Hitung jumlah kamar Single yang tersedia.
        $totalSingle = $kamarTersedia
            ->where('tipe', 'single')
            ->count();

        // Hitung jumlah kamar Double yang tersedia.
        $totalDouble = $kamarTersedia
            ->where('tipe', 'double')
            ->count();

        return view('home', [
            'kamars' => $kamars,
            'totalSingle' => $totalSingle,
            'totalDouble' => $totalDouble,
            'totalTersedia' => $kamarTersedia->count(),
        ]);
    }
}
