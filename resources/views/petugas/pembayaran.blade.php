
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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
            --border: rgba(198,164,119,.15);
            --success: #91AE9B;
            --success-bg: rgba(145,174,155,.13);
            --warning: #D9B77F;
            --warning-bg: rgba(217,183,127,.13);
            --danger: #D58F8F;
            --danger-bg: rgba(213,143,143,.13);
            --shadow: 0 12px 35px rgba(0,0,0,.14);
            --sidebar-width: 270px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        body, button, input, select, textarea {
            font-family: 'DM Sans', sans-serif;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button { cursor: pointer; }

        a {
            color: inherit;
            text-decoration: none;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background: var(--bg-deep);
            color: var(--text);
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border);
            transition: transform .3s ease;
        }

        .brand {
            padding: 27px 25px 24px;
            border-bottom: 1px solid var(--border);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .brand-name span { color: var(--gold); }

        .brand small {
            display: block;
            margin-top: 5px;
            color: var(--silver);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-label {
            padding: 25px 25px 10px;
            color: var(--silver);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 0 13px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 9px;
            color: #B9C0C7;
            font-size: 13px;
            font-weight: 500;
            transition: .2s;
        }

        .nav-link i {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }

        .nav-link:hover {
            color: var(--ivory);
            background: rgba(255,255,255,.06);
        }

        .nav-link.active {
            color: var(--gold-light);
            background: rgba(198,164,119,.12);
            border-left: 3px solid var(--gold);
            padding-left: 11px;
        }

        .sidebar-bottom {
            padding: 16px;
            border-top: 1px solid var(--border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 7px 15px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--gold);
            color: var(--bg-deep);
            font-weight: 700;
            font-size: 14px;
        }

        .user-info strong {
            display: block;
            font-size: 12px;
            color: var(--text);
        }

        .user-info small {
            color: var(--silver);
            font-size: 10px;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 13px;
            border: 1px solid rgba(213,143,143,.2);
            border-radius: 8px;
            background: transparent;
            color: var(--danger);
            font-size: 12px;
            text-align: left;
            transition: .2s;
        }

        .logout-btn:hover {
            background: var(--danger-bg);
        }

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 30px 35px 45px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 30px;
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
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .breadcrumb span {
            color: var(--gold);
            margin: 0 6px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--ivory);
            font-size: 28px;
            font-weight: 700;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--silver-light);
            font-size: 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 10px 14px;
            border-radius: 9px;
        }

        .topbar-date i { color: var(--gold); }

        .intro { margin-bottom: 23px; }

        .intro h2 {
            font-size: 16px;
            font-weight: 700;
            color: var(--ivory);
            margin-bottom: 5px;
        }

        .intro p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.7;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 19px;
            box-shadow: var(--shadow);
            min-width: 0;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: grid;
            place-items: center;
            font-size: 17px;
        }

        .icon-total {
            background: rgba(198,164,119,.13);
            color: var(--gold);
        }

        .icon-pending {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .icon-approved {
            background: var(--success-bg);
            color: var(--success);
        }

        .icon-rejected {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .stat-value {
            color: var(--ivory);
            font-size: 25px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .stat-note {
            color: var(--muted);
            font-size: 10px;
            margin-top: 5px;
        }

        .content-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-heading {
            padding: 21px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .card-heading h3 {
            color: var(--ivory);
            font-size: 15px;
            font-weight: 700;
        }

        .card-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 4px;
        }

        .record-count {
            background: rgba(198,164,119,.13);
            color: var(--gold-light);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 6px 11px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .filters {
            padding: 17px 22px;
            display: flex;
            align-items: center;
            gap: 11px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--border);
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 210px;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--silver);
            font-size: 14px;
        }

        .search-box input,
        .filter-select {
            width: 100%;
            height: 39px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            background: var(--bg);
            color: var(--text);
            font-size: 11px;
            transition: .2s;
        }

        .search-box input { padding: 0 12px 0 37px; }

        .search-box input::placeholder { color: #7F8993; }

        .filter-select {
            width: 185px;
            padding: 0 10px;
        }

        .search-box input:focus,
        .filter-select:focus,
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .filter-select option {
            background: var(--surface);
            color: var(--text);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead { background: var(--surface-light); }

        th {
            color: var(--silver);
            font-size: 10px;
            font-weight: 700;
            text-align: left;
            padding: 14px 17px;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        td {
            padding: 15px 17px;
            border-bottom: 1px solid rgba(255,255,255,.045);
            font-size: 11px;
            color: var(--silver-light);
            vertical-align: middle;
        }

        tbody tr { transition: .2s; }
        tbody tr:hover { background: rgba(255,255,255,.025); }

        .tenant-name {
            color: var(--ivory);
            font-weight: 700;
            font-size: 11px;
        }

        .sub-text {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-top: 4px;
        }

        .amount {
            color: var(--gold-light);
            font-weight: 700;
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status.pending {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .status.approved {
            background: var(--success-bg);
            color: var(--success);
        }

        .status.rejected {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--surface-light);
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
            transition: .2s;
        }

        .action-btn:hover {
            background: rgba(198,164,119,.13);
            border-color: var(--gold);
        }

        .empty-state {
            text-align: center;
            padding: 45px 15px;
            color: var(--muted);
            font-size: 12px;
        }

        .empty-state i {
            display: block;
            font-size: 30px;
            margin-bottom: 10px;
            color: var(--silver);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 15px 22px;
            color: var(--muted);
            font-size: 10px;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(0,0,0,.72);
            padding: 20px;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .modal-overlay.show { display: flex; }

        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 570px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,.4);
            animation: modalIn .2s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 19px 22px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            color: var(--ivory);
            font-size: 19px;
        }

        .close-modal {
            border: none;
            background: transparent;
            color: var(--silver);
            font-size: 21px;
        }

        .close-modal:hover { color: var(--gold); }

        .modal-body { padding: 22px; }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .detail-item small {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-bottom: 5px;
        }

        .detail-item strong {
            color: var(--ivory);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .detail-divider {
            border: 0;
            border-top: 1px solid var(--border);
            margin: 20px 0;
        }

        .proof-title {
            color: var(--ivory);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .proof-placeholder {
            min-height: 150px;
            border: 1px dashed rgba(198,164,119,.35);
            border-radius: 10px;
            background: rgba(255,255,255,.025);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--muted);
            text-align: center;
            padding: 20px;
            font-size: 11px;
        }

        .proof-placeholder i {
            color: var(--gold);
            font-size: 30px;
        }

        .proof-placeholder strong { color: var(--silver-light); }

        .reason-box {
            display: none;
            margin-top: 18px;
        }

        .reason-box.show { display: block; }

        .reason-box label {
            display: block;
            color: var(--ivory);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 11px;
            outline: none;
            resize: vertical;
            background: var(--bg);
            color: var(--text);
        }

        .form-control::placeholder { color: #7F8993; }

        .form-error {
            display: none;
            color: var(--danger);
            font-size: 10px;
            margin-top: 5px;
        }

        .form-error.show { display: block; }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 17px 22px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .btn {
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-secondary {
            background: var(--surface-light);
            border-color: var(--border);
            color: var(--silver-light);
        }

        .btn-secondary:hover { background: var(--surface-soft); }

        .btn-success {
            background: rgba(145,174,155,.18);
            border-color: rgba(145,174,155,.3);
            color: var(--success);
        }

        .btn-success:hover { background: rgba(145,174,155,.27); }

        .btn-danger {
            background: rgba(213,143,143,.15);
            border-color: rgba(213,143,143,.3);
            color: var(--danger);
        }

        .btn-danger:hover { background: rgba(213,143,143,.24); }

        .btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 3000;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: calc(100% - 40px);
            padding: 13px 17px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--bg-deep);
            color: var(--text);
            font-size: 11px;
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
            font-size: 16px;
        }

        .sidebar-overlay { display: none; }

        @media (max-width: 1100px) {
            .main { padding: 25px 22px 40px; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 999;
                background: rgba(0,0,0,.6);
            }

            .main {
                margin-left: 0;
                padding: 20px 17px 35px;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }

            .page-title { font-size: 23px; }
            .topbar-date { display: none; }

            .card-heading,
            .filters {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        @media (max-width: 480px) {
            .main { padding: 16px 12px 30px; }
            .topbar { margin-bottom: 23px; }
            .page-title { font-size: 21px; }
            .breadcrumb { font-size: 10px; }

            .stats-grid { gap: 10px; }

            .stat-card { padding: 14px; }
            .stat-value { font-size: 21px; }
            .stat-label { font-size: 10px; }

            .stat-icon {
                width: 31px;
                height: 31px;
                font-size: 15px;
            }

            .filters { align-items: stretch; }

            .search-box,
            .filter-select {
                width: 100%;
                min-width: 100%;
            }

            .card-heading { align-items: flex-start; }
            .record-count { font-size: 9px; }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .modal-overlay { padding: 10px; }

            .modal { max-height: calc(100vh - 20px); }
            .modal-body { padding: 17px; }

            .modal-header,
            .modal-actions {
                padding-left: 17px;
                padding-right: 17px;
            }

            .modal-actions .btn { flex: 1; }

            .table-footer {
                padding: 13px 15px;
                flex-direction: column;
            }

            .toast {
                right: 12px;
                bottom: 12px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
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
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('petugas.kamar.index') }}" class="nav-link">
                <i class="bi bi-door-closed"></i>
                Data Kamar
            </a>

            <a href="{{ route('petugas.penghuni.index') }}" class="nav-link">
                <i class="bi bi-people"></i>
                Data Penghuni
            </a>

            <a href="{{ route('petugas.tagihan.index') }}" class="nav-link">
                <i class="bi bi-receipt"></i>
                Tagihan Bulanan
            </a>

            <a href="{{ route('petugas.pembayaran.index') }}" class="nav-link active" aria-current="page">
                <i class="bi bi-wallet2"></i>
                Pembayaran
            </a>

            <a href="{{ route('petugas.aktivitas.index') }}" class="nav-link">
                <i class="bi bi-clock-history"></i>
                Aktivitas
            </a>

            <div class="sidebar-label">Akun</div>

            <a href="{{ route('petugas.profil.index') }}" class="nav-link">
                <i class="bi bi-person-circle"></i>
                Profil Saya
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="user-card">
                <div class="avatar">PT</div>
                <div class="user-info">
                    <strong>Petugas Kos</strong>
                    <small>Staff Operasional</small>
                </div>
            </div>

            <button class="logout-btn" id="logoutBtn" type="button">
                <i class="bi bi-box-arrow-left"></i>
                Keluar dari akun
            </button>
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
                    <div class="breadcrumb">Menu Utama <span>/</span> Pembayaran</div>
                    <h1 class="page-title">Data Pembayaran</h1>
                </div>
            </div>

            <div class="topbar-date">
                <i class="bi bi-calendar3"></i>
                <span id="currentDate"></span>
            </div>
        </header>

        <section class="intro">
            <h2>Kelola Pembayaran Penghuni</h2>
            <p>Periksa transaksi pembayaran, lihat bukti pembayaran, dan lakukan verifikasi pembayaran penghuni.</p>
        </section>

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Pembayaran</span>
                    <div class="stat-icon icon-total"><i class="bi bi-wallet2"></i></div>
                </div>
                <div class="stat-value" id="totalPayments">0</div>
                <div class="stat-note">Seluruh transaksi tercatat</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Menunggu Verifikasi</span>
                    <div class="stat-icon icon-pending"><i class="bi bi-hourglass-split"></i></div>
                </div>
                <div class="stat-value" id="pendingPayments">0</div>
                <div class="stat-note">Perlu diperiksa petugas</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Disetujui</span>
                    <div class="stat-icon icon-approved"><i class="bi bi-check-circle"></i></div>
                </div>
                <div class="stat-value" id="approvedPayments">0</div>
                <div class="stat-note">Transaksi berhasil diverifikasi</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Ditolak</span>
                    <div class="stat-icon icon-rejected"><i class="bi bi-x-circle"></i></div>
                </div>
                <div class="stat-value" id="rejectedPayments">0</div>
                <div class="stat-note">Transaksi yang tidak disetujui</div>
            </div>
        </section>

        <section class="content-card">
            <div class="card-heading">
                <div>
                    <h3>Riwayat Pembayaran</h3>
                    <p>Daftar pembayaran yang dikirimkan oleh penghuni kos.</p>
                </div>
                <span class="record-count" id="recordCount">0 Transaksi</span>
            </div>

            <div class="filters">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="search" id="searchInput"
                           placeholder="Cari nama penghuni atau kamar..."
                           aria-label="Cari pembayaran">
                </div>

                <select class="filter-select" id="statusFilter" aria-label="Filter status pembayaran">
                    <option value="Semua">Semua Status</option>
                    <option value="Menunggu">Menunggu Verifikasi</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Penghuni</th>
                            <th>Kamar</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="paymentTableBody"></tbody>
                </table>
            </div>

            <div class="table-footer">
                <span id="tableInfo">Menampilkan 0 transaksi</span>
                <span>Data pembayaran KosHaven</span>
            </div>
        </section>
    </main>

    <!-- Detail Pembayaran -->
    <div class="modal-overlay" id="detailModal" role="dialog"
         aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalTitle">Detail Pembayaran</h3>
                <button class="close-modal" type="button" id="closeModal"
                        aria-label="Tutup modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <small>Nama Penghuni</small>
                        <strong id="detailName">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Nomor Kamar</small>
                        <strong id="detailRoom">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Periode Tagihan</small>
                        <strong id="detailPeriod">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Jumlah Pembayaran</small>
                        <strong id="detailAmount">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Tanggal Pembayaran</small>
                        <strong id="detailDate">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Metode Pembayaran</small>
                        <strong id="detailMethod">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Nomor Referensi</small>
                        <strong id="detailReference">-</strong>
                    </div>
                    <div class="detail-item">
                        <small>Status Pembayaran</small>
                        <strong id="detailStatus">-</strong>
                    </div>
                </div>

                <hr class="detail-divider">

                <div class="proof-title">Bukti Pembayaran</div>
                <div class="proof-placeholder" id="proofContainer">
                    <i class="bi bi-image"></i>
                    <strong>Bukti pembayaran demo</strong>
                    <span>File bukti pembayaran asli akan ditampilkan setelah terhubung dengan backend.</span>
                </div>

                <div class="reason-box" id="reasonBox">
                    <label for="rejectionReason">
                        Alasan Penolakan <span style="color:var(--danger)">*</span>
                    </label>
                    <textarea class="form-control" id="rejectionReason" rows="3"
                              maxlength="300"
                              placeholder="Tuliskan alasan penolakan pembayaran..."
                              aria-describedby="reasonError"></textarea>
                    <div class="form-error" id="reasonError">
                        Alasan penolakan wajib diisi minimal 5 karakter.
                    </div>
                </div>
            </div>

            <div class="modal-actions" id="modalActions">
                <button class="btn btn-secondary" type="button" id="cancelModal">Tutup</button>
                <button class="btn btn-danger" type="button" id="rejectBtn">
                    <i class="bi bi-x-circle"></i> Tolak
                </button>
                <button class="btn btn-success" type="button" id="approveBtn">
                    <i class="bi bi-check-circle"></i> Setujui
                </button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMessage">Berhasil</span>
    </div>

    <script>
        (() => {
            'use strict';

            const STORAGE_KEY = 'koshaven_petugas_payments_v1';
            const ACTIVITY_KEY = 'koshaven_petugas_activities_v1';

            const initialPayments = [
                {
                    id: 'PAY-001',
                    name: 'Andi Pratama',
                    room: 'A-01',
                    period: 'November 2026',
                    amount: 1200000,
                    date: '2026-11-23',
                    method: 'Transfer Bank',
                    reference: 'TRX-20261123-001',
                    status: 'Menunggu',
                    reason: ''
                },
                {
                    id: 'PAY-002',
                    name: 'Siti Rahma',
                    room: 'A-02',
                    period: 'November 2026',
                    amount: 1200000,
                    date: '2026-11-22',
                    method: 'Transfer Bank',
                    reference: 'TRX-20261122-002',
                    status: 'Disetujui',
                    reason: ''
                },
                {
                    id: 'PAY-003',
                    name: 'Budi Santoso',
                    room: 'B-01',
                    period: 'November 2026',
                    amount: 1000000,
                    date: '2026-11-21',
                    method: 'Transfer Bank',
                    reference: 'TRX-20261121-003',
                    status: 'Menunggu',
                    reason: ''
                },
                {
                    id: 'PAY-004',
                    name: 'Dewi Lestari',
                    room: 'B-02',
                    period: 'November 2026',
                    amount: 1000000,
                    date: '2026-11-20',
                    method: 'Tunai',
                    reference: 'TRX-20261120-004',
                    status: 'Ditolak',
                    reason: 'Bukti pembayaran tidak sesuai dengan jumlah tagihan.'
                },
                {
                    id: 'PAY-005',
                    name: 'Rizky Maulana',
                    room: 'C-01',
                    period: 'November 2026',
                    amount: 1300000,
                    date: '2026-11-19',
                    method: 'Transfer Bank',
                    reference: 'TRX-20261119-005',
                    status: 'Disetujui',
                    reason: ''
                },
                {
                    id: 'PAY-006',
                    name: 'Nadia Putri',
                    room: 'C-02',
                    period: 'November 2026',
                    amount: 1300000,
                    date: '2026-11-18',
                    method: 'E-Wallet',
                    reference: 'TRX-20261118-006',
                    status: 'Menunggu',
                    reason: ''
                }
            ];

            const $ = selector => document.querySelector(selector);

            const tableBody = $('#paymentTableBody');
            const detailModal = $('#detailModal');
            const reasonBox = $('#reasonBox');
            const reasonInput = $('#rejectionReason');
            const reasonError = $('#reasonError');

            const allowedStatuses = ['Menunggu', 'Disetujui', 'Ditolak'];

            let payments = loadPayments();
            let selectedPaymentId = null;
            let toastTimeout = null;

            function cloneData(data) {
                return JSON.parse(JSON.stringify(data));
            }

            function isValidPayment(payment) {
                return payment &&
                    typeof payment.id === 'string' &&
                    typeof payment.name === 'string' &&
                    typeof payment.room === 'string' &&
                    typeof payment.period === 'string' &&
                    Number.isFinite(Number(payment.amount)) &&
                    Number(payment.amount) >= 0 &&
                    typeof payment.date === 'string' &&
                    typeof payment.method === 'string' &&
                    typeof payment.reference === 'string' &&
                    allowedStatuses.includes(payment.status) &&
                    typeof payment.reason === 'string';
            }

            function loadPayments() {
                try {
                    const saved = localStorage.getItem(STORAGE_KEY);

                    if (saved === null) {
                        localStorage.setItem(STORAGE_KEY, JSON.stringify(initialPayments));
                        return cloneData(initialPayments);
                    }

                    const parsed = JSON.parse(saved);

                    if (!Array.isArray(parsed) || !parsed.every(isValidPayment)) {
                        throw new Error('Format data pembayaran tidak valid.');
                    }

                    return parsed;
                } catch (error) {
                    console.error('Gagal membaca data pembayaran:', error);
                    return cloneData(initialPayments);
                }
            }

            function savePayments() {
                try {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(payments));
                    return true;
                } catch (error) {
                    console.error('Gagal menyimpan pembayaran:', error);
                    showToast('Data gagal disimpan di browser.', false);
                    return false;
                }
            }

            function escapeHTML(value) {
                return String(value ?? '').replace(/[&<>"']/g, char => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[char]);
            }

            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(Number(value) || 0);
            }

            function formatDate(value) {
                if (!value) return '-';

                const date = new Date(value + 'T00:00:00');

                if (Number.isNaN(date.getTime())) return '-';

                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }).format(date);
            }

            function statusClass(status) {
                if (status === 'Disetujui') return 'approved';
                if (status === 'Ditolak') return 'rejected';
                return 'pending';
            }

            function statusIcon(status) {
                if (status === 'Disetujui') return 'bi-check-circle-fill';
                if (status === 'Ditolak') return 'bi-x-circle-fill';
                return 'bi-hourglass-split';
            }

            function renderStats() {
                $('#totalPayments').textContent = payments.length;

                $('#pendingPayments').textContent =
                    payments.filter(item => item.status === 'Menunggu').length;

                $('#approvedPayments').textContent =
                    payments.filter(item => item.status === 'Disetujui').length;

                $('#rejectedPayments').textContent =
                    payments.filter(item => item.status === 'Ditolak').length;
            }

            function renderTable() {
                const keyword = $('#searchInput').value.trim().toLowerCase();
                const selectedStatus = $('#statusFilter').value;

                const filtered = payments.filter(payment => {
                    const searchableText = [
                        payment.name,
                        payment.room,
                        payment.reference
                    ].join(' ').toLowerCase();

                    const matchesKeyword = searchableText.includes(keyword);
                    const matchesStatus =
                        selectedStatus === 'Semua' ||
                        payment.status === selectedStatus;

                    return matchesKeyword && matchesStatus;
                });

                $('#recordCount').textContent = `${filtered.length} Transaksi`;

                $('#tableInfo').textContent =
                    `Menampilkan ${filtered.length} dari ${payments.length} transaksi`;

                if (filtered.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    Tidak ada data pembayaran yang ditemukan.
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                tableBody.innerHTML = filtered.map((payment, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            <span class="tenant-name">${escapeHTML(payment.name)}</span>
                            <span class="sub-text">${escapeHTML(payment.reference)}</span>
                        </td>
                        <td>${escapeHTML(payment.room)}</td>
                        <td>${escapeHTML(payment.period)}</td>
                        <td><span class="amount">${formatRupiah(payment.amount)}</span></td>
                        <td>${formatDate(payment.date)}</td>
                        <td>
                            <span class="status ${statusClass(payment.status)}">
                                <i class="bi ${statusIcon(payment.status)}"></i>
                                ${escapeHTML(payment.status)}
                            </span>
                        </td>
                        <td>
                            <button class="action-btn" type="button"
                                    data-action="detail"
                                    data-id="${escapeHTML(payment.id)}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                `).join('');
            }

            function renderAll() {
                renderStats();
                renderTable();
            }

            function showToast(message, success = true) {
                const toast = $('#toast');

                $('#toastMessage').textContent = message;

                toast.querySelector('i').className = success
                    ? 'bi bi-check-circle-fill'
                    : 'bi bi-exclamation-circle-fill';

                toast.classList.add('show');

                clearTimeout(toastTimeout);

                toastTimeout = setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }

            function openDetail(paymentId) {
                const payment = payments.find(item => item.id === paymentId);

                if (!payment) {
                    showToast('Data pembayaran tidak ditemukan.', false);
                    return;
                }

                selectedPaymentId = payment.id;

                $('#detailName').textContent = payment.name;
                $('#detailRoom').textContent = payment.room;
                $('#detailPeriod').textContent = payment.period;
                $('#detailAmount').textContent = formatRupiah(payment.amount);
                $('#detailDate').textContent = formatDate(payment.date);
                $('#detailMethod').textContent = payment.method;
                $('#detailReference').textContent = payment.reference;
                $('#detailStatus').textContent = payment.status;

                const proofContainer = $('#proofContainer');

                proofContainer.replaceChildren();

                const proofIcon = document.createElement('i');
                proofIcon.className = 'bi bi-image';

                const proofTitle = document.createElement('strong');
                proofTitle.textContent = 'Bukti pembayaran demo';

                const proofDescription = document.createElement('span');
                proofDescription.textContent = 'Belum ada file bukti asli yang terhubung.';

                proofContainer.append(proofIcon, proofTitle, proofDescription);

                if (payment.reason) {
                    const reasonText = document.createElement('span');
                    reasonText.style.color = 'var(--danger)';
                    reasonText.style.marginTop = '8px';
                    reasonText.textContent = 'Alasan penolakan: ' + payment.reason;
                    proofContainer.appendChild(reasonText);
                }

                reasonBox.classList.remove('show');
                reasonInput.value = '';
                reasonError.classList.remove('show');
                reasonError.textContent = 'Alasan penolakan wajib diisi minimal 5 karakter.';

                const isPending = payment.status === 'Menunggu';

                $('#approveBtn').style.display = isPending ? 'inline-block' : 'none';
                $('#rejectBtn').style.display = isPending ? 'inline-block' : 'none';

                detailModal.classList.add('show');
                document.body.style.overflow = 'hidden';
                $('#closeModal').focus();
            }

            function closeDetail() {
                detailModal.classList.remove('show');
                selectedPaymentId = null;

                reasonBox.classList.remove('show');
                reasonInput.value = '';
                reasonError.classList.remove('show');

                if (!$('#sidebar').classList.contains('open')) {
                    document.body.style.overflow = '';
                }
            }

            function addActivity(message) {
                try {
                    const saved = localStorage.getItem(ACTIVITY_KEY);
                    const activities = saved ? JSON.parse(saved) : [];

                    if (!Array.isArray(activities)) return;

                    activities.unshift({
                        id: 'ACT-' + Date.now(),
                        message,
                        date: new Date().toISOString()
                    });

                    localStorage.setItem(
                        ACTIVITY_KEY,
                        JSON.stringify(activities.slice(0, 100))
                    );
                } catch (error) {
                    console.warn('Aktivitas demo tidak dapat disimpan:', error);
                }
            }

            function approvePayment() {
                const payment = payments.find(item => item.id === selectedPaymentId);

                if (!payment || payment.status !== 'Menunggu') {
                    showToast('Pembayaran ini sudah diproses atau tidak ditemukan.', false);
                    closeDetail();
                    return;
                }

                const confirmed = confirm(
                    `Setujui pembayaran ${payment.name} sebesar ${formatRupiah(payment.amount)}?`
                );

                if (!confirmed) return;

                const oldStatus = payment.status;
                const oldReason = payment.reason;

                payment.status = 'Disetujui';
                payment.reason = '';

                if (!savePayments()) {
                    payment.status = oldStatus;
                    payment.reason = oldReason;
                    return;
                }

                addActivity(
                    `Pembayaran ${payment.name} (${payment.room}) telah disetujui.`
                );

                closeDetail();
                renderAll();
                showToast('Pembayaran berhasil disetujui.');
            }

            function rejectPayment() {
                const payment = payments.find(item => item.id === selectedPaymentId);

                if (!payment || payment.status !== 'Menunggu') {
                    showToast('Pembayaran ini sudah diproses atau tidak ditemukan.', false);
                    closeDetail();
                    return;
                }

                if (!reasonBox.classList.contains('show')) {
                    reasonBox.classList.add('show');
                    reasonInput.focus();
                    return;
                }

                const reason = reasonInput.value.trim();

                if (reason.length < 5) {
                    reasonError.textContent =
                        'Alasan penolakan wajib diisi minimal 5 karakter.';
                    reasonError.classList.add('show');
                    reasonInput.focus();
                    return;
                }

                if (reason.length > 300) {
                    reasonError.textContent =
                        'Alasan penolakan maksimal 300 karakter.';
                    reasonError.classList.add('show');
                    reasonInput.focus();
                    return;
                }

                const confirmed = confirm(
                    `Tolak pembayaran ${payment.name}?\nAlasan: ${reason}`
                );

                if (!confirmed) return;

                const oldStatus = payment.status;
                const oldReason = payment.reason;

                payment.status = 'Ditolak';
                payment.reason = reason;

                if (!savePayments()) {
                    payment.status = oldStatus;
                    payment.reason = oldReason;
                    return;
                }

                addActivity(
                    `Pembayaran ${payment.name} (${payment.room}) ditolak. Alasan: ${reason}`
                );

                closeDetail();
                renderAll();
                showToast('Pembayaran berhasil ditolak.');
            }

            // Event daftar pembayaran
            tableBody.addEventListener('click', event => {
                const button = event.target.closest('[data-action="detail"]');

                if (!button) return;

                openDetail(button.dataset.id);
            });

            $('#searchInput').addEventListener('input', renderTable);
            $('#statusFilter').addEventListener('change', renderTable);

            // Event modal
            $('#closeModal').addEventListener('click', closeDetail);
            $('#cancelModal').addEventListener('click', closeDetail);
            $('#approveBtn').addEventListener('click', approvePayment);
            $('#rejectBtn').addEventListener('click', rejectPayment);

            reasonInput.addEventListener('input', () => {
                if (reasonInput.value.trim().length >= 5 &&
                    reasonInput.value.trim().length <= 300) {
                    reasonError.classList.remove('show');
                }
            });

            detailModal.addEventListener('click', event => {
                if (event.target === detailModal) closeDetail();
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    if (detailModal.classList.contains('show')) {
                        closeDetail();
                    }

                    closeSidebar();
                }
            });

            // Sidebar responsive
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

                if (!detailModal.classList.contains('show')) {
                    document.body.style.overflow = '';
                }
            }

            menuToggle.addEventListener('click', () => {
                sidebar.classList.contains('open')
                    ? closeSidebar()
                    : openSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) closeSidebar();
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) closeSidebar();
            });

            // Logout demo: perilaku mengikuti kode sebelumnya
            $('#logoutBtn').addEventListener('click', () => {
                if (confirm('Apakah kamu yakin ingin keluar dari akun?')) {
                    window.location.href = "{{ route('login') }}";
                }
            });

            // Tanggal hari ini
            $('#currentDate').textContent = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(new Date());

            renderAll();
        })();
    </script>
</body>
</html>
