<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi {{ $k['nomor'] }} - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --gold: #A98B62;
            --gold-dark: #7E6642;
            --ink: #1E2329;
            --muted: #5F6873;
            --line: #D9D3C7;
            --paper: #FFFFFF;
            --bg: #191D22;
            --ok: #2F7D55;
            --warn: #B7791F;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            padding: 24px 16px 48px;
        }

        .toolbar {
            max-width: 780px;
            margin: 0 auto 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 18px;
            border-radius: 9px;
            border: 1px solid rgba(198,164,119,.4);
            background: transparent;
            color: #E0C49B;
            font: 600 13px 'DM Sans', sans-serif;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .btn:hover { background: rgba(198,164,119,.14); transform: translateY(-1px); }

        .btn.primary { background: #C6A477; color: #191D22; border-color: #C6A477; }
        .btn.primary:hover { background: #E0C49B; }

        .receipt {
            max-width: 780px;
            margin: 0 auto;
            background: var(--paper);
            border-radius: 14px;
            padding: 44px 48px 36px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,.35);
        }

        .receipt::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 8px;
            background: linear-gradient(90deg, #E0C49B, var(--gold));
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-24deg);
            font: 700 110px 'Playfair Display', serif;
            letter-spacing: 8px;
            color: rgba(47,125,85,.07);
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }

        .watermark.partial { color: rgba(183,121,31,.08); font-size: 78px; }

        .head {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
            padding-bottom: 22px;
            border-bottom: 2px solid var(--line);
            position: relative;
        }

        .brand { display: flex; gap: 13px; align-items: center; }

        .brand-icon {
            width: 48px; height: 48px;
            border-radius: 13px;
            background: linear-gradient(135deg, #E0C49B, var(--gold));
            color: #191D22;
            display: grid; place-items: center;
            font-size: 24px;
        }

        .brand h1 { font: 700 24px 'Playfair Display', serif; line-height: 1.1; }
        .brand p { margin-top: 4px; font-size: 11px; color: var(--muted); max-width: 300px; line-height: 1.5; }

        .doc-title { text-align: right; }
        .doc-title h2 {
            font: 700 22px 'Playfair Display', serif;
            letter-spacing: 3px;
            color: var(--gold-dark);
        }
        .doc-title .no { margin-top: 6px; font-size: 13px; font-weight: 700; }
        .doc-title .date { margin-top: 2px; font-size: 11.5px; color: var(--muted); }

        .rows { margin: 26px 0 8px; position: relative; }

        .row {
            display: grid;
            grid-template-columns: 190px 14px 1fr;
            gap: 4px;
            padding: 11px 0;
            border-bottom: 1px dashed var(--line);
            font-size: 13.5px;
            line-height: 1.55;
        }

        .row .label { color: var(--muted); font-weight: 500; }
        .row .value { font-weight: 600; }

        .row.terbilang .value {
            font-style: italic;
            font-weight: 600;
            text-transform: capitalize;
            color: var(--gold-dark);
        }

        .summary {
            margin-top: 22px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            align-items: stretch;
            position: relative;
        }

        .amount-box {
            border: 2px solid var(--gold);
            border-radius: 12px;
            padding: 16px 20px;
            background: #FBF8F2;
        }

        .amount-box small { display: block; font-size: 11px; color: var(--muted); letter-spacing: 1.2px; font-weight: 700; }
        .amount-box strong { display: block; margin-top: 6px; font: 700 28px 'Playfair Display', serif; color: var(--ink); }

        .status-chip {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 10px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 11px; font-weight: 800; letter-spacing: .8px;
        }
        .status-chip.ok { background: rgba(47,125,85,.12); color: var(--ok); }
        .status-chip.partial { background: rgba(183,121,31,.14); color: var(--warn); }

        .balance {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 12.5px;
        }

        .balance div { display: flex; justify-content: space-between; gap: 12px; padding: 4px 0; }
        .balance div span { color: var(--muted); }
        .balance div strong { font-weight: 700; }
        .balance .sisa { margin-top: 6px; padding-top: 9px; border-top: 1px solid var(--line); font-size: 13.5px; }

        .sign {
            margin-top: 34px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            position: relative;
        }

        .note { font-size: 10.5px; color: var(--muted); max-width: 360px; line-height: 1.7; }

        .sign-box { text-align: center; min-width: 210px; font-size: 12.5px; }
        .sign-box .stamp {
            margin: 10px auto 8px;
            width: 108px; height: 108px;
            border: 3px double var(--ok);
            color: var(--ok);
            border-radius: 50%;
            display: grid; place-items: center;
            font: 800 13px 'DM Sans', sans-serif;
            letter-spacing: 1.5px;
            transform: rotate(-12deg);
            line-height: 1.3;
        }
        .sign-box .stamp.partial { border-color: var(--warn); color: var(--warn); }
        .sign-box strong { display: block; border-top: 1px solid var(--ink); padding-top: 6px; margin-top: 4px; }
        .sign-box span { color: var(--muted); font-size: 11px; }

        .footer-note {
            margin-top: 26px;
            padding-top: 14px;
            border-top: 2px solid var(--line);
            text-align: center;
            font-size: 10.5px;
            color: var(--muted);
            line-height: 1.7;
            position: relative;
        }

        @media (max-width: 640px) {
            .receipt { padding: 34px 20px 26px; }
            .head { flex-direction: column; }
            .doc-title { text-align: left; }
            .row { grid-template-columns: 1fr; gap: 0; }
            .row .sep { display: none; }
            .summary { grid-template-columns: 1fr; }
            .sign { flex-direction: column; align-items: stretch; }
            .watermark { font-size: 64px; }
        }

        @page { size: A4; margin: 14mm; }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none !important; }
            .receipt { box-shadow: none; border-radius: 0; max-width: none; padding: 20px 8px; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <a href="{{ $kembaliUrl }}" class="btn">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <button type="button" class="btn primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak / Simpan PDF
        </button>
    </div>

    <main class="receipt" id="receipt">

        <div class="watermark {{ $k['lunas'] ? '' : 'partial' }}">{{ $k['lunas'] ? 'LUNAS' : 'CICILAN' }}</div>

        <header class="head">
            <div class="brand">
                <div class="brand-icon"><i class="bi bi-house-heart-fill"></i></div>
                <div>
                    <h1>KosHaven</h1>
                    <p>
                        {{ $k['namaKos'] }}
                        @if($k['alamatKos'])<br>{{ $k['alamatKos'] }}@endif
                        @if($k['whatsappKos'])<br>WhatsApp {{ $k['whatsappKos'] }}@endif
                    </p>
                </div>
            </div>

            <div class="doc-title">
                <h2>KUITANSI</h2>
                <div class="no">No. {{ $k['nomor'] }}</div>
                <div class="date">Tanggal terbit: {{ $k['tanggalTerbit'] }}</div>
            </div>
        </header>

        <section class="rows">
            <div class="row">
                <span class="label">Telah terima dari</span><span class="sep">:</span>
                <span class="value">{{ $k['diterimaDari'] }} (Kamar {{ $k['nomorKamar'] }})</span>
            </div>

            <div class="row terbilang">
                <span class="label">Uang sejumlah</span><span class="sep">:</span>
                <span class="value">{{ $k['terbilang'] }}</span>
            </div>

            <div class="row">
                <span class="label">Untuk pembayaran</span><span class="sep">:</span>
                <span class="value">{{ $k['untukPembayaran'] }}</span>
            </div>

            @if($k['nomorInvoice'])
                <div class="row">
                    <span class="label">Nomor tagihan</span><span class="sep">:</span>
                    <span class="value">{{ $k['nomorInvoice'] }}</span>
                </div>
            @endif

            <div class="row">
                <span class="label">Metode pembayaran</span><span class="sep">:</span>
                <span class="value">{{ $k['metode'] }}</span>
            </div>

            <div class="row">
                <span class="label">Tanggal pembayaran</span><span class="sep">:</span>
                <span class="value">{{ $k['tanggalBayar'] }}</span>
            </div>
        </section>

        <section class="summary">
            <div class="amount-box">
                <small>JUMLAH DITERIMA</small>
                <strong>{{ $k['jumlahFormat'] }}</strong>

                @if($k['lunas'])
                    <span class="status-chip ok"><i class="bi bi-check-circle-fill"></i> LUNAS</span>
                @else
                    <span class="status-chip partial"><i class="bi bi-hourglass-split"></i> PEMBAYARAN SEBAGIAN</span>
                @endif
            </div>

            @if($k['adaTagihan'])
                <div class="balance">
                    <div><span>Total tagihan</span><strong>Rp {{ number_format($k['totalTagihan'], 0, ',', '.') }}</strong></div>
                    <div><span>Total terbayar (s.d. kuitansi ini)</span><strong>Rp {{ number_format($k['terbayar'], 0, ',', '.') }}</strong></div>
                    <div class="sisa"><span>Sisa tagihan</span><strong>Rp {{ number_format($k['sisa'], 0, ',', '.') }}</strong></div>
                </div>
            @else
                <div class="balance">
                    <div><span>Jenis</span><strong>Uang Muka (DP) Booking</strong></div>
                    <div class="sisa"><span>Status</span><strong>Diterima</strong></div>
                </div>
            @endif
        </section>

        <section class="sign">
            <p class="note">
                Kuitansi ini sah sebagai bukti pembayaran yang telah diverifikasi oleh
                pengelola KosHaven. Mohon disimpan dengan baik dan tunjukkan apabila
                diperlukan. Pembayaran yang telah diterima tidak dapat dikembalikan,
                kecuali sesuai kebijakan pengelola.
            </p>

            <div class="sign-box">
                <div>Bangkalan, {{ $k['tanggalTerbit'] }}</div>
                <div class="stamp {{ $k['lunas'] ? '' : 'partial' }}">{{ $k['lunas'] ? 'LUNAS' : 'DITERIMA' }}<br>KOSHAVEN</div>
                <strong>{{ $k['penerima'] }}</strong>
                <span>Penerima / Pengelola KosHaven</span>
            </div>
        </section>

        <footer class="footer-note">
            Dokumen ini diterbitkan secara elektronik oleh sistem KosHaven dan sah tanpa tanda tangan basah.
            @if($k['emailKos']) · {{ $k['emailKos'] }} @endif
        </footer>

    </main>

</body>
</html>
