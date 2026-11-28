
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Saya - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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
            --muted-dark: #7F8993;
            --border: rgba(198,164,119,.16);
            --success: #91AE9B;
            --warning: #D9B77F;
            --danger: #D58F8F;
            --sidebar-width: 270px;
            --shadow: 0 12px 35px rgba(0,0,0,.16);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        button, input, textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            background: var(--bg-deep);
            border-right: 1px solid var(--border);
            transition: transform .3s ease;
        }

        .brand {
            padding: 27px 25px 24px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .brand-name {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .brand-name span {
            color: var(--gold);
        }

        .brand small {
            display: block;
            margin-top: 5px;
            color: var(--muted-dark);
            font-size: 10px;
            letter-spacing: 1.7px;
            text-transform: uppercase;
        }

        .sidebar-label {
            padding: 25px 25px 11px;
            color: #737E89;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.6px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 13px;
            overflow-y: auto;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #AEB7C0;
            font-size: 12px;
            font-weight: 500;
            transition: .2s;
        }

        .nav-link i {
            width: 20px;
            color: #929DA8;
            font-size: 17px;
            text-align: center;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.045);
            color: var(--ivory);
        }

        .nav-link.active {
            background: rgba(198,164,119,.12);
            border-color: rgba(198,164,119,.15);
            color: var(--gold-light);
        }

        .nav-link.active i {
            color: var(--gold);
        }

        .sidebar-bottom {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 7px 15px;
        }

        .avatar {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid rgba(198,164,119,.4);
            border-radius: 50%;
            background: var(--surface-soft);
            color: var(--gold-light);
            font-size: 13px;
            font-weight: 700;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            min-width: 0;
        }

        .user-info strong {
            display: block;
            overflow: hidden;
            color: var(--ivory);
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-info small {
            color: var(--muted-dark);
            font-size: 10px;
        }

        /* SHARED LOGOUT COMPONENT */
        .sidebar-bottom .kh-logout-component-wrapper {
            width: 100%;
            margin-top: 0;
        }

        .sidebar-bottom .kh-logout-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            padding: 12px 14px;
            color: #D58F8F;
            background: rgba(213,143,143,.07);
            border: 1px solid rgba(213,143,143,.12);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            color: #E5AAAA;
            background: rgba(213,143,143,.15);
            border-color: rgba(213,143,143,.25);
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 16px;
            flex-shrink: 0;
        }

        /* MAIN */
        .main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            padding: 30px 35px 50px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 32px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface);
            color: var(--gold);
            font-size: 20px;
        }

        .breadcrumb {
            margin-bottom: 5px;
            color: var(--muted-dark);
            font-size: 11px;
        }

        .breadcrumb span {
            margin: 0 7px;
            color: var(--gold);
        }

        .page-title {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 29px;
            font-weight: 700;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface);
            color: var(--silver);
            font-size: 11px;
        }

        .topbar-date i {
            color: var(--gold);
        }

        .intro {
            margin-bottom: 25px;
        }

        .intro h2 {
            margin-bottom: 7px;
            color: var(--ivory);
            font-size: 16px;
            font-weight: 700;
        }

        .intro p {
            max-width: 650px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .profile-layout {
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
            gap: 20px;
            align-items: start;
        }

        /* PROFILE CARD */
        .profile-card,
        .form-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .profile-card {
            padding: 26px 21px;
            text-align: center;
        }

        .profile-card-top {
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .profile-photo-wrap {
            position: relative;
            width: 108px;
            height: 108px;
            margin: 0 auto 16px;
        }

        .profile-photo {
            width: 108px;
            height: 108px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 4px solid rgba(198,164,119,.2);
            border-radius: 50%;
            background: var(--surface-soft);
            color: var(--gold-light);
            font-size: 35px;
            font-weight: 700;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-edit {
            position: absolute;
            right: 0;
            bottom: 1px;
            width: 33px;
            height: 33px;
            display: grid;
            place-items: center;
            border: 3px solid var(--surface);
            border-radius: 50%;
            background: var(--gold);
            color: var(--bg-deep);
            font-size: 13px;
        }

        .photo-edit:hover {
            background: var(--gold-light);
        }

        .profile-name {
            overflow-wrap: anywhere;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
        }

        .profile-role {
            display: inline-block;
            margin-top: 9px;
            padding: 6px 13px;
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 20px;
            background: rgba(198,164,119,.1);
            color: var(--gold-light);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .4px;
        }

        .photo-help {
            margin-top: 12px;
            color: var(--muted-dark);
            font-size: 9px;
            line-height: 1.6;
        }

        .profile-contact {
            padding-top: 20px;
            text-align: left;
        }

        .contact-title {
            margin-bottom: 16px;
            color: var(--muted-dark);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            min-width: 0;
            margin-bottom: 17px;
        }

        .contact-icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: rgba(198,164,119,.07);
            color: var(--gold);
            font-size: 13px;
        }

        .contact-item div:last-child {
            min-width: 0;
            padding-top: 2px;
        }

        .contact-item small {
            display: block;
            margin-bottom: 4px;
            color: var(--muted-dark);
            font-size: 9px;
        }

        .contact-item strong {
            display: block;
            overflow-wrap: anywhere;
            color: var(--silver);
            font-size: 10px;
            font-weight: 600;
        }

        .account-info {
            margin-top: 5px;
            padding: 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--bg);
            text-align: left;
        }

        .account-info small {
            display: block;
            margin-bottom: 6px;
            color: var(--muted-dark);
            font-size: 9px;
        }

        .account-info strong {
            color: var(--gold-light);
            font-size: 11px;
        }

        /* FORM CARDS */
        .form-card {
            margin-bottom: 20px;
        }

        .form-heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .heading-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: rgba(198,164,119,.08);
            color: var(--gold);
            font-size: 15px;
        }

        .form-heading h3 {
            margin-top: 1px;
            color: var(--ivory);
            font-size: 13px;
            font-weight: 700;
        }

        .form-heading p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.6;
        }

        .form-body {
            padding: 23px 22px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--silver);
            font-size: 10px;
            font-weight: 700;
        }

        .required {
            color: var(--danger);
        }

        .input-wrap,
        .password-wrap {
            position: relative;
        }

        .input-wrap > i {
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);
            color: var(--muted-dark);
            font-size: 13px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            min-height: 43px;
            padding: 11px 13px;
            outline: none;
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 8px;
            background: var(--bg);
            color: var(--ivory);
            font-size: 11px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-wrap .form-control {
            padding-left: 39px;
        }

        .form-control::placeholder {
            color: #68737D;
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.1);
        }

        .form-control:disabled {
            border-color: rgba(255,255,255,.05);
            background: var(--surface-light);
            color: var(--muted-dark);
            cursor: not-allowed;
        }

        .form-control[aria-invalid="true"] {
            border-color: var(--danger);
        }

        textarea.form-control {
            min-height: 90px;
            resize: vertical;
            line-height: 1.6;
        }

        .field-hint {
            margin-top: 7px;
            color: var(--muted-dark);
            font-size: 9px;
            line-height: 1.6;
        }

        .field-error {
            display: none;
            margin-top: 6px;
            color: var(--danger);
            font-size: 9px;
            line-height: 1.5;
        }

        .field-error.show {
            display: block;
        }

        .password-wrap .form-control {
            padding-right: 43px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 14px;
        }

        .toggle-password:hover {
            color: var(--gold);
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 9px;
            padding: 15px 22px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .btn {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-primary {
            background: var(--gold);
            color: var(--bg-deep);
        }

        .btn-primary:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
        }

        .btn-secondary {
            border-color: rgba(255,255,255,.1);
            background: var(--surface-light);
            color: var(--silver);
        }

        .btn-secondary:hover {
            background: var(--surface-soft);
        }

        .btn:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .security-note {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 19px;
            padding: 12px;
            border: 1px solid rgba(198,164,119,.15);
            border-radius: 8px;
            background: rgba(198,164,119,.055);
            color: var(--muted);
            font-size: 9px;
            line-height: 1.6;
        }

        .security-note i {
            margin-top: 1px;
            color: var(--gold);
            font-size: 13px;
        }

        /* TOAST */
        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 3000;
            max-width: calc(100% - 40px);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 17px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface-light);
            color: var(--ivory);
            font-size: 10px;
            box-shadow: var(--shadow);
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: .25s;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast i {
            color: var(--success);
            font-size: 15px;
        }

        .toast.error i {
            color: var(--danger);
        }

        .sidebar-overlay {
            display: none;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .main {
                padding: 25px 22px 40px;
            }

            .profile-layout {
                grid-template-columns: 250px minmax(0, 1fr);
                gap: 15px;
            }

            .profile-card {
                padding: 22px 17px;
            }
        }

        @media (max-width: 900px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }

            .profile-card {
                display: grid;
                grid-template-columns: 115px minmax(0, 1fr);
                align-items: center;
                gap: 0 20px;
                text-align: left;
            }

            .profile-card-top {
                display: contents;
            }

            .profile-photo-wrap {
                grid-column: 1;
                grid-row: 1 / span 3;
                margin: 0;
            }

            .profile-card-top > div:nth-child(2) {
                grid-column: 2;
                align-self: end;
            }

            .photo-help {
                grid-column: 2;
                align-self: start;
                margin-top: 8px;
            }

            .profile-contact {
                grid-column: 1 / -1;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                margin-top: 20px;
                border-top: 1px solid var(--border);
            }

            .contact-title {
                grid-column: 1 / -1;
                margin-bottom: 0;
            }

            .account-info {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                position: fixed;
                inset: 0;
                z-index: 999;
                display: block;
                background: rgba(0,0,0,.65);
            }

            .main {
                margin-left: 0;
                padding: 20px 17px 35px;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }

            .page-title {
                font-size: 24px;
            }

            .topbar-date {
                display: none;
            }
        }

        @media (max-width: 520px) {
            .main {
                padding: 17px 12px 30px;
            }

            .topbar {
                margin-bottom: 25px;
            }

            .page-title {
                font-size: 22px;
            }

            .breadcrumb {
                font-size: 10px;
            }

            .intro h2 {
                font-size: 14px;
            }

            .intro p {
                font-size: 10px;
            }

            .profile-card {
                grid-template-columns: 82px minmax(0, 1fr);
                gap: 0 13px;
                padding: 18px 14px;
            }

            .profile-photo-wrap,
            .profile-photo {
                width: 78px;
                height: 78px;
            }

            .profile-photo {
                font-size: 26px;
            }

            .photo-edit {
                width: 29px;
                height: 29px;
                font-size: 11px;
            }

            .profile-name {
                font-size: 16px;
            }

            .profile-role {
                padding: 5px 9px;
                font-size: 8px;
            }

            .photo-help {
                font-size: 8px;
            }

            .profile-contact {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .form-heading {
                padding: 16px;
            }

            .form-body {
                padding: 18px 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-footer {
                padding: 13px 16px;
            }

            .form-footer .btn {
                flex: 1;
                padding: 10px 9px;
                font-size: 9px;
            }

            .toast {
                right: 12px;
                bottom: 12px;
            }
        }

        @media (max-width: 350px) {
            .profile-card {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .profile-photo-wrap {
                grid-column: 1;
                grid-row: auto;
                margin: 0 auto 13px;
            }

            .profile-card-top > div:nth-child(2),
            .photo-help {
                grid-column: 1;
            }

            .profile-contact {
                text-align: left;
            }

            .form-footer {
                flex-direction: column-reverse;
            }

            .form-footer .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-name">Kos<span>Haven</span></div>
        <small>Boarding House Management</small>
    </div>

    <div class="sidebar-label">Menu Utama</div>

    <nav class="sidebar-nav">
        <a href="{{ route('petugas.dashboard') }}" class="nav-link">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <a href="{{ route('petugas.kamar.index') }}" class="nav-link">
            <i class="bi bi-door-closed"></i> Data Kamar
        </a>

        <a href="{{ route('petugas.penghuni.index') }}" class="nav-link">
            <i class="bi bi-people"></i> Data Penghuni
        </a>

        <a href="{{ route('petugas.tagihan.index') }}" class="nav-link">
            <i class="bi bi-receipt"></i> Tagihan Bulanan
        </a>

        <a href="{{ route('petugas.pembayaran.index') }}" class="nav-link">
            <i class="bi bi-wallet2"></i> Pembayaran
        </a>

        <a href="{{ route('petugas.aktivitas.index') }}" class="nav-link">
            <i class="bi bi-clock-history"></i> Aktivitas
        </a>

        <div class="sidebar-label">Akun</div>

        <a href="{{ route('petugas.profil.index') }}" class="nav-link active" aria-current="page">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="user-card">
            <div class="avatar" id="sidebarAvatar">PT</div>
            <div class="user-info">
                <strong id="sidebarName">Petugas Kos</strong>
                <small>Staff Operasional</small>
            </div>
        </div>

        <div class="kh-logout-component-wrapper">
            @include('components.logout-modal')
        </div>
    </div>
</aside>

<main class="main">

    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" type="button"
                    aria-label="Buka navigasi" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <div class="breadcrumb">Akun <span>/</span> Profil Saya</div>
                <h1 class="page-title">Profil Saya</h1>
            </div>
        </div>

        <div class="topbar-date">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </header>

    <section class="intro">
        <h2>Informasi Akun Petugas</h2>
        <p>Kelola informasi pribadi dan keamanan akun yang digunakan untuk mengakses sistem KosHaven.</p>
    </section>

    <section class="profile-layout">

        <!-- KARTU PROFIL -->
        <aside class="profile-card">
            <div class="profile-card-top">
                <div class="profile-photo-wrap">
                    <div class="profile-photo" id="profilePhoto">
                        <span id="profileInitial">PT</span>
                    </div>

                    <button class="photo-edit" id="photoEditBtn" type="button"
                            aria-label="Ubah foto profil">
                        <i class="bi bi-camera-fill"></i>
                    </button>
                </div>

                <div>
                    <h2 class="profile-name" id="profileName">Petugas Kos</h2>
                    <span class="profile-role">PETUGAS OPERASIONAL</span>
                </div>

                <p class="photo-help">
                    Klik ikon kamera untuk mengganti foto profil.
                    Format JPG, PNG, atau WEBP, maksimal 2 MB.
                </p>
            </div>

            <input type="file" id="photoInput"
                   accept="image/jpeg,image/png,image/webp" hidden>

            <div class="profile-contact">
                <div class="contact-title">Informasi Kontak</div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <small>Alamat Email</small>
                        <strong id="profileEmail">petugas@koshaven.com</strong>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <small>Nomor Telepon</small>
                        <strong id="profilePhone">081234567890</strong>
                    </div>
                </div>
            </div>

            <div class="account-info">
                <small>Role Akun</small>
                <strong><i class="bi bi-shield-check"></i> Petugas</strong>
            </div>
        </aside>

        <!-- FORM -->
        <div>

            <!-- INFORMASI PRIBADI -->
            <form class="form-card" id="profileForm" novalidate>
                <div class="form-heading">
                    <div class="heading-icon">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div>
                        <h3>Informasi Pribadi</h3>
                        <p>Perbarui data diri yang digunakan dalam sistem pengelolaan kos.</p>
                    </div>
                </div>

                <div class="form-body">
                    <div class="form-grid">

                        <div class="form-group">
                            <label for="fullName">Nama Lengkap <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-person"></i>
                                <input class="form-control" type="text" id="fullName"
                                       maxlength="100" autocomplete="name"
                                       placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="field-error" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-envelope"></i>
                                <input class="form-control" type="email" id="email"
                                       maxlength="150" autocomplete="email"
                                       placeholder="contoh@email.com" required>
                            </div>
                            <div class="field-error" id="emailError"></div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-telephone"></i>
                                <input class="form-control" type="tel" id="phone"
                                       maxlength="16" autocomplete="tel"
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="field-error" id="phoneError"></div>
                            <div class="field-hint">Gunakan nomor aktif yang dapat dihubungi.</div>
                        </div>

                        <div class="form-group">
                            <label for="role">Jabatan</label>
                            <div class="input-wrap">
                                <i class="bi bi-person-badge"></i>
                                <input class="form-control" type="text" id="role"
                                       value="Petugas Operasional" disabled>
                            </div>
                            <div class="field-hint">Jabatan hanya dapat diubah oleh Administrator.</div>
                        </div>

                        <div class="form-group full">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address"
                                      maxlength="300"
                                      placeholder="Masukkan alamat tempat tinggal"></textarea>
                            <div class="field-error" id="addressError"></div>
                            <div class="field-hint">Maksimal 300 karakter.</div>
                        </div>

                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-secondary" type="reset" id="resetProfile">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>

                    <button class="btn btn-primary" type="submit" id="saveProfile">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

            <!-- KEAMANAN AKUN -->
            <form class="form-card" id="passwordForm" novalidate>
                <div class="form-heading">
                    <div class="heading-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h3>Keamanan Akun</h3>
                        <p>Perbarui password untuk menjaga keamanan akun petugas.</p>
                    </div>
                </div>

                <div class="form-body">
                    <div class="form-grid">

                        <div class="form-group full">
                            <label for="oldPassword">Password Lama <span class="required">*</span></label>
                            <div class="password-wrap">
                                <input class="form-control" type="password" id="oldPassword"
                                       autocomplete="current-password"
                                       placeholder="Masukkan password lama" required>
                                <button class="toggle-password" type="button"
                                        data-target="oldPassword" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="field-error" id="oldPasswordError"></div>
                        </div>

                        <div class="form-group">
                            <label for="newPassword">Password Baru <span class="required">*</span></label>
                            <div class="password-wrap">
                                <input class="form-control" type="password" id="newPassword"
                                       maxlength="72" autocomplete="new-password"
                                       placeholder="Minimal 8 karakter" required>
                                <button class="toggle-password" type="button"
                                        data-target="newPassword" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="field-error" id="newPasswordError"></div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Konfirmasi Password <span class="required">*</span></label>
                            <div class="password-wrap">
                                <input class="form-control" type="password" id="confirmPassword"
                                       maxlength="72" autocomplete="new-password"
                                       placeholder="Ulangi password baru" required>
                                <button class="toggle-password" type="button"
                                        data-target="confirmPassword" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="field-error" id="confirmPasswordError"></div>
                        </div>

                    </div>

                    <div class="security-note">
                        <i class="bi bi-info-circle"></i>
                        <span>
                            Gunakan password minimal 8 karakter. Kombinasikan huruf besar,
                            huruf kecil, angka, atau simbol agar akun lebih aman.
                        </span>
                    </div>
                </div>

                <div class="form-footer">
                    <button class="btn btn-secondary" type="reset" id="resetPassword">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>

                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-lock"></i> Ubah Password
                    </button>
                </div>
            </form>

        </div>
    </section>
</main>

<div class="toast" id="toast" role="status" aria-live="polite">
    <i class="bi bi-check-circle-fill"></i>
    <span id="toastMessage">Berhasil</span>
</div>

<script>
(() => {
    'use strict';

    @php
        $authUser = auth()->user();
        $serverProfile = $profileData ?? [
            'id' => $authUser?->id ?? 0,
            'name' => $authUser?->name ?? 'Petugas KosHaven',
            'email' => $authUser?->email ?? '',
            'phone' => $authUser?->phone ?? '',
        ];
    @endphp
    const serverProfile = @json($serverProfile);
    const PROFILE_KEY = 'koshaven_petugas_profile_u_' + String(serverProfile.id || 0);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";
    const updateProfileUrl = "{{ route('petugas.profil.update') }}";
    const updatePasswordUrl = "{{ route('petugas.profil.password') }}";

    const $ = selector => document.querySelector(selector);

    const defaultProfile = {
        name: serverProfile.name || 'Petugas KosHaven',
        email: serverProfile.email || '',
        phone: serverProfile.phone || '',
        address: '',
        photo: ''
    };

    let profile = loadProfile();
    let toastTimeout = null;

    function cloneDefault() {
        return { ...defaultProfile };
    }

    function loadProfile() {
        try {
            const saved = localStorage.getItem(PROFILE_KEY);
            const parsed = saved ? JSON.parse(saved) : {};

            return {
                ...defaultProfile,
                address: typeof parsed?.address === 'string' ? parsed.address : '',
                photo: typeof parsed?.photo === 'string' ? parsed.photo : ''
            };
        } catch (error) {
            return cloneDefault();
        }
    }

    function saveProfileData() {
        try {
            localStorage.setItem(PROFILE_KEY, JSON.stringify(profile));
            return true;
        } catch (error) {
            console.error('Gagal menyimpan profil:', error);
            showToast('Penyimpanan gagal. Periksa kapasitas browser.', false);
            return false;
        }
    }

    function getInitials(name) {
        const parts = String(name || '').trim().split(/\s+/).filter(Boolean);

        if (!parts.length) return 'PT';

        return parts.slice(0, 2)
            .map(part => part[0].toUpperCase())
            .join('');
    }

    function renderProfile() {
        $('#fullName').value = profile.name || '';
        $('#email').value = profile.email || '';
        $('#phone').value = profile.phone || '';
        $('#address').value = profile.address || '';

        $('#profileName').textContent = profile.name || 'Petugas Kos';
        $('#profileEmail').textContent = profile.email || '-';
        $('#profilePhone').textContent = profile.phone || '-';
        $('#sidebarName').textContent = profile.name || 'Petugas Kos';

        const initials = getInitials(profile.name);

        if (profile.photo) {
            const image = document.createElement('img');
            image.src = profile.photo;
            image.alt = 'Foto profil petugas';

            const sidebarImage = document.createElement('img');
            sidebarImage.src = profile.photo;
            sidebarImage.alt = 'Foto profil';

            $('#profilePhoto').replaceChildren(image);
            $('#sidebarAvatar').replaceChildren(sidebarImage);
        } else {
            const initial = document.createElement('span');
            initial.textContent = initials;

            $('#profilePhoto').replaceChildren(initial);
            $('#sidebarAvatar').textContent = initials;
        }
    }

    function showToast(message, success = true) {
        const toast = $('#toast');

        $('#toastMessage').textContent = message;
        toast.querySelector('i').className = success
            ? 'bi bi-check-circle-fill'
            : 'bi bi-exclamation-circle-fill';

        toast.classList.toggle('error', !success);
        toast.classList.add('show');

        clearTimeout(toastTimeout);

        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(error => {
            error.textContent = '';
            error.classList.remove('show');
        });

        form.querySelectorAll('.form-control').forEach(input => {
            input.removeAttribute('aria-invalid');
        });
    }

    function setError(inputId, errorId, message) {
        const input = $('#' + inputId);
        const error = $('#' + errorId);

        input.setAttribute('aria-invalid', 'true');
        error.textContent = message;
        error.classList.add('show');
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email);
    }

    function isValidPhone(phone) {
        return /^\+?[0-9]{9,15}$/.test(phone);
    }

    // SIMPAN INFORMASI PROFIL
    $('#profileForm').addEventListener('submit', event => {
        event.preventDefault();

        const form = event.currentTarget;
        clearErrors(form);

        const name = $('#fullName').value.trim().replace(/\s+/g, ' ');
        const email = $('#email').value.trim().toLowerCase();
        const phone = $('#phone').value.trim();
        const address = $('#address').value.trim();

        let valid = true;

        if (!name) {
            setError('fullName', 'nameError', 'Nama lengkap wajib diisi.');
            valid = false;
        } else if (name.length < 3) {
            setError('fullName', 'nameError', 'Nama lengkap minimal 3 karakter.');
            valid = false;
        } else if (name.length > 100) {
            setError('fullName', 'nameError', 'Nama maksimal 100 karakter.');
            valid = false;
        } else if (!/^[\p{L}\p{M} .'-]+$/u.test(name)) {
            setError('fullName', 'nameError', 'Nama hanya boleh berisi huruf dan tanda baca yang umum.');
            valid = false;
        }

        if (!email) {
            setError('email', 'emailError', 'Email wajib diisi.');
            valid = false;
        } else if (email.length > 150 || !isValidEmail(email)) {
            setError('email', 'emailError', 'Format email tidak valid.');
            valid = false;
        }

        if (!phone) {
            setError('phone', 'phoneError', 'Nomor telepon wajib diisi.');
            valid = false;
        } else if (!isValidPhone(phone)) {
            setError('phone', 'phoneError', 'Nomor harus berisi 9–15 digit dan boleh diawali +.');
            valid = false;
        }

        if (address.length > 300) {
            setError('address', 'addressError', 'Alamat maksimal 300 karakter.');
            valid = false;
        }

        if (!valid) {
            form.querySelector('[aria-invalid="true"]')?.focus();
            return;
        }

        fetch(updateProfileUrl, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ name, email, phone, address })
        })
        .then(async response => {
            const result = await response.json().catch(() => ({}));
            if (!response.ok) {
                const firstErr = result.errors ? Object.values(result.errors).flat()[0] : null;
                showToast(firstErr || result.message || 'Gagal memperbarui profil.', false);
                return;
            }

            profile.name = result.profile?.name ?? name;
            profile.email = result.profile?.email ?? email;
            profile.phone = result.profile?.phone ?? phone;
            profile.address = address;

            saveProfileData();
            renderProfile();
            showToast(result.message || 'Informasi profil berhasil diperbarui.');
        })
        .catch(() => {
            showToast('Terjadi gangguan jaringan saat menyimpan profil.', false);
        });
    });

    // RESET FORM PROFIL
    $('#resetProfile').addEventListener('click', () => {
        setTimeout(() => {
            renderProfile();
            clearErrors($('#profileForm'));
        }, 0);
    });

    // FOTO PROFIL
    $('#photoEditBtn').addEventListener('click', () => {
        $('#photoInput').click();
    });

    $('#photoInput').addEventListener('change', event => {
        const file = event.target.files?.[0];

        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 2 * 1024 * 1024;

        if (!allowedTypes.includes(file.type)) {
            showToast('Format foto harus JPG, PNG, atau WEBP.', false);
            event.target.value = '';
            return;
        }

        if (file.size > maxSize) {
            showToast('Ukuran foto maksimal 2 MB.', false);
            event.target.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = () => {
            if (typeof reader.result !== 'string') {
                showToast('Foto tidak dapat diproses.', false);
                event.target.value = '';
                return;
            }

            const previousPhoto = profile.photo;
            profile.photo = reader.result;

            if (!saveProfileData()) {
                profile.photo = previousPhoto;
                event.target.value = '';
                return;
            }

            renderProfile();
            showToast('Foto profil berhasil diperbarui.');
            event.target.value = '';
        };

        reader.onerror = () => {
            showToast('Foto gagal dibaca. Coba pilih file lain.', false);
            event.target.value = '';
        };

        reader.readAsDataURL(file);
    });

    // TAMPILKAN / SEMBUNYIKAN PASSWORD
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', () => {
            const input = $('#' + button.dataset.target);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
                button.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
                button.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    });

    // UBAH PASSWORD DEMO
    $('#passwordForm').addEventListener('submit', event => {
        event.preventDefault();

        const form = event.currentTarget;
        clearErrors(form);

        const oldPassword = $('#oldPassword').value;
        const newPassword = $('#newPassword').value;
        const confirmPassword = $('#confirmPassword').value;

        let valid = true;

        if (!oldPassword) {
            setError('oldPassword', 'oldPasswordError', 'Password lama wajib diisi.');
            valid = false;
        }

        if (!newPassword) {
            setError('newPassword', 'newPasswordError', 'Password baru wajib diisi.');
            valid = false;
        } else if (newPassword.length < 8) {
            setError('newPassword', 'newPasswordError', 'Password baru minimal 8 karakter.');
            valid = false;
        } else if (newPassword.length > 72) {
            setError('newPassword', 'newPasswordError', 'Password terlalu panjang.');
            valid = false;
        } else if (newPassword === oldPassword) {
            setError('newPassword', 'newPasswordError', 'Password baru harus berbeda dari password lama.');
            valid = false;
        }

        if (!confirmPassword) {
            setError('confirmPassword', 'confirmPasswordError', 'Konfirmasi password wajib diisi.');
            valid = false;
        } else if (newPassword !== confirmPassword) {
            setError('confirmPassword', 'confirmPasswordError', 'Konfirmasi password tidak cocok.');
            valid = false;
        }

        if (!valid) {
            form.querySelector('[aria-invalid="true"]')?.focus();
            return;
        }

        fetch(updatePasswordUrl, {
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
        })
        .then(async response => {
            const result = await response.json().catch(() => ({}));
            if (!response.ok) {
                if (result.errors?.current_password) {
                    setError('oldPassword', 'oldPasswordError', result.errors.current_password[0]);
                }
                const firstErr = result.errors ? Object.values(result.errors).flat()[0] : null;
                showToast(firstErr || result.message || 'Gagal memperbarui password.', false);
                return;
            }

            form.reset();
            clearErrors(form);

            form.querySelectorAll('.toggle-password i').forEach(icon => {
                icon.className = 'bi bi-eye';
            });

            showToast(result.message || 'Password berhasil diperbarui.');
        })
        .catch(() => {
            showToast('Terjadi gangguan jaringan saat mengubah password.', false);
        });
    });

    // RESET FORM PASSWORD
    $('#resetPassword').addEventListener('click', () => {
        setTimeout(() => {
            clearErrors($('#passwordForm'));

            $('#passwordForm').querySelectorAll('.toggle-password i').forEach(icon => {
                icon.className = 'bi bi-eye';
            });
        }, 0);
    });

    // HILANGKAN ERROR SAAT INPUT DIPERBAIKI
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', () => {
            input.removeAttribute('aria-invalid');

            const group = input.closest('.form-group');
            const error = group?.querySelector('.field-error');

            if (error) {
                error.textContent = '';
                error.classList.remove('show');
            }
        });
    });

    // SIDEBAR RESPONSIVE
    const sidebar = $('#sidebar');
    const overlay = $('#sidebarOverlay');
    const menuToggle = $('#menuToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        menuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    menuToggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            const logoutModal = document.getElementById('khLogoutModal');

            // Jangan ganggu popup logout yang sedang terbuka.
            if (logoutModal && logoutModal.classList.contains('is-visible')) {
                return;
            }

            closeSidebar();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });

    // TANGGAL
    $('#currentDate').textContent = new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date());

    // RENDER AWAL
    renderProfile();

})();
</script>

</body>
</html>
