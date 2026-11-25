<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fasilitas Kos - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @php
        $penghuni = auth()->user();
        $namaPenghuni = $penghuni->name ?? 'Penghuni';

        $inisialPenghuni = collect(explode(' ', trim($namaPenghuni)))
            ->filter()
            ->take(2)
            ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
            ->implode('');
    @endphp

    <style>
        :root {
            /* PALET WARNA SAMA DENGAN DASHBOARD PENGHUNI */
            --primary: #C6A477;
            --primary-light: #E0C49B;
            --primary-soft: rgba(198,164,119,.13);

            --background: #191D22;
            --sidebar-bg: #12161B;

            --surface: #242A31;
            --surface-2: #2D343D;
            --surface-3: #363E48;

            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --silver: #BBC4CD;

            --border: rgba(187,196,205,.14);

            --danger: #D58F8F;
            --green: #91AE9B;
            --yellow: #D9B77F;
            --blue: #9BB5D1;

            --shadow: 0 12px 34px rgba(0,0,0,.18);
            --sidebar-width: 255px;
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
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--background);
        }

        body.sidebar-open,
        body.modal-open {
            overflow: hidden;
        }

        button,
        input,
        select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 3px solid rgba(198,164,119,.4);
            outline-offset: 3px;
        }

        /* =========================================
           SIDEBAR
           SAMA DENGAN DASHBOARD PENGHUNI
        ========================================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

            display: flex;
            flex-direction: column;

            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;

            padding: 25px 17px 20px;

            overflow-y: auto;
            overflow-x: hidden;

            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;

            scrollbar-width: thin;
            scrollbar-color: rgba(198,164,119,.35) transparent;

            color: var(--text);
            background: var(--sidebar-bg);

            transition: transform .18s ease-out;
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

            padding: 0 11px 24px;

            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 41px;
            height: 41px;
            flex-shrink: 0;

            border: 1px solid rgba(198,164,119,.2);
            border-radius: 11px;

            color: var(--primary-light);
            background: var(--primary-soft);

            font-size: 20px;
        }

        .brand-name {
            color: var(--primary-light);
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .brand-subtitle {
            display: block;
            margin-top: 4px;

            color: var(--muted-dark);
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.25px;
        }

        .nav-label {
            padding: 25px 13px 12px;

            color: var(--muted-dark);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;

            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;

            padding: 12px 14px;

            border-left: 3px solid transparent;
            border-radius: 8px;

            color: #AEB7C0;
            font-size: 12px;
            font-weight: 500;

            transition:
                background .15s ease-out,
                color .15s ease-out,
                border-color .15s ease-out;
        }

        .nav-link i {
            width: 19px;
            flex-shrink: 0;

            text-align: center;
            font-size: 17px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-light);
            background: rgba(198,164,119,.12);
            border-left-color: var(--primary);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;

            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 11px;

            min-width: 0;
            padding: 11px 8px;
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 39px;
            height: 39px;
            flex-shrink: 0;

            border-radius: 50%;

            color: #191D22;
            background: linear-gradient(135deg, #E0C49B, #A98B62);

            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .profile-mini > div:last-child {
            min-width: 0;
        }

        .profile-mini strong {
            display: block;
            max-width: 155px;

            overflow: hidden;
            overflow-wrap: anywhere;

            color: var(--text);
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-mini span {
            color: var(--muted-dark);
            font-size: 10px;
        }

        .logout {
            display: flex;
            align-items: center;
            gap: 12px;

            width: 100%;
            padding: 12px 14px;

            border: 0;
            border-radius: 8px;

            color: #AEB7C0;
            background: transparent;

            text-align: left;
            font-size: 12px;

            transition: background .15s ease-out, color .15s ease-out;
        }

        .logout i {
            font-size: 16px;
        }

        .logout:hover {
            color: var(--danger);
            background: rgba(213,143,143,.1);
        }

        .overlay {
            display: none;

            position: fixed;
            inset: 0;
            z-index: 999;

            background: rgba(0,0,0,.62);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        .overlay.show {
            display: block;
        }

        /* =========================================
           MAIN CONTENT
        ========================================= */

        .main {
            min-width: 0;
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: space-between;

            height: 76px;
            padding: 0 35px;

            border-bottom: 1px solid var(--border);

            background: rgba(25,29,34,.94);

            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .topbar-title h2 {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 21px;
        }

        .topbar-title p {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;

            width: 39px;
            height: 39px;
            flex-shrink: 0;

            border: 1px solid var(--border);
            border-radius: 9px;

            color: var(--primary-light);
            background: var(--surface);

            font-size: 21px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-date {
            color: var(--muted);
            font-size: 11px;
            white-space: nowrap;
        }

        .notification {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 38px;
            height: 38px;
            flex-shrink: 0;

            border: 1px solid var(--border);
            border-radius: 50%;

            color: var(--silver);
            background: var(--surface);

            font-size: 15px;

            transition: border-color .15s ease-out, color .15s ease-out;
        }

        .notification:hover {
            border-color: rgba(198,164,119,.45);
            color: var(--primary-light);
        }

        .notification span {
            position: absolute;
            top: 6px;
            right: 6px;

            width: 7px;
            height: 7px;

            border-radius: 50%;
            background: var(--primary);
        }

        /* =========================================
           CONTENT
        ========================================= */

        .content {
            width: 100%;
            max-width: 1600px;
            min-width: 0;

            margin: auto;
            padding: 32px 35px 45px;
        }

        /* =========================================
           PAGE HEADING
        ========================================= */

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            margin-bottom: 25px;
        }

        .eyebrow {
            margin-bottom: 8px;

            color: var(--primary);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        h1 {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .page-description {
            max-width: 620px;
            margin-top: 7px;

            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .facility-count {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;

            padding: 11px 15px;

            border: 1px solid rgba(198,164,119,.18);
            border-radius: 8px;

            color: var(--primary-light);
            background: var(--primary-soft);

            font-size: 11px;
            font-weight: 700;
        }

        .facility-count i {
            font-size: 15px;
        }

        /* =========================================
           WELCOME BANNER
        ========================================= */

        .welcome-banner {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            overflow: hidden;

            margin-bottom: 28px;
            padding: 24px 27px;

            border: 1px solid rgba(198,164,119,.18);
            border-radius: 11px;

            color: var(--text);
            background: linear-gradient(120deg, #2D343D, #242A31);
        }

        .welcome-banner::before,
        .welcome-banner::after {
            position: absolute;
            content: '';

            border: 1px solid rgba(198,164,119,.13);
            border-radius: 50%;

            pointer-events: none;
        }

        .welcome-banner::before {
            top: -100px;
            right: 25px;

            width: 210px;
            height: 210px;
        }

        .welcome-banner::after {
            top: -65px;
            right: 80px;

            width: 140px;
            height: 140px;
        }

        .welcome-banner-content {
            position: relative;
            z-index: 1;
        }

        .welcome-banner h2 {
            margin-bottom: 7px;

            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 21px;
        }

        .welcome-banner p {
            max-width: 540px;

            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .banner-icon {
            position: relative;
            z-index: 1;

            flex-shrink: 0;
            margin-right: 17px;

            color: var(--primary-light);
            font-size: 44px;
        }

        /* =========================================
           SECTION HEADING
        ========================================= */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            margin-bottom: 16px;
        }

        .section-heading h2 {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 19px;
        }

        .section-heading p {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        /* =========================================
           FILTER PANEL
        ========================================= */

        .filter-panel {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;

            margin-bottom: 20px;
            padding: 15px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: var(--surface);
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 210px;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);

            color: var(--muted);
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            height: 42px;

            padding: 0 13px 0 38px;

            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;

            color: var(--text);
            background: var(--surface-2);

            font-size: 12px;

            transition: border-color .15s ease-out, box-shadow .15s ease-out;
        }

        .search-box input::placeholder {
            color: var(--muted-dark);
        }

        .search-box input:focus,
        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(198,164,119,.1);
        }

        .filter-select {
            min-width: 155px;
            height: 42px;

            padding: 0 12px;

            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;

            color: var(--silver);
            background: var(--surface-2);

            font-size: 12px;

            transition: border-color .15s ease-out, box-shadow .15s ease-out;
        }

        .filter-select option {
            color: var(--text);
            background: var(--surface);
        }

        .reset-btn {
            height: 42px;
            padding: 0 14px;

            border: 1px solid rgba(198,164,119,.2);
            border-radius: 8px;

            color: var(--primary-light);
            background: var(--primary-soft);

            font-size: 12px;
            font-weight: 700;

            transition: background .15s ease-out, border-color .15s ease-out;
        }

        .reset-btn:hover {
            border-color: rgba(198,164,119,.4);
            background: rgba(198,164,119,.2);
        }

        /* =========================================
           FACILITY CARDS
        ========================================= */

        .facility-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .facility-card {
            display: flex;
            align-items: flex-start;
            gap: 14px;

            min-width: 0;
            padding: 16px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: var(--surface);

            transition:
                transform .18s ease-out,
                box-shadow .18s ease-out,
                border-color .18s ease-out;
        }

        .facility-card:hover {
            transform: translateY(-2px);

            border-color: rgba(198,164,119,.35);
            box-shadow: 0 7px 20px rgba(0,0,0,.13);
        }

        .facility-visual {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 48px;
            height: 48px;
            flex-shrink: 0;

            border: 1px solid rgba(198,164,119,.12);
            border-radius: 9px;

            color: var(--primary-light);
            background: var(--primary-soft);
        }

        .facility-visual i {
            font-size: 21px;
        }

        .facility-card-content {
            flex: 1;
            min-width: 0;
        }

        .facility-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;

            margin-bottom: 7px;
        }

        .facility-card-body h3 {
            color: var(--text);
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .category-label {
            display: inline-flex;
            align-items: center;

            padding: 5px 8px;

            border: 1px solid rgba(198,164,119,.13);
            border-radius: 20px;

            color: var(--primary-light);
            background: var(--primary-soft);

            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .facility-card-body p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .facility-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;

            margin-top: 12px;
            padding-top: 11px;

            border-top: 1px solid var(--border);
        }

        .availability {
            display: flex;
            align-items: center;
            gap: 5px;

            color: var(--green);
            font-size: 10px;
            font-weight: 700;
        }

        .availability.unavailable {
            color: var(--danger);
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            padding: 8px 12px;

            border: 1px solid var(--primary);
            border-radius: 7px;

            color: #191D22;
            background: var(--primary);

            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;

            transition: background .15s ease-out, transform .15s ease-out;
        }

        .detail-btn:hover {
            transform: translateY(-1px);
            background: var(--primary-light);
        }

        .empty-state {
            display: none;
            grid-column: 1 / -1;

            padding: 35px 20px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: var(--surface);

            text-align: center;
        }

        .empty-state i {
            color: var(--primary-light);
            font-size: 32px;
        }

        .empty-state h3 {
            margin: 12px 0 6px;

            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 16px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        /* =========================================
           INFORMATION PANEL
        ========================================= */

        .info-panel {
            display: flex;
            align-items: flex-start;
            gap: 13px;

            margin-top: 25px;
            padding: 19px 21px;

            border: 1px solid rgba(198,164,119,.18);
            border-radius: 10px;

            background: var(--surface);
        }

        .info-panel > i {
            flex-shrink: 0;

            color: var(--primary-light);
            font-size: 20px;
        }

        .info-panel h3 {
            margin-bottom: 5px;

            color: var(--text);
            font-size: 12px;
        }

        .info-panel p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        /* =========================================
           DETAIL MODAL
        ========================================= */

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 2000;

            display: none;
            align-items: center;
            justify-content: center;

            padding: 18px;
            overflow-y: auto;

            background: rgba(0,0,0,.68);

            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 460px;
            max-height: calc(100dvh - 36px);

            overflow-y: auto;

            border: 1px solid var(--border);
            border-radius: 12px;

            background: var(--surface);

            box-shadow: var(--shadow);

            animation: modalIn .18s ease-out;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            position: sticky;
            top: 0;
            z-index: 1;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 19px 21px;

            border-bottom: 1px solid var(--border);

            background: var(--surface-2);
        }

        .modal-header h3 {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }

        .modal-close {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 31px;
            height: 31px;

            border: 1px solid var(--border);
            border-radius: 7px;

            color: var(--silver);
            background: var(--surface-3);

            font-size: 18px;

            transition: background .15s ease-out, color .15s ease-out;
        }

        .modal-close:hover {
            color: var(--text);
            background: #444D58;
        }

        .modal-body {
            padding: 22px;
        }

        .modal-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 65px;
            height: 65px;

            margin-bottom: 15px;

            border: 1px solid rgba(198,164,119,.16);
            border-radius: 12px;

            color: var(--primary-light);
            background: var(--primary-soft);

            font-size: 28px;
        }

        .modal-body h4 {
            margin-bottom: 8px;

            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }

        .modal-body p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .detail-info {
            margin-top: 17px;
            padding: 13px;

            border: 1px solid var(--border);
            border-radius: 9px;

            background: var(--surface-2);
        }

        .detail-info div {
            display: flex;
            justify-content: space-between;
            gap: 10px;

            padding: 9px 0;

            border-bottom: 1px solid var(--border);

            font-size: 11px;
        }

        .detail-info div:last-child {
            border-bottom: 0;
        }

        .detail-info span:first-child {
            color: var(--muted);
        }

        .detail-info span:last-child {
            color: var(--silver);
            font-weight: 700;
            text-align: right;
        }

        .modal-footer {
            padding: 0 22px 20px;
        }

        .close-detail {
            width: 100%;
            padding: 11px;

            border: 1px solid var(--primary);
            border-radius: 8px;

            color: #191D22;
            background: var(--primary);

            font-size: 12px;
            font-weight: 700;

            transition: background .15s ease-out;
        }

        .close-detail:hover {
            background: var(--primary-light);
        }

        /* =========================================
           TOAST
        ========================================= */

        .toast {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 3000;

            display: none;

            max-width: calc(100% - 30px);
            padding: 13px 18px;

            border: 1px solid rgba(198,164,119,.2);
            border-radius: 9px;

            color: var(--text);
            background: var(--surface-2);

            box-shadow: var(--shadow);

            font-size: 12px;
        }

        /* =========================================
           TABLET
        ========================================= */

        @media (max-width: 1200px) {
            .content {
                padding: 28px 25px;
            }

            .facility-grid {
                gap: 12px;
            }

            .facility-card {
                padding: 14px;
            }
        }

        /* =========================================
           MOBILE NAVIGATION
        ========================================= */

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 12px 0 35px rgba(0,0,0,.3);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .topbar {
                padding: 0 25px;
            }
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 600px) {
            .topbar {
                height: 68px;
                padding: 0 16px;
            }

            .topbar-title h2 {
                font-size: 17px;
            }

            .topbar-title p {
                display: none;
            }

            .topbar-date {
                display: none;
            }

            .content {
                padding: 23px 15px 35px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 13px;

                margin-bottom: 21px;
            }

            h1 {
                font-size: 23px;
            }

            .page-description {
                font-size: 11px;
            }

            .facility-count {
                padding: 9px 12px;
                font-size: 10px;
            }

            .welcome-banner {
                padding: 20px;
            }

            .welcome-banner h2 {
                font-size: 18px;
            }

            .welcome-banner p {
                font-size: 11px;
            }

            .banner-icon {
                margin-right: 0;
                font-size: 32px;
            }

            .section-heading h2 {
                font-size: 17px;
            }

            .facility-grid {
                grid-template-columns: 1fr;
                gap: 11px;
            }

            .facility-card {
                padding: 14px;
            }

            .filter-panel {
                gap: 9px;
                padding: 12px;
            }

            .search-box {
                flex-basis: 100%;
                min-width: 100%;
            }

            .filter-select {
                flex: 1;
                min-width: 0;
                width: 100%;
            }

            .reset-btn {
                flex: 1;
            }

            .info-panel {
                padding: 16px;
            }

            .toast {
                right: 15px;
                bottom: 15px;
                left: 15px;

                max-width: none;
                text-align: center;
            }
        }

        @media (max-width: 360px) {
            .sidebar {
                width: min(255px, 85vw);
            }

            .content {
                padding-left: 11px;
                padding-right: 11px;
            }

            .topbar-title h2 {
                font-size: 15px;
            }

            .welcome-banner {
                padding: 17px;
            }

            .welcome-banner h2 {
                font-size: 16px;
            }

            .facility-card {
                gap: 10px;
                padding: 12px;
            }

            .facility-visual {
                width: 42px;
                height: 42px;
            }

            .facility-card-top {
                flex-direction: column;
            }

            .facility-card-body h3 {
                font-size: 11px;
            }

            .category-label {
                white-space: normal;
            }

            .modal-body {
                padding: 17px;
            }
        }

        /* =========================================
           REDUCED MOTION
        ========================================= */

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

    <div class="nav-label">MENU PENGHUNI</div>

    <nav class="nav-menu">

        <a href="{{ route('penghuni.dashboard') }}"
           class="nav-link"
           data-page-transition>
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        <a href="{{ route('penghuni.kamar.index') }}"
           class="nav-link"
           data-page-transition>
            <i class="bi bi-door-open"></i>
            Kamar Saya
        </a>

        <a href="{{ route('penghuni.tagihan.index') }}"
           class="nav-link"
           data-page-transition>
            <i class="bi bi-receipt"></i>
            Tagihan Bulanan
        </a>

        <a href="{{ route('penghuni.riwayat.index') }}"
           class="nav-link"
           data-page-transition>
            <i class="bi bi-clock-history"></i>
            Riwayat Pembayaran
        </a>

        <a href="{{ route('penghuni.fasilitas.index') }}"
           class="nav-link active"
           aria-current="page">
            <i class="bi bi-house-check"></i>
            Fasilitas Kos
        </a>

        <a href="{{ route('penghuni.profil.index') }}"
           class="nav-link"
           data-page-transition>
            <i class="bi bi-person-circle"></i>
            Profil Saya
        </a>

    </nav>

    <div class="sidebar-bottom">

        <div class="profile-mini">
            <div class="avatar">{{ $inisialPenghuni ?: 'P' }}</div>

            <div>
                <strong>{{ $namaPenghuni }}</strong>
                <span>Penghuni Kos</span>
            </div>
        </div>

        <form method="POST"
              action="{{ route('logout') }}"
              onsubmit="return confirm('Apakah kamu yakin ingin keluar dari akun?')">
            @csrf

            <button class="logout" type="submit">
                <i class="bi bi-box-arrow-left"></i>
                Keluar
            </button>
        </form>

    </div>

</aside>

<div class="overlay" id="overlay"></div>

<!-- MAIN -->
<main class="main">

    <!-- TOPBAR -->
    <header class="topbar">

        <div class="topbar-left">

            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Buka navigasi"
                aria-expanded="false"
                aria-controls="sidebar"
            >
                <i class="bi bi-list"></i>
            </button>

            <div class="topbar-title">
                <h2>Fasilitas Kos</h2>
                <p>Informasi fasilitas dan kenyamanan tempat tinggal</p>
            </div>

        </div>

        <div class="topbar-right">

            <span class="topbar-date" id="currentDate"></span>

            <button
                class="notification"
                type="button"
                id="notificationButton"
                aria-label="Notifikasi"
            >
                <i class="bi bi-bell"></i>
                <span></span>
            </button>

        </div>

    </header>

    <!-- CONTENT -->
    <section class="content" data-page-enter>

        <!-- PAGE HEADING -->
        <div class="page-heading" data-scroll-reveal>

            <div>
                <div class="eyebrow">KENYAMANAN TEMPAT TINGGAL</div>

                <h1>Fasilitas Kos</h1>

                <p class="page-description">
                    Lihat berbagai fasilitas yang tersedia untuk menunjang kenyamanan
                    selama kamu tinggal di KosHaven.
                </p>
            </div>

            <div class="facility-count">
                <i class="bi bi-stars"></i>
                <span id="facilityCount">8 Fasilitas</span>
            </div>

        </div>

        <!-- WELCOME BANNER -->
        <div class="welcome-banner" data-scroll-reveal>

            <div class="welcome-banner-content">
                <h2>Fasilitas untuk Kenyamananmu</h2>

                <p>
                    Nikmati berbagai fasilitas yang telah disediakan untuk mendukung
                    aktivitas sehari-hari. Gunakan fasilitas dengan baik dan jaga
                    kebersihan bersama.
                </p>
            </div>

            <i class="bi bi-house-heart banner-icon"></i>

        </div>

        <!-- SECTION HEADING -->
        <div class="section-heading" data-scroll-reveal>

            <div>
                <h2>Daftar Fasilitas</h2>
                <p>Informasi fasilitas yang tersedia di lingkungan kos.</p>
            </div>

        </div>

        <!-- FILTER -->
        <div class="filter-panel" data-scroll-reveal>

            <div class="search-box">
                <i class="bi bi-search"></i>

                <input
                    type="search"
                    id="searchInput"
                    placeholder="Cari nama fasilitas..."
                    maxlength="60"
                    autocomplete="off"
                    aria-label="Cari nama fasilitas"
                >
            </div>

            <select
                class="filter-select"
                id="categoryFilter"
                aria-label="Filter kategori fasilitas"
            >
                <option value="semua">Semua Kategori</option>
                <option value="kamar">Fasilitas Kamar</option>
                <option value="bersama">Fasilitas Bersama</option>
                <option value="keamanan">Keamanan</option>
                <option value="layanan">Layanan</option>
            </select>

            <button class="reset-btn" type="button" id="resetFilters">
                <i class="bi bi-arrow-counterclockwise"></i>
                Reset
            </button>

        </div>

        <!-- FACILITY GRID -->
        <div class="facility-grid" id="facilityGrid">

            <article class="facility-card"
                     data-name="tempat tidur kasur"
                     data-category="kamar"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-lamp"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Tempat Tidur</h3>
                        <span class="category-label">Fasilitas Kamar</span>
                    </div>

                    <p>
                        Tempat tidur dan kasur untuk menunjang kenyamanan
                        istirahat penghuni.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="0">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="lemari pakaian"
                     data-category="kamar"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Lemari Pakaian</h3>
                        <span class="category-label">Fasilitas Kamar</span>
                    </div>

                    <p>
                        Lemari pribadi untuk menyimpan pakaian dan barang-barang penghuni.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="1">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="wifi internet"
                     data-category="bersama"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-wifi"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>WiFi / Internet</h3>
                        <span class="category-label">Fasilitas Bersama</span>
                    </div>

                    <p>
                        Akses internet bersama untuk mendukung kegiatan belajar
                        dan aktivitas digital.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="2">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="kamar mandi toilet"
                     data-category="bersama"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-droplet-half"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Kamar Mandi</h3>
                        <span class="category-label">Fasilitas Bersama</span>
                    </div>

                    <p>
                        Kamar mandi dengan fasilitas air dan perlengkapan sanitasi.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="3">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="dapur bersama"
                     data-category="bersama"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-cup-hot"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Dapur Bersama</h3>
                        <span class="category-label">Fasilitas Bersama</span>
                    </div>

                    <p>
                        Area memasak bersama yang dapat digunakan penghuni
                        sesuai aturan kos.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="4">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="parkir kendaraan motor"
                     data-category="bersama"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-p-square"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Area Parkir</h3>
                        <span class="category-label">Fasilitas Bersama</span>
                    </div>

                    <p>
                        Area parkir kendaraan bagi penghuni kos dengan
                        pengaturan yang tertib.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="5">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="cctv keamanan kamera pengawas"
                     data-category="keamanan"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-camera-video"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>CCTV</h3>
                        <span class="category-label">Keamanan</span>
                    </div>

                    <p>
                        Kamera pengawas di area tertentu untuk membantu
                        menjaga keamanan lingkungan.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="6">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <article class="facility-card"
                     data-name="petugas kebersihan layanan"
                     data-category="layanan"
                     data-motion-card>

                <div class="facility-visual">
                    <i class="bi bi-stars"></i>
                </div>

                <div class="facility-card-content facility-card-body">

                    <div class="facility-card-top">
                        <h3>Layanan Kebersihan</h3>
                        <span class="category-label">Layanan</span>
                    </div>

                    <p>
                        Layanan kebersihan untuk menjaga area bersama
                        tetap rapi dan nyaman.
                    </p>

                    <div class="facility-card-footer">

                        <span class="availability">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia
                        </span>

                        <button class="detail-btn"
                                type="button"
                                data-facility-index="7">
                            Detail <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>
                </div>

            </article>

            <!-- EMPTY STATE -->
            <div class="empty-state" id="emptyState">
                <i class="bi bi-search"></i>
                <h3>Fasilitas Tidak Ditemukan</h3>
                <p>Coba gunakan kata kunci atau kategori yang berbeda.</p>
            </div>

        </div>

        <!-- INFORMATION PANEL -->
        <div class="info-panel" data-scroll-reveal>

            <i class="bi bi-info-circle-fill"></i>

            <div>
                <h3>Informasi Penggunaan Fasilitas</h3>

                <p>
                    Mohon gunakan fasilitas dengan bijak, jaga kebersihan, dan
                    patuhi peraturan kos. Jika menemukan fasilitas yang rusak
                    atau tidak berfungsi, segera laporkan kepada petugas kos.
                </p>
            </div>

        </div>

    </section>

</main>

<!-- DETAIL MODAL -->
<div
    class="modal-backdrop"
    id="detailModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modalTitle"
    aria-hidden="true"
>
    <div class="modal-card">

        <div class="modal-header">
            <h3>Detail Fasilitas</h3>

            <button
                class="modal-close"
                type="button"
                id="modalClose"
                aria-label="Tutup detail fasilitas"
            >
                &times;
            </button>
        </div>

        <div class="modal-body">

            <div class="modal-icon" id="modalIcon">
                <i class="bi bi-stars"></i>
            </div>

            <h4 id="modalTitle">Nama Fasilitas</h4>
            <p id="modalDescription"></p>

            <div class="detail-info">

                <div>
                    <span>Kategori</span>
                    <span id="modalCategory"></span>
                </div>

                <div>
                    <span>Status</span>
                    <span id="modalStatus">Tersedia</span>
                </div>

                <div>
                    <span>Penggunaan</span>
                    <span id="modalUsage"></span>
                </div>

            </div>

        </div>

        <div class="modal-footer">
            <button class="close-detail" type="button" id="closeDetailButton">
                Tutup
            </button>
        </div>

    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
    /* =========================================
       DATA FASILITAS
    ========================================= */

    const facilities = [
        {
            name: 'Tempat Tidur',
            icon: 'bi-lamp',
            category: 'Fasilitas Kamar',
            description: 'Tempat tidur dan kasur yang disediakan untuk menunjang kenyamanan istirahat penghuni selama tinggal di KosHaven.',
            status: 'Tersedia',
            usage: 'Pribadi'
        },
        {
            name: 'Lemari Pakaian',
            icon: 'bi-box-seam',
            category: 'Fasilitas Kamar',
            description: 'Lemari pakaian pribadi yang dapat digunakan untuk menyimpan pakaian serta barang-barang milik penghuni.',
            status: 'Tersedia',
            usage: 'Pribadi'
        },
        {
            name: 'WiFi / Internet',
            icon: 'bi-wifi',
            category: 'Fasilitas Bersama',
            description: 'Akses jaringan internet yang dapat digunakan untuk belajar, bekerja, dan berbagai kebutuhan digital.',
            status: 'Tersedia',
            usage: 'Bersama'
        },
        {
            name: 'Kamar Mandi',
            icon: 'bi-droplet-half',
            category: 'Fasilitas Bersama',
            description: 'Fasilitas kamar mandi yang dilengkapi kebutuhan sanitasi. Penghuni diharapkan menjaga kebersihan setelah digunakan.',
            status: 'Tersedia',
            usage: 'Bersama'
        },
        {
            name: 'Dapur Bersama',
            icon: 'bi-cup-hot',
            category: 'Fasilitas Bersama',
            description: 'Area dapur yang dapat digunakan penghuni untuk menyiapkan makanan. Pastikan peralatan dan area dapur dibersihkan setelah digunakan.',
            status: 'Tersedia',
            usage: 'Bersama'
        },
        {
            name: 'Area Parkir',
            icon: 'bi-p-square',
            category: 'Fasilitas Bersama',
            description: 'Area parkir kendaraan yang disediakan bagi penghuni. Parkirkan kendaraan pada tempat yang telah ditentukan.',
            status: 'Tersedia',
            usage: 'Bersama'
        },
        {
            name: 'CCTV',
            icon: 'bi-camera-video',
            category: 'Keamanan',
            description: 'Kamera pengawas yang ditempatkan di area tertentu untuk membantu memantau keamanan lingkungan kos.',
            status: 'Tersedia',
            usage: 'Area bersama'
        },
        {
            name: 'Layanan Kebersihan',
            icon: 'bi-stars',
            category: 'Layanan',
            description: 'Layanan kebersihan untuk membantu menjaga area bersama agar tetap bersih, rapi, dan nyaman.',
            status: 'Tersedia',
            usage: 'Area bersama'
        }
    ];

    /* =========================================
       ELEMENT HALAMAN
    ========================================= */

    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');

    const facilityCards = [
        ...document.querySelectorAll('.facility-card')
    ];

    const emptyState = document.getElementById('emptyState');
    const facilityCount = document.getElementById('facilityCount');

    const detailModal = document.getElementById('detailModal');

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menuToggle');

    let previousFocusElement = null;
    let toastTimer = null;

    /* =========================================
       BODY SCROLL LOCK
    ========================================= */

    function syncBodyScrollLock() {
        const modalOpen = detailModal.classList.contains('show');

        const sidebarOpen =
            sidebar.classList.contains('show') &&
            window.innerWidth <= 850;

        document.body.classList.toggle('modal-open', modalOpen);
        document.body.classList.toggle('sidebar-open', sidebarOpen);
    }

    /* =========================================
       FILTER FASILITAS
    ========================================= */

    function filterFacilities() {
        const keyword = searchInput.value.trim().toLowerCase();
        const category = categoryFilter.value;

        let visibleCount = 0;

        facilityCards.forEach(card => {
            const name = (card.dataset.name || '').toLowerCase();
            const cardCategory = card.dataset.category;

            const matchName = name.includes(keyword);

            const matchCategory =
                category === 'semua' ||
                cardCategory === category;

            const visible = matchName && matchCategory;

            card.style.display = visible ? '' : 'none';

            if (visible) {
                visibleCount++;
            }
        });

        emptyState.style.display =
            visibleCount === 0 ? 'block' : 'none';

        facilityCount.textContent =
            visibleCount + ' Fasilitas';
    }

    searchInput.addEventListener('input', filterFacilities);

    categoryFilter.addEventListener('change', filterFacilities);

    /* =========================================
       RESET FILTER
    ========================================= */

    document.getElementById('resetFilters').addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = 'semua';

        filterFacilities();
        searchInput.focus();
    });

    /* =========================================
       DETAIL FASILITAS
    ========================================= */

    function showDetail(index) {
        const facility = facilities[index];

        if (!facility) {
            showToast('Informasi fasilitas tidak ditemukan.');
            return;
        }

        previousFocusElement = document.activeElement;

        const modalIcon = document.getElementById('modalIcon');

        modalIcon.replaceChildren();

        const iconElement = document.createElement('i');
        iconElement.className = 'bi ' + facility.icon;

        modalIcon.appendChild(iconElement);

        document.getElementById('modalTitle').textContent =
            facility.name;

        document.getElementById('modalDescription').textContent =
            facility.description;

        document.getElementById('modalCategory').textContent =
            facility.category;

        document.getElementById('modalStatus').textContent =
            facility.status;

        document.getElementById('modalUsage').textContent =
            facility.usage;

        detailModal.classList.add('show');
        detailModal.setAttribute('aria-hidden', 'false');

        syncBodyScrollLock();

        requestAnimationFrame(() => {
            document.getElementById('modalClose').focus();
        });
    }

    function closeDetail() {
        if (!detailModal.classList.contains('show')) {
            return;
        }

        detailModal.classList.remove('show');
        detailModal.setAttribute('aria-hidden', 'true');

        syncBodyScrollLock();

        if (
            previousFocusElement &&
            typeof previousFocusElement.focus === 'function'
        ) {
            previousFocusElement.focus();
        }

        previousFocusElement = null;
    }

    document.querySelectorAll('[data-facility-index]').forEach(button => {
        button.addEventListener('click', () => {
            const index = Number(button.dataset.facilityIndex);
            showDetail(index);
        });
    });

    document.getElementById('modalClose')
        .addEventListener('click', closeDetail);

    document.getElementById('closeDetailButton')
        .addEventListener('click', closeDetail);

    detailModal.addEventListener('click', event => {
        if (event.target === detailModal) {
            closeDetail();
        }
    });

    /* =========================================
       TOAST NOTIFICATION
    ========================================= */

    function showToast(message) {
        const toast = document.getElementById('toast');

        toast.textContent = message;
        toast.style.display = 'block';

        clearTimeout(toastTimer);

        toastTimer = setTimeout(() => {
            toast.style.display = 'none';
        }, 2500);
    }

    /* =========================================
       NOTIFIKASI
    ========================================= */

    document.getElementById('notificationButton')
        .addEventListener('click', () => {
            showToast('Belum ada notifikasi baru.');
        });

    /* =========================================
       TANGGAL
    ========================================= */

    document.getElementById('currentDate').textContent =
        new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date());

    /* =========================================
       SIDEBAR RESPONSIVE
    ========================================= */

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');

        menuToggle.setAttribute('aria-expanded', 'true');
        menuToggle.setAttribute('aria-label', 'Tutup navigasi');

        syncBodyScrollLock();
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');

        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'Buka navigasi');

        syncBodyScrollLock();
    }

    menuToggle.addEventListener('click', () => {
        if (sidebar.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 850) {
                closeSidebar();
            }
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 850) {
            closeSidebar();
        }

        syncBodyScrollLock();
    });

    /* =========================================
       KEYBOARD ACCESSIBILITY
    ========================================= */

    document.addEventListener('keydown', event => {

        if (event.key === 'Escape') {
            if (detailModal.classList.contains('show')) {
                closeDetail();
            } else if (sidebar.classList.contains('show')) {
                closeSidebar();
            }
        }

        if (
            event.key === 'Tab' &&
            detailModal.classList.contains('show')
        ) {
            const focusableElements = [
                ...detailModal.querySelectorAll(
                    'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled])'
                )
            ];

            if (!focusableElements.length) {
                return;
            }

            const firstElement = focusableElements[0];
            const lastElement =
                focusableElements[focusableElements.length - 1];

            if (
                event.shiftKey &&
                document.activeElement === firstElement
            ) {
                event.preventDefault();
                lastElement.focus();

            } else if (
                !event.shiftKey &&
                document.activeElement === lastElement
            ) {
                event.preventDefault();
                firstElement.focus();
            }
        }
    });

    /* =========================================
       INITIALIZATION
    ========================================= */

    filterFacilities();
</script>

@vite('resources/js/app.js')

</body>
</html>