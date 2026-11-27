<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">
    <title>Profil Admin - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #191D22;
            --primary-deep: #12161B;
            --primary-light: #2D343D;
            --surface: #242A31;
            --surface-light: #2D343D;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --gold-soft: rgba(198,164,119,.13);
            --background: #171B20;
            --white: #242A31;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.13);
            --silver: #BBC4CD;
            --danger: #D58F8F;
            --success: #91AE9B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: auto;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
            color: var(--text);
            overflow-x: hidden;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        textarea {
            font-family: inherit;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 255px;
            height: 100vh;
            height: 100dvh;
            background: var(--primary-deep);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 18px 20px;
            display: flex;
            flex-direction: column;
            z-index: 1001;
            transition: transform .22s ease-out;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(198,164,119,.35) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(198,164,119,.35);
            border-radius: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 12px 24px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 39px;
            height: 39px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--gold-soft);
            color: var(--gold-light);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 10px;
            font-size: 19px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: #F1F0EC;
            white-space: nowrap;
        }

        .brand-name span {
            color: var(--gold-light);
        }

        .brand small {
            display: block;
            font-size: 9px;
            letter-spacing: 1.5px;
            color: var(--muted);
            margin-top: 5px;
            white-space: nowrap;
        }

        .menu-label {
            font-size: 10px;
            color: var(--muted-dark);
            letter-spacing: 1.5px;
            padding: 24px 13px 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border-radius: 8px;
            color: #C1C8CF;
            font-size: 13px;
            transition: background .2s ease, color .2s ease;
            min-height: 43px;
        }

        .menu a i {
            font-size: 17px;
            width: 19px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(198,164,119,.12);
            color: var(--gold-light);
        }

        .menu a.active {
            border-left: 3px solid var(--gold);
            padding-left: 11px;
            font-weight: 700;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding-top: 15px;
            flex-shrink: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 8px;
            min-width: 0;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: var(--gold);
            color: var(--primary-deep);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }

        .admin-info > div:last-child {
            min-width: 0;
        }

        .admin-info strong {
            display: block;
            font-size: 12px;
            color: var(--text);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 150px;
        }

        .admin-info small {
            color: var(--muted);
            font-size: 10px;
        }

        .logout {
            width: 100%;
            border: none;
            background: transparent;
            color: #C1C8CF;
            text-align: left;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 13px;
            border-radius: 8px;
            transition: background .2s ease, color .2s ease;
        }

        .logout:hover {
            background: rgba(213,143,143,.1);
            color: var(--danger);
        }

        .sidebar-overlay {
            display: none;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main {
            margin-left: 255px;
            min-height: 100vh;
            min-width: 0;
            transition: margin-left .22s ease-out;
        }

        .topbar {
            min-height: 76px;
            background: #1D2329;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 35px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .topbar h2 {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            color: var(--text);
        }

        .topbar p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .menu-toggle {
            display: none;
            border: none;
            background: transparent;
            font-size: 25px;
            color: var(--gold-light);
            cursor: pointer;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .menu-toggle:hover {
            background: var(--gold-soft);
        }

        .content {
            padding: 32px 35px;
            max-width: 1400px;
            margin: auto;
            width: 100%;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--text);
        }

        .page-heading p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 7px;
            line-height: 1.6;
        }

        /* =========================
           PROFILE HEADER
        ========================= */

        .profile-header {
            background:
                radial-gradient(circle at 90% 10%, rgba(198,164,119,.13), transparent 28%),
                linear-gradient(120deg, #242A31, #191D22);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 13px;
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 22px;
            color: var(--text);
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            border: 1px solid rgba(198,164,119,.16);
            border-radius: 50%;
            right: -35px;
            top: -75px;
            pointer-events: none;
        }

        .profile-header::before {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border: 1px solid rgba(198,164,119,.1);
            border-radius: 50%;
            right: 85px;
            bottom: -90px;
            pointer-events: none;
        }

        .profile-avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E0C49B, #B99464);
            color: #191D22;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            flex-shrink: 0;
            border: 4px solid rgba(255,255,255,.12);
            position: relative;
            z-index: 1;
        }

        .profile-header > div:last-child {
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .profile-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            margin-bottom: 6px;
            overflow-wrap: anywhere;
            color: #F1F0EC;
        }

        .profile-header p {
            color: var(--muted);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .role-badge {
            display: inline-block;
            margin-top: 11px;
            padding: 6px 12px;
            border-radius: 20px;
            background: rgba(198,164,119,.13);
            border: 1px solid rgba(198,164,119,.2);
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        /* =========================
           PROFILE LAYOUT
        ========================= */

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(280px, 1fr);
            gap: 22px;
            align-items: start;
        }

        .profile-column {
            min-width: 0;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 24px;
            margin-bottom: 22px;
            min-width: 0;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 23px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h3 {
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 18px;
        }

        .panel-heading i {
            color: var(--gold);
            font-size: 20px;
            flex-shrink: 0;
        }

        /* =========================
           FORM
        ========================= */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            border: 1px solid rgba(187,196,205,.18);
            background: #1D2329;
            border-radius: 7px;
            padding: 12px 13px;
            font-size: 12px;
            color: var(--text);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
            min-width: 0;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 85px;
            line-height: 1.6;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--gold);
            background: #20262D;
            box-shadow: 0 0 0 3px rgba(198,164,119,.1);
        }

        .form-group input:disabled {
            background: #20252B;
            color: var(--muted-dark);
            cursor: not-allowed;
            border-color: var(--border);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #77818C;
        }

        .hint {
            display: block;
            font-size: 10px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.5;
        }

        .btn {
            border: 1px solid transparent;
            border-radius: 7px;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s ease, color .2s ease, border-color .2s ease, transform .2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
        }

        .btn:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .btn-primary {
            background: var(--gold);
            color: #191D22;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--gold-light);
            transform: translateY(-1px);
        }

        .btn-light {
            background: #343C45;
            border-color: rgba(187,196,205,.12);
            color: var(--silver);
        }

        .btn-light:hover {
            background: #3B444E;
            color: #F1F0EC;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 8px;
        }

        /* =========================
           PASSWORD
        ========================= */

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .toggle-password:hover {
            color: var(--gold-light);
            background: var(--gold-soft);
        }

        /* =========================
           ACCOUNT INFORMATION
        ========================= */

        .info-list {
            display: flex;
            flex-direction: column;
        }

        .info-item {
            display: flex;
            gap: 13px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }

        .info-item:first-child {
            padding-top: 0;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-icon {
            width: 37px;
            height: 37px;
            border-radius: 9px;
            background: var(--gold-soft);
            color: var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(198,164,119,.12);
        }

        .info-item > div:last-child {
            min-width: 0;
        }

        .info-item strong {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
            color: var(--text);
        }

        .info-item small {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .status-active {
            color: var(--success) !important;
            font-weight: 700;
        }

        .security-note {
            background: rgba(198,164,119,.06);
            border: 1px solid rgba(198,164,119,.16);
            border-radius: 8px;
            padding: 15px;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .security-note i {
            color: var(--gold);
            margin-right: 5px;
        }

        .security-note strong {
            color: var(--gold-light);
        }

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 11px;
            padding: 20px 0 5px;
            line-height: 1.6;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1200px) {
            .content {
                padding-left: 27px;
                padding-right: 27px;
            }

            .topbar {
                padding-left: 27px;
                padding-right: 27px;
            }

            .profile-grid {
                grid-template-columns: minmax(0, 1.3fr) minmax(260px, 1fr);
                gap: 17px;
            }

            .panel {
                padding: 20px;
            }
        }

        @media (max-width: 1050px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-column:last-child {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                gap: 17px;
                align-items: start;
            }

            .profile-column:last-child .panel {
                margin-bottom: 0;
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 8px 0 25px rgba(0,0,0,.35);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.62);
                z-index: 1000;
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: inline-flex;
            }

            .topbar {
                padding-left: 22px;
                padding-right: 22px;
            }

            .content {
                padding: 27px 22px;
            }
        }

        @media (max-width: 650px) {
            .profile-column:last-child {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .profile-column:last-child .panel {
                margin-bottom: 20px;
            }

            .profile-header {
                padding: 22px;
            }

            .profile-avatar {
                width: 72px;
                height: 72px;
                font-size: 27px;
            }

            .profile-header h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 550px) {
            .topbar {
                min-height: 68px;
                padding: 10px 15px;
            }

            .topbar-left {
                gap: 10px;
            }

            .topbar h2 {
                font-size: 17px;
            }

            .topbar p {
                display: none;
            }

            .content {
                padding: 23px 15px;
            }

            .page-heading {
                margin-bottom: 20px;
            }

            .page-heading h1 {
                font-size: 23px;
            }

            .page-heading p {
                font-size: 12px;
            }

            .profile-header {
                padding: 19px;
                gap: 14px;
                margin-bottom: 18px;
            }

            .profile-avatar {
                width: 62px;
                height: 62px;
                font-size: 24px;
            }

            .profile-header h2 {
                font-size: 18px;
            }

            .profile-header p {
                font-size: 11px;
            }

            .role-badge {
                font-size: 9px;
                padding: 5px 9px;
            }

            .profile-grid {
                gap: 0;
            }

            .panel {
                padding: 18px;
                margin-bottom: 17px;
            }

            .panel-heading {
                margin-bottom: 19px;
            }

            .panel-heading h3 {
                font-size: 17px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }

            .footer {
                padding-top: 12px;
            }
        }

        @media (max-width: 360px) {
            .content {
                padding-left: 11px;
                padding-right: 11px;
            }

            .profile-header {
                padding: 15px;
                gap: 11px;
            }

            .profile-avatar {
                width: 54px;
                height: 54px;
                font-size: 21px;
            }

            .profile-header h2 {
                font-size: 16px;
            }

            .panel {
                padding: 15px;
            }

            .topbar h2 {
                font-size: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR OVERLAY -->
    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
        aria-hidden="true"
    ></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-house-heart-fill"></i>
            </div>

            <div>
                <div class="brand-name">Kos<span>Haven</span></div>
                <small>BOARDING HOUSE MANAGEMENT</small>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="menu" aria-label="Navigasi utama">

            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.kamar.index') }}">
                <i class="bi bi-door-open"></i>
                Data Kamar
            </a>

            <a href="{{ route('admin.booking.index') }}">
                <i class="bi bi-journal-check"></i>
                Booking Kos
            </a>

            <a href="{{ route('admin.penghuni.index') }}">
                <i class="bi bi-people"></i>
                Data Penghuni
            </a>

            <a href="{{ route('admin.petugas.index') }}">
                <i class="bi bi-person-badge"></i>
                Data Petugas
            </a>

            <a href="{{ route('admin.pengguna.index') }}">
                <i class="bi bi-person-gear"></i>
                Manajemen Pengguna
            </a>

        </nav>

        <div class="menu-label">KEUANGAN</div>

        <nav class="menu" aria-label="Navigasi keuangan">

            <a href="{{ route('admin.tagihan.index') }}">
                <i class="bi bi-receipt"></i>
                Tagihan Bulanan
            </a>

            <a href="{{ route('admin.pembayaran.index') }}">
                <i class="bi bi-wallet2"></i>
                Pembayaran
            </a>

            <a href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Laporan
            </a>

        </nav>

        <div class="menu-label">PENGATURAN</div>

        <nav class="menu" aria-label="Pengaturan akun">

            <a
                href="{{ route('admin.profil.index') }}"
                class="active"
                aria-current="page"
            >
                <i class="bi bi-person-circle"></i>
                Profil Admin
            </a>

        </nav>

        <div class="sidebar-bottom">

            <div class="admin-info">
                <div class="admin-avatar" id="sidebarAvatar">A</div>

                <div>
                    <strong id="sidebarName">Administrator</strong>
                    <small>Admin KosHaven</small>
                </div>
            </div>

            <button
                type="button"
                class="logout"
                onclick="logoutDemo()"
            >
                <i class="bi bi-box-arrow-left"></i>
                Keluar
            </button>

        </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false"
                    aria-controls="sidebar"
                >
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h2>Profil Admin</h2>
                    <p>Pengaturan informasi akun administrator</p>
                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <div class="content">

            <section class="page-heading">
                <h1>Profil Administrator</h1>
                <p>
                    Kelola informasi pribadi dan keamanan akun admin KosHaven.
                </p>
            </section>

            <!-- PROFILE HEADER -->
            <section class="profile-header">

                <div class="profile-avatar" id="profileAvatar">A</div>

                <div>
                    <h2 id="headerName">Administrator</h2>
                    <p id="headerEmail">admin@koshaven.com</p>

                    <span class="role-badge">
                        <i class="bi bi-shield-check"></i>
                        ADMINISTRATOR
                    </span>
                </div>

            </section>

            <div class="profile-grid">

                <!-- KOLOM KIRI -->
                <div class="profile-column">

                    <!-- FORM INFORMASI PROFIL -->
                    <section class="panel">

                        <div class="panel-heading">
                            <h3>Informasi Pribadi</h3>
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <form id="profileForm" novalidate>

                            <div class="form-grid">

                                <div class="form-group">
                                    <label for="fullName">Nama Lengkap</label>

                                    <input
                                        type="text"
                                        id="fullName"
                                        name="fullName"
                                        required
                                        minlength="3"
                                        maxlength="60"
                                        autocomplete="name"
                                        placeholder="Masukkan nama lengkap"
                                    >

                                    <small class="hint">
                                        Minimal 3 karakter dan maksimal 60 karakter.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        maxlength="100"
                                        autocomplete="email"
                                        placeholder="Masukkan email"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="phone">Nomor Telepon</label>

                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        maxlength="20"
                                        autocomplete="tel"
                                        placeholder="Masukkan nomor telepon"
                                    >

                                    <small class="hint">
                                        Contoh: 081234567890 atau +6281234567890.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="role">Jabatan</label>

                                    <input
                                        type="text"
                                        id="role"
                                        value="Administrator"
                                        disabled
                                    >
                                </div>

                                <div class="form-group full">
                                    <label for="address">Alamat</label>

                                    <textarea
                                        id="address"
                                        name="address"
                                        maxlength="250"
                                        placeholder="Masukkan alamat lengkap"
                                    ></textarea>

                                    <small class="hint">
                                        Maksimal 250 karakter.
                                    </small>
                                </div>

                            </div>

                            <div class="form-actions">

                                <button
                                    type="reset"
                                    class="btn btn-light"
                                >
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Reset
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="bi bi-check-circle"></i>
                                    Simpan Perubahan
                                </button>

                            </div>

                        </form>

                    </section>

                    <!-- FORM PASSWORD -->
                    <section class="panel">

                        <div class="panel-heading">
                            <h3>Keamanan Akun</h3>
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        <form id="passwordForm" novalidate>

                            <div class="form-group">

                                <label for="oldPassword">
                                    Password Saat Ini
                                </label>

                                <div class="password-field">

                                    <input
                                        type="password"
                                        id="oldPassword"
                                        required
                                        autocomplete="current-password"
                                        placeholder="Masukkan password saat ini"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        onclick="togglePassword('oldPassword', this)"
                                        aria-label="Tampilkan password saat ini"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="newPassword">
                                    Password Baru
                                </label>

                                <div class="password-field">

                                    <input
                                        type="password"
                                        id="newPassword"
                                        required
                                        minlength="8"
                                        maxlength="72"
                                        autocomplete="new-password"
                                        placeholder="Minimal 8 karakter"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        onclick="togglePassword('newPassword', this)"
                                        aria-label="Tampilkan password baru"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                                <small class="hint">
                                    Password baru minimal 8 karakter.
                                </small>

                            </div>

                            <div class="form-group">

                                <label for="confirmPassword">
                                    Konfirmasi Password Baru
                                </label>

                                <div class="password-field">

                                    <input
                                        type="password"
                                        id="confirmPassword"
                                        required
                                        minlength="8"
                                        maxlength="72"
                                        autocomplete="new-password"
                                        placeholder="Ulangi password baru"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        onclick="togglePassword('confirmPassword', this)"
                                        aria-label="Tampilkan konfirmasi password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="form-actions">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="bi bi-lock"></i>
                                    Perbarui Password
                                </button>

                            </div>

                        </form>

                    </section>

                </div>

                <!-- KOLOM KANAN -->
                <div class="profile-column">

                    <!-- INFORMASI AKUN -->
                    <section class="panel">

                        <div class="panel-heading">
                            <h3>Informasi Akun</h3>
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div class="info-list">

                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>

                                <div>
                                    <strong>Jenis Akun</strong>
                                    <small>Administrator KosHaven</small>
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-calendar-check"></i>
                                </div>

                                <div>
                                    <strong>Status Akun</strong>
                                    <small class="status-active">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Aktif
                                    </small>
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div>
                                    <strong>Hak Akses</strong>
                                    <small>
                                        Pengelolaan seluruh fitur administrasi
                                    </small>
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-icon">
                                    <i class="bi bi-building"></i>
                                </div>

                                <div>
                                    <strong>Nama Sistem</strong>
                                    <small>
                                        KosHaven - Boarding House Management
                                    </small>
                                </div>

                            </div>

                        </div>

                    </section>

                    <!-- INFORMASI KEAMANAN -->
                    <div class="security-note">

                        <i class="bi bi-info-circle-fill"></i>

                        <strong>Informasi:</strong>

                        Halaman ini masih menggunakan penyimpanan sementara
                        di browser untuk keperluan demonstrasi frontend.
                        Data profil dan password demo belum terhubung ke
                        database Laravel.

                        <br><br>

                        Untuk penggunaan sebenarnya, pengelolaan akun dan
                        password harus menggunakan autentikasi Laravel,
                        validasi server, serta penyimpanan password berbentuk
                        hash. Jangan menyimpan password asli di LocalStorage
                        pada aplikasi produksi.

                    </div>

                </div>

            </div>

            <footer class="footer">
                © 2026 KosHaven. Sistem Manajemen Kos.
            </footer>

        </div>

    </main>

    <script>
        /* =====================================
           SIDEBAR NAVIGATION
        ===================================== */

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');

        function openSidebar() {
            if (window.innerWidth > 850) return;

            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');

            document.body.classList.add('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Tutup menu navigasi');

            menuToggle.innerHTML = '<i class="bi bi-x-lg"></i>';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');

            document.body.classList.remove('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Buka menu navigasi');

            menuToggle.innerHTML = '<i class="bi bi-list"></i>';
        }

        function toggleSidebar() {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        menuToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.sidebar .menu a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 850) {
                    closeSidebar();
                }
            });
        });

        document.addEventListener('keydown', function(event) {
            if (
                event.key === 'Escape' &&
                sidebar.classList.contains('show')
            ) {
                closeSidebar();
                menuToggle.focus();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 850) {
                closeSidebar();
            }
        });

        /* =====================================
           LOGOUT
        ===================================== */

        function logoutDemo() {
            const confirmLogout = confirm(
                'Apakah kamu yakin ingin keluar dari dashboard?'
            );

            if (confirmLogout) {
                window.location.href = "{{ route('login') }}";
            }
        }

        /* =====================================
           DATA PROFIL
        ===================================== */

        @php
            $authUser = auth()->user();
            $serverProfile = $profileData ?? [
                'id' => $authUser?->id ?? 0,
                'fullName' => $authUser?->name ?? 'Admin KosHaven',
                'email' => $authUser?->email ?? '',
                'phone' => $authUser?->phone ?? '',
            ];
        @endphp
        const serverProfile = @json($serverProfile);
        const PROFILE_KEY = 'koshaven_admin_profile_u_' + String(serverProfile.id || 0);
        const csrfToken = "{{ csrf_token() }}";
        const updateProfileUrl = "{{ route('admin.profil.update') }}";
        const updatePasswordUrl = "{{ route('admin.profil.password') }}";

        const defaultProfile = {
            fullName: serverProfile.fullName || 'Admin KosHaven',
            email: serverProfile.email || '',
            phone: serverProfile.phone || '',
            address: ''
        };

        let currentProfile = { ...defaultProfile };

        function getProfile() {
            try {
                const saved = localStorage.getItem(PROFILE_KEY);
                const parsed = saved ? JSON.parse(saved) : {};

                return {
                    ...defaultProfile,
                    address: typeof parsed?.address === 'string' ? parsed.address.slice(0, 250) : ''
                };
            } catch (error) {
                return { ...defaultProfile };
            }
        }

        function saveProfile(profile) {
            try {
                localStorage.setItem(
                    PROFILE_KEY,
                    JSON.stringify(profile)
                );

                return true;

            } catch (error) {
                console.error('Gagal menyimpan profil:', error);

                alert(
                    'Data profil gagal disimpan. Periksa penyimpanan browser kamu.'
                );

                return false;
            }
        }

        /* =====================================
           UPDATE TAMPILAN PROFIL
        ===================================== */

        function updateProfileDisplay(profile) {
            const safeName = profile.fullName || 'Administrator';
            const safeEmail = profile.email || '';

            document.getElementById('fullName').value = safeName;
            document.getElementById('email').value = safeEmail;
            document.getElementById('phone').value = profile.phone || '';
            document.getElementById('address').value = profile.address || '';

            document.getElementById('headerName').textContent = safeName;
            document.getElementById('headerEmail').textContent = safeEmail;

            const initial = safeName.trim().charAt(0).toUpperCase() || 'A';

            document.getElementById('profileAvatar').textContent = initial;
            document.getElementById('sidebarAvatar').textContent = initial;
            document.getElementById('sidebarName').textContent = safeName;
        }

        currentProfile = getProfile();
        updateProfileDisplay(currentProfile);

        /* =====================================
           VALIDASI PROFIL
        ===================================== */

        function validateProfile(profile) {

            if (!profile.fullName) {
                alert('Nama lengkap wajib diisi.');
                document.getElementById('fullName').focus();
                return false;
            }

            if (profile.fullName.length < 3) {
                alert('Nama lengkap minimal 3 karakter.');
                document.getElementById('fullName').focus();
                return false;
            }

            if (profile.fullName.length > 60) {
                alert('Nama lengkap maksimal 60 karakter.');
                document.getElementById('fullName').focus();
                return false;
            }

            const namePattern = /^[\p{L}\p{M} .'-]+$/u;

            if (!namePattern.test(profile.fullName)) {
                alert(
                    'Nama hanya boleh berisi huruf, spasi, titik, tanda petik, dan tanda hubung.'
                );

                document.getElementById('fullName').focus();
                return false;
            }

            if (!profile.email) {
                alert('Email wajib diisi.');
                document.getElementById('email').focus();
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

            if (!emailPattern.test(profile.email)) {
                alert('Format email tidak valid.');
                document.getElementById('email').focus();
                return false;
            }

            if (profile.email.length > 100) {
                alert('Email maksimal 100 karakter.');
                document.getElementById('email').focus();
                return false;
            }

            if (profile.phone) {
                const normalizedPhone = profile.phone.replace(
                    /[\s()-]/g,
                    ''
                );

                const phonePattern = /^\+?\d{9,15}$/;

                if (!phonePattern.test(normalizedPhone)) {
                    alert(
                        'Nomor telepon harus berisi 9 sampai 15 digit dan boleh diawali tanda +.'
                    );

                    document.getElementById('phone').focus();
                    return false;
                }

                profile.phone = normalizedPhone;
            }

            if (profile.address.length > 250) {
                alert('Alamat maksimal 250 karakter.');
                document.getElementById('address').focus();
                return false;
            }

            return true;
        }

        /* =====================================
           SIMPAN PROFIL
        ===================================== */

        document.getElementById('profileForm').addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();

                const profile = {
                    fullName: document.getElementById('fullName')
                        .value.trim().replace(/\s+/g, ' '),

                    email: document.getElementById('email')
                        .value.trim().toLowerCase(),

                    phone: document.getElementById('phone')
                        .value.trim(),

                    address: document.getElementById('address')
                        .value.trim()
                };

                if (!validateProfile(profile)) {
                    return;
                }

                try {
                    const response = await fetch(updateProfileUrl, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: profile.fullName,
                            email: profile.email,
                            phone: profile.phone,
                            address: profile.address
                        })
                    });

                    const result = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        const firstErr = result.errors ? Object.values(result.errors).flat()[0] : null;
                        alert(firstErr || result.message || 'Gagal memperbarui profil.');
                        return;
                    }

                    saveProfile(profile);
                    currentProfile = { ...profile };
                    updateProfileDisplay(currentProfile);
                    alert(result.message || 'Profil admin berhasil disimpan.');
                } catch (error) {
                    alert('Terjadi gangguan jaringan saat menyimpan profil.');
                }
            }
        );

        /* =====================================
           RESET FORM PROFIL
        ===================================== */

        document.getElementById('profileForm').addEventListener(
            'reset',
            function() {

                setTimeout(function() {
                    updateProfileDisplay(currentProfile);
                }, 0);

            }
        );

        /* =====================================
           PASSWORD DEMO
        ===================================== */

        const PASSWORD_KEY = 'koshaven_admin_password_demo_v1';

        const DEFAULT_DEMO_PASSWORD = 'admin12345';

        function getDemoPassword() {
            try {
                return localStorage.getItem(PASSWORD_KEY) ||
                    DEFAULT_DEMO_PASSWORD;

            } catch (error) {
                console.error('Gagal membaca password demo:', error);
                return DEFAULT_DEMO_PASSWORD;
            }
        }

        /* =====================================
           TAMPILKAN / SEMBUNYIKAN PASSWORD
        ===================================== */

        function togglePassword(id, button) {

            const input = document.getElementById(id);
            const icon = button.querySelector('i');

            if (input.type === 'password') {

                input.type = 'text';
                icon.className = 'bi bi-eye-slash';

                button.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {

                input.type = 'password';
                icon.className = 'bi bi-eye';

                button.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );
            }
        }

        /* =====================================
           VALIDASI PASSWORD
        ===================================== */

        function validatePassword(
            oldPassword,
            newPassword,
            confirmPassword
        ) {

            if (!oldPassword) {
                alert('Password saat ini wajib diisi.');
                document.getElementById('oldPassword').focus();
                return false;
            }

            if (!newPassword) {
                alert('Password baru wajib diisi.');
                document.getElementById('newPassword').focus();
                return false;
            }

            if (newPassword.length < 8) {
                alert('Password baru minimal 8 karakter.');
                document.getElementById('newPassword').focus();
                return false;
            }

            if (newPassword.length > 72) {
                alert('Password baru maksimal 72 karakter.');
                document.getElementById('newPassword').focus();
                return false;
            }

            if (newPassword === oldPassword) {
                alert(
                    'Password baru harus berbeda dari password saat ini.'
                );

                document.getElementById('newPassword').focus();
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert('Konfirmasi password baru tidak sama.');
                document.getElementById('confirmPassword').focus();
                return false;
            }

            return true;
        }

        /* =====================================
           SIMPAN PASSWORD BARU
        ===================================== */

        document.getElementById('passwordForm').addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();

                const oldPassword =
                    document.getElementById('oldPassword').value;

                const newPassword =
                    document.getElementById('newPassword').value;

                const confirmPassword =
                    document.getElementById('confirmPassword').value;

                if (
                    !validatePassword(
                        oldPassword,
                        newPassword,
                        confirmPassword
                    )
                ) {
                    return;
                }

                try {
                    const response = await fetch(updatePasswordUrl, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            current_password: oldPassword,
                            password: newPassword,
                            password_confirmation: confirmPassword
                        })
                    });

                    const result = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        const firstErr = result.errors ? Object.values(result.errors).flat()[0] : null;
                        alert(firstErr || result.message || 'Gagal memperbarui password.');
                        return;
                    }

                    this.reset();

                    document.querySelectorAll('.toggle-password i').forEach(
                        function(icon) {
                            icon.className = 'bi bi-eye';
                        }
                    );

                    document.querySelectorAll('.toggle-password').forEach(
                        function(button) {
                            button.setAttribute(
                                'aria-label',
                                'Tampilkan password'
                            );
                        }
                    );

                    alert(result.message || 'Password berhasil diperbarui.');
                } catch (error) {
                    alert('Terjadi gangguan jaringan saat mengubah password.');
                }

            }
        );

    </script>

</body>
</html>