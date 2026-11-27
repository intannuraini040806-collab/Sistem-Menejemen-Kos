<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PembayaranBuktiController extends Controller
{
    public function __invoke(Request $request, Pembayaran $pembayaran): StreamedResponse
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Silakan login terlebih dahulu untuk melihat bukti pembayaran.');
        }

        $pembayaran->loadMissing(['tagihan.booking', 'booking']);

        $isOwner = (int) $pembayaran->user_id === (int) $user->id
            || (int) ($pembayaran->tagihan?->booking?->user_id) === (int) $user->id
            || (int) ($pembayaran->booking?->user_id) === (int) $user->id;

        if (! $user->isAdmin() && ! $user->isPetugas() && ! $isOwner) {
            abort(403, 'Anda tidak memiliki izin untuk melihat bukti pembayaran ini.');
        }

        $rawPath = ltrim(str_replace('\\', '/', (string) $pembayaran->bukti_pembayaran), '/');
        $normalizedPath = preg_replace('#^(storage|public)/#', '', $rawPath) ?: $rawPath;

        if ($normalizedPath === '') {
            abort(404, 'File bukti pembayaran belum diunggah.');
        }

        $candidates = array_values(array_unique([$normalizedPath, $rawPath]));

        foreach (['public', 'local'] as $disk) {
            foreach ($candidates as $candidate) {
                if (Storage::disk($disk)->exists($candidate)) {
                    $mimeType = Storage::disk($disk)->mimeType($candidate) ?: 'application/octet-stream';
                    $filename = basename($candidate);

                    return Storage::disk($disk)->response($candidate, $filename, [
                        'Content-Type' => $mimeType,
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    ]);
                }
            }
        }

        abort(404, 'File bukti pembayaran tidak ditemukan di server.');
    }
}

