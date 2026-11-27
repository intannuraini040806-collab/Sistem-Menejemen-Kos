<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\Kamar;
use App\Models\TenantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PenghuniController extends Controller
{
    /**
     * Menampilkan data penghuni dan statistik.
     */
    public function index()
    {
        $users = DB::table('users')
            ->where('role', 'penghuni')
            ->orderBy('name')
            ->get();

        $penghuni = $users->map(function ($user) {
            $booking = DB::table('bookings')
                ->leftJoin('kamars', 'bookings.kamar_id', '=', 'kamars.id')
                ->where('bookings.user_id', $user->id)
                ->orderByDesc('bookings.id')
                ->select(
                    'bookings.id',
                    'bookings.tanggal_masuk',
                    'bookings.tanggal_keluar',
                    'bookings.alasan_keluar',
                    'bookings.status',
                    'kamars.nomor_kamar',
                    'kamars.tipe'
                )
                ->first();

            $statusAktif = $booking && $booking->status === 'disetujui';

            return (object) [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'nomor_kamar' => $booking->nomor_kamar ?? '-',
                'tipe_kamar' => $booking->tipe ?? '-',
                'tanggal_masuk' => $booking->tanggal_masuk ?? null,
                'tanggal_keluar' => $booking->tanggal_keluar ?? null,
                'alasan_keluar' => $booking->alasan_keluar ?? null,
                'booking_id' => $booking->id ?? null,
                'booking_status' => $booking->status ?? null,
                'status' => $statusAktif ? 'aktif' : 'nonaktif',
                'status_label' => $statusAktif
                    ? 'Aktif'
                    : ($booking?->status === 'selesai'
                        ? 'Selesai / Keluar'
                        : ($booking ? 'Nonaktif' : 'Belum memiliki booking')),
            ];
        });

        $totalPenghuni = $penghuni->count();

        $penghuniAktif = $penghuni
            ->where('status', 'aktif')
            ->count();

        $penghuniNonaktif = $penghuni
            ->where('status', 'nonaktif')
            ->count();

        $kamarTerisi = DB::table('kamars')
            ->where('status', 'terisi')
            ->count();

        $kamars = DB::table('kamars')
            ->orderBy('nomor_kamar')
            ->get();

        return view('admin.penghuni.index', compact(
            'penghuni',
            'totalPenghuni',
            'penghuniAktif',
            'penghuniNonaktif',
            'kamarTerisi',
            'kamars'
        ));
    }

    /**
     * Menambahkan akun penghuni beserta booking-nya.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'room' => ['required', 'string', 'max:20'],
            'joinDate' => ['required', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'name.required' => 'Nama penghuni wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'room.required' => 'Kamar wajib dipilih.',
            'joinDate.required' => 'Tanggal masuk wajib diisi.',
            'status.required' => 'Status penghuni wajib dipilih.',
        ]);

        $nomorKamar = strtoupper(
            str_replace(['-', ' '], '', $data['room'])
        );

        $kamar = DB::table('kamars')
            ->where('nomor_kamar', $nomorKamar)
            ->first();

        if (!$kamar) {
            throw ValidationException::withMessages([
                'room' => 'Kamar yang dipilih tidak ditemukan.',
            ]);
        }

        if ($kamar->status === 'maintenance') {
            throw ValidationException::withMessages([
                'room' => 'Kamar sedang dalam perbaikan dan tidak dapat dipilih.',
            ]);
        }

        $bookingStatus = $data['status'] === 'aktif'
            ? 'disetujui'
            : 'selesai';

        if ($bookingStatus === 'disetujui') {
            $jumlahTerisi = DB::table('bookings')
                ->where('kamar_id', $kamar->id)
                ->where('status', 'disetujui')
                ->count();

            if ($jumlahTerisi >= $kamar->kapasitas) {
                throw ValidationException::withMessages([
                    'room' => 'Kapasitas kamar sudah penuh. Silakan pilih kamar lain.',
                ]);
            }
        }

        $passwordSementara = Str::random(12);

        DB::transaction(function () use (
            $data,
            $kamar,
            $bookingStatus,
            $passwordSementara
        ) {
            $userId = DB::table('users')->insertGetId([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($passwordSementara),
                'role' => 'penghuni',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('bookings')->insert([
                'user_id' => $userId,
                'kamar_id' => $kamar->id,
                'tanggal_booking' => now()->toDateString(),
                'tanggal_masuk' => $data['joinDate'],
                'tanggal_keluar' => $bookingStatus === 'selesai'
                    ? now()->toDateString()
                    : null,
                'status' => $bookingStatus,
                'catatan' => 'Data penghuni ditambahkan oleh admin.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Data penghuni berhasil ditambahkan.')
            ->with('temporary_password', $passwordSementara)
            ->with('temporary_email', $data['email']);
    }

    /**
     * Memperbarui data penghuni dan booking terbarunya.
     */
    public function update(Request $request, $id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->where('role', 'penghuni')
            ->first();

        if (!$user) {
            abort(404, 'Data penghuni tidak ditemukan.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'room' => ['required', 'string', 'max:20'],
            'joinDate' => ['required', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'name.required' => 'Nama penghuni wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan penghuni lain.',
            'room.required' => 'Kamar wajib dipilih.',
            'joinDate.required' => 'Tanggal masuk wajib diisi.',
            'status.required' => 'Status penghuni wajib dipilih.',
        ]);

        $nomorKamar = strtoupper(
            str_replace(['-', ' '], '', $data['room'])
        );

        $kamar = DB::table('kamars')
            ->where('nomor_kamar', $nomorKamar)
            ->first();

        if (!$kamar) {
            throw ValidationException::withMessages([
                'room' => 'Kamar yang dipilih tidak ditemukan.',
            ]);
        }

        if ($kamar->status === 'maintenance') {
            throw ValidationException::withMessages([
                'room' => 'Kamar sedang dalam perbaikan dan tidak dapat dipilih.',
            ]);
        }

        $bookingLama = DB::table('bookings')
            ->where('user_id', $id)
            ->orderByDesc('id')
            ->first();

        $bookingStatus = $data['status'] === 'aktif'
            ? 'disetujui'
            : 'selesai';

        if ($bookingStatus === 'disetujui') {
            $jumlahTerisi = DB::table('bookings')
                ->where('kamar_id', $kamar->id)
                ->where('status', 'disetujui')
                ->when(
                    $bookingLama,
                    fn ($query) => $query->where('id', '!=', $bookingLama->id)
                )
                ->count();

            if ($jumlahTerisi >= $kamar->kapasitas) {
                throw ValidationException::withMessages([
                    'room' => 'Kapasitas kamar sudah penuh. Silakan pilih kamar lain.',
                ]);
            }
        }

        DB::transaction(function () use (
            $id,
            $data,
            $kamar,
            $bookingLama,
            $bookingStatus
        ) {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'updated_at' => now(),
                ]);

            $bookingData = [
                'user_id' => $id,
                'kamar_id' => $kamar->id,
                'tanggal_masuk' => $data['joinDate'],
                'tanggal_keluar' => $bookingStatus === 'selesai'
                    ? now()->toDateString()
                    : null,
                'status' => $bookingStatus,
                'updated_at' => now(),
            ];

            if ($bookingLama) {
                DB::table('bookings')
                    ->where('id', $bookingLama->id)
                    ->update($bookingData);
            } else {
                $bookingData['tanggal_booking'] = now()->toDateString();
                $bookingData['catatan'] = 'Data penghuni ditambahkan oleh admin.';
                $bookingData['created_at'] = now();

                DB::table('bookings')->insert($bookingData);
            }
        });

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    /**
     * Memproses keluar kos (check-out / berhenti sewa) penghuni aktif.
     */
    public function checkout(Request $request, $id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->where('role', 'penghuni')
            ->first();

        if (! $user) {
            abort(404, 'Data penghuni tidak ditemukan.');
        }

        $validated = $request->validate([
            'tanggal_keluar' => ['required', 'date'],
            'alasan_keluar' => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal_keluar.required' => 'Tanggal keluar wajib diisi.',
            'tanggal_keluar.date' => 'Format tanggal keluar tidak valid.',
            'alasan_keluar.max' => 'Alasan keluar maksimal 500 karakter.',
        ]);

        $hasil = DB::transaction(function () use ($id, $validated) {
            $booking = Booking::query()
                ->where('user_id', $id)
                ->where('status', 'disetujui')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if (! $booking) {
                return [
                    'ok' => false,
                    'message' => 'Penghuni ini tidak memiliki kontrak hunian aktif untuk di-check-out.',
                ];
            }

            $adaTagihanBelumLunas = $booking->tagihans()
                ->whereIn('status', [
                    'belum_dibayar',
                    'menunggu_verifikasi',
                    'dibayar_sebagian',
                    'terlambat',
                ])
                ->exists();

            if ($adaTagihanBelumLunas) {
                return [
                    'ok' => false,
                    'message' => 'Check-out ditolak. Penghuni masih memiliki tagihan yang belum lunas atau sedang menunggu verifikasi.',
                ];
            }

            $alasan = isset($validated['alasan_keluar']) && trim((string) $validated['alasan_keluar']) !== ''
                ? trim((string) $validated['alasan_keluar'])
                : null;

            $booking->update([
                'status' => 'selesai',
                'tanggal_keluar' => $validated['tanggal_keluar'],
                'alasan_keluar' => $alasan,
            ]);

            Contract::query()
                ->where('booking_id', $booking->id)
                ->where('status', 'aktif')
                ->update([
                    'status' => 'selesai',
                    'tanggal_akhir' => $validated['tanggal_keluar'],
                ]);

            TenantProfile::query()
                ->where('user_id', $id)
                ->update(['status_penghuni' => 'keluar']);

            $kamar = Kamar::query()
                ->whereKey($booking->kamar_id)
                ->lockForUpdate()
                ->first();

            if ($kamar) {
                $penghuniAktifDiKamar = Booking::query()
                    ->where('kamar_id', $kamar->id)
                    ->where('status', 'disetujui')
                    ->count();

                $kamar->update([
                    'jumlah_penghuni' => $penghuniAktifDiKamar,
                    'status' => $kamar->status === 'maintenance'
                        ? 'maintenance'
                        : ($penghuniAktifDiKamar >= $kamar->kapasitas ? 'terisi' : 'tersedia'),
                ]);
            }

            return [
                'ok' => true,
                'message' => 'Check-out berhasil diproses. Status hunian telah selesai dan kamar kembali tersedia.',
            ];
        }, 3);

        return redirect()
            ->route('admin.penghuni.index')
            ->with($hasil['ok'] ? 'success' : 'error', $hasil['message']);
    }

    /**
     * Menghapus akun hanya jika belum memiliki riwayat booking.
     */
    public function destroy($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->where('role', 'penghuni')
            ->first();

        if (!$user) {
            abort(404, 'Data penghuni tidak ditemukan.');
        }

        $memilikiBooking = DB::table('bookings')
            ->where('user_id', $id)
            ->exists();

        if ($memilikiBooking) {
            return redirect()
                ->route('admin.penghuni.index')
                ->with('error', 'Akun tidak dapat dihapus karena memiliki riwayat booking. Riwayat penghuni harus tetap tersimpan.');
        }

        DB::table('users')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Akun penghuni berhasil dihapus.');
    }
}
