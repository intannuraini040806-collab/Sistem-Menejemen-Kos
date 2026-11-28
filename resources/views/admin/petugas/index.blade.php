
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Petugas - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #191D22;
            --primary-light: #2D343D;
            --primary-deep: #12161B;
            --primary-soft: #303943;
            --gold: #C6A477;
            --gold-light: #38332B;
            --gold-hover: #E0C49B;
            --background: #171B20;
            --white: #242A31;
            --surface: #2D343D;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: #3B444E;
            --danger: #D58F8F;
            --success: #91AE9B;
            --silver: #BBC4CD;
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
            min-height: 100vh;
        }

        body.sidebar-open,
        body.modal-open {
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input {
            font-family: inherit;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
        }

        /* SIDEBAR */

        .sidebar {
            width: 255px;
            height: 100vh;
            height: 100dvh;
            background: var(--primary-deep);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 17px 18px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .22s ease-out;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #58616B transparent;
            -webkit-overflow-scrolling: touch;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #58616B;
            border-radius: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 11px 24px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(198,164,119,.14);
            color: var(--gold-hover);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 11px;
            font-size: 19px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: #F4F0E8;
            line-height: 1.1;
        }

        .brand-name span {
            color: var(--gold);
        }

        .brand small {
            display: block;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.35px;
            color: var(--muted-dark);
            margin-top: 5px;
        }

        .menu-label {
            font-size: 9px;
            color: #7E8994;
            letter-spacing: 1.6px;
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
            padding: 11px 13px;
            border-radius: 8px;
            color: #B9C0C8;
            font-size: 12px;
            font-weight: 500;
            transition: background .16s ease, color .16s ease;
            min-height: 42px;
        }

        .menu a i {
            font-size: 17px;
            width: 19px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu a:hover {
            background: rgba(255,255,255,.065);
            color: var(--gold-hover);
        }

        .menu a.active {
            background: rgba(198,164,119,.13);
            color: var(--gold-hover);
            border-left: 3px solid var(--gold);
            padding-left: 10px;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.1);
            padding-top: 14px;
            flex-shrink: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 8px;
            min-width: 0;
        }

        .admin-avatar {
            width: 39px;
            height: 39px;
            background: linear-gradient(145deg, #E0C49B, #A98A60);
            color: #191D22;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }

        .admin-info strong {
            display: block;
            font-size: 11px;
            color: #F1F0EC;
            overflow-wrap: anywhere;
        }

        .admin-info small {
            color: #87919B;
            font-size: 10px;
        }

       /* LOGOUT MODAL - SIDEBAR DATA PETUGAS */
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
            padding: 11px 13px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: transparent;
            color: #B9C0C8;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            cursor: pointer;
            transition: background .16s ease, color .16s ease;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            background: rgba(213,143,143,.1);
            color: var(--danger);
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MAIN */

        .main {
            margin-left: 255px;
            min-height: 100vh;
            min-width: 0;
            transition: margin .22s ease-out;
        }

        .topbar {
            min-height: 75px;
            background: rgba(30,35,41,.96);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 34px;
            position: sticky;
            top: 0;
            z-index: 50;
            gap: 15px;
            backdrop-filter: blur(12px);
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
            font-size: 10px;
            color: var(--muted);
            margin-top: 4px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--border);
            background: var(--white);
            font-size: 21px;
            color: var(--gold);
            cursor: pointer;
            padding: 6px 9px;
            line-height: 1;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-label {
            padding: 9px 13px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
            font-size: 10px;
            white-space: nowrap;
        }

        .date-label i {
            color: var(--gold);
            margin-right: 5px;
        }

        .content {
            padding: 31px 34px;
            max-width: 1600px;
            margin: auto;
            width: 100%;
            min-width: 0;
        }

        /* WELCOME */

        .welcome {
            margin-bottom: 26px;
        }

        .welcome h1 {
            font-family: 'Playfair Display', serif;
            font-size: 29px;
            color: var(--text);
            letter-spacing: -.4px;
        }

        .welcome p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.7;
        }

        .breadcrumb {
            font-size: 10px;
            color: var(--muted-dark);
            margin-bottom: 12px;
        }

        .breadcrumb span {
            color: var(--gold);
            font-weight: 700;
        }

        /* ALERT */

        .alert {
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 19px;
            font-size: 11px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.7;
        }

        .alert-success {
            background: rgba(145,174,155,.1);
            color: #B3D0BB;
            border: 1px solid rgba(145,174,155,.24);
        }

        .alert-danger {
            background: rgba(213,143,143,.1);
            color: #E5AAAA;
            border: 1px solid rgba(213,143,143,.24);
        }

        .alert ul {
            padding-left: 18px;
            margin-top: 4px;
        }

        /* STATISTIK */

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 21px;
            transition: transform .18s ease, border-color .18s ease;
            position: relative;
            overflow: hidden;
            min-width: 0;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            right: -22px;
            bottom: -38px;
            width: 105px;
            height: 105px;
            border-radius: 50%;
            background: rgba(198,164,119,.08);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(198,164,119,.4);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 17px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(198,164,119,.12);
            color: var(--gold);
            border: 1px solid rgba(198,164,119,.13);
            border-radius: 10px;
            font-size: 19px;
        }

        .stat-card h3 {
            font-size: 26px;
            color: var(--text);
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
            font-weight: 700;
        }

        .stat-card p {
            font-size: 11px;
            color: var(--muted);
            position: relative;
            z-index: 1;
        }

        /* PANEL */

        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 23px;
            min-width: 0;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 21px;
            gap: 15px;
        }

        .panel-heading h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            color: var(--text);
            white-space: nowrap;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        /* INPUT DAN BUTTON */

        input {
            font: inherit;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 11px 13px;
            outline: none;
            background: #1C2229;
            color: var(--text);
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        input::placeholder {
            color: #75808B;
        }

        input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.1);
        }

        .search {
            width: 235px;
            font-size: 11px;
            min-width: 0;
        }

        button {
            border: none;
            cursor: pointer;
            font: 600 11px 'DM Sans', sans-serif;
            border-radius: 8px;
            padding: 11px 15px;
            transition: background .16s ease, color .16s ease, border-color .16s ease;
        }

        button:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .btn-primary {
            background: var(--gold);
            color: #191D22;
        }

        .btn-primary:hover {
            background: var(--gold-hover);
        }

        .btn-light {
            background: #343B43;
            color: var(--silver);
            border: 1px solid var(--border);
        }

        .btn-light:hover {
            background: #414A54;
            color: #fff;
        }

        /* TABEL */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            scrollbar-width: thin;
            scrollbar-color: #68727D #242A31;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #242A31;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #68727D;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: #303740;
            color: #B5BEC7;
            font-size: 9px;
            text-align: left;
            padding: 14px 12px;
            font-weight: 700;
            letter-spacing: .7px;
            white-space: nowrap;
        }

        th:first-child {
            border-radius: 7px 0 0 7px;
        }

        th:last-child {
            border-radius: 0 7px 7px 0;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #363E47;
            font-size: 11px;
            vertical-align: middle;
            color: #D5D9DD;
        }

        tbody tr {
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #2B323A;
        }

        .person {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .person-icon {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(198,164,119,.14);
            color: var(--gold-hover);
            border: 1px solid rgba(198,164,119,.16);
            font-weight: 700;
            font-size: 12px;
            flex-shrink: 0;
        }

        .person strong {
            display: block;
            font-size: 11px;
            color: var(--text);
            margin-bottom: 3px;
        }

        .person small {
            color: var(--muted-dark);
            font-size: 9px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }

        .terdaftar {
            color: #A9C8B1;
            background: rgba(145,174,155,.12);
            border: 1px solid rgba(145,174,155,.17);
        }

        .edit {
            background: rgba(198,164,119,.14);
            color: var(--gold-hover);
            margin-right: 4px;
            padding: 8px 10px;
        }

        .edit:hover {
            background: rgba(198,164,119,.25);
        }

        .delete {
            background: rgba(213,143,143,.12);
            color: var(--danger);
            padding: 8px 10px;
        }

        .delete:hover {
            background: rgba(213,143,143,.22);
        }

        .empty {
            text-align: center;
            color: var(--muted);
            padding: 32px;
            font-size: 11px;
        }

        /* PAGINATION */

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .pagination-info {
            color: var(--muted);
            font-size: 10px;
        }

        .pagination {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 9px;
            border-radius: 7px;
            border: 1px solid var(--border);
            font-size: 10px;
            color: var(--silver);
            background: #303740;
        }

        .pagination a:hover,
        .pagination .current {
            background: var(--gold);
            color: #191D22;
            border-color: var(--gold);
        }

        .pagination .disabled {
            color: #737D87;
            background: #252B32;
        }

        /* MODAL */

        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(5,8,12,.78);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .modal {
            background: #252C34;
            border: 1px solid #414A54;
            width: 100%;
            max-width: 490px;
            border-radius: 13px;
            padding: 27px;
            max-height: 90vh;
            max-height: 90dvh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            animation: modalIn .16s ease-out;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(7px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 10px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal-head h3 {
            font: 700 21px 'Playfair Display', serif;
            color: var(--text);
        }

        .close {
            background: transparent;
            color: var(--muted);
            font-size: 23px;
            padding: 0 5px;
        }

        .close:hover {
            color: var(--danger);
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #D8DDE1;
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            font-size: 11px;
            background: #1B2128;
        }

        .field small {
            display: block;
            color: var(--muted);
            font-size: 9px;
            line-height: 1.6;
            margin-top: 6px;
        }

        .field-error {
            display: block;
            color: var(--danger);
            font-size: 10px;
            margin-top: 6px;
        }

        .input-error {
            border-color: var(--danger) !important;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 23px;
        }

        /* FOOTER */

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 10px;
            padding: 26px 0 5px;
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 1200px) {
            .content {
                padding: 27px 25px;
            }

            .topbar {
                padding: 12px 25px;
            }

            .search {
                width: 200px;
            }
        }

        @media (max-width: 1050px) {
            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .actions {
                width: 100%;
            }

            .search {
                flex: 1;
                min-width: 0;
            }
        }

        /* RESPONSIVE SIDEBAR */

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 8px 0 30px rgba(0,0,0,.35);
                height: 100vh;
                height: 100dvh;
                overflow-y: auto;
                overscroll-behavior-y: contain;
                padding-bottom: 20px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.58);
                z-index: 999;
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .sidebar-bottom {
                margin-top: 22px;
            }
        }

        /* RESPONSIVE HP */

        @media (max-width: 600px) {
            .topbar {
                min-height: 66px;
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

            .topbar-right {
                gap: 5px;
            }

            .date-label {
                font-size: 9px;
                padding: 8px;
            }

            .content {
                padding: 22px 15px;
            }

            .welcome h1 {
                font-size: 24px;
            }

            .welcome p {
                font-size: 11px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 17px;
            }

            .stat-card h3 {
                font-size: 23px;
            }

            .panel {
                padding: 17px;
            }

            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .panel-heading h3 {
                font-size: 18px;
            }

            .actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .actions form {
                width: 100%;
                flex-wrap: wrap;
            }

            .search {
                width: 100%;
                flex: 1 1 100%;
            }

            .actions form button,
            .actions form a {
                flex: 1;
            }

            .actions > button {
                width: 100%;
            }

            .modal {
                padding: 21px;
            }

            .modal-buttons {
                flex-direction: column-reverse;
            }

            .modal-buttons button {
                width: 100%;
            }

            .pagination-wrapper {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 380px) {
            .topbar {
                padding-left: 11px;
                padding-right: 11px;
            }

            .topbar h2 {
                font-size: 15px;
            }

            .date-label {
                font-size: 8px;
                padding: 7px;
            }

            .content {
                padding-left: 11px;
                padding-right: 11px;
            }

            .panel {
                padding: 14px;
            }

            .welcome h1 {
                font-size: 21px;
            }

            .modal {
                padding: 17px;
            }

            .sidebar {
                width: min(285px, 85vw);
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
    <div class="sidebar-overlay" id="sidebarOverlay"
         onclick="closeSidebar()" aria-hidden="true"></div>

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
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <a href="{{ route('admin.kamar.index') }}">
                <i class="bi bi-door-open"></i> Data Kamar
            </a>

            <a href="{{ route('admin.booking.index') }}">
                <i class="bi bi-calendar-check"></i> Booking Kos
            </a>

            <a href="{{ route('admin.penghuni.index') }}">
                <i class="bi bi-people"></i> Data Penghuni
            </a>

            <a href="{{ route('admin.petugas.index') }}" class="active" aria-current="page">
                <i class="bi bi-person-badge"></i> Data Petugas
            </a>

            <a href="{{ route('admin.pengguna.index') }}">
                <i class="bi bi-person-gear"></i> Manajemen Pengguna
            </a>

            <a href="{{ route('admin.tagihan.index') }}">
                <i class="bi bi-receipt"></i> Data Tagihan
            </a>

            <a href="{{ route('admin.pembayaran.index') }}">
                <i class="bi bi-wallet2"></i> Data Pembayaran
            </a>

            <a href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>

        </nav>

        <div class="menu-label">PENGATURAN</div>

        <nav class="menu" aria-label="Pengaturan">
            <a href="{{ route('admin.profil.index') }}">
                <i class="bi bi-person-circle"></i> Profil
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="admin-info">
                <div class="admin-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div>
                    <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                    <small>Admin KosHaven</small>
                </div>
            </div>

            <div class="kh-logout-component-wrapper">
                @include('components.logout-modal')
            </div>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

        <header class="topbar">

            <div class="topbar-left">

                <button type="button" class="menu-toggle"
                        id="menuToggle"
                        onclick="toggleSidebar()"
                        aria-label="Buka menu navigasi"
                        aria-expanded="false"
                        aria-controls="sidebar">
                    <i class="bi bi-list" id="menuToggleIcon"></i>
                </button>

                <div>
                    <h2>Data Petugas</h2>
                    <p>Panel pengelolaan KosHaven</p>
                </div>

            </div>

            <div class="topbar-right">
                <div class="date-label" id="currentDate">
                    <i class="bi bi-calendar3"></i>
                    Memuat tanggal...
                </div>
            </div>

        </header>

        <div class="content">

            <!-- WELCOME -->
            <section class="welcome">

                <div class="breadcrumb">
                    Dashboard / <span>Data Petugas</span>
                </div>

                <h1>Data Petugas</h1>

                <p>
                    Kelola informasi petugas yang bertugas dan membantu
                    operasional KosHaven.
                </p>

            </section>

            <!-- NOTIFIKASI -->
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong>Periksa kembali data yang dimasukkan:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- STATISTIK -->
            <section class="stats">

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>

                    <h3>{{ number_format($totalPetugas, 0, ',', '.') }}</h3>
                    <p>Total Petugas Terdaftar</p>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>

                    <h3>{{ $petugas->total() }}</h3>
                    <p>Data Petugas pada Hasil Pencarian</p>
                </div>

            </section>

            <!-- DAFTAR PETUGAS -->
            <section class="panel">

                <div class="panel-heading">

                    <h3>Daftar Petugas</h3>

                    <div class="actions">

                        <form action="{{ route('admin.petugas.index') }}"
                              method="GET"
                              style="display:flex;gap:10px;flex:1;min-width:0;">

                            <input
                                id="search"
                                class="search"
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, email, atau telepon..."
                                aria-label="Cari petugas"
                            >

                            <button type="submit" class="btn-light">
                                <i class="bi bi-search"></i>
                                Cari
                            </button>

                            @if(request('search'))
                                <a href="{{ route('admin.petugas.index') }}"
                                   class="btn-light"
                                   style="display:flex;align-items:center;justify-content:center;white-space:nowrap;">
                                    Reset
                                </a>
                            @endif

                        </form>

                        <button type="button" class="btn-primary"
                                onclick="openAddModal()">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Petugas
                        </button>

                    </div>

                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA PETUGAS</th>
                                <th>NO. TELEPON</th>
                                <th>EMAIL</th>
                                <th>STATUS AKUN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($petugas as $index => $item)

                                <tr>

                                    <td>
                                        {{ $petugas->firstItem() + $index }}
                                    </td>

                                    <td>
                                        <div class="person">

                                            <div class="person-icon">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <strong>{{ $item->name }}</strong>
                                                <small>Petugas KosHaven</small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>{{ $item->phone ?: '-' }}</td>

                                    <td>{{ $item->email }}</td>

                                    <td>
                                        <span class="status terdaftar">
                                            <i class="bi bi-check-circle"></i>
                                            Akun Terdaftar
                                        </span>
                                    </td>

                                    <td>

                                        <button
                                            type="button"
                                            class="edit"
                                            onclick="openEditModal(
                                                {{ $item->id }},
                                                {{ Js::from($item->name) }},
                                                {{ Js::from($item->email) }},
                                                {{ Js::from($item->phone ?? '') }}
                                            )"
                                            title="Edit petugas"
                                            aria-label="Edit petugas {{ $item->name }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form
                                            action="{{ route('admin.petugas.destroy', $item->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus akun petugas {{ addslashes($item->name) }}?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="delete"
                                                title="Hapus petugas"
                                                aria-label="Hapus petugas">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="empty">
                                        <i class="bi bi-people"
                                           style="font-size:25px;display:block;margin-bottom:8px;"></i>

                                        @if(request('search'))
                                            Data petugas dengan kata kunci
                                            "{{ request('search') }}"
                                            tidak ditemukan.
                                        @else
                                            Belum ada data petugas yang terdaftar.
                                        @endif
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                @if($petugas->hasPages() || $petugas->total() > 0)

                    <div class="pagination-wrapper">

                        <div class="pagination-info">
                            Menampilkan
                            {{ $petugas->firstItem() ?? 0 }}
                            sampai
                            {{ $petugas->lastItem() ?? 0 }}
                            dari
                            {{ $petugas->total() }}
                            petugas
                        </div>

                        <div class="pagination">

                            @if($petugas->onFirstPage())
                                <span class="disabled">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $petugas->previousPageUrl() }}"
                                   aria-label="Halaman sebelumnya">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            @endif

                            @foreach($petugas->getUrlRange(1, $petugas->lastPage()) as $page => $url)

                                @if($page == $petugas->currentPage())
                                    <span class="current">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif

                            @endforeach

                            @if($petugas->hasMorePages())
                                <a href="{{ $petugas->nextPageUrl() }}"
                                   aria-label="Halaman berikutnya">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            @else
                                <span class="disabled">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            @endif

                        </div>

                    </div>

                @endif

            </section>

            <div class="footer">
                © {{ date('Y') }} KosHaven. Sistem Manajemen Kos.
            </div>

        </div>

    </main>

    <!-- MODAL TAMBAH / EDIT -->
    <div class="modal-bg" id="modalBg"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalTitle">

        <div class="modal">

            <div class="modal-head">

                <h3 id="modalTitle">Tambah Petugas</h3>

                <button type="button" class="close"
                        onclick="closeModal()"
                        aria-label="Tutup modal">
                    &times;
                </button>

            </div>

            <form id="staffForm"
                  action="{{ route('admin.petugas.store') }}"
                  method="POST">

                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="petugas_id" id="petugasId" value="{{ old('petugas_id') }}">

                <div class="field">

                    <label for="name">Nama Lengkap *</label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        minlength="3"
                        maxlength="255"
                        autocomplete="name"
                        placeholder="Masukkan nama petugas"
                        value="{{ old('name') }}"
                    >

                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="field">

                    <label for="email">Email *</label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        maxlength="255"
                        autocomplete="email"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                    >

                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="field">

                    <label for="phone">Nomor Telepon *</label>

                    <input
                        id="phone"
                        name="phone"
                        type="tel"
                        required
                        maxlength="20"
                        inputmode="tel"
                        autocomplete="tel"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('phone') }}"
                    >

                    @error('phone')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="field">

                    <label for="password">
                        Password
                        <span id="passwordRequired">*</span>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        minlength="8"
                        maxlength="72"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                    >

                    <small id="passwordHint">
                        Password wajib diisi untuk akun petugas baru.
                    </small>

                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="field">

                    <label for="password_confirmation">
                        Konfirmasi Password
                        <span id="confirmationRequired">*</span>
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        minlength="8"
                        maxlength="72"
                        autocomplete="new-password"
                        placeholder="Ulangi password"
                    >

                </div>

                <div class="modal-buttons">

                    <button type="button" class="btn-light"
                            onclick="closeModal()">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary"
                            id="submitButton">
                        <i class="bi bi-check-lg"></i>
                        Simpan Petugas
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        // ==========================================
        // SIDEBAR
        // ==========================================

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const menuToggleIcon = document.getElementById('menuToggleIcon');

        function openSidebar() {
            if (window.innerWidth > 850) return;

            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.classList.add('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Tutup menu navigasi');
            menuToggleIcon.className = 'bi bi-x-lg';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Buka menu navigasi');
            menuToggleIcon.className = 'bi bi-list';
        }

        function toggleSidebar() {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        document.querySelectorAll('.sidebar .menu a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 850) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 850) {
                closeSidebar();
            }
        });

        // ==========================================
        // TANGGAL
        // ==========================================

        function displayDate() {
            const today = new Date();

            document.getElementById('currentDate').innerHTML =
                '<i class="bi bi-calendar3"></i> ' +
                today.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
        }

        displayDate();

        // ==========================================
        // MODAL
        // ==========================================

        const modalBg = document.getElementById('modalBg');
        const staffForm = document.getElementById('staffForm');

        const formMethod = document.getElementById('formMethod');
        const petugasId = document.getElementById('petugasId');
        const modalTitle = document.getElementById('modalTitle');

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');

        const passwordInput = document.getElementById('password');
        const confirmationInput = document.getElementById('password_confirmation');

        const passwordHint = document.getElementById('passwordHint');
        const passwordRequired = document.getElementById('passwordRequired');
        const confirmationRequired = document.getElementById('confirmationRequired');

        const submitButton = document.getElementById('submitButton');

        const storeUrl = @json(route('admin.petugas.store'));
        const updateBaseUrl = @json(url('/admin/petugas'));

        function showModal() {
            modalBg.style.display = 'flex';
            document.body.classList.add('modal-open');
            document.body.style.overflow = 'hidden';

            setTimeout(function() {
                nameInput.focus();
            }, 80);
        }

        function openAddModal() {
            staffForm.reset();

            staffForm.action = storeUrl;
            formMethod.value = 'POST';
            petugasId.value = '';

            modalTitle.textContent = 'Tambah Petugas';

            submitButton.disabled = false;
            submitButton.innerHTML =
                '<i class="bi bi-check-lg"></i> Simpan Petugas';

            passwordInput.required = true;
            confirmationInput.required = true;

            passwordRequired.style.display = 'inline';
            confirmationRequired.style.display = 'inline';

            passwordHint.textContent =
                'Password wajib diisi untuk akun petugas baru.';

            showModal();
        }

        function openEditModal(id, name, email, phone) {
            staffForm.reset();

            staffForm.action =
                updateBaseUrl + '/' + encodeURIComponent(id);

            formMethod.value = 'PUT';
            petugasId.value = id;

            modalTitle.textContent = 'Edit Petugas';

            submitButton.disabled = false;
            submitButton.innerHTML =
                '<i class="bi bi-check-lg"></i> Simpan Perubahan';

            nameInput.value = name;
            emailInput.value = email;
            phoneInput.value = phone;

            passwordInput.required = false;
            confirmationInput.required = false;

            passwordRequired.style.display = 'none';
            confirmationRequired.style.display = 'none';

            passwordHint.textContent =
                'Kosongkan password jika tidak ingin mengubah password lama.';

            showModal();
        }

        function closeModal() {
            modalBg.style.display = 'none';

            staffForm.reset();
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
        }

        // Tutup modal dengan klik area luar.
        modalBg.addEventListener('click', function(event) {
            if (event.target === modalBg) {
                closeModal();
            }
        });

        // Tutup modal dengan tombol Escape.
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (modalBg.style.display === 'flex') {
                    closeModal();
                }

                closeSidebar();
            }
        });

        // ==========================================
        // VALIDASI KONFIRMASI PASSWORD
        // ==========================================

        staffForm.addEventListener('submit', function(event) {
            if (
                passwordInput.value &&
                confirmationInput.value !== passwordInput.value
            ) {
                event.preventDefault();

                confirmationInput.setCustomValidity(
                    'Konfirmasi password tidak sama.'
                );

                confirmationInput.reportValidity();
                confirmationInput.focus();

                return;
            }

            confirmationInput.setCustomValidity('');

            // Cegah submit ganda.
            submitButton.disabled = true;

            submitButton.innerHTML =
                '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        });

        confirmationInput.addEventListener('input', function() {
            confirmationInput.setCustomValidity('');
        });

        passwordInput.addEventListener('input', function() {
            confirmationInput.setCustomValidity('');
        });

        // ==========================================
        // BUKA KEMBALI MODAL JIKA VALIDASI GAGAL
        // ==========================================

        @if($errors->any())

            @if(old('_method') === 'PUT' && old('petugas_id'))

                staffForm.action =
                    updateBaseUrl + '/' + encodeURIComponent(@json(old('petugas_id')));

                formMethod.value = 'PUT';
                petugasId.value = @json(old('petugas_id'));

                modalTitle.textContent = 'Edit Petugas';

                passwordInput.required = false;
                confirmationInput.required = false;

                passwordRequired.style.display = 'none';
                confirmationRequired.style.display = 'none';

                passwordHint.textContent =
                    'Kosongkan password jika tidak ingin mengubah password lama.';

                submitButton.innerHTML =
                    '<i class="bi bi-check-lg"></i> Simpan Perubahan';

            @else

                staffForm.action = storeUrl;

                formMethod.value = 'POST';
                petugasId.value = '';

                modalTitle.textContent = 'Tambah Petugas';

                passwordInput.required = true;
                confirmationInput.required = true;

                passwordRequired.style.display = 'inline';
                confirmationRequired.style.display = 'inline';

                passwordHint.textContent =
                    'Password wajib diisi untuk akun petugas baru.';

            @endif

            submitButton.disabled = false;

            showModal();

        @endif
    </script>

</body>
</html>
