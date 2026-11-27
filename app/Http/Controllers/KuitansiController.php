<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Services\KuitansiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KuitansiController extends Controller
{
    public function __construct(
        protected KuitansiService $kuitansiService
    ) {}

    public function show(Request $request, Pembayaran $pembayaran): View
    {
        $user = $request->user();
        $pembayaran->loadMissing(['tagihan.booking', 'booking']);

        $isOwner = (int) $pembayaran->user_id === (int) $user->id
            || (int) ($pembayaran->tagihan?->booking?->user_id) === (int) $user->id
            || (int) ($pembayaran->booking?->user_id) === (int) $user->id;

        if (! $user->isAdmin() && ! $user->isPetugas() && ! $isOwner) {
            abort(403, 'Anda tidak memiliki izin untuk melihat kuitansi ini.');
        }

        if ($pembayaran->status !== 'disetujui') {
            abort(404, 'Kuitansi hanya tersedia untuk pembayaran yang sudah diverifikasi.');
        }

        return view('kuitansi.show', [
            'k' => $this->kuitansiService->susunData($pembayaran),
            'kembaliUrl' => match (true) {
                $user->isAdmin() => route('admin.pembayaran.index'),
                $user->isPetugas() => route('petugas.pembayaran.index'),
                default => route('penghuni.riwayat.index'),
            },
        ]);
    }
}
