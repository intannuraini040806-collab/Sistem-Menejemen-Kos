<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tagihan - KosHaven</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #C6A477;
            --primary-dark: #E0C49B;
            --primary-light: rgba(198,164,119,.13);

            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-2: #2D343D;
            --surface-3: #363E48;

            --white: #F1F0EC;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.13);

            --green: #91AE9B;
            --green-bg: rgba(145,174,155,.14);
            --orange: #D9B77F;
            --orange-bg: rgba(217,183,127,.14);
            --red: #D58F8F;
            --red-bg: rgba(213,143,143,.14);
            --blue: #91B1D2;
            --blue-bg: rgba(145,177,210,.14);

            --shadow: 0 12px 35px rgba(0,0,0,.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: auto;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a, button, input, select, textarea {
            -webkit-tap-highlight-color: transparent;
        }

        .layout {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            height: 100vh;
            height: 100dvh;
            background: var(--bg-deep);
            color: var(--white);
            padding: 25px 17px 18px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(198,164,119,.35) transparent;
            transition: transform .22s ease-out;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(198,164,119,.35);
            border-radius: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 11px 23px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: rgba(198,164,119,.15);
            color: var(--primary-dark);
            font-size: 21px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 700;
            color: var(--white);
        }

        .brand small {
            display: block;
            font-size: 9px;
            color: var(--muted);
            letter-spacing: 1.8px;
            margin-top: 3px;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 18px 10px;
            margin-bottom: 5px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-profile-avatar {
            width: 37px;
            height: 37px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            background: rgba(198,164,119,.17);
            color: var(--primary-dark);
            font-size: 15px;
            font-weight: 800;
        }

        .sidebar-profile-name {
            color: var(--white);
            font-size: 12px;
            font-weight: 700;
        }

        .sidebar-profile-role {
            color: var(--muted);
            font-size: 10px;
            margin-top: 3px;
        }

        .nav-label {
            color: var(--muted-dark);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 20px 13px 10px;
            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
        }

        .nav-menu a {
            position: relative;
            color: #B9C0C8;
            text-decoration: none;
            padding: 11px 13px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 11px;
            transition: background .2s ease, color .2s ease;
            flex-shrink: 0;
        }

        .nav-menu a i {
            width: 19px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .nav-menu a:hover {
            background: rgba(255,255,255,.06);
            color: var(--white);
        }

        .nav-menu a.active {
            background: rgba(198,164,119,.13);
            color: var(--primary-dark);
            font-weight: 700;
        }

        .nav-menu a.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 3px;
            background: var(--primary);
            border-radius: 0 5px 5px 0;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 13px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-bottom .nav-label {
            padding-top: 8px;
        }

        .main {
            margin-left: 250px;
            padding: 30px 36px;
            min-height: 100vh;
            min-width: 0;
            transition: margin-left .22s ease-out;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 30px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--primary-dark);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 21px;
            flex-shrink: 0;
        }

        .menu-toggle:hover {
            background: var(--surface-2);
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 5px;
        }

        .breadcrumb span {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 29px;
            color: var(--white);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 41px;
            height: 41px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 19px;
        }

        .profile-info strong {
            display: block;
            font-size: 12px;
            color: var(--white);
        }

        .profile-info small {
            color: var(--muted);
            font-size: 10px;
        }

        /* PAGE HEADING */
        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 25px;
        }

        .page-heading h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .page-heading p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.6;
        }

        /* BUTTON */
        .btn {
            border: 1px solid transparent;
            border-radius: 9px;
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            color: #191D22;
            background: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-light {
            background: var(--surface-2);
            color: var(--text);
            border-color: var(--border);
        }

        .btn-light:hover {
            background: var(--surface-3);
        }

        .btn-danger {
            background: var(--red-bg);
            color: var(--red);
        }

        .btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        /* STATISTICS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 18px;
            box-shadow: var(--shadow);
            min-width: 0;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 10px;
            font-weight: 600;
            line-height: 1.5;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-card h3 {
            font-size: 25px;
            color: var(--white);
            overflow-wrap: anywhere;
        }

        .stat-card small {
            display: block;
            margin-top: 5px;
            color: var(--muted-dark);
            font-size: 9px;
            line-height: 1.5;
        }

        .stat-total .stat-icon { background: var(--primary-light); color: var(--primary-dark); }
        .stat-paid .stat-icon { background: var(--green-bg); color: var(--green); }
        .stat-unpaid .stat-icon { background: var(--orange-bg); color: var(--orange); }
        .stat-pending .stat-icon { background: var(--blue-bg); color: var(--blue); }
        .stat-late .stat-icon { background: var(--red-bg); color: var(--red); }

        /* CONTENT */
        .content-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            overflow: hidden;
            min-width: 0;
        }

        .card-header {
            padding: 21px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            font-size: 14px;
            color: var(--white);
        }

        .card-header p {
            color: var(--muted);
            font-size: 10px;
            margin-top: 4px;
        }

        /* FILTER */
        .filters {
            padding: 17px 22px;
            display: grid;
            grid-template-columns: minmax(180px, 1fr) 180px 160px auto;
            gap: 11px;
            border-bottom: 1px solid var(--border);
        }

        .field {
            width: 100%;
            min-width: 0;
        }

        .field label {
            display: block;
            color: #C4CBD2;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .control {
            width: 100%;
            min-height: 41px;
            border: 1px solid rgba(187,196,205,.2);
            border-radius: 8px;
            padding: 9px 11px;
            outline: none;
            color: var(--text);
            background: var(--surface-2);
            font-size: 11px;
            color-scheme: dark;
        }

        .control::placeholder {
            color: var(--muted-dark);
        }

        .control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(198,164,119,.1);
        }

        select.control option {
            background: var(--surface-2);
            color: var(--white);
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px;
            top: 13px;
            color: var(--muted);
            font-size: 12px;
        }

        .search-wrap input {
            padding-left: 34px;
        }

        .filter-actions {
            display: flex;
            align-items: flex-end;
            gap: 8px;
        }

        /* TABLE */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--surface-3) transparent;
        }

        .table-wrap::-webkit-scrollbar {
            height: 6px;
        }

        .table-wrap::-webkit-scrollbar-thumb {
            background: var(--surface-3);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #20262D;
            color: var(--muted);
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .6px;
            text-align: left;
            padding: 14px 17px;
            white-space: nowrap;
        }

        td {
            padding: 15px 17px;
            border-top: 1px solid var(--border);
            font-size: 10px;
            vertical-align: middle;
            color: #D5D9DD;
        }

        tbody tr {
            transition: background .18s ease;
        }

        tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        .tenant-name {
            font-weight: 700;
            color: var(--white);
            font-size: 11px;
        }

        .sub-text {
            color: var(--muted-dark);
            display: block;
            font-size: 9px;
            margin-top: 4px;
        }

        .amount {
            color: var(--primary-dark);
            font-weight: 800;
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-lunas { background: var(--green-bg); color: var(--green); }
        .status-belum { background: var(--orange-bg); color: var(--orange); }
        .status-menunggu { background: var(--blue-bg); color: var(--blue); }
        .status-terlambat { background: var(--red-bg); color: var(--red); }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-buttons form {
            display: flex;
        }

        .icon-btn {
            width: 30px;
            height: 30px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--surface-2);
            color: var(--primary-dark);
            display: grid;
            place-items: center;
            font-size: 13px;
            transition: background .2s ease, color .2s ease;
        }

        .icon-btn:hover {
            background: var(--surface-3);
        }

        .icon-btn.delete {
            color: var(--red);
            background: var(--red-bg);
            border-color: transparent;
        }

        .icon-btn.delete:hover {
            background: rgba(213,143,143,.23);
        }

        .empty-state {
            padding: 45px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 35px;
            display: block;
            margin-bottom: 10px;
            color: var(--muted-dark);
        }

        .empty-state strong {
            color: var(--white);
            font-size: 12px;
        }

        /* PAGINATION */
        .pagination-wrap {
            padding: 17px 22px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: var(--muted);
            font-size: 10px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            border-radius: 6px;
            display: grid;
            place-items: center;
            text-decoration: none;
            font-size: 10px;
            color: var(--text);
            background: var(--surface-2);
        }

        .pagination .active span {
            color: #191D22;
            background: var(--primary);
        }

        .pagination .disabled span {
            opacity: .4;
        }

        .pagination nav {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(5,8,11,.78);
            backdrop-filter: blur(4px);
            z-index: 300;
            padding: 20px;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 570px;
            max-height: 90vh;
            max-height: 90dvh;
            overflow-y: auto;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: 0 20px 70px rgba(0,0,0,.35);
            animation: modalIn .2s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 20px 23px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            color: var(--white);
            font-size: 20px;
        }

        .close-modal {
            border: 1px solid var(--border);
            background: var(--surface-2);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            color: var(--white);
            font-size: 18px;
        }

        .close-modal:hover {
            background: var(--surface-3);
        }

        .modal-body {
            padding: 22px 23px;
        }

        .form-grid,
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-grid .full,
        .detail-item.full {
            grid-column: 1 / -1;
        }

        textarea.control {
            resize: vertical;
            min-height: 85px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 16px 23px;
            border-top: 1px solid var(--border);
        }

        .detail-item {
            padding: 13px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 9px;
            min-width: 0;
        }

        .detail-item small {
            display: block;
            color: var(--muted);
            font-size: 9px;
            margin-bottom: 6px;
        }

        .detail-item strong {
            font-size: 11px;
            color: var(--white);
            overflow-wrap: anywhere;
        }

        #detailPembayaran {
            color: #D5D9DD;
        }

        .error-text {
            color: var(--red);
            font-size: 10px;
            margin-top: 5px;
        }

        /* MOBILE SIDEBAR OVERLAY */
        .overlay-sidebar {
            display: none;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .filters {
                grid-template-columns: 1fr 1fr;
            }

            .filter-actions {
                align-items: center;
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .overlay-sidebar.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.55);
                z-index: 90;
            }

            .main {
                margin-left: 0;
                padding: 23px;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 17px 13px;
            }

            .topbar {
                margin-bottom: 23px;
            }

            .page-title {
                font-size: 22px;
            }

            .profile-info {
                display: none;
            }

            .profile-avatar {
                width: 37px;
                height: 37px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
                margin-bottom: 20px;
            }

            .page-heading .btn {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 18px;
            }

            .stat-card {
                padding: 13px;
            }

            .stat-card h3 {
                font-size: 21px;
            }

            .stat-label {
                font-size: 9px;
            }

            .stat-icon {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            .filters {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .filter-actions {
                align-items: stretch;
            }

            .filter-actions .btn {
                flex: 1;
            }

            .card-header {
                padding: 17px 15px;
            }

            .pagination-wrap {
                padding: 15px;
            }

            .pagination-wrap {
                align-items: flex-start;
                flex-direction: column;
            }

            .form-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .form-grid .full,
            .detail-item.full {
                grid-column: auto;
            }

            .modal-overlay {
                padding: 10px;
                align-items: flex-start;
            }

            .modal {
                max-height: 95vh;
                max-height: 95dvh;
                margin: auto 0;
            }

            .modal-body {
                padding: 17px;
            }

            .modal-header,
            .modal-footer {
                padding: 15px 17px;
            }

            .modal-footer .btn {
                flex: 1;
            }
        }

        @media (max-width: 360px) {
            .main {
                padding-left: 10px;
                padding-right: 10px;
            }

            .page-title {
                font-size: 19px;
            }

            .stats-grid {
                gap: 8px;
            }

            .stat-card {
                padding: 11px;
            }

            .stat-card h3 {
                font-size: 19px;
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
<div class="layout">

    <div class="overlay-sidebar" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon"><i class="bi bi-house-heart"></i></div>
            <div>
                <div class="brand-name">KosHaven</div>
                <small>MANAGEMENT SYSTEM</small>
            </div>
        </div>

        <div class="sidebar-profile">
            <div class="sidebar-profile-avatar">A</div>
            <div>
                <div class="sidebar-profile-name">Administrator</div>
                <div class="sidebar-profile-role">Admin KosHaven</div>
            </div>
        </div>

        <div class="nav-label">MENU UTAMA</div>
        <nav class="nav-menu">
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

        <div class="nav-label">KEUANGAN</div>
        <nav class="nav-menu">
            <a href="{{ route('admin.tagihan.index') }}" class="active" aria-current="page">
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

        <div class="sidebar-bottom">
            <div class="nav-label">PENGATURAN</div>

            <nav class="nav-menu">
                <a href="{{ route('admin.profil.index') }}">
                    <i class="bi bi-person-circle"></i>
                    Profil Admin
                </a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin keluar dari halaman admin?')) document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </a>
            </nav>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                @csrf
            </form>
        </div>
    </aside>

    <main class="main">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" onclick="toggleSidebar()" aria-label="Buka menu" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="breadcrumb">Admin / <span>Tagihan</span></div>
                    <h1 class="page-title">Manajemen Tagihan</h1>
                </div>
            </div>

            <div class="admin-profile">
                <div class="profile-avatar"><i class="bi bi-person"></i></div>
                <div class="profile-info">
                    <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                    <small>Administrator</small>
                </div>
            </div>
        </header>

        <section class="page-heading">
            <div>
                <h2 style="font-size:17px;color:var(--white)">Daftar Tagihan Penghuni</h2>
                <p>Kelola tagihan dan pantau status pembayaran penghuni KosHaven.</p>
            </div>

            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i class="bi bi-plus-lg"></i> Tambah Tagihan
            </button>
        </section>

        <section class="stats-grid">
            <div class="stat-card stat-total">
                <div class="stat-top">
                    <span class="stat-label">Total Tagihan</span>
                    <span class="stat-icon"><i class="bi bi-receipt"></i></span>
                </div>
                <h3>{{ $ringkasan['total'] ?? 0 }}</h3>
                <small>Seluruh data tagihan</small>
            </div>

            <div class="stat-card stat-paid">
                <div class="stat-top">
                    <span class="stat-label">Lunas</span>
                    <span class="stat-icon"><i class="bi bi-check-circle"></i></span>
                </div>
                <h3>{{ $ringkasan['lunas'] ?? 0 }}</h3>
                <small>Tagihan telah dibayar</small>
            </div>

            <div class="stat-card stat-unpaid">
                <div class="stat-top">
                    <span class="stat-label">Belum Dibayar</span>
                    <span class="stat-icon"><i class="bi bi-clock"></i></span>
                </div>
                <h3>{{ $ringkasan['belum_dibayar'] ?? 0 }}</h3>
                <small>Menunggu pembayaran</small>
            </div>

            <div class="stat-card stat-pending">
                <div class="stat-top">
                    <span class="stat-label">Menunggu Verifikasi</span>
                    <span class="stat-icon"><i class="bi bi-hourglass-split"></i></span>
                </div>
                <h3>{{ $ringkasan['menunggu_verifikasi'] ?? 0 }}</h3>
                <small>Pembayaran perlu diperiksa</small>
            </div>

            <div class="stat-card stat-late">
                <div class="stat-top">
                    <span class="stat-label">Terlambat</span>
                    <span class="stat-icon"><i class="bi bi-exclamation-circle"></i></span>
                </div>
                <h3>{{ $ringkasan['terlambat'] ?? 0 }}</h3>
                <small>Melewati tanggal jatuh tempo</small>
            </div>
        </section>

        <section class="content-card">
            <div class="card-header">
                <div>
                    <h2>Data Tagihan</h2>
                    <p>Data tagihan yang tersimpan di database.</p>
                </div>
            </div>

            <form action="{{ route('admin.tagihan.index') }}" method="GET" class="filters">
                <div class="field">
                    <label for="search">Cari Tagihan</label>
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input class="control" type="text" id="search" name="search"
                               value="{{ request('search') }}"
                               placeholder="Nama penghuni atau nomor kamar...">
                    </div>
                </div>

                <div class="field">
                    <label for="status">Status</label>
                    <select class="control" name="status" id="status">
                        <option value="">Semua Status</option>
                        <option value="lunas" @selected(request('status') === 'lunas')>Lunas</option>
                        <option value="belum_dibayar" @selected(request('status') === 'belum_dibayar')>Belum Dibayar</option>
                        <option value="menunggu_verifikasi" @selected(request('status') === 'menunggu_verifikasi')>Menunggu Verifikasi</option>
                        <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
                    </select>
                </div>

                <div class="field">
                    <label for="periode">Periode</label>
                    <input class="control" type="month" name="periode" id="periode"
                           value="{{ request('periode') }}">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-light">
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($tagihans as $index => $tagihan)
                        @php
                            $booking = $tagihan->booking;
                            $penghuniNama = $booking?->user?->name ?? 'Penghuni tidak ditemukan';
                            $nomorKamar = $booking?->kamar?->nomor_kamar ?? '-';
                            $statusTampilan = $tagihan->status_tampilan ?? $tagihan->status;

                            $statusLabel = [
                                'lunas' => 'Lunas',
                                'belum_dibayar' => 'Belum Dibayar',
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'terlambat' => 'Terlambat',
                            ][$statusTampilan] ?? ucfirst(str_replace('_', ' ', $statusTampilan));

                            $statusClass = [
                                'lunas' => 'status-lunas',
                                'belum_dibayar' => 'status-belum',
                                'menunggu_verifikasi' => 'status-menunggu',
                                'terlambat' => 'status-terlambat',
                            ][$statusTampilan] ?? 'status-belum';

                            $detailData = [
                                'id' => $tagihan->id,
                                'nama' => $penghuniNama,
                                'email' => $booking?->user?->email ?? '-',
                                'kamar' => $nomorKamar,
                                'booking' => $tagihan->booking_id,
                                'periode' => $tagihan->periode,
                                'jumlah' => $tagihan->jumlah,
                                'tanggal_terbit' => $tagihan->tanggal_terbit?->format('Y-m-d'),
                                'tanggal_jatuh_tempo' => $tagihan->tanggal_jatuh_tempo?->format('Y-m-d'),
                                'status' => $tagihan->status,
                                'status_tampilan' => $statusTampilan,
                                'keterangan' => $tagihan->keterangan ?? '-',
                                'pembayaran' => $tagihan->pembayarans->map(function ($p) {
                                    return [
                                        'jumlah' => $p->jumlah_bayar,
                                        'metode' => $p->metode,
                                        'tanggal' => $p->tanggal_pembayaran,
                                        'status' => $p->status,
                                    ];
                                })->values(),
                            ];
                        @endphp

                        <tr>
                            <td>{{ $tagihans->firstItem() + $index }}</td>

                            <td>
                                <span class="tenant-name">{{ $penghuniNama }}</span>
                                <span class="sub-text">{{ $booking?->user?->email ?? '-' }}</span>
                            </td>

                            <td>
                                <strong>{{ $nomorKamar }}</strong>
                            </td>

                            <td>{{ $tagihan->periode }}</td>

                            <td class="amount">
                                Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $tagihan->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td>
                                <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="icon-btn"
                                            title="Detail"
                                            aria-label="Lihat detail tagihan"
                                            onclick='openDetailModal(@json($detailData))'>
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button type="button" class="icon-btn"
                                            title="Edit"
                                            aria-label="Edit tagihan"
                                            onclick='openEditModal(@json($detailData))'>
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <form action="{{ route('admin.tagihan.destroy', $tagihan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus tagihan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="icon-btn delete" title="Hapus" aria-label="Hapus tagihan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-receipt"></i>
                                    <strong>Belum ada data tagihan</strong>
                                    <p style="font-size:10px;margin-top:5px">
                                        Data tagihan yang sesuai dengan pencarian belum ditemukan.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan {{ $tagihans->firstItem() ?? 0 }}
                    - {{ $tagihans->lastItem() ?? 0 }}
                    dari {{ $tagihans->total() }} data
                </div>

                @if($tagihans->hasPages())
                    <div class="pagination">
                        {{ $tagihans->withQueryString()->links('pagination::simple-bootstrap-5') }}
                    </div>
                @endif
            </div>
        </section>

    </main>
</div>

{{-- MODAL TAMBAH / EDIT --}}
<div class="modal-overlay" id="billModal" role="dialog" aria-modal="true" aria-labelledby="billModalTitle">
    <div class="modal">
        <div class="modal-header">
            <h3 id="billModalTitle">Tambah Tagihan</h3>
            <button type="button" class="close-modal" onclick="closeBillModal()" aria-label="Tutup modal">&times;</button>
        </div>

        <form id="billForm" action="{{ route('admin.tagihan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="billMethod" value="POST">

            <div class="modal-body">
                <div class="form-grid">
                    <div class="field full">
                        <label for="bookingSelect">Penghuni dan Kamar <span style="color:var(--red)">*</span></label>

                        <select class="control" id="bookingSelect" name="booking_id" required>
                            <option value="">Pilih penghuni</option>
                            @foreach($penghuni as $orang)
                                @if($orang->booking_aktif)
                                    <option value="{{ $orang->booking_aktif->id }}">
                                        {{ $orang->name }}
                                        — Kamar {{ $orang->booking_aktif->kamar?->nomor_kamar ?? '-' }}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        {{-- Dipakai saat edit agar booking_id tetap terkirim meskipun select dinonaktifkan. --}}
                        <input type="hidden" id="bookingIdHidden" disabled>
                    </div>

                    <div class="field">
                        <label for="periodeInput">Periode <span style="color:var(--red)">*</span></label>
                        <input class="control" type="month" id="periodeInput" name="periode" required>
                    </div>

                    <div class="field">
                        <label for="jumlahInput">Jumlah Tagihan <span style="color:var(--red)">*</span></label>
                        <input class="control" type="number" id="jumlahInput" name="jumlah"
                               min="1" step="1" placeholder="Contoh: 1500000" required>
                    </div>

                    <div class="field">
                        <label for="terbitInput">Tanggal Terbit <span style="color:var(--red)">*</span></label>
                        <input class="control" type="date" id="terbitInput" name="tanggal_terbit" required>
                    </div>

                    <div class="field">
                        <label for="tempoInput">Tanggal Jatuh Tempo <span style="color:var(--red)">*</span></label>
                        <input class="control" type="date" id="tempoInput" name="tanggal_jatuh_tempo" required>
                    </div>

                    <div class="field full" id="statusField" style="display:none">
                        <label for="statusInput">Status Tagihan</label>
                        <select class="control" name="status" id="statusInput">
                            <option value="belum_dibayar">Belum Dibayar</option>
                            <option value="lunas">Lunas</option>
                            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="terlambat">Terlambat</option>
                        </select>
                    </div>

                    <div class="field full">
                        <label for="keteranganInput">Keterangan</label>
                        <textarea class="control" id="keteranganInput" name="keterangan"
                                  placeholder="Tambahkan keterangan tagihan..."></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="closeBillModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="saveBillButton">
                    <i class="bi bi-check-lg"></i> Simpan Tagihan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal-overlay" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="detailModalTitle">
    <div class="modal">
        <div class="modal-header">
            <h3 id="detailModalTitle">Detail Tagihan</h3>
            <button type="button" class="close-modal" onclick="closeDetailModal()" aria-label="Tutup modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <small>Nama Penghuni</small>
                    <strong id="detailNama">-</strong>
                </div>

                <div class="detail-item">
                    <small>Email</small>
                    <strong id="detailEmail">-</strong>
                </div>

                <div class="detail-item">
                    <small>Nomor Kamar</small>
                    <strong id="detailKamar">-</strong>
                </div>

                <div class="detail-item">
                    <small>Periode</small>
                    <strong id="detailPeriode">-</strong>
                </div>

                <div class="detail-item">
                    <small>Jumlah Tagihan</small>
                    <strong id="detailJumlah">-</strong>
                </div>

                <div class="detail-item">
                    <small>Status</small>
                    <strong id="detailStatus">-</strong>
                </div>

                <div class="detail-item">
                    <small>Tanggal Terbit</small>
                    <strong id="detailTerbit">-</strong>
                </div>

                <div class="detail-item">
                    <small>Jatuh Tempo</small>
                    <strong id="detailTempo">-</strong>
                </div>

                <div class="detail-item full">
                    <small>Keterangan</small>
                    <strong id="detailKeterangan">-</strong>
                </div>

                <div class="detail-item full">
                    <small>Riwayat Pembayaran</small>
                    <div id="detailPembayaran" style="font-size:10px;line-height:1.8">-</div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    const billModal = document.getElementById('billModal');
    const detailModal = document.getElementById('detailModal');
    const billForm = document.getElementById('billForm');

    const bookingSelect = document.getElementById('bookingSelect');
    const bookingIdHidden = document.getElementById('bookingIdHidden');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const menuToggle = document.querySelector('.menu-toggle');

    const storeUrl = @json(route('admin.tagihan.store'));
    const updateBaseUrl = @json(url('/admin/tagihan'));

    function toggleSidebar() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
        menuToggle?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
        menuToggle?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 850) {
            closeSidebar();
        }
    });

    function openCreateModal() {
        billForm.reset();

        billForm.action = storeUrl;
        document.getElementById('billMethod').value = 'POST';
        document.getElementById('billModalTitle').textContent = 'Tambah Tagihan';

        document.getElementById('saveBillButton').innerHTML =
            '<i class="bi bi-check-lg"></i> Simpan Tagihan';

        bookingSelect.disabled = false;
        bookingSelect.name = 'booking_id';
        bookingSelect.value = '';

        bookingIdHidden.disabled = true;
        bookingIdHidden.removeAttribute('name');
        bookingIdHidden.value = '';

        document.getElementById('statusField').style.display = 'none';
        document.getElementById('statusInput').value = 'belum_dibayar';

        billModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function openEditModal(data) {
        billForm.reset();

        billForm.action = updateBaseUrl + '/' + encodeURIComponent(data.id);
        document.getElementById('billMethod').value = 'PUT';
        document.getElementById('billModalTitle').textContent = 'Edit Tagihan';

        document.getElementById('saveBillButton').innerHTML =
            '<i class="bi bi-check-lg"></i> Simpan Perubahan';

        // Saat edit, dropdown dikunci dan booking_id dikirim melalui hidden input.
        bookingSelect.disabled = true;
        bookingSelect.removeAttribute('name');
        bookingSelect.value = String(data.booking || '');

        bookingIdHidden.name = 'booking_id';
        bookingIdHidden.value = data.booking || '';
        bookingIdHidden.disabled = false;

        document.getElementById('periodeInput').value = data.periode || '';
        document.getElementById('jumlahInput').value = data.jumlah || '';
        document.getElementById('terbitInput').value = data.tanggal_terbit || '';
        document.getElementById('tempoInput').value = data.tanggal_jatuh_tempo || '';
        document.getElementById('statusInput').value = data.status || 'belum_dibayar';

        document.getElementById('keteranganInput').value =
            data.keterangan === '-' ? '' : (data.keterangan || '');

        document.getElementById('statusField').style.display = 'block';

        billModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeBillModal() {
        billModal.classList.remove('show');

        bookingSelect.disabled = false;
        bookingSelect.name = 'booking_id';

        bookingIdHidden.disabled = true;
        bookingIdHidden.removeAttribute('name');
        bookingIdHidden.value = '';

        document.body.style.overflow = '';
    }

    function openDetailModal(data) {
        document.getElementById('detailNama').textContent = data.nama || '-';
        document.getElementById('detailEmail').textContent = data.email || '-';
        document.getElementById('detailKamar').textContent = data.kamar || '-';
        document.getElementById('detailPeriode').textContent = data.periode || '-';

        document.getElementById('detailJumlah').textContent =
            'Rp ' + Number(data.jumlah || 0).toLocaleString('id-ID');

        document.getElementById('detailStatus').textContent =
            String(data.status_tampilan || data.status || '-').replaceAll('_', ' ');

        document.getElementById('detailTerbit').textContent =
            formatDate(data.tanggal_terbit);

        document.getElementById('detailTempo').textContent =
            formatDate(data.tanggal_jatuh_tempo);

        document.getElementById('detailKeterangan').textContent =
            data.keterangan || '-';

        const paymentContainer = document.getElementById('detailPembayaran');
        paymentContainer.replaceChildren();

        if (!data.pembayaran || data.pembayaran.length === 0) {
            paymentContainer.textContent = 'Belum ada riwayat pembayaran.';
        } else {
            data.pembayaran.forEach((payment, index) => {
                const item = document.createElement('div');

                const tanggal = payment.tanggal
                    ? ' — ' + formatDate(String(payment.tanggal).substring(0, 10))
                    : '';

                item.textContent =
                    (index + 1) + '. Rp ' +
                    Number(payment.jumlah || 0).toLocaleString('id-ID') +
                    ' — ' + (payment.metode || '-') +
                    ' — ' + (payment.status || '-') +
                    tanggal;

                paymentContainer.appendChild(item);
            });
        }

        detailModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        detailModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    function formatDate(value) {
        if (!value) return '-';

        const parts = value.split('-');

        if (parts.length !== 3) return value;

        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    [billModal, detailModal].forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeBillModal();
            closeDetailModal();
            closeSidebar();
        }
    });

    // Validasi tanggal dan nominal sebelum form dikirim.
    billForm.addEventListener('submit', function(event) {
        const periode = document.getElementById('periodeInput').value;
        const terbit = document.getElementById('terbitInput').value;
        const tempo = document.getElementById('tempoInput').value;
        const jumlahInput = document.getElementById('jumlahInput');
        const jumlah = Number(jumlahInput.value);

        if (!periode || !terbit || !tempo || !Number.isFinite(jumlah) || jumlah <= 0) {
            event.preventDefault();
            alert('Lengkapi semua data wajib dengan benar.');
            return;
        }

        if (!bookingSelect.value && document.getElementById('billMethod').value === 'POST') {
            event.preventDefault();
            alert('Silakan pilih penghuni dan kamar terlebih dahulu.');
            bookingSelect.focus();
            return;
        }

        if (tempo < terbit) {
            event.preventDefault();
            alert('Tanggal jatuh tempo tidak boleh sebelum tanggal terbit.');
            return;
        }

        if (terbit.substring(0, 7) !== periode || tempo.substring(0, 7) !== periode) {
            event.preventDefault();
            alert('Tanggal terbit dan jatuh tempo harus berada pada periode tagihan yang dipilih.');
            return;
        }

        if (!Number.isSafeInteger(jumlah)) {
            event.preventDefault();
            alert('Jumlah tagihan harus berupa angka bulat yang valid.');
            return;
        }
    });
</script>

</body>
</html>