
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aktivitas Petugas - KosHaven</title>

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

            --green: #91AE9B;
            --green-bg: rgba(145,174,155,.13);

            --yellow: #D9B77F;
            --yellow-bg: rgba(217,183,127,.13);

            --red: #D58F8F;
            --red-bg: rgba(213,143,143,.13);

            --blue: #91AAC8;
            --blue-bg: rgba(145,170,200,.13);

            --purple: #B5A0D2;
            --purple-bg: rgba(181,160,210,.13);

            --border: rgba(198,164,119,.15);
            --shadow: 0 12px 35px rgba(0,0,0,.13);

            --sidebar-width: 270px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        body,
        button,
        input,
        select {
            font-family: 'DM Sans', sans-serif;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* =========================
           SIDEBAR
        ========================= */

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
            letter-spacing: -.5px;
            color: var(--ivory);
        }

        .brand-name span {
            color: var(--gold);
        }

        .brand small {
            display: block;
            margin-top: 5px;
            color: var(--silver);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-label {
            padding: 25px 25px 11px;
            color: var(--silver);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 0 13px 15px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: var(--surface-soft);
            border-radius: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 9px;
            color: var(--silver-light);
            font-size: 12px;
            font-weight: 500;
            transition: .2s;
        }

        .nav-link i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .nav-link:hover {
            color: var(--ivory);
            background: rgba(255,255,255,.055);
        }

        .nav-link.active {
            color: var(--gold-light);
            background: rgba(198,164,119,.13);
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
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            color: var(--bg-deep);
            font-weight: 700;
            font-size: 13px;
        }

        .user-info {
            min-width: 0;
        }

        .user-info strong {
            display: block;
            color: var(--ivory);
            font-size: 12px;
            font-weight: 600;
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
            color: var(--red);
            font-size: 11px;
            text-align: left;
            transition: .2s;
        }

        .logout-btn:hover {
            background: var(--red-bg);
            border-color: rgba(213,143,143,.4);
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 30px 35px 45px;
            transition: .3s;
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
            min-width: 0;
        }

        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface);
            color: var(--gold-light);
            font-size: 20px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 11px;
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
            letter-spacing: -.3px;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--silver-light);
            font-size: 11px;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 11px 15px;
            border-radius: 9px;
            white-space: nowrap;
        }

        .topbar-date i {
            color: var(--gold);
            font-size: 14px;
        }

        /* =========================
           INTRO
        ========================= */

        .intro {
            margin-bottom: 23px;
        }

        .intro h2 {
            font-size: 16px;
            font-weight: 700;
            color: var(--ivory);
            margin-bottom: 6px;
        }

        .intro p {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.7;
        }

        /* =========================
           STATISTICS
        ========================= */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .stat-card {
            position: relative;
            min-width: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.35);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 17px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 10px;
            font-weight: 600;
        }

        .stat-icon {
            width: 37px;
            height: 37px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .icon-total {
            background: rgba(198,164,119,.14);
            color: var(--gold-light);
        }

        .icon-today {
            background: var(--yellow-bg);
            color: var(--yellow);
        }

        .icon-payment {
            background: var(--green-bg);
            color: var(--green);
        }

        .icon-other {
            background: var(--purple-bg);
            color: var(--purple);
        }

        .stat-value {
            color: var(--ivory);
            font-size: 27px;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-note {
            color: var(--silver);
            font-size: 10px;
            margin-top: 7px;
        }

        /* =========================
           CONTENT CARD
        ========================= */

        .content-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-heading {
            padding: 21px 23px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .card-heading h3 {
            color: var(--ivory);
            font-size: 14px;
            font-weight: 700;
        }

        .card-heading p {
            color: var(--muted);
            font-size: 10px;
            margin-top: 5px;
        }

        .record-count {
            background: rgba(198,164,119,.13);
            color: var(--gold-light);
            border: 1px solid rgba(198,164,119,.18);
            border-radius: 20px;
            padding: 7px 12px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================
           FILTERS
        ========================= */

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
            min-width: 200px;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--silver);
            font-size: 14px;
            pointer-events: none;
        }

        .search-box input,
        .filter-select {
            width: 100%;
            height: 40px;
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 8px;
            outline: none;
            background: var(--surface-light);
            color: var(--text);
            font-size: 11px;
            transition: .2s;
        }

        .search-box input {
            padding: 0 12px 0 37px;
        }

        .search-box input::placeholder {
            color: var(--silver);
        }

        .filter-select {
            width: 175px;
            padding: 0 10px;
            cursor: pointer;
        }

        .filter-select option {
            background: var(--surface);
            color: var(--text);
        }

        .search-box input:focus,
        .filter-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        /* =========================
           TIMELINE
        ========================= */

        .timeline {
            padding: 25px 26px;
        }

        .timeline-group {
            margin-bottom: 27px;
        }

        .timeline-group:last-child {
            margin-bottom: 0;
        }

        .timeline-date {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 19px;
            color: var(--gold-light);
            font-size: 11px;
            font-weight: 700;
        }

        .timeline-date::after {
            content: "";
            height: 1px;
            flex: 1;
            background: var(--border);
        }

        .activity-item {
            display: flex;
            gap: 15px;
            position: relative;
            padding-bottom: 24px;
        }

        .activity-item:last-child {
            padding-bottom: 0;
        }

        .activity-item:not(:last-child)::before {
            content: "";
            position: absolute;
            top: 41px;
            left: 18px;
            bottom: 0;
            width: 1px;
            background: rgba(187,196,205,.17);
        }

        .activity-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 15px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255,255,255,.04);
        }

        .activity-icon.payment {
            color: var(--green);
            background: var(--green-bg);
        }

        .activity-icon.tenant {
            color: var(--blue);
            background: var(--blue-bg);
        }

        .activity-icon.room {
            color: var(--yellow);
            background: var(--yellow-bg);
        }

        .activity-icon.system {
            color: var(--purple);
            background: var(--purple-bg);
        }

        .activity-content {
            flex: 1;
            min-width: 0;
            padding-top: 2px;
        }

        .activity-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .activity-title {
            color: var(--ivory);
            font-size: 12px;
            font-weight: 700;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .activity-time {
            color: var(--silver);
            font-size: 10px;
            white-space: nowrap;
            padding-top: 2px;
        }

        .activity-description {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
            margin-top: 5px;
            overflow-wrap: anywhere;
        }

        .activity-meta {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .category-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 20px;
            background: rgba(198,164,119,.12);
            color: var(--gold-light);
            border: 1px solid rgba(198,164,119,.12);
            font-size: 9px;
            font-weight: 700;
        }

        .detail-link {
            border: none;
            background: none;
            color: var(--gold);
            font-size: 10px;
            font-weight: 700;
            padding: 4px;
            transition: .2s;
        }

        .detail-link:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 48px 15px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .empty-state i {
            display: block;
            font-size: 34px;
            color: var(--silver);
            opacity: .65;
            margin-bottom: 12px;
        }

        /* =========================
           MODAL
        ========================= */

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(0,0,0,.72);
            backdrop-filter: blur(4px);
            padding: 20px;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background: var(--surface);
            width: 100%;
            max-width: 490px;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            animation: modalIn .2s ease;
            overflow: hidden;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface-light);
            color: var(--silver-light);
            font-size: 15px;
            transition: .2s;
        }

        .close-modal:hover {
            color: var(--red);
            border-color: rgba(213,143,143,.3);
        }

        .modal-body {
            padding: 21px 22px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
            font-size: 11px;
        }

        .detail-row:first-child {
            padding-top: 0;
        }

        .detail-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .detail-row span {
            color: var(--silver);
            flex-shrink: 0;
        }

        .detail-row strong {
            color: var(--ivory);
            text-align: right;
            max-width: 65%;
            font-weight: 600;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .modal-footer {
            padding: 15px 22px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }

        .btn-close {
            border: 1px solid rgba(198,164,119,.25);
            background: var(--gold);
            color: var(--bg-deep);
            padding: 10px 19px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-close:hover {
            background: var(--gold-light);
        }

        /* =========================
           TOAST
        ========================= */

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
            background: var(--surface-light);
            color: var(--ivory);
            font-size: 11px;
            box-shadow: 0 8px 25px rgba(0,0,0,.25);
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
            color: var(--green);
            font-size: 16px;
        }

        /* =========================
           SIDEBAR OVERLAY
        ========================= */

        .sidebar-overlay {
            display: none;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1200px) {
            .main {
                padding: 26px 24px 40px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0,1fr));
            }
        }

        @media (max-width: 900px) {
            :root {
                --sidebar-width: 250px;
            }

            .main {
                padding: 24px 20px 38px;
            }

            .page-title {
                font-size: 25px;
            }

            .filters {
                gap: 9px;
            }

            .search-box {
                min-width: 100%;
            }

            .filter-select {
                flex: 1;
                width: auto;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 15px 0 40px rgba(0,0,0,.25);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 999;
                background: rgba(0,0,0,.58);
            }

            .main {
                margin-left: 0;
                padding: 21px 18px 35px;
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
                padding: 17px 13px 30px;
            }

            .topbar {
                margin-bottom: 25px;
            }

            .page-title {
                font-size: 21px;
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

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0,1fr));
                gap: 10px;
            }

            .stat-card {
                padding: 14px;
            }

            .stat-top {
                margin-bottom: 13px;
                align-items: flex-start;
            }

            .stat-label {
                font-size: 9px;
                line-height: 1.5;
            }

            .stat-icon {
                width: 31px;
                height: 31px;
                font-size: 14px;
            }

            .stat-value {
                font-size: 22px;
            }

            .stat-note {
                font-size: 9px;
                line-height: 1.5;
            }

            .card-heading {
                padding: 17px 15px;
                align-items: flex-start;
            }

            .card-heading h3 {
                font-size: 12px;
            }

            .card-heading p {
                font-size: 9px;
                line-height: 1.5;
            }

            .record-count {
                font-size: 9px;
                padding: 6px 8px;
            }

            .filters {
                padding: 14px;
            }

            .search-box,
            .filter-select {
                width: 100%;
                min-width: 100%;
                flex: 1 1 100%;
            }

            .timeline {
                padding: 21px 15px;
            }

            .activity-item {
                gap: 11px;
            }

            .activity-icon {
                width: 34px;
                height: 34px;
                font-size: 13px;
            }

            .activity-item:not(:last-child)::before {
                left: 16px;
                top: 37px;
            }

            .activity-title-row {
                flex-direction: column;
                gap: 3px;
            }

            .activity-title {
                font-size: 11px;
            }

            .activity-time {
                font-size: 9px;
                white-space: normal;
            }

            .activity-description {
                font-size: 10px;
            }

            .modal-overlay {
                padding: 12px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .detail-row {
                font-size: 10px;
                gap: 10px;
            }

            .toast {
                right: 12px;
                bottom: 12px;
            }
        }

        @media (max-width: 360px) {
            .page-title {
                font-size: 19px;
            }

            .stats-grid {
                gap: 8px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-value {
                font-size: 20px;
            }

            .card-heading {
                flex-direction: column;
            }

            .record-count {
                align-self: flex-start;
            }

            .timeline {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

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

            <a href="{{ route('petugas.pembayaran.index') }}" class="nav-link">
                <i class="bi bi-wallet2"></i>
                Pembayaran
            </a>

            <a href="{{ route('petugas.aktivitas.index') }}"
               class="nav-link active"
               aria-current="page">
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
                <button class="menu-toggle"
                        id="menuToggle"
                        type="button"
                        aria-label="Buka navigasi"
                        aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <div class="breadcrumb">
                        Menu Utama <span>/</span> Aktivitas
                    </div>

                    <h1 class="page-title">Riwayat Aktivitas</h1>
                </div>
            </div>

            <div class="topbar-date">
                <i class="bi bi-calendar3"></i>
                <span id="currentDate"></span>
            </div>
        </header>

        <section class="intro">
            <h2>Aktivitas Operasional Petugas</h2>
            <p>
                Pantau seluruh riwayat kegiatan dan perubahan data
                yang dilakukan selama pengelolaan kos.
            </p>
        </section>

        <!-- STATISTIK -->
        <section class="stats-grid">

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Aktivitas</span>
                    <div class="stat-icon icon-total">
                        <i class="bi bi-activity"></i>
                    </div>
                </div>

                <div class="stat-value" id="totalActivities">0</div>
                <div class="stat-note">Seluruh aktivitas tercatat</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Aktivitas Hari Ini</span>
                    <div class="stat-icon icon-today">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>

                <div class="stat-value" id="todayActivities">0</div>
                <div class="stat-note">Kegiatan pada hari ini</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Aktivitas Pembayaran</span>
                    <div class="stat-icon icon-payment">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <div class="stat-value" id="paymentActivities">0</div>
                <div class="stat-note">Kegiatan terkait pembayaran</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Aktivitas Lainnya</span>
                    <div class="stat-icon icon-other">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>

                <div class="stat-value" id="otherActivities">0</div>
                <div class="stat-note">Penghuni, kamar, dan sistem</div>
            </div>

        </section>

        <!-- RIWAYAT AKTIVITAS -->
        <section class="content-card">

            <div class="card-heading">
                <div>
                    <h3>Daftar Riwayat Aktivitas</h3>
                    <p>Catatan kegiatan petugas berdasarkan waktu kejadian.</p>
                </div>

                <span class="record-count" id="recordCount">
                    0 Aktivitas
                </span>
            </div>

            <!-- FILTER -->
            <div class="filters">

                <div class="search-box">
                    <i class="bi bi-search"></i>

                    <input type="search"
                           id="searchInput"
                           placeholder="Cari aktivitas, penghuni, atau kamar..."
                           aria-label="Cari aktivitas">
                </div>

                <select class="filter-select"
                        id="categoryFilter"
                        aria-label="Filter kategori">

                    <option value="Semua">Semua Kategori</option>
                    <option value="Pembayaran">Pembayaran</option>
                    <option value="Penghuni">Penghuni</option>
                    <option value="Kamar">Kamar</option>
                    <option value="Sistem">Sistem</option>
                </select>

                <select class="filter-select"
                        id="dateFilter"
                        aria-label="Filter tanggal">

                    <option value="Semua">Semua Tanggal</option>
                    <option value="HariIni">Hari Ini</option>
                    <option value="7Hari">7 Hari Terakhir</option>
                    <option value="30Hari">30 Hari Terakhir</option>
                </select>

            </div>

            <!-- TIMELINE -->
            <div class="timeline" id="activityTimeline"></div>

        </section>

    </main>

    <!-- MODAL DETAIL AKTIVITAS -->
    <div class="modal-overlay"
         id="detailModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalTitle">

        <div class="modal">

            <div class="modal-header">
                <h3 id="modalTitle">Detail Aktivitas</h3>

                <button class="close-modal"
                        type="button"
                        id="closeModal"
                        aria-label="Tutup modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="detail-row">
                    <span>Aktivitas</span>
                    <strong id="detailTitle">-</strong>
                </div>

                <div class="detail-row">
                    <span>Kategori</span>
                    <strong id="detailCategory">-</strong>
                </div>

                <div class="detail-row">
                    <span>Deskripsi</span>
                    <strong id="detailDescription">-</strong>
                </div>

                <div class="detail-row">
                    <span>Petugas</span>
                    <strong id="detailActor">-</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal dan Waktu</span>
                    <strong id="detailTime">-</strong>
                </div>

                <div class="detail-row">
                    <span>ID Aktivitas</span>
                    <strong id="detailId">-</strong>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn-close"
                        type="button"
                        id="cancelModal">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toast" role="status" aria-live="polite">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMessage">Berhasil</span>
    </div>

    <script>
        (() => {
            'use strict';

            const STORAGE_KEY = 'koshaven_petugas_activities_v1';

            const $ = selector => document.querySelector(selector);

            const now = new Date();

            const initialActivities = [
                {
                    id: 'ACT-001',
                    title: 'Pembayaran berhasil disetujui',
                    description: 'Pembayaran Andi Pratama untuk kamar A-01 telah diverifikasi dan disetujui.',
                    category: 'Pembayaran',
                    actor: 'Petugas Kos',
                    date: daysAgo(0, 9, 15)
                },
                {
                    id: 'ACT-002',
                    title: 'Data penghuni diperbarui',
                    description: 'Informasi kontak penghuni kamar B-01 berhasil diperbarui.',
                    category: 'Penghuni',
                    actor: 'Petugas Kos',
                    date: daysAgo(0, 10, 30)
                },
                {
                    id: 'ACT-003',
                    title: 'Pembayaran ditolak',
                    description: 'Pembayaran Dewi Lestari untuk kamar B-02 ditolak karena bukti pembayaran tidak sesuai.',
                    category: 'Pembayaran',
                    actor: 'Petugas Kos',
                    date: daysAgo(1, 14, 20)
                },
                {
                    id: 'ACT-004',
                    title: 'Pemeriksaan kondisi kamar',
                    description: 'Pemeriksaan fasilitas dan kebersihan kamar C-01 telah dilakukan.',
                    category: 'Kamar',
                    actor: 'Petugas Kos',
                    date: daysAgo(2, 8, 45)
                },
                {
                    id: 'ACT-005',
                    title: 'Pembayaran berhasil disetujui',
                    description: 'Pembayaran Rizky Maulana untuk kamar C-01 telah diverifikasi.',
                    category: 'Pembayaran',
                    actor: 'Petugas Kos',
                    date: daysAgo(3, 11, 10)
                },
                {
                    id: 'ACT-006',
                    title: 'Data penghuni ditambahkan',
                    description: 'Data penghuni baru berhasil dicatat pada sistem.',
                    category: 'Penghuni',
                    actor: 'Petugas Kos',
                    date: daysAgo(5, 13, 5)
                },
                {
                    id: 'ACT-007',
                    title: 'Pemeriksaan kamar selesai',
                    description: 'Pemeriksaan rutin kondisi kamar A-02 telah selesai dilakukan.',
                    category: 'Kamar',
                    actor: 'Petugas Kos',
                    date: daysAgo(8, 9, 0)
                }
            ];

            function daysAgo(days, hour = 10, minute = 0) {
                const date = new Date();

                date.setDate(date.getDate() - days);
                date.setHours(hour, minute, 0, 0);

                return date.toISOString();
            }

            /* =========================
               STORAGE
            ========================= */

            function loadActivities() {
                try {
                    const saved = localStorage.getItem(STORAGE_KEY);

                    if (saved === null) {
                        localStorage.setItem(
                            STORAGE_KEY,
                            JSON.stringify(initialActivities)
                        );

                        return initialActivities.map(item => ({ ...item }));
                    }

                    const parsed = JSON.parse(saved);

                    if (!Array.isArray(parsed)) {
                        throw new Error('Format aktivitas tidak valid.');
                    }

                    return parsed.filter(item =>
                        item &&
                        typeof item === 'object' &&
                        typeof item.id === 'string' &&
                        typeof item.title === 'string' &&
                        typeof item.category === 'string'
                    );

                } catch (error) {
                    console.error('Gagal membaca aktivitas:', error);
                    return initialActivities.map(item => ({ ...item }));
                }
            }

            let activities = loadActivities();

            /* =========================
               HELPER
            ========================= */

            function escapeHTML(value) {
                return String(value ?? '').replace(/[&<>"']/g, char => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[char]);
            }

            function validDate(value) {
                const date = new Date(value);

                return !Number.isNaN(date.getTime())
                    ? date
                    : null;
            }

            function getLocalDateKey(date) {
                if (!date || !(date instanceof Date)) {
                    return 'unknown';
                }

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }

            function categoryIcon(category) {
                const icons = {
                    Pembayaran: 'bi-wallet2',
                    Penghuni: 'bi-people',
                    Kamar: 'bi-door-closed',
                    Sistem: 'bi-gear'
                };

                return icons[category] || 'bi-activity';
            }

            function categoryClass(category) {
                const classes = {
                    Pembayaran: 'payment',
                    Penghuni: 'tenant',
                    Kamar: 'room',
                    Sistem: 'system'
                };

                return classes[category] || 'system';
            }

            function formatDate(dateValue) {
                const date = validDate(dateValue);

                if (!date) {
                    return 'Tanggal tidak tersedia';
                }

                return new Intl.DateTimeFormat('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }).format(date);
            }

            function formatTime(dateValue) {
                const date = validDate(dateValue);

                if (!date) {
                    return '-';
                }

                return new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }).format(date) + ' WIB';
            }

            function isSameDay(dateA, dateB) {
                return dateA.getFullYear() === dateB.getFullYear() &&
                    dateA.getMonth() === dateB.getMonth() &&
                    dateA.getDate() === dateB.getDate();
            }

            /* =========================
               STATISTICS
            ========================= */

            function renderStats() {
                const today = new Date();

                const validActivities = activities.filter(item =>
                    validDate(item.date)
                );

                const todayCount = validActivities.filter(item =>
                    isSameDay(validDate(item.date), today)
                ).length;

                const paymentCount = activities.filter(item =>
                    item.category === 'Pembayaran'
                ).length;

                const otherCount = activities.length - paymentCount;

                $('#totalActivities').textContent = activities.length;
                $('#todayActivities').textContent = todayCount;
                $('#paymentActivities').textContent = paymentCount;
                $('#otherActivities').textContent = Math.max(0, otherCount);
            }

            /* =========================
               FILTER
            ========================= */

            function getFilteredActivities() {
                const keyword = $('#searchInput').value
                    .trim()
                    .toLowerCase();

                const category = $('#categoryFilter').value;
                const dateRange = $('#dateFilter').value;

                const today = new Date();

                const startToday = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    today.getDate()
                );

                return activities
                    .filter(item => {
                        const searchable = [
                            item.title,
                            item.description,
                            item.actor,
                            item.category,
                            item.id
                        ].join(' ').toLowerCase();

                        const matchesSearch =
                            searchable.includes(keyword);

                        const matchesCategory =
                            category === 'Semua' ||
                            item.category === category;

                        const date = validDate(item.date);

                        let matchesDate = true;

                        if (!date) {
                            matchesDate = dateRange === 'Semua';
                        } else if (dateRange === 'HariIni') {
                            matchesDate = isSameDay(date, today);
                        } else if (
                            dateRange === '7Hari' ||
                            dateRange === '30Hari'
                        ) {
                            const start = new Date(startToday);

                            const days = dateRange === '7Hari' ? 6 : 29;

                            start.setDate(start.getDate() - days);

                            matchesDate =
                                date >= start &&
                                date <= today;
                        }

                        return matchesSearch &&
                            matchesCategory &&
                            matchesDate;
                    })
                    .sort((a, b) => {
                        const dateA = validDate(a.date)?.getTime() || 0;
                        const dateB = validDate(b.date)?.getTime() || 0;

                        return dateB - dateA;
                    });
            }

            /* =========================
               RENDER TIMELINE
            ========================= */

            function renderActivities() {
                const filtered = getFilteredActivities();

                $('#recordCount').textContent =
                    `${filtered.length} Aktivitas`;

                const timeline = $('#activityTimeline');

                if (filtered.length === 0) {
                    timeline.innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-journal-x"></i>
                            <strong>Tidak ada aktivitas ditemukan.</strong>
                            <div>Coba ubah kata kunci atau filter pencarian.</div>
                        </div>
                    `;

                    return;
                }

                const groups = new Map();

                filtered.forEach(activity => {
                    const date = validDate(activity.date);

                    const key = date
                        ? getLocalDateKey(date)
                        : 'unknown';

                    if (!groups.has(key)) {
                        groups.set(key, []);
                    }

                    groups.get(key).push(activity);
                });

                timeline.innerHTML = [...groups.entries()]
                    .map(([dateKey, items]) => {
                        const dateLabel = dateKey === 'unknown'
                            ? 'Tanggal tidak tersedia'
                            : formatDate(dateKey);

                        const itemsHTML = items.map(activity => `
                            <div class="activity-item">

                                <div class="activity-icon ${categoryClass(activity.category)}">
                                    <i class="bi ${categoryIcon(activity.category)}"></i>
                                </div>

                                <div class="activity-content">

                                    <div class="activity-title-row">
                                        <div class="activity-title">
                                            ${escapeHTML(activity.title)}
                                        </div>

                                        <div class="activity-time">
                                            ${formatTime(activity.date)}
                                        </div>
                                    </div>

                                    <div class="activity-description">
                                        ${escapeHTML(activity.description)}
                                    </div>

                                    <div class="activity-meta">

                                        <span class="category-badge">
                                            ${escapeHTML(activity.category)}
                                        </span>

                                        <button class="detail-link"
                                                type="button"
                                                data-action="detail"
                                                data-id="${escapeHTML(activity.id)}">
                                            Lihat detail
                                            <i class="bi bi-arrow-right"></i>
                                        </button>

                                    </div>

                                </div>
                            </div>
                        `).join('');

                        return `
                            <div class="timeline-group">

                                <div class="timeline-date">
                                    ${escapeHTML(dateLabel)}
                                </div>

                                ${itemsHTML}

                            </div>
                        `;
                    }).join('');
            }

            function renderAll() {
                renderStats();
                renderActivities();
            }

            /* =========================
               DETAIL MODAL
            ========================= */

            function openDetail(id) {
                const activity = activities.find(item =>
                    item.id === id
                );

                if (!activity) {
                    showToast('Aktivitas tidak ditemukan.');
                    return;
                }

                $('#detailTitle').textContent =
                    activity.title || '-';

                $('#detailCategory').textContent =
                    activity.category || '-';

                $('#detailDescription').textContent =
                    activity.description || '-';

                $('#detailActor').textContent =
                    activity.actor || 'Petugas Kos';

                $('#detailTime').textContent =
                    formatDate(activity.date) +
                    ' • ' +
                    formatTime(activity.date);

                $('#detailId').textContent =
                    activity.id || '-';

                $('#detailModal').classList.add('show');

                document.body.style.overflow = 'hidden';

                $('#closeModal').focus();
            }

            function closeDetail() {
                $('#detailModal').classList.remove('show');

                if (!$('#sidebar').classList.contains('open')) {
                    document.body.style.overflow = '';
                }
            }

            /* =========================
               TOAST
            ========================= */

            let toastTimeout;

            function showToast(message) {
                const toast = $('#toast');

                $('#toastMessage').textContent = message;

                toast.classList.add('show');

                clearTimeout(toastTimeout);

                toastTimeout = setTimeout(() => {
                    toast.classList.remove('show');
                }, 2800);
            }

            /* =========================
               EVENT FILTER
            ========================= */

            $('#activityTimeline').addEventListener('click', event => {
                const button = event.target.closest(
                    '[data-action="detail"]'
                );

                if (!button) {
                    return;
                }

                openDetail(button.dataset.id);
            });

            $('#searchInput').addEventListener('input', renderActivities);

            $('#categoryFilter').addEventListener('change', renderActivities);

            $('#dateFilter').addEventListener('change', renderActivities);

            /* =========================
               MODAL EVENTS
            ========================= */

            $('#closeModal').addEventListener('click', closeDetail);

            $('#cancelModal').addEventListener('click', closeDetail);

            $('#detailModal').addEventListener('click', event => {
                if (event.target === $('#detailModal')) {
                    closeDetail();
                }
            });

            /* =========================
               SIDEBAR RESPONSIVE
            ========================= */

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

                if (!$('#detailModal').classList.contains('show')) {
                    document.body.style.overflow = '';
                }
            }

            menuToggle.addEventListener('click', () => {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            sidebar.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });

            /* =========================
               KEYBOARD ACCESSIBILITY
            ========================= */

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    closeDetail();
                    closeSidebar();
                }
            });

            /* =========================
               LOGOUT
            ========================= */

            $('#logoutBtn').addEventListener('click', () => {
                const confirmed = confirm(
                    'Apakah kamu yakin ingin keluar dari akun?'
                );

                if (confirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });

            /* =========================
               CURRENT DATE
            ========================= */

            $('#currentDate').textContent =
                new Intl.DateTimeFormat('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }).format(now);

            /* =========================
               INITIAL RENDER
            ========================= */

            renderAll();

        })();
    </script>

</body>
</html>
