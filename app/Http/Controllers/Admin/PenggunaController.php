<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    /**
     * Menampilkan seluruh akun pengguna.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian nama, email, dan nomor HP.
        if ($request->filled('search')) {
            $keyword = trim($request->search);

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        // Filter berdasarkan role.
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $pengguna = $query
            ->withCount([
                'bookings',
                'pembayarans',
                'pembayaranDiverifikasi',
            ])
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $ringkasan = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'petugas' => User::where('role', 'petugas')->count(),
            'penghuni' => User::where('role', 'penghuni')->count(),
        ];

        return view('admin.pengguna.index', compact(
            'pengguna',
            'ringkasan'
        ));
    }

    /**
     * Menambahkan akun pengguna.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+().\-\s]+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:72',
            ],
            'role' => [
                'required',
                Rule::in(['admin', 'petugas', 'penghuni']),
            ],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'phone.regex' => 'Format nomor HP tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role pengguna tidak valid.',
        ]);

        $validated['name'] = trim($validated['name']);
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['phone'] = isset($validated['phone'])
            ? trim($validated['phone'])
            : null;

        // Password otomatis di-hash melalui cast model User.
        User::create($validated);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Memperbarui akun pengguna.
     */
    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($pengguna->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+().\-\s]+$/',
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:72',
            ],
            'role' => [
                'required',
                Rule::in(['admin', 'petugas', 'penghuni']),
            ],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'phone.regex' => 'Format nomor HP tidak valid.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role pengguna tidak valid.',
        ]);

        $userLogin = $request->user();

        // Admin tidak boleh mengubah role akunnya sendiri.
        if (
            $userLogin &&
            $userLogin->id === $pengguna->id &&
            $validated['role'] !== 'admin'
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Kamu tidak dapat mengubah role akun yang sedang digunakan.',
                ]);
        }

        // Lindungi satu-satunya akun Admin.
        if (
            $pengguna->role === 'admin' &&
            $validated['role'] !== 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' => 'Tidak dapat mengubah role karena sistem harus memiliki minimal satu Admin.',
                ]);
        }

        $validated['name'] = trim($validated['name']);
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['phone'] = isset($validated['phone'])
            ? trim($validated['phone'])
            : null;

        // Password kosong berarti password lama dipertahankan.
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $pengguna->update($validated);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request, User $pengguna)
    {
        $userLogin = $request->user();

        // Tidak boleh menghapus akun sendiri.
        if ($userLogin && $userLogin->id === $pengguna->id) {
            return back()->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dihapus.'
            );
        }

        // Lindungi Admin terakhir.
        if (
            $pengguna->role === 'admin' &&
            User::where('role', 'admin')->count() <= 1
        ) {
            return back()->with(
                'error',
                'Akun Admin terakhir tidak dapat dihapus.'
            );
        }

        // Cek seluruh relasi yang dapat membuat penghapusan berisiko.
        $memilikiBooking = $pengguna->bookings()->exists();

        $memilikiPembayaran = $pengguna->pembayarans()->exists();

        $PernahMemverifikasi = $pengguna
            ->pembayaranDiverifikasi()
            ->exists();

        if (
            $memilikiBooking ||
            $memilikiPembayaran ||
            $PernahMemverifikasi
        ) {
            return back()->with(
                'error',
                'Akun tidak dapat dihapus karena masih memiliki riwayat booking atau pembayaran. Data akun tetap dipertahankan.'
            );
        }

        DB::transaction(function () use ($pengguna) {
            $pengguna->delete();
        });

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
