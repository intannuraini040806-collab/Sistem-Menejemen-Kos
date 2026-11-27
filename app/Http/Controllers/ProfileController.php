<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TenantProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private function buildInitials(string $name, string $fallback = 'KH'): string
    {
        $initials = collect(preg_split('/\s+/', trim($name)))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : $fallback;
    }

    public function showAdmin(Request $request): View
    {
        $user = $request->user();

        return view('admin.profil.index', [
            'user' => $user,
            'profileData' => [
                'id' => $user->id,
                'fullName' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'role' => 'Admin KosHaven',
                'initials' => $this->buildInitials($user->name, 'AD'),
                'joinedAt' => $user->created_at?->locale('id')->translatedFormat('F Y') ?? '-',
            ],
        ]);
    }

    public function showPetugas(Request $request): View
    {
        $user = $request->user();

        return view('petugas.profil', [
            'user' => $user,
            'profileData' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => '',
                'role' => 'Petugas KosHaven',
                'initials' => $this->buildInitials($user->name, 'PT'),
                'joinedAt' => $user->created_at?->locale('id')->translatedFormat('F Y') ?? '-',
            ],
        ]);
    }

    public function showPenghuni(Request $request): View
    {
        $user = $request->user()->loadMissing('tenantProfile');

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

        $joinDate = $bookingAktif?->tanggal_masuk
            ? $bookingAktif->tanggal_masuk->locale('id')->translatedFormat('d F Y')
            : ($user->created_at?->locale('id')->translatedFormat('F Y') ?? '-');

        return view('penghuni.profil', [
            'user' => $user,
            'profileData' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => $user->tenantProfile?->alamat_asal ?? '',
                'pekerjaan' => $user->tenantProfile?->pekerjaan ?? '',
                'room' => $bookingAktif?->kamar?->nomor_kamar ?? 'Belum ada kamar',
                'joinDate' => $joinDate,
                'initials' => $this->buildInitials($user->name, 'PG'),
                'statusPenghuni' => $user->tenantProfile?->status_penghuni ?? 'aktif',
            ],
        ]);
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^(\+?[0-9\s\-]{8,20})?$/'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan oleh akun lain.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
        ]);

        $user->update([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'phone' => isset($validated['phone']) && trim((string) $validated['phone']) !== ''
                ? trim((string) $validated['phone'])
                : null,
        ]);

        if ($user->isPenghuni() && array_key_exists('address', $validated)) {
            TenantProfile::updateOrCreate(
                ['user_id' => $user->id],
                ['alamat_asal' => trim((string) ($validated['address'] ?? ''))]
            );
        }

        $freshUser = $user->fresh('tenantProfile');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Profil berhasil diperbarui.',
                'profile' => [
                    'id' => $freshUser->id,
                    'name' => $freshUser->name,
                    'fullName' => $freshUser->name,
                    'email' => $freshUser->email,
                    'phone' => $freshUser->phone ?? '',
                    'address' => $freshUser->tenantProfile?->alamat_asal ?? '',
                    'initials' => $this->buildInitials($freshUser->name),
                ],
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Password lama tidak sesuai.',
                    'errors' => [
                        'current_password' => ['Password lama tidak sesuai.'],
                    ],
                ], 422);
            }

            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Password berhasil diperbarui.',
            ]);
        }

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
