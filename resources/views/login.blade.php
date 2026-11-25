<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk - KosHaven</title>

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

        button, input { font-family: inherit; }
        a {
            color: inherit;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.04fr) minmax(420px, .96fr);
            background: var(--bg);
        }

        /* PANEL VISUAL */
        .login-visual {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            isolation: isolate;
            background: #20262D;
        }

        .login-visual::after {
            content: "";
            position: absolute;
            z-index: 1;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(18, 22, 27, .08) 0%, rgba(18, 22, 27, .28) 42%, rgba(18, 22, 27, .94) 100%),
                linear-gradient(90deg, rgba(18, 22, 27, .22), transparent 70%);
            pointer-events: none;
        }

        .login-visual img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: saturate(.78);
        }

        .visual-content {
            position: absolute;
            z-index: 2;
            left: clamp(34px, 8%, 100px);
            right: clamp(30px, 8%, 90px);
            bottom: clamp(48px, 9%, 100px);
            max-width: 590px;
            color: var(--ivory);
        }

        .visual-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.4px;
            text-transform: uppercase;
        }

        .visual-line {
            width: 43px;
            height: 2px;
            background: var(--gold);
            border-radius: 10px;
        }

        .visual-content h1 {
            margin: 22px 0 15px;
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 4vw, 58px);
            line-height: 1.15;
            font-weight: 600;
            letter-spacing: -.7px;
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
            margin-top: 29px;
            color: rgba(244, 240, 232, .72);
            font-size: 10px;
            letter-spacing: .5px;
        }

        .visual-caption i { color: var(--gold-light); font-size: 14px; }

        /* PANEL FORM */
        .login-content {
            min-width: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 54px clamp(30px, 7.5%, 90px);
            background:
                radial-gradient(circle at 100% 0%, rgba(198, 164, 119, .055), transparent 35%),
                var(--bg);
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 430px;
            min-width: 0;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 48px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
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

        .logo-gold { color: var(--gold); }

        .form-heading { margin-bottom: 30px; }

        .form-heading > span {
            display: inline-block;
            margin-bottom: 12px;
            color: var(--gold);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.3px;
        }

        .form-heading h2 {
            margin-bottom: 11px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(31px, 3vw, 39px);
            line-height: 1.2;
            font-weight: 600;
        }

        .form-heading p {
            max-width: 370px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.85;
        }

        /* ALERT */
        .alert-message {
            margin-bottom: 20px;
            padding: 13px 15px;
            border: 1px solid;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .error-message {
            color: var(--danger);
            background: var(--danger-bg);
            border-color: rgba(225, 154, 145, .28);
        }

        .success-message {
            color: var(--success);
            background: var(--success-bg);
            border-color: rgba(168, 201, 178, .25);
        }

        .alert-message ul { margin: 7px 0 0; padding-left: 19px; }
        .alert-message li + li { margin-top: 3px; }

        /* INPUT */
        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            color: #D9DCE0;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .input-wrapper { position: relative; width: 100%; }

        .input-wrapper > i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #929BA5;
            font-size: 15px;
            pointer-events: none;
            transition: color .2s ease;
        }

        .input-wrapper input {
            display: block;
            width: 100%;
            height: 51px;
            padding: 0 48px;
            border: 1px solid rgba(187, 196, 205, .16);
            border-radius: 9px;
            outline: none;
            background: #20262D;
            color: var(--ivory);
            font-size: 12px;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .input-wrapper input::placeholder { color: #77818C; opacity: 1; }

        .input-wrapper input:hover { border-color: rgba(198, 164, 119, .35); }

        .input-wrapper input:focus {
            border-color: var(--gold);
            background: #242B33;
            box-shadow: 0 0 0 3px rgba(198, 164, 119, .12);
        }

        .input-wrapper:focus-within > i { color: var(--gold-light); }

        .input-wrapper input.is-invalid {
            border-color: #C97870;
            background: rgba(153, 64, 57, .08);
        }

        .input-wrapper input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(201, 120, 112, .12);
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 10px;
            line-height: 1.6;
        }

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

        /* FORM OPTIONS */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin: 4px 0 25px;
            font-size: 10px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            width: 15px;
            height: 15px;
            margin: 0;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--gold-light);
            font-weight: 700;
            transition: color .2s ease;
        }

        .forgot-link:hover { color: var(--ivory); }

        /* BUTTON */
        .login-button {
            width: 100%;
            min-height: 51px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            padding: 13px 18px;
            border: 1px solid rgba(224, 196, 155, .42);
            border-radius: 9px;
            background: linear-gradient(110deg, #B89464, #D2B486);
            color: #1A1E23;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .25px;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .18);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .login-button:hover {
            filter: brightness(1.07);
            transform: translateY(-1px);
            box-shadow: 0 11px 25px rgba(0, 0, 0, .25);
        }

        .login-button:active { transform: translateY(0); }
        .login-button i { font-size: 15px; }
        .login-button:disabled { opacity: .65; cursor: not-allowed; transform: none; }

        .register-text {
            margin-top: 25px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            text-align: center;
        }

        .register-text a {
            color: var(--gold-light);
            font-weight: 700;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin: 31px auto 0;
            width: 100%;
            color: #858F99;
            font-size: 10px;
            line-height: 1.7;
            transition: color .2s ease;
        }

        .back-home:hover { color: var(--gold-light); }
        .register-text a:hover { color: var(--ivory); text-decoration: underline; }

        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid var(--gold-light);
            outline-offset: 3px;
        }

        /* TABLET */
        @media (max-width: 1024px) {
            .login-page { grid-template-columns: minmax(0, .9fr) minmax(390px, 1.1fr); }
            .login-content { padding: 45px 6%; }
            .visual-content { left: 7%; right: 7%; }
            .visual-content h1 { font-size: clamp(34px, 4vw, 46px); }
        }

        /* TABLET KECIL / MOBILE */
        @media (max-width: 850px) {
            .login-page { grid-template-columns: 1fr; }
            .login-visual { display: none; }
            .login-content {
                min-height: 100vh;
                padding: 55px 7%;
                background:
                    radial-gradient(ellipse at 50% 0%, rgba(198, 164, 119, .09), transparent 48%),
                    var(--bg);
            }
            .login-form-wrapper { max-width: 440px; }
            .logo { margin-bottom: 42px; }
        }

        @media (max-width: 600px) {
            .login-content { padding: 38px 24px; }
            .logo { margin-bottom: 34px; font-size: 25px; }
            .logo-icon { width: 41px; height: 41px; }
            .form-heading { margin-bottom: 26px; }
            .form-heading h2 { font-size: 32px; }
            .form-group { margin-bottom: 18px; }
            .input-wrapper input { height: 50px; }
            .form-options { margin-bottom: 22px; }
            .login-button { min-height: 50px; }
            .back-home { margin-top: 27px; }
        }

        @media (max-width: 380px) {
            .login-content { padding: 31px 19px; }
            .logo { margin-bottom: 29px; font-size: 23px; }
            .logo-icon { width: 39px; height: 39px; }
            .form-heading h2 { font-size: 29px; }
            .form-heading p { font-size: 11px; }
            .form-options { gap: 9px; font-size: 9px; }
            .register-text { font-size: 10px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body>
<div class="login-page">

    <!-- PANEL VISUAL -->
    <section class="login-visual" aria-label="Informasi KosHaven">
        <img
            src="{{ asset('image/gambar utama navbar.jpeg') }}"
            alt="Hunian nyaman KosHaven"
        >

        <div class="visual-content">
            <div class="visual-eyebrow">
                <span class="visual-line"></span>
                <span>Selamat datang di KosHaven</span>
            </div>

            <h1>Hunian Nyaman,<br>Hidup Lebih Tenang.</h1>

            <p>
                Masuk ke akunmu dan nikmati kemudahan dalam mengelola
                informasi kamar, tagihan, serta pembayaran kos dalam satu tempat.
            </p>

            <div class="visual-caption">
                <i class="bi bi-shield-check"></i>
                <span>Pengelolaan hunian yang lebih praktis dan terorganisir</span>
            </div>
        </div>
    </section>

    <!-- FORM LOGIN -->
    <main class="login-content">
        <div class="login-form-wrapper">

            <a href="{{ url('/') }}" class="logo" aria-label="KosHaven - halaman utama">
                <span class="logo-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </span>
                <span>Kos<span class="logo-gold">Haven</span></span>
            </a>

            <div class="form-heading">
                <span>AKSES AKUN</span>
                <h2>Selamat Datang!</h2>
                <p>Silakan masuk menggunakan email dan kata sandi yang sudah terdaftar.</p>
            </div>

            @if (session('status'))
                <div class="alert-message success-message" role="status" aria-live="polite">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-message error-message" role="alert" aria-live="assertive">
                    <strong>
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Login belum berhasil.
                    </strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.authenticate') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan alamat email"
                            autocomplete="username"
                            value="{{ old('email') }}"
                            maxlength="255"
                            required
                            autofocus
                            aria-describedby="@error('email') emailError @enderror"
                            class="@error('email') is-invalid @enderror"
                        >
                    </div>
                    @error('email')
                        <span class="field-error" id="emailError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                            aria-describedby="@error('password') passwordError @enderror"
                            class="@error('password') is-invalid @enderror"
                        >
                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan kata sandi"
                            aria-pressed="false"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error" id="passwordError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>Ingat saya</span>
                    </label>

                    <a href="#" class="forgot-link" id="forgotLink">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="login-button" id="loginButton">
                    <span>Masuk ke Akun</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="register-text">
                Belum memiliki akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>

            <a href="{{ url('/') }}" class="back-home">
                <i class="bi bi-arrow-left"></i>
                Kembali ke halaman utama
            </a>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tampilkan / sembunyikan password
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        if (passwordInput && togglePassword) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                togglePassword.innerHTML = isPassword
                    ? '<i class="bi bi-eye-slash"></i>'
                    : '<i class="bi bi-eye"></i>';

                togglePassword.setAttribute(
                    'aria-label',
                    isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
                );
                togglePassword.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        }

        // Informasi fitur lupa password
        const forgotLink = document.getElementById('forgotLink');

        if (forgotLink) {
            forgotLink.addEventListener('click', function (event) {
                event.preventDefault();
                alert(
                    'Fitur lupa kata sandi belum tersedia. ' +
                    'Silakan hubungi Admin KosHaven untuk bantuan.'
                );
            });
        }

        // Validasi dasar browser; autentikasi tetap diproses Laravel
        const loginForm = document.getElementById('loginForm');

        if (loginForm) {
            loginForm.addEventListener('submit', function (event) {
                const email = document.getElementById('email');
                const password = document.getElementById('password');

                email.value = email.value.trim();

                if (!email.value || !password.value) {
                    event.preventDefault();
                    loginForm.reportValidity();
                    return;
                }

                if (!email.checkValidity()) {
                    event.preventDefault();
                    email.reportValidity();
                }
            });
        }
    });
</script>
</body>
</html>
