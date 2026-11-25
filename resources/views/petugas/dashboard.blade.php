
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">
    <title>Dashboard Petugas - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-soft: #363E48;

            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --ivory: #F4F0E8;

            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7F8994;

            --green: #91AE9B;
            --yellow: #D9B77F;
            --red: #D58F8F;
            --blue: #91AFC7;

            --border: rgba(198, 164, 119, .15);
            --sidebar-width: 270px;
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;
            background: var(--bg-deep);
            color: var(--text);
            position: fixed;
            top: 0;
            left: 0;
            padding: 27px 18px 20px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
            overflow-y: auto;
            border-right: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 25px;
            border-bottom: 1px solid rgba(255,255,255,.09);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            background: rgba(198,164,119,.13);
            color: var(--gold-light);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 11px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            color: var(--gold-light);
            letter-spacing: -.5px;
        }

        .brand-subtitle {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.35px;
            color: var(--silver);
            margin-top: 4px;
        }

        .menu-label {
            font-size: 10px;
            color: var(--muted-dark);
            letter-spacing: 1.6px;
            padding: 27px 13px 13px;
            font-weight: 700;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #B9C0C8;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            transition: .2s ease;
            border-left: 3px solid transparent;
        }

        .nav-menu a i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: rgba(198,164,119,.12);
            color: var(--gold-light);
            border-left-color: var(--gold);
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.09);
            padding-top: 8px;
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px 8px 5px;
            margin-top: 8px;
        }

        .profile-avatar {
            width: 39px;
            height: 39px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            color: var(--bg-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .profile-info {
            min-width: 0;
        }

        .profile-info strong {
            display: block;
            font-size: 12px;
            color: var(--text);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-info span {
            font-size: 10px;
            color: var(--muted);
        }

        .sidebar-overlay {
            display: none;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            min-width: 0;
        }

        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            min-height: 78px;
            background: rgba(25,29,34,.96);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .page-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--ivory);
        }

        .page-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 4px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .date-display {
            font-size: 11px;
            color: var(--silver-light);
            white-space: nowrap;
        }

        .notification {
            width: 39px;
            height: 39px;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 50%;
            color: var(--gold-light);
            font-size: 16px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: .2s;
        }

        .notification:hover {
            background: var(--surface-light);
            border-color: var(--gold);
        }

        .notification-dot {
            width: 7px;
            height: 7px;
            background: var(--red);
            border: 1px solid var(--bg);
            border-radius: 50%;
            position: absolute;
            top: 6px;
            right: 6px;
        }

        .mobile-menu {
            display: none;
            border: none;
            background: transparent;
            color: var(--gold-light);
            font-size: 25px;
            cursor: pointer;
            padding: 4px;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            width: 100%;
            max-width: 1650px;
            margin: 0 auto;
            padding: 32px 35px;
        }

        /* WELCOME */

        .welcome-card {
            background:
                radial-gradient(circle at 90% 20%, rgba(198,164,119,.16), transparent 30%),
                linear-gradient(115deg, #292F36, #343B43 65%, #3A3E42);
            border: 1px solid rgba(198,164,119,.22);
            border-radius: var(--radius);
            padding: 29px 31px;
            color: var(--text);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            overflow: hidden;
            position: relative;
        }

        .welcome-card::after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            border: 1px solid rgba(224,196,155,.1);
            border-radius: 50%;
            right: 50px;
            top: -115px;
            pointer-events: none;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--gold-light);
            font-size: 9px;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 11px;
        }

        .welcome-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 600;
            margin-bottom: 9px;
            color: var(--ivory);
        }

        .welcome-card p {
            font-size: 12px;
            color: #C2C7CC;
            line-height: 1.8;
            max-width: 570px;
        }

        .welcome-icon {
            font-size: 70px;
            color: rgba(224,196,155,.55);
            padding: 0 25px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        /* SECTION TITLE */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--ivory);
        }

        .section-subtitle {
            color: var(--muted);
            font-size: 10px;
            margin-top: 5px;
        }

        /* STATISTICS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 125px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.38);
        }

        .stat-info {
            min-width: 0;
        }

        .stat-info span {
            display: block;
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .stat-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 600;
            color: var(--ivory);
            overflow-wrap: anywhere;
        }

        .stat-info small {
            display: block;
            font-size: 10px;
            color: var(--muted-dark);
            margin-top: 6px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }

        .icon-green {
            background: rgba(145,174,155,.14);
            color: var(--green);
        }

        .icon-gold {
            background: rgba(198,164,119,.15);
            color: var(--gold-light);
        }

        .icon-blue {
            background: rgba(145,175,199,.14);
            color: var(--blue);
        }

        .icon-red {
            background: rgba(213,143,143,.14);
            color: var(--red);
        }

        /* PANELS */

        .content-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .panel,
        .table-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 23px;
            min-width: 0;
        }

        .table-panel {
            margin-bottom: 22px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 21px;
        }

        .panel-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--ivory);
        }

        .panel-header a {
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s;
        }

        .panel-header a:hover {
            color: white;
        }

        /* ROOM SUMMARY */

        .room-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .room-box {
            padding: 19px 10px;
            border-radius: 9px;
            text-align: center;
            border: 1px solid transparent;
        }

        .room-box strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .room-box span {
            font-size: 10px;
        }

        .room-occupied {
            background: rgba(145,174,155,.11);
            color: var(--green);
            border-color: rgba(145,174,155,.13);
        }

        .room-empty {
            background: rgba(217,183,127,.11);
            color: var(--yellow);
            border-color: rgba(217,183,127,.13);
        }

        .room-maintenance {
            background: rgba(213,143,143,.11);
            color: var(--red);
            border-color: rgba(213,143,143,.13);
        }

        /* PROGRESS */

        .room-progress {
            margin-top: 24px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 10px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .progress-label strong {
            color: var(--gold-light);
        }

        .progress-bar {
            height: 8px;
            background: var(--surface-soft);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 75%;
            background: linear-gradient(90deg, #9C8059, var(--gold-light));
            border-radius: 20px;
        }

        /* ACTIVITY */

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .task-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .task-item:first-child {
            padding-top: 0;
        }

        .task-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .task-icon {
            width: 37px;
            height: 37px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(198,164,119,.12);
            color: var(--gold-light);
            flex-shrink: 0;
            font-size: 16px;
        }

        .task-info {
            min-width: 0;
        }

        .task-info strong {
            display: block;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text);
        }

        .task-info span {
            font-size: 10px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            scrollbar-width: thin;
            scrollbar-color: var(--surface-soft) transparent;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 610px;
        }

        th {
            background: #2B3139;
            color: var(--silver);
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .5px;
            padding: 14px 13px;
            white-space: nowrap;
        }

        th:first-child {
            border-radius: 7px 0 0 7px;
        }

        th:last-child {
            border-radius: 0 7px 7px 0;
        }

        td {
            padding: 15px 13px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            font-size: 10px;
            color: var(--silver-light);
            white-space: nowrap;
        }

        tbody tr {
            transition: background .2s;
        }

        tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .tenant-name {
            font-weight: 700;
            color: var(--ivory);
        }

        /* STATUS */

        .status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-paid {
            background: rgba(145,174,155,.14);
            color: var(--green);
        }

        .status-unpaid {
            background: rgba(213,143,143,.14);
            color: var(--red);
        }

        .status-process {
            background: rgba(217,183,127,.14);
            color: var(--yellow);
        }

        /* FOOTER */

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 10px;
            padding: 17px 0 5px;
            border-top: 1px solid rgba(255,255,255,.06);
            margin-top: 8px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1250px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            :root {
                --sidebar-width: 270px;
            }

            .sidebar {
                transform: translateX(-100%);
                box-shadow: 15px 0 40px rgba(0,0,0,.25);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.58);
                z-index: 90;
                opacity: 0;
                visibility: hidden;
                transition: .3s;
                display: block;
            }

            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu {
                display: block;
            }

            .topbar {
                padding: 0 25px;
            }

            .content {
                padding: 28px 25px;
            }
        }

        @media (max-width: 600px) {
            .topbar {
                min-height: 68px;
                padding: 0 16px;
            }

            .topbar-left {
                gap: 10px;
            }

            .page-heading h1 {
                font-size: 18px;
            }

            .page-heading p {
                display: none;
            }

            .topbar-right {
                gap: 9px;
            }

            .date-display {
                display: none;
            }

            .notification {
                width: 36px;
                height: 36px;
            }

            .content {
                padding: 22px 15px;
            }

            .welcome-card {
                padding: 23px 20px;
                margin-bottom: 25px;
            }

            .welcome-card h2 {
                font-size: 21px;
            }

            .welcome-card p {
                font-size: 10px;
            }

            .welcome-icon {
                font-size: 43px;
                padding: 0;
            }

            .welcome-card::after {
                right: -70px;
            }

            .section-title {
                font-size: 18px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 11px;
                margin-bottom: 25px;
            }

            .stat-card {
                min-height: 100px;
                padding: 17px;
            }

            .stat-info h3 {
                font-size: 24px;
            }

            .stat-icon {
                width: 41px;
                height: 41px;
                font-size: 17px;
            }

            .content-grid {
                gap: 15px;
                margin-bottom: 20px;
            }

            .panel,
            .table-panel {
                padding: 17px;
            }

            .panel-header {
                align-items: flex-start;
                margin-bottom: 17px;
            }

            .panel-header h3 {
                font-size: 16px;
            }

            .panel-header a {
                font-size: 9px;
                padding-top: 4px;
            }

            .room-summary {
                gap: 7px;
            }

            .room-box {
                padding: 15px 5px;
            }

            .room-box strong {
                font-size: 23px;
            }

            .room-box span {
                font-size: 9px;
            }

            .footer {
                font-size: 9px;
                line-height: 1.7;
            }
        }

        @media (max-width: 380px) {
            .welcome-card {
                padding: 20px 16px;
            }

            .welcome-card h2 {
                font-size: 18px;
            }

            .welcome-icon {
                font-size: 35px;
            }

            .room-summary {
                grid-template-columns: 1fr;
            }

            .room-box {
                padding: 13px;
            }

            .room-box strong {
                font-size: 21px;
            }

            .panel,
            .table-panel {
                padding: 14px;
            }

            .panel-header h3 {
                font-size: 14px;
            }
        }

        /* REDUCED MOTION */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-house-heart-fill"></i>
            </div>

            <div>
                <div class="brand-name">KosHaven.</div>
                <span class="brand-subtitle">BOARDING HOUSE MANAGEMENT</span>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="nav-menu" aria-label="Navigasi utama">

            <a href="{{ route('petugas.dashboard') }}" class="active" aria-current="page">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('petugas.kamar.index') }}">
                <i class="bi bi-door-open"></i>
                Data Kamar
            </a>

            <a href="{{ route('petugas.penghuni.index') }}">
                <i class="bi bi-people"></i>
                Data Penghuni
            </a>

            <a href="{{ route('petugas.tagihan.index') }}">
                <i class="bi bi-receipt"></i>
                Tagihan Bulanan
            </a>

            <a href="{{ route('petugas.pembayaran.index') }}">
                <i class="bi bi-wallet2"></i>
                Pembayaran
            </a>

            <a href="{{ route('petugas.aktivitas.index') }}">
                <i class="bi bi-clock-history"></i>
                Aktivitas
            </a>

        </nav>

        <div class="sidebar-bottom">

            <div class="menu-label">AKUN</div>

            <nav class="nav-menu" aria-label="Navigasi akun">

                <a href="#profil">
                    <i class="bi bi-person-circle"></i>
                    Profil Saya
                </a>

                <a href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-left"></i>
                    Keluar
                </a>

            </nav>

            <div class="profile-mini">
                <div class="profile-avatar">P</div>

                <div class="profile-info">
                    <strong>Petugas Kos</strong>
                    <span>Petugas</span>
                </div>
            </div>

        </div>

    </aside>

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
        onclick="closeSidebar()"
        aria-hidden="true">
    </div>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button
                    class="mobile-menu"
                    id="mobileMenu"
                    type="button"
                    onclick="toggleSidebar()"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false"
                    aria-controls="sidebar">

                    <i class="bi bi-list"></i>
                </button>

                <div class="page-heading">
                    <h1>Dashboard Petugas</h1>
                    <p>Panel operasional KosHaven</p>
                </div>

            </div>

            <div class="topbar-right">

                <span class="date-display" id="currentDate"></span>

                <button
                    class="notification"
                    type="button"
                    title="Notifikasi"
                    onclick="showNotification()"
                    aria-label="Lihat notifikasi">

                    <i class="bi bi-bell"></i>
                    <span class="notification-dot"></span>
                </button>

            </div>

        </header>

        <div class="content">

            <!-- WELCOME -->
            <section class="welcome-card">

                <div class="welcome-content">

                    <div class="welcome-label">
                        <i class="bi bi-stars"></i>
                        PETUGAS KOSHAVEN
                    </div>

                    <h2>Selamat Datang, Petugas!</h2>

                    <p>
                        Pantau aktivitas kos, kelola informasi penghuni,
                        dan bantu operasional KosHaven hari ini.
                        Pastikan seluruh kegiatan berjalan dengan baik.
                    </p>

                </div>

                <div class="welcome-icon" aria-hidden="true">
                    <i class="bi bi-buildings"></i>
                </div>

            </section>

            <!-- STATISTIK -->
            <section aria-labelledby="statisticsTitle">

                <div class="section-heading">
                    <div>
                        <h2 class="section-title" id="statisticsTitle">
                            Ringkasan Operasional
                        </h2>
                        <p class="section-subtitle">
                            Gambaran umum kondisi kos saat ini
                        </p>
                    </div>
                </div>

                <div class="stats-grid">

                    <div class="stat-card">
                        <div class="stat-info">
                            <span>Total Kamar</span>
                            <h3>24</h3>
                            <small>Seluruh kamar kos</small>
                        </div>

                        <div class="stat-icon icon-green">
                            <i class="bi bi-door-closed"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <span>Total Penghuni</span>
                            <h3>18</h3>
                            <small>Penghuni terdaftar</small>
                        </div>

                        <div class="stat-icon icon-blue">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <span>Tagihan Belum Dibayar</span>
                            <h3>12</h3>
                            <small>Perlu dipantau</small>
                        </div>

                        <div class="stat-icon icon-red">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-info">
                            <span>Pembayaran Diterima</span>
                            <h3>6</h3>
                            <small>Pembayaran bulan ini</small>
                        </div>

                        <div class="stat-icon icon-gold">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>

                </div>

            </section>

            <!-- STATUS KAMAR DAN AKTIVITAS -->
            <section class="content-grid">

                <!-- STATUS KAMAR -->
                <div class="panel" id="data-kamar">

                    <div class="panel-header">
                        <h3>Status Kamar</h3>

                        <a href="{{ route('petugas.kamar.index') }}">
                            Lihat Detail
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>

                    <div class="room-summary">

                        <div class="room-box room-occupied">
                            <strong>18</strong>
                            <span>Terisi</span>
                        </div>

                        <div class="room-box room-empty">
                            <strong>4</strong>
                            <span>Kosong</span>
                        </div>

                        <div class="room-box room-maintenance">
                            <strong>2</strong>
                            <span>Perbaikan</span>
                        </div>

                    </div>

                    <div class="room-progress">

                        <div class="progress-label">
                            <span>Persentase Kamar Terisi</span>
                            <strong>75%</strong>
                        </div>

                        <div
                            class="progress-bar"
                            role="progressbar"
                            aria-label="Persentase kamar terisi"
                            aria-valuenow="75"
                            aria-valuemin="0"
                            aria-valuemax="100">

                            <div class="progress-fill"></div>

                        </div>

                    </div>

                </div>

                <!-- AKTIVITAS TERBARU -->
                <div class="panel" id="aktivitas">

                    <div class="panel-header">
                        <h3>Aktivitas Terbaru</h3>

                        <a href="{{ route('petugas.aktivitas.index') }}">
                            Lihat Semua
                            <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>

                    <div class="task-list">

                        <div class="task-item">

                            <div class="task-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>

                            <div class="task-info">
                                <strong>Penghuni Baru Terdaftar</strong>
                                <span>Andi Pratama · Kamar A-03</span>
                            </div>

                        </div>

                        <div class="task-item">

                            <div class="task-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>

                            <div class="task-info">
                                <strong>Pembayaran Diterima</strong>
                                <span>Rp1.200.000 · Kamar B-02</span>
                            </div>

                        </div>

                        <div class="task-item">

                            <div class="task-icon">
                                <i class="bi bi-tools"></i>
                            </div>

                            <div class="task-info">
                                <strong>Pemeliharaan Kamar</strong>
                                <span>Kamar C-01 sedang diperbaiki</span>
                            </div>

                        </div>

                    </div>

                </div>

            </section>

            <!-- DATA PENGHUNI -->
            <section class="table-panel" id="data-penghuni">

                <div class="panel-header">
                    <h3>Data Penghuni Terbaru</h3>

                    <a href="{{ route('petugas.penghuni.index') }}">
                        Lihat Semua
                        <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>NAMA PENGHUNI</th>
                                <th>KAMAR</th>
                                <th>NOMOR HP</th>
                                <th>TANGGAL MASUK</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td class="tenant-name">Andi Pratama</td>
                                <td>A-03</td>
                                <td>0812-xxxx-1234</td>
                                <td>01 Nov 2026</td>
                                <td>
                                    <span class="status status-paid">Aktif</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tenant-name">Siti Rahma</td>
                                <td>A-05</td>
                                <td>0813-xxxx-5678</td>
                                <td>03 Nov 2026</td>
                                <td>
                                    <span class="status status-paid">Aktif</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tenant-name">Budi Santoso</td>
                                <td>B-02</td>
                                <td>0821-xxxx-9012</td>
                                <td>05 Nov 2026</td>
                                <td>
                                    <span class="status status-paid">Aktif</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tenant-name">Dewi Lestari</td>
                                <td>B-04</td>
                                <td>0852-xxxx-3456</td>
                                <td>08 Nov 2026</td>
                                <td>
                                    <span class="status status-paid">Aktif</span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </section>

            <!-- TAGIHAN BULANAN -->
            <section class="table-panel" id="tagihan">

                <div class="panel-header">
                    <h3>Pemantauan Tagihan Bulanan</h3>

                    <a href="{{ route('petugas.tagihan.index') }}">
                        Lihat Semua
                        <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>NAMA PENGHUNI</th>
                                <th>KAMAR</th>
                                <th>JUMLAH TAGIHAN</th>
                                <th>JATUH TEMPO</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td class="tenant-name">Andi Pratama</td>
                                <td>A-03</td>
                                <td>Rp1.200.000</td>
                                <td>05 Nov 2026</td>
                                <td>
                                    <span class="status status-paid">Lunas</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tenant-name">Siti Rahma</td>
                                <td>A-05</td>
                                <td>Rp1.000.000</td>
                                <td>10 Nov 2026</td>
                                <td>
                                    <span class="status status-unpaid">Belum Bayar</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tenant-name">Budi Santoso</td>
                                <td>B-02</td>
                                <td>Rp1.200.000</td>
                                <td>12 Nov 2026</td>
                                <td>
                                    <span class="status status-process">Menunggu Konfirmasi</span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </section>

            <!-- FOOTER -->
            <footer class="footer">
                © 2026 KosHaven. Hunian Nyaman, Hidup Lebih Tenang.
            </footer>

        </div>

    </main>

    <script>
        /* =========================
           TANGGAL OTOMATIS
        ========================= */

        function updateDate() {
            const dateElement = document.getElementById('currentDate');

            if (!dateElement) return;

            const today = new Date();

            dateElement.textContent = today.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        updateDate();

        /* =========================
           SIDEBAR MOBILE
        ========================= */

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileMenu = document.getElementById('mobileMenu');

        function toggleSidebar() {
            if (!sidebar || !sidebarOverlay) return;

            const isOpen = sidebar.classList.contains('show');

            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
                document.body.classList.add('sidebar-open');

                if (mobileMenu) {
                    mobileMenu.setAttribute('aria-expanded', 'true');
                    mobileMenu.setAttribute('aria-label', 'Tutup menu navigasi');
                }
            }
        }

        function closeSidebar() {
            if (!sidebar || !sidebarOverlay) return;

            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('sidebar-open');

            if (mobileMenu) {
                mobileMenu.setAttribute('aria-expanded', 'false');
                mobileMenu.setAttribute('aria-label', 'Buka menu navigasi');
            }
        }

        /* =========================
           MENU SIDEBAR
        ========================= */

        const menuLinks = document.querySelectorAll('.nav-menu a');

        menuLinks.forEach(link => {
            link.addEventListener('click', function() {

                if (window.innerWidth <= 900) {
                    closeSidebar();
                }

            });
        });

        /* =========================
           NOTIFIKASI
        ========================= */

        function showNotification() {
            alert('Belum ada notifikasi baru.');
        }

        /* =========================
           TUTUP SIDEBAR DENGAN ESCAPE
        ========================= */

        document.addEventListener('keydown', function(event) {

            if (event.key === 'Escape') {
                closeSidebar();
            }

        });

        /* =========================
           RESPONSIVE SIDEBAR
        ========================= */

        window.addEventListener('resize', function() {

            if (window.innerWidth > 900) {
                closeSidebar();
            }

        });
    </script>

</body>
</html>
