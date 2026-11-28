<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KamarController extends Controller
{
    /**
     * Menampilkan halaman kamar penghuni.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Booking yang sudah disetujui dan masih aktif.
        $bookingAktif = Booking::query()
            ->with('kamar')
            ->where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where(function ($query) {
                $query->whereNull('tanggal_keluar')
                    ->orWhereDate('tanggal_keluar', '>=', today());
            })
            ->latest('tanggal_masuk')
            ->first();

        // Booking yang masih menunggu persetujuan.
        $bookingMenunggu = Booking::query()
            ->with([
                'kamar',
                'pembayarans' => function ($query) {
                    $query->where('jenis_pembayaran', 'dp_booking')
                        ->latest();
                },
            ])
            ->where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        $kamar = $bookingAktif?->kamar;

        $fasilitasKamar = $kamar?->fasilitas ?? [];

        if (! is_array($fasilitasKamar)) {
            $fasilitasKamar = [];
        }

        // Hanya mengambil kamar yang masih tersedia.
        $kamarsTersedia = Kamar::query()
            ->where('status', 'tersedia')
            ->whereColumn('jumlah_penghuni', '<', 'kapasitas')
            ->orderBy('tipe')
            ->orderBy('nomor_kamar')
            ->get();

        return view('penghuni.kamar', [
            'user' => $user,
            'bookingAktif' => $bookingAktif,
            'bookingMenunggu' => $bookingMenunggu,
            'kamar' => $kamar,
            'fasilitasKamar' => $fasilitasKamar,
            'kamarsTersedia' => $kamarsTersedia,
        ]);
    }

    /**
     * Mengajukan booking kamar dan menghitung DP minimum.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kamar_id' => [
                'required',
                'integer',
                'exists:kamars,id',
            ],
            'tanggal_masuk' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'kamar_id.required' => 'Silakan pilih kamar terlebih dahulu.',
            'kamar_id.exists' => 'Kamar yang dipilih tidak ditemukan.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'tanggal_masuk.after_or_equal' => 'Tanggal masuk tidak boleh sebelum hari ini.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $user = $request->user();

        $booking = DB::transaction(function () use ($user, $validated) {
            // Mengunci pengguna untuk mencegah booking ganda.
            $user->newQuery()
                ->whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $sudahMemilikiBooking = Booking::query()
                ->where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('status', 'menunggu')
                        ->orWhere(function ($activeQuery) {
                            $activeQuery->where('status', 'disetujui')
                                ->where(function ($dateQuery) {
                                    $dateQuery->whereNull('tanggal_keluar')
                                        ->orWhereDate(
                                            'tanggal_keluar',
                                            '>=',
                                            today()
                                        );
                                });
                        });
                })
                ->exists();

            if ($sudahMemilikiBooking) {
                throw ValidationException::withMessages([
                    'kamar_id' => 'Kamu masih memiliki booking yang menunggu persetujuan atau kamar yang sedang ditempati.',
                ]);
            }

            // Mengunci kamar agar kapasitas tidak berubah
            // selama pengajuan booking diproses.
            $kamar = Kamar::query()
                ->whereKey($validated['kamar_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $kamar->status !== 'tersedia'
                || $kamar->jumlah_penghuni >= $kamar->kapasitas
            ) {
                throw ValidationException::withMessages([
                    'kamar_id' => 'Maaf, kamar tersebut sudah tidak tersedia. Silakan pilih kamar lain.',
                ]);
            }

            // Harga kamar diambil langsung dari database.
            // Nominal DP tidak pernah dipercaya dari input browser.
            $hargaKamar = (int) $kamar->harga;

            if ($hargaKamar <= 0) {
                throw ValidationException::withMessages([
                    'kamar_id' => 'Harga kamar belum valid. Silakan hubungi admin.',
                ]);
            }

            // DP minimum sebesar 30% dari harga sewa bulanan.
            $nominalDpMinimum = (int) ceil($hargaKamar * 0.30);

            $booking = Booking::create([
                'user_id' => $user->id,
                'kamar_id' => $kamar->id,
                'tanggal_booking' => today(),
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'nominal_dp' => $nominalDpMinimum,
                'tenggat_dp' => null,
                'kebijakan_dp' => 'DP minimum sebesar 30% dari harga sewa kamar per bulan. Penghuni dapat membayar lebih dari nominal minimum tersebut. Booking hanya dapat disetujui setelah pembayaran DP diverifikasi oleh admin.',
                'status' => 'menunggu',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            return $booking;
        }, 3);

        return redirect()
            ->route('penghuni.kamar.index')
            ->with(
                'success',
                'Pengajuan booking berhasil dibuat. DP minimum kamu adalah Rp '
                . number_format($booking->nominal_dp, 0, ',', '.')
                . '. Silakan lanjutkan pembayaran DP.'
            );
    }
}
