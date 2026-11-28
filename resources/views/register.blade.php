<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Akun - KosHaven</title>

    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-soft: #363E48;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --silver: #BBC4CD;
            --ivory: #F4F0E8;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --border: rgba(198, 164, 119, .20);
            --danger: #E19A91;
            --danger-bg: rgba(153, 64, 57, .15);
            --success: #A8C9B2;
            --success-bg: rgba(72, 126, 88, .16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-deep);
            color: var(--text);
        }

        body.transition-active {
            overflow: hidden;
        }

        button, input {
            font-family: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* =========================
           MAIN LAYOUT
        ========================= */

        .register-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.04fr) minmax(440px, .96fr);
            background: var(--bg);
        }

        /* =========================
           PANEL VISUAL
        ========================= */

        .register-visual {
            position: relative;
            min-height: 100vh;
            overflow: visible;
            isolation: isolate;
            background: #20262D;
            z-index: 2;
        }

        .register-visual img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: saturate(.78);
        }

        .visual-overlay {
            position: absolute;
            z-index: 1;
            inset: 0;
            background:
                linear-gradient(
                    180deg,
                    rgba(18, 22, 27, .08) 0%,
                    rgba(18, 22, 27, .28) 42%,
                    rgba(18, 22, 27, .94) 100%
                ),
                linear-gradient(
                    90deg,
                    rgba(18, 22, 27, .22),
                    transparent 70%
                );
            pointer-events: none;
        }

        .visual-content {
            position: absolute;
            z-index: 2;
            left: clamp(34px, 8%, 100px);
            right: clamp(55px, 12%, 120px);
            bottom: clamp(48px, 9%, 100px);
            max-width: 590px;
            color: var(--ivory);
            animation: visualReveal .9s ease both;
        }

        .visual-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.3px;
            text-transform: uppercase;
        }

        .visual-line {
            width: 43px;
            height: 2px;
            flex: 0 0 auto;
            background: var(--gold);
            border-radius: 10px;
        }

        .visual-content h1 {
            margin: 22px 0 15px;
            font-family: 'Playfair Display', serif;
            font-size: clamp(35px, 3.8vw, 55px);
            line-height: 1.16;
            font-weight: 600;
            letter-spacing: -.6px;
        }

        .visual-content p {
            max-width: 440px;
            color: rgba(244, 240, 232, .78);
            font-size: 13px;
            line-height: 1.9;
        }

        .visual-caption {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
            color: rgba(244, 240, 232, .72);
            font-size: 10px;
            letter-spacing: .35px;
        }

        .visual-caption i {
            color: var(--gold-light);
            font-size: 14px;
        }

        /* PEMBATAS GELOMBANG */

        .wave-divider {
            position: absolute;
            z-index: 5;
            top: 0;
            right: -1px;
            width: clamp(65px, 7vw, 105px);
            height: 100%;
            pointer-events: none;
            overflow: visible;
        }

        .wave-divider svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .wave-divider path {
            fill: var(--bg);
        }

        /* =========================
           PANEL FORM
        ========================= */

        .register-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 42px clamp(30px, 7.5%, 90px);
            background:
                radial-gradient(
                    circle at 100% 0%,
                    rgba(198, 164, 119, .055),
                    transparent 35%
                ),
                var(--bg);
        }

        .register-form-wrapper {
            width: 100%;
            max-width: 440px;
            min-width: 0;
            animation: formReveal .8s cubic-bezier(.2, .7, .2, 1) both;
        }

        /* =========================
           LOGO
        ========================= */

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 29px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .logo-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 1px solid rgba(198, 164, 119, .42);
            border-radius: 11px;
            background: linear-gradient(145deg, #303740, #20262D);
            color: var(--gold-light);
            font-size: 20px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .18);
        }

        .logo-gold {
            color: var(--gold);
        }

        /* =========================
           HEADING
        ========================= */

        .form-heading {
            margin-bottom: 24px;
        }

        .form-heading > span {
            display: inline-block;
            margin-bottom: 10px;
            color: var(--gold);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.2px;
        }

        .form-heading h2 {
            margin-bottom: 9px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 2.8vw, 35px);
            line-height: 1.22;
            font-weight: 600;
        }

        .form-heading p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        /* =========================
           ALERT
        ========================= */

        .error-message,
        .success-message {
            margin-bottom: 17px;
            padding: 12px 14px;
            border: 1px solid;
            border-radius: 9px;
            font-size: 11px;
            line-height: 1.7;
            overflow-wrap: anywhere;
            animation: alertReveal .4s ease both;
        }

        .error-message {
            color: var(--danger);
            background: var(--danger-bg);
            border-color: rgba(225, 154, 145, .28);
        }

        .error-message strong {
            display: block;
            margin-bottom: 5px;
        }

        .error-message ul {
            padding-left: 18px;
            margin: 0;
        }

        .error-message li + li {
            margin-top: 3px;
        }

        .success-message {
            color: var(--success);
            background: var(--success-bg);
            border-color: rgba(168, 201, 178, .25);
        }

        /* =========================
           INPUT
        ========================= */

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #D9DCE0;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .15px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
            border-radius: 9px;
        }

        /* ANIMASI SHAKE LEMBUT PER INPUT */

        .input-wrapper.shake {
            animation: inputShake .55s ease-in-out both;
        }

        @keyframes inputShake {
            0%, 100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-3px);
            }

            40% {
                transform: translateX(3px);
            }

            60% {
                transform: translateX(-2px);
            }

            80% {
                transform: translateX(2px);
            }
        }

        .input-wrapper > i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #929BA5;
            font-size: 15px;
            pointer-events: none;
            transition: color .2s ease;
        }

        .input-wrapper input {
            display: block;
            width: 100%;
            height: 48px;
            padding: 0 47px;
            border: 1px solid rgba(187, 196, 205, .16);
            border-radius: 9px;
            outline: none;
            background: #20262D;
            color: var(--ivory);
            font-size: 11px;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .input-wrapper input::placeholder {
            color: #77818C;
            opacity: 1;
        }

        .input-wrapper input:hover {
            border-color: rgba(198, 164, 119, .35);
        }

        .input-wrapper input:focus {
            border-color: var(--gold);
            background: #242B33;
            box-shadow: 0 0 0 3px rgba(198, 164, 119, .12);
        }

        .input-wrapper:focus-within > i {
            color: var(--gold-light);
        }

        .input-wrapper input.is-invalid {
            border-color: #C97870;
            background: rgba(153, 64, 57, .08);
        }

        .input-wrapper input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(201, 120, 112, .12);
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: var(--danger);
            font-size: 10px;
            line-height: 1.6;
        }

        .field-hint {
            display: block;
            margin-top: 6px;
            color: #8E98A2;
            font-size: 9px;
            line-height: 1.55;
        }

        /* =========================
           TOGGLE PASSWORD
        ========================= */

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 9px;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: #929BA5;
            cursor: pointer;
            font-size: 15px;
            transition: background .2s ease, color .2s ease;
        }

        .toggle-password:hover {
            background: rgba(198, 164, 119, .10);
            color: var(--gold-light);
        }

        /* =========================
           REGISTER BUTTON
        ========================= */

        .register-button {
            position: relative;
            width: 100%;
            min-height: 49px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 7px;
            padding: 12px 18px;
            border: 1px solid rgba(224, 196, 155, .42);
            border-radius: 9px;
            background: linear-gradient(110deg, #B89464, #D2B486);
            color: #1A1E23;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .18);
            transition:
                width .4s cubic-bezier(.68, -.2, .27, 1.2),
                min-height .35s ease,
                border-radius .35s ease,
                background .35s ease,
                border-color .35s ease,
                box-shadow .35s ease,
                transform .2s ease;
        }

        .register-button:hover:not(:disabled) {
            filter: brightness(1.07);
            transform: translateY(-2px);
            box-shadow: 0 11px 25px rgba(0, 0, 0, .25);
        }

        .register-button:active:not(:disabled) {
            transform: translateY(0);
        }

        .register-button:disabled {
            cursor: wait;
        }

        .button-label,
        .button-arrow {
            transition: opacity .2s ease;
        }

        /* DUA TITIK LOADING */

        .loading-dots {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .loading-dots span {
            width: 9px;
            height: 9px;
            display: block;
            border-radius: 50%;
            background: #BFC1C3;
            animation: loadingDot .7s ease-in-out infinite;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: .18s;
        }

        @keyframes loadingDot {
            0%, 100% {
                transform: scale(.75);
                opacity: .45;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }
        }

        .register-button.is-loading {
            width: 80px;
            min-height: 43px;
            margin-left: auto;
            margin-right: auto;
            padding: 0;
            gap: 0;
            border: 0;
            border-radius: 50px;
            background: #080808;
            color: #fff;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .2);
            transform: scale(1);
        }

        .register-button.is-loading .button-label,
        .register-button.is-loading .button-arrow {
            display: none;
        }

        .register-button.is-loading .loading-dots {
            display: flex;
        }

        /* =========================
           PAGE TRANSITION WAVE
        ========================= */

        .page-transition {
            position: fixed;
            z-index: 99999;
            top: -120vh;
            left: -15%;
            width: 130%;
            height: 125vh;
            background: #080808;
            border-radius: 0 0 48% 52% / 0 0 10% 10%;
            pointer-events: none;
            visibility: hidden;
            transform: translateY(0);
        }

        .page-transition.active {
            visibility: visible;
            animation: waveCover .9s cubic-bezier(.77, 0, .18, 1) forwards;
        }

        @keyframes waveCover {
            0% {
                transform: translateY(0);
                border-radius: 0 0 48% 52% / 0 0 10% 10%;
            }

            45% {
                border-radius: 0 0 42% 58% / 0 0 22% 18%;
            }

            100% {
                transform: translateY(120vh);
                border-radius: 0 0 50% 50% / 0 0 8% 8%;
            }
        }

        /* =========================
           FOOTER
        ========================= */

        .login-link {
            margin-top: 20px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            text-align: center;
        }

        .login-link a {
            color: var(--gold-light);
            font-weight: 700;
        }

        .login-link a:hover {
            color: var(--ivory);
            text-decoration: underline;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            margin: 24px auto 0;
            color: #858F99;
            font-size: 10px;
            line-height: 1.7;
            transition: color .2s ease;
        }

        .back-home:hover {
            color: var(--gold-light);
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 2px solid var(--gold-light);
            outline-offset: 3px;
        }

        /* =========================
           ANIMATIONS
        ========================= */

        @keyframes formReveal {
            from {
                opacity: 0;
                transform: translateX(25px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes visualReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes alertReveal {
            from {
                opacity: 0;
                transform: translateY(-7px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================
           TABLET
        ========================= */

        @media (max-width: 1024px) {
            .register-page {
                grid-template-columns: minmax(0, .9fr) minmax(400px, 1.1fr);
            }

            .register-content {
                padding: 38px 6%;
            }

            .visual-content {
                left: 7%;
                right: 12%;
            }

            .visual-content h1 {
                font-size: clamp(32px, 3.6vw, 43px);
            }

            .wave-divider {
                width: 65px;
            }

            .logo {
                margin-bottom: 25px;
            }
        }

        /* =========================
           TABLET KECIL
        ========================= */

        @media (max-width: 850px) {
            .register-page {
                grid-template-columns: 1fr;
            }

            .register-visual {
                display: none;
            }

            .register-content {
                min-height: 100vh;
                padding: 42px 7%;
                background:
                    radial-gradient(
                        ellipse at 50% 0%,
                        rgba(198, 164, 119, .09),
                        transparent 48%
                    ),
                    var(--bg);
            }

            .register-form-wrapper {
                max-width: 460px;
            }
        }

        /* =========================
           HP
        ========================= */

        @media (max-width: 600px) {
            .register-content {
                padding: 32px 23px;
            }

            .logo {
                font-size: 25px;
                margin-bottom: 25px;
            }

            .logo-icon {
                width: 41px;
                height: 41px;
            }

            .form-heading {
                margin-bottom: 22px;
            }

            .form-heading h2 {
                font-size: 30px;
            }

            .form-heading p {
                font-size: 11px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .input-wrapper input {
                height: 47px;
            }

            .register-button {
                min-height: 48px;
            }

            .register-button.is-loading {
                min-height: 43px;
            }

            .login-link {
                margin-top: 18px;
            }

            .back-home {
                margin-top: 22px;
            }
        }

        @media (max-width: 380px) {
            .register-content {
                padding: 28px 18px;
            }

            .logo {
                font-size: 23px;
                margin-bottom: 22px;
            }

            .logo-icon {
                width: 39px;
                height: 39px;
            }

            .form-heading h2 {
                font-size: 27px;
            }

            .form-heading p {
                font-size: 10px;
            }

            .form-group label {
                font-size: 10px;
            }

            .input-wrapper input {
                font-size: 10px;
            }

            .field-hint {
                font-size: 8px;
            }

            .login-link {
                font-size: 10px;
            }
        }

        /* =========================
           REDUCED MOTION
        ========================= */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body>

<div class="register-page">

    <!-- PANEL VISUAL -->
    <section class="register-visual" aria-label="Informasi KosHaven">

        <img
            src="{{ asset('image/gambar utama navbar.jpeg') }}"
            alt="Hunian nyaman KosHaven"
        >

        <div class="visual-overlay"></div>

        <div class="visual-content">

            <div class="visual-eyebrow">
                <span class="visual-line"></span>
                <span>Bergabung bersama KosHaven</span>
            </div>

            <h1>Mulai Perjalanan<br>Hunian Nyamanmu.</h1>

            <p>
                Buat akun KosHaven dan nikmati kemudahan dalam mengelola
                informasi kamar, tagihan, serta pembayaran kos dalam satu tempat.
            </p>

            <div class="visual-caption">
                <i class="bi bi-shield-check"></i>
                <span>Pengelolaan hunian yang lebih praktis dan terorganisir</span>
            </div>

        </div>

        <!-- PEMBATAS GELOMBANG VERTIKAL -->
        <div class="wave-divider" aria-hidden="true">
            <svg
                viewBox="0 0 100 1000"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="
                    M 42 0
                    C 15 90, 78 160, 53 250
                    C 28 340, 15 405, 48 500
                    C 82 590, 82 660, 47 750
                    C 12 840, 20 920, 55 1000
                    L 100 1000
                    L 100 0
                    Z
                "/>
            </svg>
        </div>

    </section>


    <!-- PANEL FORM REGISTER -->
    <main class="register-content">

        <div class="register-form-wrapper">

            <a
                href="{{ url('/') }}"
                class="logo"
                aria-label="KosHaven - halaman utama"
            >
                <span class="logo-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </span>

                <span>
                    Kos<span class="logo-gold">Haven</span>
                </span>
            </a>

            <div class="form-heading">
                <span>BUAT AKUN BARU</span>
                <h2>Bergabung dengan Kami!</h2>
                <p>
                    Lengkapi informasi berikut untuk membuat akun
                    dan mulai menggunakan layanan KosHaven.
                </p>
            </div>


            <!-- ERROR MESSAGE -->
            @if ($errors->any())
                <div class="error-message" role="alert" aria-live="polite">

                    <strong>
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Pendaftaran belum berhasil.
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            <!-- SUCCESS MESSAGE -->
            @if (session('success'))
                <div class="success-message" role="status" aria-live="polite">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif


            <!-- FORM -->
            <form
                id="registerForm"
                method="POST"
                action="{{ route('register.store') }}"
            >
                @csrf


                <!-- NAMA LENGKAP -->
                <div class="form-group">

                    <label for="name">Nama Lengkap</label>

                    <div class="input-wrapper {{ $errors->has('name') ? 'shake' : '' }}">

                        <i class="bi bi-person"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            maxlength="100"
                            class="@error('name') is-invalid @enderror"
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            aria-describedby="@error('name') name-error @enderror"
                            required
                        >

                    </div>

                    @error('name')
                        <span class="field-error" id="name-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">Alamat Email</label>

                    <div class="input-wrapper {{ $errors->has('email') ? 'shake' : '' }}">

                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="nama@gmail.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            maxlength="255"
                            pattern="[A-Za-z0-9._%+-]+@gmail\.com"
                            title="Gunakan alamat email yang berakhiran @gmail.com."
                            class="@error('email') is-invalid @enderror"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            aria-describedby="email-hint @error('email') email-error @enderror"
                            required
                        >

                    </div>

                    <small class="field-hint" id="email-hint">
                        Gunakan alamat Gmail yang berakhiran @gmail.com.
                    </small>

                    @error('email')
                        <span class="field-error" id="email-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- NOMOR HP -->
                <div class="form-group">

                    <label for="phone">Nomor HP</label>

                    <div class="input-wrapper {{ $errors->has('phone') ? 'shake' : '' }}">

                        <i class="bi bi-telephone"></i>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Contoh: 081234567890"
                            value="{{ old('phone') }}"
                            autocomplete="tel-national"
                            inputmode="numeric"
                            minlength="10"
                            maxlength="13"
                            pattern="08[0-9]{8,11}"
                            title="Nomor HP harus diawali 08 dan terdiri dari 10 sampai 13 digit angka."
                            class="@error('phone') is-invalid @enderror"
                            aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                            aria-describedby="phone-hint @error('phone') phone-error @enderror"
                            required
                        >

                    </div>

                    <small class="field-hint" id="phone-hint">
                        Masukkan 10–13 digit angka dan awali dengan 08.
                    </small>

                    @error('phone')
                        <span class="field-error" id="phone-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">Kata Sandi</label>

                    <div class="input-wrapper {{ $errors->has('password') ? 'shake' : '' }}">

                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            minlength="8"
                            autocomplete="new-password"
                            class="@error('password') is-invalid @enderror"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            aria-describedby="password-hint @error('password') password-error @enderror"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password"
                            aria-label="Tampilkan kata sandi"
                            aria-pressed="false"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                    <small class="field-hint" id="password-hint">
                        Minimal 8 karakter dan harus mengandung huruf serta angka.
                    </small>

                    @error('password')
                        <span class="field-error" id="password-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- KONFIRMASI PASSWORD -->
                <div class="form-group">

                    <label for="password_confirmation">
                        Konfirmasi Kata Sandi
                    </label>

                    <div class="input-wrapper {{ $errors->has('password') ? 'shake' : '' }}">

                        <i class="bi bi-lock-fill"></i>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Masukkan ulang kata sandi"
                            minlength="8"
                            autocomplete="new-password"
                            class="@error('password') is-invalid @enderror"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            aria-describedby="@error('password') confirmation-error @enderror"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password_confirmation"
                            aria-label="Tampilkan konfirmasi kata sandi"
                            aria-pressed="false"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                    @error('password')
                        <span class="field-error" id="confirmation-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- BUTTON REGISTER -->
                <button
                    type="submit"
                    class="register-button"
                    id="registerButton"
                    aria-busy="false"
                >

                    <span class="button-label">
                        Daftar Sekarang
                    </span>

                    <span class="loading-dots" aria-hidden="true">
                        <span></span>
                        <span></span>
                    </span>

                    <i class="bi bi-arrow-right button-arrow"></i>

                </button>

            </form>


            <!-- LOGIN LINK -->
            <p class="login-link">
                Sudah memiliki akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>


            <!-- BACK HOME -->
            <a href="{{ url('/') }}" class="back-home">
                <i class="bi bi-arrow-left"></i>
                Kembali ke halaman utama
            </a>

        </div>

    </main>

</div>


<!-- OVERLAY TRANSISI GELOMBANG -->
<div
    class="page-transition"
    id="pageTransition"
    aria-hidden="true"
></div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const registerForm = document.getElementById('registerForm');
    const registerButton = document.getElementById('registerButton');

    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    const passwordInput = document.getElementById('password');
    const confirmationInput = document.getElementById('password_confirmation');

    const pageTransition = document.getElementById('pageTransition');

    let isSubmitting = false;


    /* =========================
       SHAKE PER CARD INPUT
    ========================= */

    function triggerFieldShake(input) {

        if (!input) return;

        const inputWrapper = input.closest('.input-wrapper');

        if (!inputWrapper) return;

        inputWrapper.classList.remove('shake');

        // Paksa browser membaca ulang posisi elemen.
        void inputWrapper.offsetWidth;

        // Jalankan animasi pada card yang bermasalah.
        inputWrapper.classList.add('shake');

    }


    // Bersihkan class setelah animasi selesai.
    document.querySelectorAll('.input-wrapper').forEach(function (wrapper) {

        wrapper.addEventListener('animationend', function (event) {

            if (event.animationName === 'inputShake') {
                wrapper.classList.remove('shake');
            }

        });

    });


    /* =========================
       TOGGLE PASSWORD
    ========================= */

    document.querySelectorAll('.toggle-password').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) return;

            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            this.innerHTML = isPassword
                ? '<i class="bi bi-eye-slash"></i>'
                : '<i class="bi bi-eye"></i>';

            this.setAttribute(
                'aria-label',
                isPassword
                    ? 'Sembunyikan kata sandi'
                    : 'Tampilkan kata sandi'
            );

            this.setAttribute(
                'aria-pressed',
                isPassword ? 'true' : 'false'
            );

        });

    });


    /* =========================
       VALIDASI EMAIL GMAIL
    ========================= */

    if (emailInput) {

        emailInput.addEventListener('input', function () {
            this.setCustomValidity('');
        });

        emailInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {
                this.setCustomValidity('Alamat email wajib diisi.');
            } else if (this.validity.typeMismatch) {
                this.setCustomValidity('Masukkan alamat email dengan format yang benar.');
            } else if (this.validity.patternMismatch) {
                this.setCustomValidity('Email harus menggunakan alamat Gmail dengan akhiran @gmail.com.');
            } else {
                this.setCustomValidity('');
            }

        });

    }


    /* =========================
       VALIDASI NOMOR HP
    ========================= */

    if (phoneInput) {

        phoneInput.addEventListener('input', function () {

            this.value = this.value
                .replace(/[^0-9]/g, '')
                .slice(0, 13);

            this.setCustomValidity('');

        });

        phoneInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {
                this.setCustomValidity('Nomor HP wajib diisi.');
            } else if (this.validity.tooShort || this.validity.tooLong) {
                this.setCustomValidity('Nomor HP harus terdiri dari 10 sampai 13 digit angka.');
            } else if (this.validity.patternMismatch) {
                this.setCustomValidity('Nomor HP harus diawali dengan 08.');
            } else {
                this.setCustomValidity('');
            }

        });

    }


    /* =========================
       VALIDASI PASSWORD
    ========================= */

    function validatePassword() {

        if (!passwordInput || !confirmationInput) {
            return true;
        }

        const password = passwordInput.value;
        const confirmation = confirmationInput.value;

        passwordInput.setCustomValidity('');
        confirmationInput.setCustomValidity('');

        if (password.length < 8) {

            passwordInput.setCustomValidity(
                'Kata sandi harus memiliki minimal 8 karakter.'
            );

            return false;

        }

        if (!/[A-Za-z]/.test(password) || !/[0-9]/.test(password)) {

            passwordInput.setCustomValidity(
                'Kata sandi harus mengandung minimal satu huruf dan satu angka.'
            );

            return false;

        }

        if (password !== confirmation) {

            confirmationInput.setCustomValidity(
                'Konfirmasi kata sandi tidak sama dengan kata sandi.'
            );

            return false;

        }

        return true;

    }


    // Bersihkan pesan validasi password saat pengguna mengetik ulang.
    [passwordInput, confirmationInput].forEach(function (input) {

        if (!input) return;

        input.addEventListener('input', function () {

            passwordInput.setCustomValidity('');
            confirmationInput.setCustomValidity('');

        });

    });


    /* =========================
       SHAKE SAAT VALIDASI BROWSER GAGAL
    ========================= */

    if (registerForm) {

        registerForm.addEventListener('invalid', function (event) {

            triggerFieldShake(event.target);

        }, true);

    }


    /* =========================
       REGISTER + LOADING + WAVE
    ========================= */

    if (registerForm && registerButton) {

        registerForm.addEventListener('submit', function (event) {

            if (isSubmitting) {
                event.preventDefault();
                return;
            }

            // Periksa kekuatan dan kecocokan password.
            if (!validatePassword()) {

                event.preventDefault();

                if (passwordInput.validity.customError) {
                    triggerFieldShake(passwordInput);
                    passwordInput.reportValidity();
                } else {
                    triggerFieldShake(confirmationInput);
                    confirmationInput.reportValidity();
                }

                return;

            }

            // Semua validasi sudah lolos.
            event.preventDefault();

            isSubmitting = true;

            registerButton.disabled = true;

            registerButton.classList.add('is-loading');

            registerButton.setAttribute('aria-busy', 'true');

            document.body.classList.add('transition-active');


            // Mulai transisi wave setelah loading terlihat.
            setTimeout(function () {

                if (pageTransition) {
                    pageTransition.classList.add('active');
                }

            }, 450);


            // Kirim form menggunakan submit native.
            setTimeout(function () {

                HTMLFormElement.prototype.submit.call(registerForm);

            }, 1050);

        });

    }

});
</script>

</body>
</html>
