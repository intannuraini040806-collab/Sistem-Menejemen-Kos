<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    /**
     * Menampilkan seluruh data petugas.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'petugas');

        // Pencarian nama, email, atau nomor telepon.
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $petugas = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $totalPetugas = User::where('role', 'petugas')->count();

        return view('admin.petugas.index', compact(
            'petugas',
            'totalPetugas'
        ));
    }

    /**
     * Menambahkan akun petugas.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role' => 'petugas',
        ]);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    /**
     * Memperbarui data petugas.
     */
    public function update(Request $request, User $petugas)
    {
        abort_unless($petugas->role === 'petugas', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($petugas->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($petugas->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        // Password hanya diperbarui jika diisi.
        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $petugas->update($data);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Menghapus akun petugas.
     */
    public function destroy(User $petugas)
    {
        abort_unless($petugas->role === 'petugas', 404);

        // Melindungi riwayat verifikasi pembayaran.
        if ($petugas->pembayaranDiverifikasi()->exists()) {
            return redirect()
                ->route('admin.petugas.index')
                ->with('error', 'Akun tidak dapat dihapus karena masih tercatat sebagai petugas yang memverifikasi pembayaran.');
        }

        DB::transaction(function () use ($petugas) {
            $petugas->delete();
        });

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Akun petugas berhasil dihapus.');
    }
}
