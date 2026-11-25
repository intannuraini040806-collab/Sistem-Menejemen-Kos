<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tagihan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function index(Request $request): View
    {
        $semuaTagihan = Tagihan::with([
            'booking.user',
            'booking.kamar',
            'pembayarans.user',
            'pembayarans.verifikator',
        ])->orderByDesc('periode')->orderByDesc('id')->get();

        $hariIni = today();

        $semuaTagihan->each(function (Tagihan $tagihan) use ($hariIni): void {
            $pembayaranDisetujui = $tagihan->pembayarans
                ->contains(fn ($pembayaran) => $pembayaran->status === 'disetujui');

            $adaMenungguVerifikasi = $tagihan->pembayarans
                ->contains(fn ($pembayaran) => $pembayaran->status === 'menunggu_verifikasi');

            $pembayaranTerakhir = $tagihan->pembayarans->sortByDesc('id')->first();
            $tagihan->setAttribute('pembayaran_terakhir', $pembayaranTerakhir);

            if ($tagihan->status === 'lunas' || $pembayaranDisetujui) {
                $status = 'lunas';
            } elseif ($adaMenungguVerifikasi) {
                $status = 'menunggu_verifikasi';
            } elseif (
                $tagihan->tanggal_jatuh_tempo &&
                $tagihan->tanggal_jatuh_tempo->lt($hariIni)
            ) {
                $status = 'terlambat';
            } else {
                $status = 'belum_dibayar';
            }

            $tagihan->setAttribute('status_tampilan', $status);
        });

        $ringkasan = [
            'total' => $semuaTagihan->count(),
            'lunas' => $semuaTagihan->where('status_tampilan', 'lunas')->count(),
            'menunggu_verifikasi' => $semuaTagihan->where('status_tampilan', 'menunggu_verifikasi')->count(),
            'belum_dibayar' => $semuaTagihan->where('status_tampilan', 'belum_dibayar')->count(),
            'terlambat' => $semuaTagihan->where('status_tampilan', 'terlambat')->count(),
            'total_nominal' => $semuaTagihan->sum('jumlah'),
            'nominal_lunas' => $semuaTagihan->where('status_tampilan', 'lunas')->sum('jumlah'),
        ];

        $kataKunci = trim((string) $request->query('q', ''));
        $statusFilter = (string) $request->query('status', '');
        $periodeFilter = (string) $request->query('periode', '');

        $hasilFilter = $semuaTagihan->filter(function (Tagihan $tagihan) use ($kataKunci, $statusFilter, $periodeFilter): bool {
            $nama = $tagihan->booking?->user?->name ?? '';
            $kamar = $tagihan->booking?->kamar?->nomor_kamar ?? '';
            $idTagihan = 'TAG-' . str_pad((string) $tagihan->id, 5, '0', STR_PAD_LEFT);

            $cocokKataKunci = $kataKunci === '' ||
                str_contains(mb_strtolower($nama), mb_strtolower($kataKunci)) ||
                str_contains(mb_strtolower($kamar), mb_strtolower($kataKunci)) ||
                str_contains(mb_strtolower($idTagihan), mb_strtolower($kataKunci)) ||
                str_contains((string) $tagihan->id, $kataKunci);

            $cocokStatus = $statusFilter === '' || $tagihan->status_tampilan === $statusFilter;
            $cocokPeriode = $periodeFilter === '' || $tagihan->periode === $periodeFilter;

            return $cocokKataKunci && $cocokStatus && $cocokPeriode;
        })->values();

        $perHalaman = 10;
        $halaman = LengthAwarePaginator::resolveCurrentPage();
        $tagihans = new LengthAwarePaginator(
            $hasilFilter->forPage($halaman, $perHalaman)->values(),
            $hasilFilter->count(),
            $perHalaman,
            $halaman,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $penghuni = User::query()
            ->where('role', 'penghuni')
            ->whereHas('bookings', fn ($query) => $query->where('status', 'disetujui'))
            ->with(['bookings' => function ($query): void {
                $query->where('status', 'disetujui')
                    ->with('kamar')
                    ->orderByDesc('id');
            }])
            ->orderBy('name')
            ->get()
            ->each(function (User $user): void {
                $user->setAttribute('booking_aktif', $user->bookings->first());
            });

        return view('admin.tagihan.index', compact('tagihans', 'ringkasan', 'penghuni'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateTagihan($request);

        $booking = Booking::with('user', 'kamar')->findOrFail($data['booking_id']);

        if ($booking->status !== 'disetujui' || $booking->user?->role !== 'penghuni') {
            throw ValidationException::withMessages([
                'booking_id' => 'Tagihan hanya dapat dibuat untuk penghuni dengan booking yang sudah disetujui.',
            ]);
        }

        $sudahAda = Tagihan::where('booking_id', $booking->id)
            ->where('periode', $data['periode'])
            ->exists();

        if ($sudahAda) {
            throw ValidationException::withMessages([
                'periode' => 'Booking ini sudah memiliki tagihan pada periode tersebut.',
            ]);
        }

        DB::transaction(function () use ($data): void {
            Tagihan::create([
                'booking_id' => $data['booking_id'],
                'periode' => $data['periode'],
                'jumlah' => $data['jumlah'],
                'tanggal_terbit' => $data['tanggal_terbit'],
                'tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo'],
                'status' => 'belum_dibayar',
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        });

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function update(Request $request, Tagihan $tagihan): RedirectResponse
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'tanggal_terbit' => ['required', 'date_format:Y-m-d'],
            'tanggal_jatuh_tempo' => ['required', 'date_format:Y-m-d'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'jumlah.required' => 'Nominal tagihan wajib diisi.',
            'jumlah.integer' => 'Nominal tagihan harus berupa angka bulat.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi.',
        ]);

        $this->validateDatesWithinPeriod(
            $tagihan->periode,
            $data['tanggal_terbit'],
            $data['tanggal_jatuh_tempo']
        );

        if ($tagihan->pembayarans()->exists() && (int) $data['jumlah'] !== (int) $tagihan->jumlah) {
            throw ValidationException::withMessages([
                'jumlah' => 'Nominal tidak dapat diubah karena tagihan sudah memiliki riwayat pembayaran.',
            ]);
        }

        $tagihan->update($data);

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan): RedirectResponse
    {
        if ($tagihan->pembayarans()->exists()) {
            return redirect()->route('admin.tagihan.index')->with(
                'error',
                'Tagihan tidak dapat dihapus karena sudah memiliki riwayat pembayaran.'
            );
        }

        $tagihan->delete();

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    private function validateTagihan(Request $request): array
    {
        $data = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'periode' => ['required', 'date_format:Y-m'],
            'jumlah' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'tanggal_terbit' => ['required', 'date_format:Y-m-d'],
            'tanggal_jatuh_tempo' => ['required', 'date_format:Y-m-d'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'booking_id.required' => 'Pilih penghuni terlebih dahulu.',
            'booking_id.exists' => 'Data booking penghuni tidak ditemukan.',
            'periode.required' => 'Periode tagihan wajib dipilih.',
            'periode.date_format' => 'Format periode tagihan tidak valid.',
            'jumlah.required' => 'Nominal tagihan wajib diisi.',
            'jumlah.integer' => 'Nominal tagihan harus berupa angka bulat.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo wajib diisi.',
        ]);

        $this->validateDatesWithinPeriod(
            $data['periode'],
            $data['tanggal_terbit'],
            $data['tanggal_jatuh_tempo']
        );

        return $data;
    }

    private function validateDatesWithinPeriod(string $periode, string $tanggalTerbit, string $tanggalJatuhTempo): void
    {
        $awalPeriode = Carbon::createFromFormat('Y-m-d', $periode . '-01')->startOfDay();
        $akhirPeriode = $awalPeriode->copy()->endOfMonth();
        $terbit = Carbon::createFromFormat('Y-m-d', $tanggalTerbit)->startOfDay();
        $jatuhTempo = Carbon::createFromFormat('Y-m-d', $tanggalJatuhTempo)->startOfDay();

        if ($terbit->lt($awalPeriode) || $terbit->gt($akhirPeriode)) {
            throw ValidationException::withMessages([
                'tanggal_terbit' => 'Tanggal terbit harus berada dalam bulan periode tagihan.',
            ]);
        }

        if ($jatuhTempo->lt($awalPeriode) || $jatuhTempo->gt($akhirPeriode)) {
            throw ValidationException::withMessages([
                'tanggal_jatuh_tempo' => 'Tanggal jatuh tempo harus berada dalam bulan periode tagihan.',
            ]);
        }

        if ($jatuhTempo->lt($terbit)) {
            throw ValidationException::withMessages([
                'tanggal_jatuh_tempo' => 'Tanggal jatuh tempo tidak boleh sebelum tanggal terbit.',
            ]);
        }
    }
}
