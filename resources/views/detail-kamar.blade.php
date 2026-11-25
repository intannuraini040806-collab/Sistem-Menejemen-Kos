<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Kamar - KosHaven</title>

    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --teal: #173d3a;
            --gold: #c5a46d;
            --ivory: #f8f7f2;
            --text: #333b38;
            --muted: #777f7b;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--ivory);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* ==============================
           NAVBAR
        ============================== */

        .detail-navbar {
            background: #fff;
            border-bottom: 1px solid #eae9e3;
            padding: 18px 7%;
        }

        .detail-nav {
            max-width: 1250px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .detail-logo {
            color: var(--teal);
            font-size: 25px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .detail-logo span {
            color: var(--gold);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--teal);
            font-weight: 600;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #a38655;
        }

        /* ==============================
           CONTAINER UTAMA
        ============================== */

        .detail-container {
            max-width: 1120px;
            width: 90%;
            margin: 45px auto 70px;
            min-width: 0;
        }

        /* ==============================
           BREADCRUMB
        ============================== */

        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .breadcrumb a {
            color: var(--teal);
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* ==============================
           JUDUL DETAIL
        ============================== */

        .detail-heading {
            margin-bottom: 25px;
        }

        .detail-label {
            color: #a38655;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .detail-heading h1 {
            font-family: 'Playfair Display', serif;
            color: var(--teal);
            font-size: clamp(28px, 3.5vw, 38px);
            line-height: 1.25;
            margin: 10px 0;
            overflow-wrap: anywhere;
        }

        .detail-heading p {
            color: var(--muted);
            margin: 0;
            font-size: 14px;
            line-height: 1.7;
        }

        /* ==============================
           LAYOUT DETAIL
        ============================== */

        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(280px, 1fr);
            gap: 30px;
            align-items: start;
        }

        .detail-main {
            min-width: 0;
        }

        /* ==============================
           FOTO KAMAR
        ============================== */

        .detail-photo {
            width: 100%;
            height: 390px;
            object-fit: cover;
            object-position: center;
            border-radius: 8px;
            display: block;
            background: #e9e7df;
        }

        /* ==============================
           KARTU INFORMASI
        ============================== */

        .detail-card {
            background: #fff;
            border: 1px solid #eeece5;
            border-radius: 8px;
            padding: 25px;
            margin-top: 22px;
            min-width: 0;
        }

        .detail-card h2 {
            font-family: 'Playfair Display', serif;
            color: var(--teal);
            font-size: 22px;
            line-height: 1.3;
            margin: 0 0 15px;
        }

        .description {
            color: #68716d;
            line-height: 1.8;
            font-size: 14px;
            margin: 0;
            overflow-wrap: anywhere;
        }

        /* ==============================
           FASILITAS
        ============================== */

        .facility-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #59635e;
            font-size: 14px;
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .facility-item i {
            color: var(--gold);
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ==============================
           KARTU PENYEWAAN
        ============================== */

        .booking-card {
            background: #fff;
            border: 1px solid #eeece5;
            border-radius: 8px;
            padding: 26px;
            min-width: 0;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .status i {
            font-size: 8px;
        }

        .status.available {
            color: #39734f;
            background: #eaf4ec;
        }

        .status.unavailable {
            color: #a34b45;
            background: #f8eae8;
        }

        .booking-card h2 {
            color: var(--teal);
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            line-height: 1.35;
            margin: 0 0 10px;
        }

        .booking-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }

        /* ==============================
           INFORMASI HARGA
        ============================== */

        .login-price {
            border-top: 1px solid #eeece5;
            border-bottom: 1px solid #eeece5;
            padding: 18px 0;
            margin: 20px 0;
        }

        .login-price span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 7px;
        }

        .login-price strong {
            color: var(--teal);
            font-size: 16px;
            line-height: 1.5;
            display: block;
        }

        /* ==============================
           TOMBOL LOGIN
        ============================== */

        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 48px;
            background: var(--teal);
            color: #fff;
            text-align: center;
            padding: 13px 15px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
            transition: background 0.2s, transform 0.2s;
        }

        .login-button:hover {
            background: #24534e;
        }

        .login-button:active {
            transform: scale(0.99);
        }

        .booking-note {
            font-size: 12px !important;
            text-align: center;
            margin-top: 14px !important;
        }

        /* ==============================
           HALAMAN KAMAR TIDAK DITEMUKAN
        ============================== */

        .not-found-card {
            max-width: 600px;
            margin: 50px auto;
            padding: 35px;
            text-align: center;
        }

        .not-found-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #f4f0e6;
            color: var(--gold);
            font-size: 27px;
        }

        .not-found-card h2 {
            margin-bottom: 12px;
        }

        .not-found-card .login-button {
            max-width: 250px;
            margin: 23px auto 0;
        }

        /* ==============================
           FOOTER
        ============================== */

        .detail-footer {
            background: var(--teal);
            color: #e8e8df;
            padding: 23px 7%;
            text-align: center;
            font-size: 13px;
            line-height: 1.7;
        }

        /* ==============================
           FOKUS AKSESIBILITAS
        ============================== */

        a:focus-visible {
            outline: 3px solid rgba(197, 164, 109, 0.6);
            outline-offset: 4px;
        }

        /* ==============================
           LAPTOP KECIL
        ============================== */

        @media (max-width: 1000px) {
            .detail-container {
                width: 92%;
            }

            .detail-layout {
                grid-template-columns: minmax(0, 1.4fr) minmax(260px, 1fr);
                gap: 22px;
            }

            .booking-card {
                padding: 22px;
            }

            .detail-photo {
                height: 340px;
            }
        }

        /* ==============================
           TABLET
        ============================== */

        @media (max-width: 768px) {
            .detail-navbar {
                padding: 17px 5%;
            }

            .detail-layout {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .detail-container {
                width: 90%;
                margin-top: 30px;
                margin-bottom: 50px;
            }

            .detail-heading h1 {
                font-size: 30px;
            }

            .detail-photo {
                height: clamp(250px, 48vw, 360px);
            }

            .booking-card {
                padding: 25px;
            }

            .booking-card h2 {
                font-size: 23px;
            }

            .detail-card {
                padding: 23px;
            }
        }

        /* ==============================
           HP
        ============================== */

        @media (max-width: 520px) {
            .detail-navbar {
                padding: 15px 5%;
            }

            .detail-nav {
                gap: 12px;
            }

            .detail-logo {
                font-size: 21px;
            }

            .back-link {
                font-size: 11px;
                gap: 5px;
                text-align: right;
            }

            .detail-container {
                width: 90%;
                margin-top: 25px;
                margin-bottom: 40px;
            }

            .breadcrumb {
                font-size: 11px;
                gap: 6px;
                margin-bottom: 20px;
            }

            .detail-heading {
                margin-bottom: 20px;
            }

            .detail-label {
                font-size: 10px;
            }

            .detail-heading h1 {
                font-size: 27px;
                margin: 8px 0;
            }

            .detail-heading p {
                font-size: 12px;
            }

            .detail-photo {
                height: 250px;
                border-radius: 7px;
            }

            .detail-card {
                padding: 20px;
                margin-top: 16px;
            }

            .detail-card h2 {
                font-size: 20px;
            }

            .description {
                font-size: 13px;
            }

            .facility-list {
                grid-template-columns: 1fr 1fr;
                gap: 15px 10px;
            }

            .facility-item {
                font-size: 12px;
                gap: 8px;
            }

            .facility-item i {
                font-size: 17px;
            }

            .booking-card {
                padding: 21px;
                border-radius: 7px;
            }

            .booking-card h2 {
                font-size: 21px;
            }

            .booking-card p {
                font-size: 13px;
            }

            .login-price strong {
                font-size: 15px;
            }

            .login-button {
                font-size: 12px;
                padding: 12px;
            }

            .detail-footer {
                padding: 20px 5%;
                font-size: 11px;
            }
        }

        /* ==============================
           HP KECIL
        ============================== */

        @media (max-width: 360px) {
            .detail-nav {
                align-items: flex-start;
            }

            .detail-logo {
                font-size: 19px;
            }

            .back-link {
                max-width: 145px;
                line-height: 1.5;
            }

            .detail-heading h1 {
                font-size: 24px;
            }

            .detail-photo {
                height: 215px;
            }

            .detail-card {
                padding: 17px;
            }

            .facility-list {
                grid-template-columns: 1fr;
            }

            .booking-card {
                padding: 18px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body>

@php
    $rooms = [
        1 => [
            'name' => 'Kamar Minimalis Nyaman',
            'type' => 'KAMAR SINGLE',
            'status' => 'Tersedia',
            'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85',
            'description' => 'Kamar dengan konsep minimalis yang dirancang untuk memberikan suasana istirahat yang nyaman dan tenang. Cocok untuk kamu yang membutuhkan tempat tinggal praktis dengan fasilitas sehari-hari.',
            'facilities' => ['WiFi', 'AC', 'Kamar Mandi']
        ],
        2 => [
            'name' => 'Kamar Modern Deluxe',
            'type' => 'KAMAR DELUXE',
            'status' => 'Tersedia',
            'image' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=85',
            'description' => 'Kamar dengan desain modern dan suasana yang lebih luas. Dilengkapi fasilitas untuk mendukung kenyamanan aktivitas dan waktu istirahat sehari-hari.',
            'facilities' => ['WiFi', 'AC', 'TV']
        ],
        3 => [
            'name' => 'Kamar Premium Eksklusif',
            'type' => 'KAMAR PREMIUM',
            'status' => 'Tersedia',
            'image' => 'https://images.unsplash.com/photo-1615874959474-d609969a20ed?auto=format&fit=crop&w=1200&q=85',
            'description' => 'Pilihan kamar dengan suasana yang lebih eksklusif dan fasilitas tambahan. Dirancang untuk memberikan pengalaman tinggal yang nyaman.',
            'facilities' => ['WiFi', 'AC', 'Pantry']
        ],
        4 => [
            'name' => 'Kamar Elegan dan Luas',
            'type' => 'KAMAR DELUXE',
            'status' => 'Penuh',
            'image' => 'https://images.unsplash.com/photo-1616486029423-aaa4789e8c9a?auto=format&fit=crop&w=1200&q=85',
            'description' => 'Kamar dengan desain elegan dan ruang yang lebih luas. Pilihan ini memiliki fasilitas yang mendukung kebutuhan penghuni sehari-hari.',
            'facilities' => ['WiFi', 'AC', 'Lemari']
        ],
    ];

    $room = $rooms[$id] ?? null;
@endphp


<!-- ==============================
     NAVBAR
============================== -->

<header class="detail-navbar">

    <div class="detail-nav">

        <a href="{{ url('/') }}" class="detail-logo">
            Kos<span>Haven</span>
        </a>

        <a href="{{ url('/#kamar') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Kembali ke pilihan kamar
        </a>

    </div>

</header>


@if ($room)

    <!-- ==============================
         DETAIL KAMAR
    ============================== -->

    <main class="detail-container">

        <!-- BREADCRUMB -->

        <div class="breadcrumb">

            <a href="{{ url('/') }}">Beranda</a>

            <span>/</span>

            <a href="{{ url('/#kamar') }}">Pilihan Kamar</a>

            <span>/</span>

            <span>Detail Kamar</span>

        </div>


        <!-- JUDUL KAMAR -->

        <div class="detail-heading">

            <span class="detail-label">
                {{ $room['type'] }}
            </span>

            <h1>{{ $room['name'] }}</h1>

            <p>
                <i class="bi bi-geo-alt"></i>
                Informasi lokasi dapat dilihat setelah login
            </p>

        </div>


        <!-- LAYOUT DETAIL -->

        <div class="detail-layout">


            <!-- BAGIAN KIRI -->

            <div class="detail-main">

                <!-- FOTO KAMAR -->

                <img
                    src="{{ $room['image'] }}"
                    alt="{{ $room['name'] }}"
                    class="detail-photo"
                    loading="eager"
                >


                <!-- DESKRIPSI KAMAR -->

                <section class="detail-card">

                    <h2>Tentang Kamar</h2>

                    <p class="description">
                        {{ $room['description'] }}
                    </p>

                </section>


                <!-- FASILITAS KAMAR -->

                <section class="detail-card">

                    <h2>Fasilitas Kamar</h2>

                    <div class="facility-list">

                        @foreach ($room['facilities'] as $facility)

                            <div class="facility-item">

                                @if ($facility === 'WiFi')

                                    <i class="bi bi-wifi"></i>

                                @elseif ($facility === 'AC')

                                    <i class="bi bi-snow"></i>

                                @elseif ($facility === 'TV')

                                    <i class="bi bi-tv"></i>

                                @elseif ($facility === 'Pantry')

                                    <i class="bi bi-cup-hot"></i>

                                @elseif ($facility === 'Lemari')

                                    <i class="bi bi-door-closed"></i>

                                @else

                                    <i class="bi bi-droplet"></i>

                                @endif

                                <span>{{ $facility }}</span>

                            </div>

                        @endforeach

                    </div>

                </section>

            </div>


            <!-- BAGIAN KANAN: INFORMASI PENYEWAAN -->

            <aside class="booking-card">

                <!-- STATUS KAMAR -->

                <span class="status {{ $room['status'] === 'Tersedia' ? 'available' : 'unavailable' }}">

                    <i class="bi bi-circle-fill"></i>

                    {{ $room['status'] }}

                </span>


                <h2>Informasi Penyewaan</h2>

                <p>
                    Tertarik dengan kamar ini? Masuk ke akun KosHaven
                    untuk melihat informasi harga dan melanjutkan proses
                    pemesanan.
                </p>


                <!-- INFORMASI HARGA -->

                <div class="login-price">

                    <span>Harga sewa kamar</span>

                    <strong>Login untuk melihat harga</strong>

                </div>


                <!-- TOMBOL LOGIN -->

                @if ($room['status'] === 'Tersedia')

                    <a href="{{ route('login') }}" class="login-button">

                        Login untuk melihat harga

                        <i class="bi bi-arrow-right"></i>

                    </a>

                @else

                    <a href="{{ route('login') }}" class="login-button">

                        Login untuk informasi kamar

                        <i class="bi bi-arrow-right"></i>

                    </a>

                @endif


                <p class="booking-note">
                    Informasi harga dan pemesanan tersedia setelah login.
                </p>

            </aside>

        </div>

    </main>

@else

    <!-- ==============================
         KAMAR TIDAK DITEMUKAN
    ============================== -->

    <main class="detail-container">

        <section class="detail-card not-found-card">

            <div class="not-found-icon">
                <i class="bi bi-house-x"></i>
            </div>

            <h2>Kamar tidak ditemukan</h2>

            <p class="description">
                Maaf, informasi kamar yang kamu cari belum tersedia.
                Silakan kembali ke halaman pilihan kamar untuk melihat
                kamar lainnya.
            </p>

            <a href="{{ url('/#kamar') }}" class="login-button">

                Kembali ke pilihan kamar

                <i class="bi bi-arrow-right"></i>

            </a>

        </section>

    </main>

@endif


<!-- ==============================
     FOOTER
============================== -->

<footer class="detail-footer">

    © {{ date('Y') }} KosHaven. All Rights Reserved.

</footer>

</body>
</html>
