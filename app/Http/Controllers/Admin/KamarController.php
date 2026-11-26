<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Kamar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KamarController extends Controller
{
    /**
     * Menampilkan halaman Data Kamar.
     */
    public function index()
    {
        return view('admin.kamar.index');
    }

    /**
     * Mengambil seluruh data kamar untuk AJAX (mendukung filter lantai & tipe).
     */
    public function data(Request $request)
    {
        $query = Kamar::with('facilities')
            ->orderBy('lantai', 'asc')
            ->orderBy('nomor_kamar', 'asc');

        if ($request->filled('lantai')) {
            $query->where('lantai', (int) $request->input('lantai'));
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', strtolower($request->input('tipe')));
        }

        $kamars = $query->get()->map(function ($kamar) {
            return $this->formatKamar($kamar);
        });

        return response()->json([
            'success' => true,
            'data' => $kamars,
        ]);
    }

    /**
     * Menambahkan kamar baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateKamar($request);

        $kapasitas = $this->getKapasitas($validated['tipe']);

        $status = $this->getStatus(
            $validated['status'] ?? 'tersedia',
            (int) $validated['jumlah_penghuni'],
            $kapasitas
        );

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kamar', 'public');
        }

        $kamar = Kamar::create([
            'nomor_kamar' => strtoupper($validated['nomor_kamar']),
            'lantai' => (int) ($validated['lantai'] ?? $this->deteksiLantaiDariNomor($validated['nomor_kamar'])),
            'tipe' => $validated['tipe'],
            'harga' => $validated['harga'],
            'kapasitas' => $kapasitas,
            'jumlah_penghuni' => $validated['jumlah_penghuni'],
            'jenis_kamar_mandi' => $validated['jenis_kamar_mandi'],
            'status' => $status,
            'fasilitas' => $validated['fasilitas'] ?? [],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoPath,
        ]);

        $this->sinkronkanFasilitasPivot($kamar, $validated['fasilitas'] ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil ditambahkan.',
            'data' => $this->formatKamar($kamar->fresh('facilities')),
        ], 201);
    }

    /**
     * Memperbarui data kamar.
     */
    public function update(Request $request, Kamar $kamar)
    {
        $validated = $this->validateKamar($request, $kamar->id);

        $kapasitas = $this->getKapasitas($validated['tipe']);

        $status = $this->getStatus(
            $validated['status'] ?? 'tersedia',
            (int) $validated['jumlah_penghuni'],
            $kapasitas
        );

        $fotoPath = $kamar->foto;
        if ($request->hasFile('foto')) {
            if ($kamar->foto && Storage::disk('public')->exists($kamar->foto)) {
                Storage::disk('public')->delete($kamar->foto);
            }
            $fotoPath = $request->file('foto')->store('kamar', 'public');
        }

        $kamar->update([
            'nomor_kamar' => strtoupper($validated['nomor_kamar']),
            'lantai' => (int) ($validated['lantai'] ?? $kamar->lantai ?? $this->deteksiLantaiDariNomor($validated['nomor_kamar'])),
            'tipe' => $validated['tipe'],
            'harga' => $validated['harga'],
            'kapasitas' => $kapasitas,
            'jumlah_penghuni' => $validated['jumlah_penghuni'],
            'jenis_kamar_mandi' => $validated['jenis_kamar_mandi'],
            'status' => $status,
            'fasilitas' => $validated['fasilitas'] ?? [],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoPath,
        ]);

        $this->sinkronkanFasilitasPivot($kamar, $validated['fasilitas'] ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Data kamar berhasil diperbarui.',
            'data' => $this->formatKamar($kamar->fresh('facilities')),
        ]);
    }

    /**
     * Menghapus kamar.
     */
    public function destroy(Kamar $kamar)
    {
        try {
            $nomorKamar = $kamar->nomor_kamar;

            if ($kamar->foto && Storage::disk('public')->exists($kamar->foto)) {
                Storage::disk('public')->delete($kamar->foto);
            }

            $kamar->facilities()->detach();
            $kamar->delete();

            return response()->json([
                'success' => true,
                'message' => "Kamar {$nomorKamar} berhasil dihapus.",
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kamar tidak dapat dihapus karena sudah digunakan dalam data booking atau transaksi.',
            ], 422);
        }
    }

    /**
     * Validasi data kamar.
     */
    private function validateKamar(Request $request, ?int $kamarId = null): array
    {
        $tipe = strtolower($request->input('tipe', ''));

        $prefix = match ($tipe) {
            'single' => 'A',
            'double' => 'B',
            default => null,
        };

        $expectedPrice = match ($tipe) {
            'single' => 1500000,
            'double' => 2000000,
            default => null,
        };

        $rules = [
            'nomor_kamar' => [
                'required',
                'string',
                'max:20',
                'regex:/^[AB][0-9]{2,}$/i',
                Rule::unique('kamars', 'nomor_kamar')->ignore($kamarId),
            ],

            'lantai' => [
                'nullable',
                'integer',
                'min:1',
                'max:10',
            ],

            'tipe' => [
                'required',
                Rule::in(['single', 'double']),
            ],

            'harga' => [
                'required',
                'integer',
                'min:1',
                Rule::in($expectedPrice ? [$expectedPrice] : []),
            ],

            'jumlah_penghuni' => [
                'required',
                'integer',
                'min:0',
                'max:' . ($tipe === 'double' ? 2 : 1),
            ],

            'jenis_kamar_mandi' => [
                'required',
                Rule::in(['dalam_kamar', 'bersama']),
            ],

            'status' => [
                'required',
                Rule::in(['tersedia', 'terisi', 'maintenance']),
            ],

            'fasilitas' => [
                'nullable',
                'array',
            ],

            'fasilitas.*' => [
                'string',
                Rule::in([
                    'AC',
                    'Wi-Fi',
                    'CCTV',
                    'Laundry',
                    'Lemari',
                    'Meja',
                ]),
            ],

            'deskripsi' => [
                'nullable',
                'string',
                'max:500',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];

        $messages = [
            'nomor_kamar.required' => 'Nomor kamar wajib diisi.',
            'nomor_kamar.unique' => 'Nomor kamar sudah digunakan.',
            'nomor_kamar.regex' => 'Nomor kamar Single harus diawali A dan Double harus diawali B.',
            'nomor_kamar.max' => 'Nomor kamar maksimal 20 karakter.',

            'lantai.integer' => 'Lantai harus berupa angka.',
            'lantai.min' => 'Lantai minimal 1.',
            'lantai.max' => 'Lantai maksimal 10.',

            'tipe.required' => 'Tipe kamar wajib dipilih.',
            'tipe.in' => 'Tipe kamar tidak valid.',

            'harga.required' => 'Harga kamar wajib diisi.',
            'harga.in' => 'Harga kamar tidak sesuai dengan tipe kamar.',

            'jumlah_penghuni.required' => 'Jumlah penghuni wajib diisi.',
            'jumlah_penghuni.integer' => 'Jumlah penghuni harus berupa angka.',
            'jumlah_penghuni.min' => 'Jumlah penghuni tidak boleh kurang dari 0.',
            'jumlah_penghuni.max' => 'Jumlah penghuni melebihi kapasitas kamar.',

            'jenis_kamar_mandi.required' => 'Jenis kamar mandi wajib dipilih.',
            'jenis_kamar_mandi.in' => 'Jenis kamar mandi tidak valid.',

            'status.required' => 'Status kamar wajib dipilih.',
            'status.in' => 'Status kamar tidak valid.',

            'fasilitas.array' => 'Format fasilitas tidak valid.',
            'fasilitas.*.in' => 'Terdapat fasilitas yang tidak tersedia.',

            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'foto.image' => 'File foto kamar harus berupa gambar.',
            'foto.max' => 'Ukuran foto kamar maksimal 2MB.',
        ];

        $validated = $request->validate($rules, $messages);

        if ($prefix && !str_starts_with(
            strtoupper($validated['nomor_kamar']),
            $prefix
        )) {
            abort(response()->json([
                'success' => false,
                'message' => "Nomor kamar {$tipe} harus diawali huruf {$prefix}.",
                'errors' => [
                    'nomor_kamar' => [
                        "Nomor kamar {$tipe} harus diawali huruf {$prefix}.",
                    ],
                ],
            ], 422));
        }

        return $validated;
    }

    /**
     * Sinkronkan nama fasilitas ke tabel pivot facility_kamar.
     */
    private function sinkronkanFasilitasPivot(Kamar $kamar, array $namaFasilitas): void
    {
        if (empty($namaFasilitas)) {
            $kamar->facilities()->sync([]);
            return;
        }

        $ids = [];
        foreach ($namaFasilitas as $nama) {
            $facility = Facility::firstOrCreate(
                ['nama' => $nama],
                ['kategori' => 'kamar']
            );
            $ids[] = $facility->id;
        }

        $kamar->facilities()->sync($ids);
    }

    /**
     * Deteksi otomatis lantai dari nomor kamar jika form belum mengirimkan input lantai
     * (misal A201 / B201 -> Lantai 2, selain itu -> Lantai 1).
     */
    private function deteksiLantaiDariNomor(string $nomorKamar): int
    {
        $angka = preg_replace('/[^0-9]/', '', $nomorKamar);

        if (strlen($angka) >= 3 && (int) $angka[0] >= 2) {
            return (int) $angka[0];
        }

        return 1;
    }

    /**
     * Menentukan kapasitas berdasarkan tipe kamar.
     */
    private function getKapasitas(string $tipe): int
    {
        return match ($tipe) {
            'single' => 1,
            'double' => 2,
            default => 1,
        };
    }

    /**
     * Menentukan status kamar.
     */
    private function getStatus(
        string $status,
        int $jumlahPenghuni,
        int $kapasitas
    ): string {
        if ($status === 'maintenance') {
            return 'maintenance';
        }

        return $jumlahPenghuni >= $kapasitas
            ? 'terisi'
            : 'tersedia';
    }

    /**
     * Mengubah format database menjadi format yang dibaca JavaScript.
     */
    private function formatKamar(Kamar $kamar): array
    {
        $fasilitas = $kamar->fasilitas;

        if (is_string($fasilitas)) {
            $fasilitas = json_decode($fasilitas, true);
        }

        if (!is_array($fasilitas)) {
            $fasilitas = [];
        }

        $lantai = (int) ($kamar->lantai ?? 1);

        return [
            'id' => $kamar->id,
            'number' => $kamar->nomor_kamar,
            'floor' => $lantai,
            'floor_label' => "Lantai {$lantai}",
            'type' => $kamar->tipe === 'single'
                ? 'Single'
                : 'Double',
            'capacity' => (int) $kamar->kapasitas,
            'occupants' => (int) $kamar->jumlah_penghuni,
            'price' => (int) $kamar->harga,
            'bathroom' => $kamar->jenis_kamar_mandi === 'dalam_kamar'
                ? 'Dalam Kamar'
                : 'Bersama',
            'status' => match ($kamar->status) {
                'tersedia' => 'Kosong',
                'terisi' => 'Terisi',
                'maintenance' => 'Perbaikan',
                default => 'Kosong',
            },
            'facilities' => array_values($fasilitas),
            'description' => $kamar->deskripsi ?? '',
            'photo_url' => $kamar->foto ? asset('storage/' . $kamar->foto) : null,
        ];
    }
}