<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Setting;
use Carbon\Carbon;

class KuitansiService
{
    /**
     * Menyusun seluruh data yang ditampilkan pada kuitansi.
     */
    public function susunData(Pembayaran $pembayaran): array
    {
        $pembayaran->loadMissing(['user', 'verifikator', 'tagihan.booking.kamar', 'tagihan.booking.user', 'booking.kamar']);

        $pembayaran->terbitkanKuitansi();

        $tagihan = $pembayaran->tagihan;
        $booking = $tagihan?->booking ?? $pembayaran->booking;
        $penghuni = $pembayaran->user ?? $booking?->user;
        $isDp = $pembayaran->jenis_pembayaran === 'dp_booking';

        $periode = null;
        if ($tagihan?->periode && preg_match('/^\d{4}-\d{2}$/', $tagihan->periode)) {
            $periode = Carbon::createFromFormat('Y-m', $tagihan->periode)->locale('id')->translatedFormat('F Y');
        }

        $untukPembayaran = $isDp
            ? 'Uang muka (DP) booking kamar ' . ($booking?->kamar?->nomor_kamar ?? '-')
            : 'Pembayaran sewa kamar ' . ($booking?->kamar?->nomor_kamar ?? '-') . ($periode ? ' periode ' . $periode : '');

        $totalTagihan = null;
        $terbayarSampaiSini = null;
        $sisa = null;
        $lunas = true;

        if ($tagihan) {
            $totalTagihan = (int) $tagihan->jumlah + (int) $tagihan->denda;
            $terbayarSampaiSini = (int) Pembayaran::query()
                ->where('tagihan_id', $tagihan->id)
                ->where('status', 'disetujui')
                ->where('id', '<=', $pembayaran->id)
                ->sum('jumlah_bayar');
            $sisa = max(0, $totalTagihan - $terbayarSampaiSini);
            $lunas = $sisa === 0;
        }

        $metode = match (strtolower((string) $pembayaran->metode_pembayaran)) {
            'transfer' => 'Transfer Bank',
            'tunai' => 'Tunai',
            default => ucfirst((string) $pembayaran->metode_pembayaran) ?: '-',
        };

        $jumlah = (int) $pembayaran->jumlah_bayar;

        return [
            'nomor' => $pembayaran->nomor_kuitansi,
            'tanggalTerbit' => $this->tanggal($pembayaran->tanggal_kuitansi),
            'diterimaDari' => $penghuni?->name ?? '-',
            'nomorKamar' => $booking?->kamar?->nomor_kamar ?? '-',
            'untukPembayaran' => $untukPembayaran,
            'nomorInvoice' => $tagihan?->nomor_invoice,
            'jumlah' => $jumlah,
            'jumlahFormat' => 'Rp ' . number_format($jumlah, 0, ',', '.'),
            'terbilang' => $this->terbilang($jumlah) . ' rupiah',
            'metode' => $metode,
            'tanggalBayar' => $this->tanggal($pembayaran->tanggal_pembayaran),
            'totalTagihan' => $totalTagihan,
            'terbayar' => $terbayarSampaiSini,
            'sisa' => $sisa,
            'lunas' => $lunas,
            'adaTagihan' => $tagihan !== null,
            'penerima' => $pembayaran->verifikator?->name ?? '-',
            'namaKos' => Setting::getVal('nama_kos', 'KosHaven - Hunian Nyaman'),
            'alamatKos' => Setting::getVal('alamat_kos', ''),
            'whatsappKos' => Setting::getVal('whatsapp_pengelola', ''),
            'emailKos' => Setting::getVal('email_kos', 'info@koshaven.com'),
        ];
    }

    private function tanggal($tanggal): string
    {
        return $tanggal ? Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') : '-';
    }

    /**
     * Mengubah angka menjadi kalimat terbilang bahasa Indonesia.
     */
    public function terbilang(int $angka): string
    {
        if ($angka < 0) {
            return 'minus ' . $this->terbilang(abs($angka));
        }

        $hasil = $this->bilang($angka);

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }

    private function bilang(int $n): string
    {
        $satuan = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($n < 12) {
            return $satuan[$n];
        }
        if ($n < 20) {
            return $this->bilang($n - 10) . ' belas';
        }
        if ($n < 100) {
            return $this->bilang(intdiv($n, 10)) . ' puluh ' . ($n % 10 ? $this->bilang($n % 10) : '');
        }
        if ($n < 200) {
            return 'seratus ' . ($n - 100 ? $this->bilang($n - 100) : '');
        }
        if ($n < 1000) {
            return $this->bilang(intdiv($n, 100)) . ' ratus ' . ($n % 100 ? $this->bilang($n % 100) : '');
        }
        if ($n < 2000) {
            return 'seribu ' . ($n - 1000 ? $this->bilang($n - 1000) : '');
        }
        if ($n < 1_000_000) {
            return $this->bilang(intdiv($n, 1000)) . ' ribu ' . ($n % 1000 ? $this->bilang($n % 1000) : '');
        }
        if ($n < 1_000_000_000) {
            return $this->bilang(intdiv($n, 1_000_000)) . ' juta ' . ($n % 1_000_000 ? $this->bilang($n % 1_000_000) : '');
        }
        if ($n < 1_000_000_000_000) {
            return $this->bilang(intdiv($n, 1_000_000_000)) . ' miliar ' . ($n % 1_000_000_000 ? $this->bilang($n % 1_000_000_000) : '');
        }

        return $this->bilang(intdiv($n, 1_000_000_000_000)) . ' triliun ' . ($n % 1_000_000_000_000 ? $this->bilang($n % 1_000_000_000_000) : '');
    }
}
