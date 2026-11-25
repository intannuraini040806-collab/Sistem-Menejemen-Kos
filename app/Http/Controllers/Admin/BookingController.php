<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                Rule::in([
                    'menunggu',
                    'disetujui',
                    'ditolak',
                    'dibatalkan',
                    'selesai',
                ]),
            ],
        ]);

        $query = Booking::with(['user', 'kamar'])
            ->latest('created_at');

        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                })->orWhereHas('kamar', function ($kamarQuery) use ($keyword) {
                    $kamarQuery->where(
                        'nomor_kamar',
                        'like',
                        "%{$keyword}%"
                    );
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Statistik seluruh booking.
        $totalBooking = Booking::count();

        $waitingBooking = Booking::where('status', 'menunggu')->count();

        $approvedBooking = Booking::where('status', 'disetujui')->count();

        $rejectedBooking = Booking::where('status', 'ditolak')->count();

        $cancelledBooking = Booking::where('status', 'dibatalkan')->count();

        $completedBooking = Booking::where('status', 'selesai')->count();

        // Data kamar dan akun penghuni untuk formulir tambah booking.
        $kamars = Kamar::orderBy('nomor_kamar')->get();

        $penghunis = User::where('role', 'penghuni')
            ->orderBy('name')
            ->get();

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.booking.index', compact(
            'bookings',
            'kamars',
            'penghunis',
            'totalBooking',
            'waitingBooking',
            'approvedBooking',
            'rejectedBooking',
            'cancelledBooking',
            'completedBooking'
        ));
    }

    /**
     * Menampilkan detail booking dalam bentuk JSON.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'kamar']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'kamar_id' => $booking->kamar_id,
                'nama_penghuni' => $booking->user?->name,
                'email' => $booking->user?->email,
                'telepon' => $booking->user?->phone,
                'nomor_kamar' => $booking->kamar?->nomor_kamar,
                'tipe_kamar' => $booking->kamar?->tipe,
                'harga_kamar' => $booking->kamar?->harga,
                'tanggal_booking' => $booking->tanggal_booking?->format('Y-m-d'),
                'tanggal_masuk' => $booking->tanggal_masuk?->format('Y-m-d'),
                'tanggal_keluar' => $booking->tanggal_keluar?->format('Y-m-d'),
                'status' => $booking->status,
                'catatan' => $booking->catatan,
                'alasan_penolakan' => $booking->alasan_penolakan,
                'created_at' => $booking->created_at?->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Menambahkan booking baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'penghuni'),
            ],
            'kamar_id' => [
                'required',
                'integer',
                'exists:kamars,id',
            ],
            'tanggal_booking' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'tanggal_masuk' => [
                'required',
                'date',
                'after_or_equal:tanggal_booking',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'user_id.required' => 'Penghuni wajib dipilih.',
            'user_id.exists' => 'Akun penghuni tidak valid.',
            'kamar_id.required' => 'Kamar wajib dipilih.',
            'kamar_id.exists' => 'Kamar yang dipilih tidak ditemukan.',
            'tanggal_booking.required' => 'Tanggal booking wajib diisi.',
            'tanggal_booking.before_or_equal' => 'Tanggal booking tidak boleh di masa depan.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.after_or_equal' => 'Tanggal masuk tidak boleh sebelum tanggal booking.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $result = DB::transaction(function () use ($validated) {
            $user = User::where('role', 'penghuni')
                ->whereKey($validated['user_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Satu penghuni hanya boleh memiliki satu booking aktif.
            $bookingAktif = Booking::where('user_id', $user->id)
                ->whereIn('status', ['menunggu', 'disetujui'])
                ->exists();

            if ($bookingAktif) {
                return [
                    'success' => false,
                    'message' => 'Penghuni tersebut masih memiliki booking aktif.',
                ];
            }

            $kamar = Kamar::whereKey($validated['kamar_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($kamar->status === 'maintenance') {
                return [
                    'success' => false,
                    'message' => 'Kamar sedang dalam perbaikan dan tidak dapat dipesan.',
                ];
            }

            if ($kamar->jumlah_penghuni >= $kamar->kapasitas) {
                return [
                    'success' => false,
                    'message' => 'Kapasitas kamar sudah penuh.',
                ];
            }

            // Booking menunggu juga diperhitungkan agar kapasitas tidak berlebih.
            $bookingMenunggu = Booking::where('kamar_id', $kamar->id)
                ->where('status', 'menunggu')
                ->count();

            $sisaKapasitas = $kamar->kapasitas
                - $kamar->jumlah_penghuni
                - $bookingMenunggu;

            if ($sisaKapasitas <= 0) {
                return [
                    'success' => false,
                    'message' => 'Sisa kapasitas kamar sudah dialokasikan untuk booking lain.',
                ];
            }

            Booking::create([
                'user_id' => $user->id,
                'kamar_id' => $kamar->id,
                'tanggal_booking' => $validated['tanggal_booking'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'status' => 'menunggu',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            return [
                'success' => true,
                'message' => 'Booking berhasil ditambahkan.',
            ];
        }, 3);

        return redirect()
            ->route('admin.booking.index')
            ->with(
                $result['success'] ? 'success' : 'error',
                $result['message']
            );
    }

    /**
     * Menyetujui booking.
     */
    public function approve(Booking $booking)
    {
        $result = DB::transaction(function () use ($booking) {
            $data = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($data->status !== 'menunggu') {
                return [
                    'success' => false,
                    'message' => 'Booking ini sudah diproses sebelumnya.',
                ];
            }

            $user = User::whereKey($data->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            $bookingLain = Booking::where('user_id', $user->id)
                ->where('id', '!=', $data->id)
                ->where('status', 'disetujui')
                ->exists();

            if ($bookingLain) {
                return [
                    'success' => false,
                    'message' => 'Penghuni sudah memiliki booking yang disetujui.',
                ];
            }

            $kamar = Kamar::whereKey($data->kamar_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($kamar->status === 'maintenance') {
                return [
                    'success' => false,
                    'message' => 'Booking tidak dapat disetujui karena kamar sedang maintenance.',
                ];
            }

            if ($kamar->jumlah_penghuni >= $kamar->kapasitas) {
                return [
                    'success' => false,
                    'message' => 'Booking tidak dapat disetujui karena kapasitas kamar sudah penuh.',
                ];
            }

            $bookingMenungguLain = Booking::where('kamar_id', $kamar->id)
                ->where('status', 'menunggu')
                ->where('id', '!=', $data->id)
                ->count();

            $sisaKapasitas = $kamar->kapasitas
                - $kamar->jumlah_penghuni
                - $bookingMenungguLain;

            // Perbaikan: kapasitas 0 juga berarti tidak tersedia.
            if ($sisaKapasitas <= 0) {
                return [
                    'success' => false,
                    'message' => 'Kapasitas kamar tidak mencukupi untuk menyetujui booking ini.',
                ];
            }

            $data->update([
                'status' => 'disetujui',
                'alasan_penolakan' => null,
            ]);

            $jumlahPenghuniBaru = $kamar->jumlah_penghuni + 1;

            $kamar->update([
                'jumlah_penghuni' => $jumlahPenghuniBaru,
                'status' => $jumlahPenghuniBaru >= $kamar->kapasitas
                    ? 'terisi'
                    : 'tersedia',
            ]);

            $periode = $data->tanggal_masuk->format('Y-m');

            Tagihan::firstOrCreate(
                [
                    'booking_id' => $data->id,
                    'periode' => $periode,
                ],
                [
                    'jumlah' => $kamar->harga,
                    'tanggal_terbit' => today(),
                    'tanggal_jatuh_tempo' => today()->addDays(7),
                    'status' => 'belum_dibayar',
                    'keterangan' => 'Tagihan awal setelah booking disetujui.',
                ]
            );

            return [
                'success' => true,
                'message' => 'Booking berhasil disetujui dan tagihan awal telah dibuat.',
            ];
        }, 3);

        return redirect()
            ->route('admin.booking.index')
            ->with(
                $result['success'] ? 'success' : 'error',
                $result['message']
            );
    }

    /**
     * Menolak booking.
     */
    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'alasan_penolakan' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.min' => 'Alasan penolakan minimal 5 karakter.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $result = DB::transaction(function () use ($booking, $validated) {
            $data = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($data->status !== 'menunggu') {
                return false;
            }

            $data->update([
                'status' => 'ditolak',
                'alasan_penolakan' => trim($validated['alasan_penolakan']),
            ]);

            return true;
        }, 3);

        return redirect()
            ->route('admin.booking.index')
            ->with(
                $result ? 'success' : 'error',
                $result
                    ? 'Booking berhasil ditolak.'
                    : 'Booking ini sudah diproses sebelumnya.'
            );
    }

    /**
     * Menghapus booking yang belum memiliki tagihan.
     */
    public function destroy(Booking $booking)
    {
        $result = DB::transaction(function () use ($booking) {
            $data = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!in_array($data->status, [
                'menunggu',
                'ditolak',
                'dibatalkan',
            ], true)) {
                return [
                    'success' => false,
                    'message' => 'Booking yang sudah disetujui atau selesai tidak dapat dihapus melalui menu ini.',
                ];
            }

            $hasInvoice = Tagihan::where('booking_id', $data->id)
                ->exists();

            if ($hasInvoice) {
                return [
                    'success' => false,
                    'message' => 'Booking tidak dapat dihapus karena sudah memiliki tagihan.',
                ];
            }

            $data->delete();

            return [
                'success' => true,
                'message' => 'Data booking berhasil dihapus.',
            ];
        }, 3);

        return redirect()
            ->route('admin.booking.index')
            ->with(
                $result['success'] ? 'success' : 'error',
                $result['message']
            );
    }
}
