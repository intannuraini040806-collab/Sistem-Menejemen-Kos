<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Memeriksa email dan password.
        if (!Auth::guard('web')->attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password yang kamu masukkan salah.',
                ])
                ->onlyInput('email');
        }

        // Memperbarui session setelah login berhasil.
        $request->session()->regenerate();

        $user = Auth::guard('web')->user();

        if (!$user) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Login gagal. Silakan coba kembali.',
                ]);
        }

        return $this->redirectByRole($user);
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Memproses registrasi penghuni.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/i',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^08[0-9]{8,11}$/',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers(),
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama maksimal 100 karakter.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.string' => 'Alamat email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.regex' => 'Email harus menggunakan alamat Gmail dengan akhiran @gmail.com.',
            'email.unique' => 'Email sudah terdaftar. Gunakan email lain.',

            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.string' => 'Nomor HP harus berupa teks.',
            'phone.regex' => 'Nomor HP harus diawali 08 dan terdiri dari 10 sampai 13 digit angka.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung huruf.',
            'password.numbers' => 'Password harus mengandung angka.',
        ]);

        // Membuat akun penghuni baru.
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role' => 'penghuni',
        ]);

        $user->notify(new UserActivityNotification([
            'key' => 'welcome-' . $user->id,
            'title' => 'Selamat Datang di KosHaven!',
            'message' => 'Halo ' . $user->name . ', selamat bergabung menjadi penghuni KosHaven. Semoga nyaman dan betah selama tinggal di sini!',
            'type' => 'welcome',
            'icon' => 'bi-house-heart',
            'url' => route('penghuni.dashboard'),
        ]));

        // Login otomatis setelah registrasi berhasil.
        Auth::guard('web')->login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('penghuni.dashboard')
            ->with('success', 'Registrasi berhasil. Selamat datang di KosHaven!');
    }

    /**
     * Mengarahkan pengguna sesuai role.
     */
    private function redirectByRole(User $user)
    {
        $routes = [
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            'penghuni' => 'penghuni.dashboard',
        ];

        if (!isset($routes[$user->role])) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Role akun tidak dikenali. Silakan hubungi administrator.',
                ]);
        }

        return redirect()->route($routes[$user->role]);
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Kamu berhasil keluar dari akun.');
    }
}
