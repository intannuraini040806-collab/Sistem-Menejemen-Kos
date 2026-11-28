<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contract;
use App\Models\InvoiceItem;
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
    /**
     * Menampilkan daftar tagihan beserta ringkasan status.
     */
    public function index(Request $request): View
    {
        $semuaTagihan = Tagihan::with([
            'booking.user',
            'booking.kamar',
            'contract',
            'items',
            'pembayarans.user',
            'pembayarans.verifikator',
        ])
            ->orderByDesc('periode')
            ->orderByDesc('id')
            ->get();

        $hariIni = today();

        // Hitung status setiap tagihan menggunakan aturan yang sama.
        $semuaTagihan->each(function (Tagihan $tagihan) use ($hariIni): void {
            $totalTerbayar = (int) $tagihan->pembayarans
                ->where('status', 'disetujui')
                ->sum('jumlah_bayar');

            $totalKewajiban = (int) $tagihan->jumlah
                + (int) $tagihan->denda;

            $sisaTagihan = max(0, $totalKewajiban - $totalTerbayar);

            $adaMenungguVerifikasi = $tagihan->pembayarans
                ->contains(function ($pembayaran): bool {
                    return $pembayaran->status === 'menunggu_verifikasi';
                });

            $pembayaranTerakhir = $tagihan->pembayarans
                ->sortByDesc('id')
                ->first();

            $tagihan->setAttribute('pembayaran_terakhir', $pembayaranTerakhir);
            $tagihan->setAttribute('total_terbayar', $totalTerbayar);
            $tagihan->setAttribute('sisa_tagihan', $sisaTagihan);

            $jatuhTempo = $tagihan->tanggal_jatuh_tempo
                ? Carbon::parse($tagihan->tanggal_jatuh_tempo)->startOfDay()
                : null;

            /*
             * Urutan status:
             * 1. Lunas: seluruh kewajiban sudah dibayar.
             * 2. Menunggu verifikasi: ada pembayaran yang belum diverifikasi.
             * 3. Terlambat: jatuh tempo lewat dan masih ada sisa kewajiban.
             * 4. Dibayar sebagian: sudah ada pembayaran tetapi belum lunas.
             * 5. Belum dibayar: belum ada pembayaran dan belum terlambat.
             */

            if (
                $totalKewajiban > 0 &&
                $totalTerbayar >= $totalKewajiban
            ) {
                $status = 'lunas';
            } elseif ($adaMenungguVerifikasi) {
                $status = 'menunggu_verifikasi';
            } elseif (
                $sisaTagihan > 0 &&
                $jatuhTempo !== null &&
                $jatuhTempo->lt($hariIni)
            ) {
                $status = 'terlambat';
            } elseif ($totalTerbayar > 0) {
                $status = 'dibayar_sebagian';
            } else {
                $status = 'belum_dibayar';
            }

            $tagihan->setAttribute('status_tampilan', $status);
        });

        // Ringkasan dihitung dari hasil klasifikasi yang sama.
        $ringkasan = [
            'total' => $semuaTagihan->count(),

            'lunas' => $semuaTagihan
                ->where('status_tampilan', 'lunas')
                ->count(),

            'menunggu_verifikasi' => $semuaTagihan
                ->where('status_tampilan', 'menunggu_verifikasi')
                ->count(),

            'dibayar_sebagian' => $semuaTagihan
                ->where('status_tampilan', 'dibayar_sebagian')
                ->count(),

            'belum_dibayar' => $semuaTagihan
                ->where('status_tampilan', 'belum_dibayar')
                ->count(),

            'terlambat' => $semuaTagihan
                ->where('status_tampilan', 'terlambat')
                ->count(),

            'total_nominal' => $semuaTagihan->sum(
                fn ($tagihan) => (int) $tagihan->jumlah + (int) $tagihan->denda
            ),

            'nominal_lunas' => $semuaTagihan
                ->where('status_tampilan', 'lunas')
                ->sum(
                    fn ($tagihan) => (int) $tagihan->jumlah + (int) $tagihan->denda
                ),
        ];

        // Filter pencarian.
        $kataKunci = trim((string) $request->query('q', ''));
        $statusFilter = (string) $request->query('status', '');
        $periodeFilter = (string) $request->query('periode', '');

        $hasilFilter = $semuaTagihan->filter(
            function (Tagihan $tagihan) use (
                $kataKunci,
                $statusFilter,
                $periodeFilter
            ): bool {
                $nama = $tagihan->booking?->user?->name ?? '';
                $kamar = $tagihan->booking?->kamar?->nomor_kamar ?? '';

                $idTagihan = $tagihan->nomor_invoice
                    ?? ('TAG-' . str_pad(
                        (string) $tagihan->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    ));

                $kata = mb_strtolower($kataKunci);

                $cocokKataKunci = $kataKunci === ''
                    || str_contains(mb_strtolower($nama), $kata)
                    || str_contains(mb_strtolower($kamar), $kata)
                    || str_contains(mb_strtolower($idTagihan), $kata)
                    || str_contains((string) $tagihan->id, $kataKunci);

                $cocokStatus = $statusFilter === ''
                    || $tagihan->status_tampilan === $statusFilter;

                $cocokPeriode = $periodeFilter === ''
                    || $tagihan->periode === $periodeFilter;

                return $cocokKataKunci
                    && $cocokStatus
                    && $cocokPeriode;
            }
        )->values();

        // Pagination.
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

        // Data penghuni untuk form tambah tagihan.
        $penghuni = User::query()
            ->where('role', 'penghuni')
            ->whereHas('bookings', function ($query): void {
                $query->where('status', 'disetujui');
            })
            ->with([
                'bookings' => function ($query): void {
                    $query->where('status', 'disetujui')
                        ->with('kamar')
                        ->orderByDesc('id');
                },
            ])
            ->orderBy('name')
            ->get()
            ->each(function (User $user): void {
                $user->setAttribute(
                    'booking_aktif',
                    $user->bookings->first()
                );
            });

        return view(
            'admin.tagihan.index',
            compact('tagihans', 'ringkasan', 'penghuni')
        );
    }

    /**
     * Membuat tagihan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateTagihan($request);

        $booking = Booking::with('user', 'kamar')
            ->findOrFail($data['booking_id']);

        if (
            $booking->status !== 'disetujui' ||
            $booking->user?->role !== 'penghuni'
        ) {
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

        $contract = Contract::where('booking_id', $booking->id)
            ->where('status', 'aktif')
            ->first();

        $itemsInput = $data['items'] ?? [];

        $totalNominal = (int) $data['jumlah'];

        if (!empty($itemsInput)) {
            $totalNominal = collect($itemsInput)->sum(
                fn ($item) => (int) ($item['nominal'] ?? 0)
            );

            if ($totalNominal <= 0) {
                throw ValidationException::withMessages([
                    'items' => 'Total nominal seluruh item tagihan harus lebih dari nol.',
                ]);
            }
        }

        DB::transaction(function () use (
            $data,
            $booking,
            $contract,
            $itemsInput,
            $totalNominal
        ): void {
            $nomorInvoice = 'INV-'
                . str_replace('-', '', $data['periode'])
                . '-'
                . str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT)
                . '-'
                . random_int(10, 99);

            $tagihan = Tagihan::create([
                'nomor_invoice' => $nomorInvoice,
                'booking_id' => $data['booking_id'],
                'contract_id' => $contract?->id,
                'periode' => $data['periode'],
                'jumlah' => $totalNominal,
                'denda' => 0,
                'tanggal_terbit' => $data['tanggal_terbit'],
                'tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo'],
                'status' => 'belum_dibayar',
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            if (!empty($itemsInput)) {
                foreach ($itemsInput as $item) {
                    $nominal = (int) ($item['nominal'] ?? 0);

                    if ($nominal <= 0) {
                        continue;
                    }

                    InvoiceItem::create([
                        'tagihan_id' => $tagihan->id,
                        'nama_item' => $item['nama_item'],
                        'jenis' => $item['jenis'] ?? 'lainnya',
                        'nominal' => $nominal,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
            } else {
                InvoiceItem::create([
                    'tagihan_id' => $tagihan->id,
                    'nama_item' => "Sewa Kamar {$booking->kamar?->nomor_kamar} ({$data['periode']})",
                    'jenis' => 'sewa_pokok',
                    'nominal' => $totalNominal,
                ]);
            }
        });

        return redirect()
            ->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil ditambahkan.');
    }

    /**
     * Memperbarui tagihan.
     */
    public function update(
        Request $request,
        Tagihan $tagihan
    ): RedirectResponse {
        $data = $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:2147483647',
            ],
            'tanggal_terbit' => [
                'required',
                'date_format:Y-m-d',
            ],
            'tanggal_jatuh_tempo' => [
                'required',
                'date_format:Y-m-d',
            ],
            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
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

        if (
            $tagihan->pembayarans()->exists() &&
            (int) $data['jumlah'] !== (int) $tagihan->jumlah
        ) {
            throw ValidationException::withMessages([
                'jumlah' => 'Nominal tidak dapat diubah karena tagihan sudah memiliki riwayat pembayaran.',
            ]);
        }

        $tagihan->update($data);

        return redirect()
            ->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil diperbarui.');
    }

    /**
     * Menghapus tagihan yang belum memiliki riwayat pembayaran.
     */
    public function destroy(Tagihan $tagihan): RedirectResponse
    {
        if ($tagihan->pembayarans()->exists()) {
            return redirect()
                ->route('admin.tagihan.index')
                ->with(
                    'error',
                    'Tagihan tidak dapat dihapus karena sudah memiliki riwayat pembayaran.'
                );
        }

        $tagihan->delete();

        return redirect()
            ->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dihapus.');
    }

    /**
     * Validasi input tagihan.
     */
    private function validateTagihan(Request $request): array
    {
        $data = $request->validate([
            'booking_id' => [
                'required',
                'integer',
                'exists:bookings,id',
            ],
            'periode' => [
                'required',
                'date_format:Y-m',
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:2147483647',
            ],
            'tanggal_terbit' => [
                'required',
                'date_format:Y-m-d',
            ],
            'tanggal_jatuh_tempo' => [
                'required',
                'date_format:Y-m-d',
            ],
            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'items' => [
                'nullable',
                'array',
            ],
            'items.*.nama_item' => [
                'required_with:items',
                'string',
                'max:100',
            ],
            'items.*.jenis' => [
                'nullable',
                'string',
                'max:30',
            ],
            'items.*.nominal' => [
                'required_with:items',
                'integer',
                'min:0',
            ],
            'items.*.keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],
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

    /**
     * Memastikan tanggal terbit dan jatuh tempo sesuai periode tagihan.
     */
    private function validateDatesWithinPeriod(
        string $periode,
        string $tanggalTerbit,
        string $tanggalJatuhTempo
    ): void {
        $awalPeriode = Carbon::createFromFormat(
            'Y-m-d',
            $periode . '-01'
        )->startOfDay();

        $akhirPeriode = $awalPeriode->copy()->endOfMonth();

        $terbit = Carbon::createFromFormat(
            'Y-m-d',
            $tanggalTerbit
        )->startOfDay();

        $jatuhTempo = Carbon::createFromFormat(
            'Y-m-d',
            $tanggalJatuhTempo
        )->startOfDay();

        if (
            $terbit->lt($awalPeriode) ||
            $terbit->gt($akhirPeriode)
        ) {
            throw ValidationException::withMessages([
                'tanggal_terbit' => 'Tanggal terbit harus berada dalam bulan periode tagihan.',
            ]);
        }

        if (
            $jatuhTempo->lt($awalPeriode) ||
            $jatuhTempo->gt($akhirPeriode)
        ) {
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
