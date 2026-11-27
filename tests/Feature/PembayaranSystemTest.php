<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PembayaranSystemTest extends TestCase
{
    use RefreshDatabase;

    private function buatSkenarioTagihan(int $nominal = 1500000): array
    {
        $penghuni = User::factory()->create([
            'name' => 'Mohammad Irfan',
            'role' => 'penghuni',
        ]);

        $petugas = User::factory()->create([
            'name' => 'Petugas KosHaven',
            'role' => 'petugas',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin KosHaven',
            'role' => 'admin',
        ]);

        $kamar = Kamar::create([
            'nomor_kamar' => 'A06',
            'tipe' => 'single',
            'harga' => $nominal,
            'kapasitas' => 1,
            'jumlah_penghuni' => 1,
            'jenis_kamar_mandi' => 'dalam_kamar',
            'status' => 'terisi',
            'fasilitas' => ['AC', 'Wi-Fi'],
        ]);

        $booking = Booking::create([
            'user_id' => $penghuni->id,
            'kamar_id' => $kamar->id,
            'tanggal_booking' => today()->subDays(7),
            'tanggal_masuk' => today()->subDays(5),
            'status' => 'disetujui',
        ]);

        $tagihan = Tagihan::create([
            'nomor_invoice' => 'INV-202611-0001',
            'booking_id' => $booking->id,
            'periode' => now()->format('Y-m'),
            'jumlah' => $nominal,
            'denda' => 0,
            'tanggal_terbit' => today()->subDays(2),
            'tanggal_jatuh_tempo' => today()->addDays(5),
            'status' => 'belum_dibayar',
            'keterangan' => 'Tagihan bulanan kamar A06',
        ]);

        return compact('penghuni', 'petugas', 'admin', 'kamar', 'booking', 'tagihan');
    }

    public function test_penghuni_tidak_bisa_membayar_tagihan_milik_penghuni_lain(): void
    {
        Storage::fake('public');
        ['tagihan' => $tagihan] = $this->buatSkenarioTagihan();

        $penghuniLain = User::factory()->create(['role' => 'penghuni']);

        $response = $this->actingAs($penghuniLain)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'tunai',
                'jumlah_bayar' => 500000,
                'tanggal_pembayaran' => today()->toDateString(),
            ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('pembayarans', 0);
    }

    public function test_alur_cicilan_pelunasan_dan_akses_bukti_pembayaran(): void
    {
        Storage::fake('public');
        ['penghuni' => $penghuni, 'petugas' => $petugas, 'admin' => $admin, 'tagihan' => $tagihan] = $this->buatSkenarioTagihan(1500000);
        $penghuniLain = User::factory()->create(['role' => 'penghuni']);

        $bukti1 = UploadedFile::fake()->create('bukti-cicilan-1.pdf', 100, 'application/pdf');

        $this->actingAs($penghuni)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'transfer',
                'jumlah_bayar' => 500000,
                'tanggal_pembayaran' => today()->toDateString(),
                'bukti_pembayaran' => $bukti1,
                'catatan' => 'Cicilan pertama',
            ])
            ->assertCreated();

        $pembayaran1 = Pembayaran::firstOrFail();
        Storage::disk('public')->assertExists($pembayaran1->bukti_pembayaran);

        // Bukti pembayaran dapat diakses oleh pemilik, petugas, & admin, tetapi 403 untuk penghuni lain
        $this->actingAs($penghuni)->get(route('pembayaran.bukti', $pembayaran1))->assertOk();
        $this->actingAs($petugas)->get(route('pembayaran.bukti', $pembayaran1))->assertOk();
        $this->actingAs($admin)->get(route('pembayaran.bukti', $pembayaran1))->assertOk();
        $this->actingAs($penghuniLain)->get(route('pembayaran.bukti', $pembayaran1))->assertForbidden();

        // Double submit saat masih menunggu verifikasi ditolak
        $this->actingAs($penghuni)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'tunai',
                'jumlah_bayar' => 500000,
                'tanggal_pembayaran' => today()->toDateString(),
            ])
            ->assertStatus(422);

        // Petugas menyetujui cicilan -> dibayar_sebagian
        $this->actingAs($petugas)
            ->patchJson(route('petugas.pembayaran.verifikasi', $pembayaran1))
            ->assertOk()
            ->assertJsonPath('status', 'Disetujui');

        $tagihan->refresh();
        $this->assertSame('dibayar_sebagian', $tagihan->status);
        $this->assertSame(1000000, $tagihan->sisa_tagihan);

        // Penghuni melunasi sisa -> petugas menyetujui -> lunas
        $this->actingAs($penghuni)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'tunai',
                'jumlah_bayar' => 1000000,
                'tanggal_pembayaran' => today()->toDateString(),
            ])
            ->assertCreated();

        $pembayaran2 = Pembayaran::latest('id')->firstOrFail();

        $this->actingAs($petugas)
            ->patchJson(route('petugas.pembayaran.verifikasi', $pembayaran2))
            ->assertOk()
            ->assertJsonPath('status', 'Disetujui');

        $tagihan->refresh();
        $this->assertSame('lunas', $tagihan->status);
        $this->assertSame(0, $tagihan->sisa_tagihan);
    }

    public function test_penolakan_pembayaran_oleh_petugas_mengembalikan_status_tagihan(): void
    {
        Storage::fake('public');
        ['penghuni' => $penghuni, 'petugas' => $petugas, 'tagihan' => $tagihan] = $this->buatSkenarioTagihan(1500000);

        $this->actingAs($penghuni)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'tunai',
                'jumlah_bayar' => 1500000,
                'tanggal_pembayaran' => today()->toDateString(),
            ])
            ->assertCreated();

        $pembayaran = Pembayaran::firstOrFail();

        $this->actingAs($petugas)
            ->patchJson(route('petugas.pembayaran.tolak', $pembayaran), [
                'catatan' => 'Nominal tidak sesuai dengan bukti mutasi.',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'Ditolak');

        $tagihan->refresh();
        $this->assertSame('belum_dibayar', $tagihan->status);
        $this->assertSame(1500000, $tagihan->sisa_tagihan);
    }

    public function test_kuitansi_terbit_setelah_verifikasi_dan_aksesnya_dibatasi(): void
    {
        Storage::fake('public');
        ['penghuni' => $penghuni, 'petugas' => $petugas, 'tagihan' => $tagihan] = $this->buatSkenarioTagihan(1500000);
        $penghuniLain = User::factory()->create(['role' => 'penghuni']);

        $this->actingAs($penghuni)
            ->postJson(route('penghuni.tagihan.bayar', $tagihan), [
                'metode_pembayaran' => 'tunai',
                'jumlah_bayar' => 500000,
                'tanggal_pembayaran' => today()->toDateString(),
            ])
            ->assertCreated();

        $pembayaran = Pembayaran::firstOrFail();

        // Belum diverifikasi: kuitansi belum ada
        $this->assertNull($pembayaran->nomor_kuitansi);
        $this->actingAs($penghuni)->get(route('kuitansi.show', $pembayaran))->assertNotFound();

        $this->actingAs($petugas)
            ->patchJson(route('petugas.pembayaran.verifikasi', $pembayaran))
            ->assertOk();

        $pembayaran->refresh();
        $this->assertMatchesRegularExpression('/^KWT-\d{6}-\d{5}$/', $pembayaran->nomor_kuitansi);

        $this->actingAs($penghuni)
            ->get(route('kuitansi.show', $pembayaran))
            ->assertOk()
            ->assertSee($pembayaran->nomor_kuitansi)
            ->assertSee('lima ratus ribu rupiah')
            ->assertSee('PEMBAYARAN SEBAGIAN')
            ->assertSee('1.000.000');

        $this->actingAs($petugas)->get(route('kuitansi.show', $pembayaran))->assertOk();
        $this->actingAs($penghuniLain)->get(route('kuitansi.show', $pembayaran))->assertForbidden();

        // Nomor kuitansi bersifat tetap
        $nomorAwal = $pembayaran->nomor_kuitansi;
        $this->assertSame($nomorAwal, $pembayaran->fresh()->terbitkanKuitansi());
    }

    public function test_terbilang_rupiah(): void
    {
        $service = new \App\Services\KuitansiService();

        $this->assertSame('satu juta lima ratus ribu', $service->terbilang(1500000));
        $this->assertSame('seratus dua puluh lima ribu', $service->terbilang(125000));
        $this->assertSame('seribu', $service->terbilang(1000));
        $this->assertSame('dua juta', $service->terbilang(2000000));
        $this->assertSame('sebelas', $service->terbilang(11));
    }

    public function test_profil_saya_menampilkan_sesi_akun_yang_login_bukan_orang_lain(): void
    {
        $penghuniA = User::factory()->create([
            'name' => 'Irfan Maulana',
            'email' => 'irfan@koshaven.test',
            'phone' => '081234560001',
            'role' => 'penghuni',
        ]);

        $penghuniB = User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@koshaven.test',
            'phone' => '081234560002',
            'role' => 'penghuni',
        ]);

        $respA = $this->actingAs($penghuniA)->get(route('penghuni.profil.index'));
        $respA->assertOk()
            ->assertSee('Irfan Maulana')
            ->assertSee('irfan@koshaven.test')
            ->assertDontSee('Andi Pratama')
            ->assertDontSee('siti@koshaven.test');

        $respB = $this->actingAs($penghuniB)->get(route('penghuni.profil.index'));
        $respB->assertOk()
            ->assertSee('Siti Nurhaliza')
            ->assertSee('siti@koshaven.test')
            ->assertDontSee('Irfan Maulana')
            ->assertDontSee('Andi Pratama');

        // Update profil penghuni A tersimpan ke database
        $this->actingAs($penghuniA)
            ->putJson(route('penghuni.profil.update'), [
                'name' => 'Irfan Maulana Putra',
                'email' => 'irfan.putra@koshaven.test',
                'phone' => '081299998888',
                'address' => 'Jl. Trunojoyo No. 12, Bangkalan',
            ])
            ->assertOk()
            ->assertJsonPath('profile.name', 'Irfan Maulana Putra');

        $this->assertDatabaseHas('users', [
            'id' => $penghuniA->id,
            'name' => 'Irfan Maulana Putra',
            'email' => 'irfan.putra@koshaven.test',
        ]);
    }

    public function test_checkout_ditolak_jika_masih_ada_tagihan_belum_lunas_dan_berhasil_setelah_lunas(): void
    {
        ['penghuni' => $penghuni, 'admin' => $admin, 'kamar' => $kamar, 'booking' => $booking, 'tagihan' => $tagihan] = $this->buatSkenarioTagihan(1500000);

        // Ditolak karena masih ada tagihan belum_dibayar
        $this->actingAs($admin)
            ->patch(route('admin.penghuni.checkout', $penghuni->id), [
                'tanggal_keluar' => today()->toDateString(),
                'alasan_keluar' => 'Lulus kuliah',
            ])
            ->assertRedirect(route('admin.penghuni.index'))
            ->assertSessionHas('error');

        $booking->refresh();
        $kamar->refresh();
        $this->assertSame('disetujui', $booking->status);
        $this->assertSame('terisi', $kamar->status);

        // Lunasi tagihan -> check-out berhasil
        $tagihan->update(['status' => 'lunas']);

        $this->actingAs($admin)
            ->patch(route('admin.penghuni.checkout', $penghuni->id), [
                'tanggal_keluar' => today()->toDateString(),
                'alasan_keluar' => 'Lulus kuliah',
            ])
            ->assertRedirect(route('admin.penghuni.index'))
            ->assertSessionHas('success');

        $booking->refresh();
        $kamar->refresh();
        $this->assertSame('selesai', $booking->status);
        $this->assertSame(today()->toDateString(), $booking->tanggal_keluar->toDateString());
        $this->assertSame('Lulus kuliah', $booking->alasan_keluar);
        $this->assertSame('tersedia', $kamar->status);
        $this->assertSame(0, $kamar->jumlah_penghuni);

        // TagihanBulananService tidak menerbitkan tagihan lagi untuk booking berstatus selesai
        $service = new \App\Services\TagihanBulananService();
        $hasil = $service->terbitkanUntukBooking($booking);
        $this->assertSame(0, $hasil['dibuat']);
    }
}
