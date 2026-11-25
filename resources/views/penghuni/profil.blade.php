
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
            --primary: #C6A477;
            --primary-light: #E0C49B;
            --primary-soft: rgba(198,164,119,.13);
            --background: #191D22;
            --sidebar: #12161B;
            --surface: #242A31;
            --surface-2: #2D343D;
            --surface-3: #363E48;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.14);
            --danger: #D58F8F;
            --success: #91AE9B;
            --yellow: #D9B77F;
            --blue: #9BB5D1;
            --silver: #BBC4CD;
            --sidebar-width: 255px;
            --shadow: 0 12px 34px rgba(0,0,0,.18);
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
            min-height: 100vh;
        }

        body.sidebar-open,
        body.modal-open {
            overflow: hidden;
        }

        button, input {
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
            height: 100dvh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background: var(--sidebar);
            color: var(--text);
            display: flex;
            flex-direction: column;
            padding: 27px 19px 20px;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(198,164,119,.4) transparent;
            transition: transform .2s ease;
            border-right: 1px solid var(--border);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(198,164,119,.4);
            border-radius: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 10px 30px;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #191D22;
            font-size: 21px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 700;
            color: var(--text);
        }

        .brand-subtitle {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 1.5px;
            margin-top: 2px;
        }

        .nav-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            color: var(--muted-dark);
            font-weight: 700;
            padding: 0 12px;
            margin: 12px 0 10px;
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
            padding: 12px 13px;
            border-radius: 9px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            transition: background-color .15s ease, color .15s ease;
        }

        .nav-link i {
            font-size: 17px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary-light);
        }

        .nav-link.active {
            border-left: 3px solid var(--primary);
            padding-left: 10px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
            flex-shrink: 0;
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 15px 8px;
            border-top: 1px solid var(--border);
            min-width: 0;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary-soft);
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar img,
        .profile-avatar img,
        .topbar-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-mini > div:last-child {
            min-width: 0;
        }

        .profile-mini strong {
            display: block;
            font-size: 12px;
            color: var(--text);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-mini span {
            color: var(--muted);
            font-size: 10px;
        }

        .logout {
            width: 100%;
            border: 1px solid transparent;
            background: rgba(213,143,143,.09);
            color: var(--danger);
            padding: 11px;
            border-radius: 8px;
            text-align: left;
            font-size: 12px;
            transition: background-color .15s ease;
        }

        .logout:hover {
            background: rgba(213,143,143,.16);
            border-color: rgba(213,143,143,.2);
        }

        .logout i {
            margin-right: 9px;
        }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.65);
            z-index: 999;
        }

        /* MAIN */

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            min-width: 0;
        }

        .topbar {
            height: 76px;
            background: rgba(25,29,34,.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--primary);
            width: 38px;
            height: 38px;
            border-radius: 8px;
            font-size: 19px;
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            background: var(--surface-2);
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
        }

        .breadcrumb strong {
            color: var(--primary-light);
        }

        .topbar-date {
            font-size: 12px;
            color: var(--muted);
        }

        .topbar-avatar {
            width: 37px;
            height: 37px;
            background: var(--primary-soft);
            color: var(--primary-light);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .content {
            padding: 34px 35px 45px;
            max-width: 1600px;
            margin: auto;
            width: 100%;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .eyebrow {
            color: var(--primary);
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            color: var(--text);
            font-weight: 700;
        }

        .page-description {
            color: var(--muted);
            font-size: 13px;
            margin-top: 7px;
            line-height: 1.7;
        }

        /* PROFILE LAYOUT */

        .profile-layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .profile-card,
        .form-card,
        .security-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            min-width: 0;
            box-shadow: var(--shadow);
        }

        .profile-card {
            padding: 25px 20px;
            text-align: center;
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 105px;
            height: 105px;
            margin: 0 auto 15px;
        }

        .profile-avatar {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            background: var(--surface-2);
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            font-weight: 700;
            overflow: hidden;
            border: 4px solid var(--surface);
            box-shadow: 0 0 0 1px rgba(198,164,119,.35);
        }

        .avatar-edit {
            position: absolute;
            right: 0;
            bottom: 2px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid var(--surface);
            background: var(--primary);
            color: #191D22;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: background-color .15s ease;
        }

        .avatar-edit:hover {
            background: var(--primary-light);
        }

        .profile-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--text);
            margin-bottom: 5px;
            overflow-wrap: anywhere;
        }

        .profile-email {
            font-size: 11px;
            color: var(--muted);
            overflow-wrap: anywhere;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(145,174,155,.13);
            color: var(--success);
            border: 1px solid rgba(145,174,155,.2);
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 13px;
        }

        .profile-divider {
            height: 1px;
            background: var(--border);
            margin: 22px 0;
        }

        .profile-info {
            text-align: left;
        }

        .profile-info-item {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 17px;
            min-width: 0;
        }

        .profile-info-item:last-child {
            margin-bottom: 0;
        }

        .profile-info-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-info-item > div:last-child {
            min-width: 0;
        }

        .profile-info-item small {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-bottom: 3px;
        }

        .profile-info-item strong {
            display: block;
            font-size: 12px;
            color: var(--text);
            overflow-wrap: anywhere;
        }

        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 0;
        }

        .form-card,
        .security-card {
            padding: 23px;
        }

        .card-heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding-bottom: 19px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 21px;
        }

        .card-heading-icon {
            width: 39px;
            height: 39px;
            border-radius: 10px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .card-heading h2 {
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 18px;
            margin-bottom: 4px;
        }

        .card-heading p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        /* FORM */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 16px;
        }

        .form-group {
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            height: 43px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 12px;
            color: var(--text);
            background: var(--surface-2);
            outline: none;
            font-size: 12px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .form-control::placeholder {
            color: var(--muted-dark);
            opacity: 1;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .form-control:disabled {
            background: #20252B;
            color: var(--muted-dark);
            border-color: rgba(187,196,205,.09);
            cursor: not-allowed;
            opacity: 1;
        }

        .field-hint {
            display: block;
            font-size: 10px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.5;
        }

        .field-error {
            color: var(--danger);
            font-size: 10px;
            display: block;
            margin-top: 6px;
            min-height: 13px;
        }

        .input-password {
            position: relative;
        }

        .input-password .form-control {
            padding-right: 42px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 15px;
        }

        .toggle-password:hover {
            color: var(--primary-light);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        .btn {
            border: 0;
            border-radius: 8px;
            padding: 11px 17px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background-color .15s ease, transform .15s ease, border-color .15s ease;
        }

        .btn:active {
            transform: scale(.98);
        }

        .btn:focus-visible,
        .avatar-edit:focus-visible,
        .toggle-password:focus-visible,
        .menu-toggle:focus-visible {
            outline: 2px solid var(--primary-light);
            outline-offset: 3px;
        }

        .btn-primary {
            background: var(--primary);
            color: #191D22;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-secondary {
            background: var(--surface-2);
            color: var(--silver);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface-3);
            border-color: rgba(198,164,119,.3);
            color: var(--text);
        }

        .btn-danger {
            background: rgba(213,143,143,.14);
            color: var(--danger);
            border: 1px solid rgba(213,143,143,.2);
        }

        .btn-danger:hover {
            background: rgba(213,143,143,.22);
        }

        /* SECURITY */

        .security-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(198,164,119,.09);
            border: 1px solid rgba(198,164,119,.16);
            border-radius: 9px;
            padding: 12px;
            margin-bottom: 19px;
        }

        .security-note i {
            color: var(--primary);
            font-size: 16px;
            flex-shrink: 0;
        }

        .security-note p {
            font-size: 10px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* TOAST */

        .toast {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 3000;
            background: var(--surface-2);
            color: var(--text);
            border: 1px solid rgba(145,174,155,.3);
            padding: 13px 18px;
            border-radius: 9px;
            font-size: 12px;
            box-shadow: var(--shadow);
            display: none;
            max-width: calc(100% - 30px);
            line-height: 1.5;
        }

        .toast.error {
            background: #30262A;
            border-color: rgba(213,143,143,.35);
            color: var(--danger);
        }

        /* MODAL */

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.72);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 410px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
        }

        .modal-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 13px;
            background: rgba(213,143,143,.13);
            color: var(--danger);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .modal-card h3 {
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 19px;
            margin-bottom: 8px;
        }

        .modal-card p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 21px;
        }

        /* TABLET */

        @media (max-width: 1100px) {
            .profile-layout {
                grid-template-columns: 250px minmax(0, 1fr);
            }

            .content {
                padding: 28px 24px;
            }

            .topbar {
                padding: 0 24px;
            }
        }

        @media (max-width: 950px) and (min-width: 851px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }

            .profile-card {
                display: grid;
                grid-template-columns: 110px minmax(0, 1fr);
                align-items: center;
                text-align: left;
                gap: 5px 17px;
            }

            .profile-avatar-wrapper {
                grid-row: span 3;
                margin: 0;
            }

            .profile-card h2 {
                align-self: end;
            }

            .profile-email {
                align-self: start;
            }

            .profile-card .status-badge {
                grid-column: 2;
                justify-self: start;
                margin-top: 5px;
            }

            .profile-divider,
            .profile-info {
                grid-column: 1 / -1;
            }

            .profile-info {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
            }

            .profile-info-item {
                margin: 0;
            }
        }

        /* MOBILE */

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .topbar {
                height: 67px;
            }

            .profile-layout {
                grid-template-columns: 1fr;
            }

            .profile-card {
                display: grid;
                grid-template-columns: 110px minmax(0, 1fr);
                align-items: center;
                text-align: left;
                gap: 5px 17px;
            }

            .profile-avatar-wrapper {
                grid-row: span 3;
                margin: 0;
            }

            .profile-card h2 {
                align-self: end;
            }

            .profile-email {
                align-self: start;
            }

            .profile-card .status-badge {
                grid-column: 2;
                justify-self: start;
                margin-top: 5px;
            }

            .profile-divider,
            .profile-info {
                grid-column: 1 / -1;
            }

            .profile-info {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
            }

            .profile-info-item {
                margin: 0;
            }
        }

        @media (max-width: 580px) {
            .content {
                padding: 24px 15px 35px;
            }

            .topbar {
                padding: 0 15px;
            }

            .topbar-date {
                display: none;
            }

            h1 {
                font-size: 26px;
            }

            .profile-card,
            .form-card,
            .security-card {
                padding: 18px;
            }

            .profile-card {
                grid-template-columns: 85px minmax(0, 1fr);
                gap: 5px 13px;
            }

            .profile-avatar-wrapper,
            .profile-avatar {
                width: 80px;
                height: 80px;
            }

            .profile-avatar {
                font-size: 28px;
            }

            .profile-card h2 {
                font-size: 17px;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }

            .card-heading h2 {
                font-size: 17px;
            }

            .modal-actions {
                flex-direction: column-reverse;
            }

            .modal-actions .btn {
                width: 100%;
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
            .profile-card {
                grid-template-columns: 1fr;
                text-align: center;
                justify-items: center;
            }

            .profile-avatar-wrapper {
                grid-row: auto;
                margin: 0 auto 10px;
            }

            .profile-card .status-badge {
                grid-column: auto;
                justify-self: center;
            }

            .profile-divider,
            .profile-info {
                grid-column: 1;
                width: 100%;
                text-align: left;
            }

            .profile-info {
                grid-template-columns: 1fr;
            }

            .breadcrumb {
                font-size: 10px;
            }
        }

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

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-house-heart-fill"></i>
        </div>
        <div>
            <div class="brand-name">KosHaven</div>
            <div class="brand-subtitle">BOARDING HOUSE</div>
        </div>
    </div>

    <div class="nav-label">MENU UTAMA</div>

    <nav class="nav-menu">
        <a href="{{ route('penghuni.dashboard') }}" class="nav-link" data-page-transition>
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <a href="{{ route('penghuni.kamar.index') }}" class="nav-link" data-page-transition>
            <i class="bi bi-door-open"></i> Kamar Saya
        </a>

        <a href="{{ route('penghuni.tagihan.index') }}" class="nav-link" data-page-transition>
            <i class="bi bi-receipt"></i> Tagihan Bulanan
        </a>

        <a href="{{ route('penghuni.riwayat.index') }}" class="nav-link" data-page-transition>
            <i class="bi bi-clock-history"></i> Riwayat Pembayaran
        </a>

        <a href="{{ route('penghuni.fasilitas.index') }}" class="nav-link" data-page-transition>
            <i class="bi bi-stars"></i> Fasilitas Kos
        </a>
    </nav>

    <div class="nav-label">AKUN</div>

    <nav class="nav-menu">
        <a href="{{ route('penghuni.profil.index') }}" class="nav-link active" aria-current="page">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="profile-mini">
            <div class="avatar" id="sidebarAvatar">AP</div>
            <div>
                <strong id="sidebarName">Andi Pratama</strong>
                <span>Penghuni Kos</span>
            </div>
        </div>

        <button class="logout" type="button" onclick="logout()">
            <i class="bi bi-box-arrow-left"></i> Keluar
        </button>
    </div>
</aside>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<main class="main">

    <header class="topbar">
        <div class="topbar-left">
            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Buka navigasi"
                aria-controls="sidebar"
                aria-expanded="false"
            >
                <i class="bi bi-list"></i>
            </button>

            <div class="breadcrumb">
                Akun / <strong>Profil Saya</strong>
            </div>
        </div>

        <div class="topbar-right">
            <span class="topbar-date" id="currentDate"></span>
            <div class="topbar-avatar" id="topbarAvatar">AP</div>
        </div>
    </header>

    <section class="content">

        <div class="page-heading">
            <div class="eyebrow">PENGATURAN AKUN</div>
            <h1>Profil Saya</h1>
            <p class="page-description">
                Kelola informasi pribadi dan keamanan akun KosHaven milikmu.
            </p>
        </div>

        <div class="profile-layout">

            <div class="profile-card">

                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar" id="profileAvatar">AP</div>

                    <button
                        class="avatar-edit"
                        type="button"
                        onclick="document.getElementById('photoInput').click()"
                        aria-label="Ubah foto profil"
                    >
                        <i class="bi bi-camera-fill"></i>
                    </button>

                    <input
                        type="file"
                        id="photoInput"
                        accept="image/png,image/jpeg,image/webp"
                        hidden
                    >
                </div>

                <h2 id="displayName">Andi Pratama</h2>
                <p class="profile-email" id="displayEmail">andi@email.com</p>

                <div class="status-badge">
                    <i class="bi bi-check-circle-fill"></i>
                    Akun Aktif
                </div>

                <div class="profile-divider"></div>

                <div class="profile-info">

                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class="bi bi-door-closed"></i>
                        </div>
                        <div>
                            <small>Nomor Kamar</small>
                            <strong id="displayRoom">A-01</strong>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <small>Status Penghuni</small>
                            <strong>Penghuni Aktif</strong>
                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <small>Bergabung Sejak</small>
                            <strong id="displayJoinDate">Januari 2026</strong>
                        </div>
                    </div>

                </div>
            </div>

            <div class="profile-main">

                <div class="form-card">

                    <div class="card-heading">
                        <div class="card-heading-icon">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <div>
                            <h2>Informasi Pribadi</h2>
                            <p>Perbarui informasi pribadi yang terhubung dengan akunmu.</p>
                        </div>
                    </div>

                    <form id="profileForm" novalidate>

                        <div class="form-grid">

                            <div class="form-group">
                                <label for="fullName">
                                    Nama Lengkap <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="fullName"
                                    class="form-control"
                                    maxlength="80"
                                    required
                                    autocomplete="name"
                                    placeholder="Masukkan nama lengkap"
                                >

                                <small class="field-error" id="nameError"></small>
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    Alamat Email <span class="required">*</span>
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    maxlength="120"
                                    required
                                    autocomplete="email"
                                    placeholder="nama@email.com"
                                >

                                <small class="field-error" id="emailError"></small>
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    Nomor Telepon <span class="required">*</span>
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    class="form-control"
                                    maxlength="16"
                                    required
                                    autocomplete="tel"
                                    inputmode="tel"
                                    placeholder="08xxxxxxxxxx"
                                >

                                <small class="field-hint">Gunakan nomor telepon aktif.</small>
                                <small class="field-error" id="phoneError"></small>
                            </div>

                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>

                                <input
                                    type="text"
                                    id="gender"
                                    class="form-control"
                                    maxlength="20"
                                    placeholder="Masukkan jenis kelamin"
                                >

                                <small class="field-error" id="genderError"></small>
                            </div>

                            <div class="form-group full">
                                <label for="address">Alamat Asal</label>

                                <input
                                    type="text"
                                    id="address"
                                    class="form-control"
                                    maxlength="180"
                                    autocomplete="street-address"
                                    placeholder="Masukkan alamat asal"
                                >

                                <small class="field-error" id="addressError"></small>
                            </div>

                            <div class="form-group">
                                <label for="room">Nomor Kamar</label>

                                <input
                                    type="text"
                                    id="room"
                                    class="form-control"
                                    value="A-01"
                                    disabled
                                >

                                <small class="field-hint">Nomor kamar dikelola oleh Admin.</small>
                            </div>

                            <div class="form-group">
                                <label for="joinDate">Tanggal Bergabung</label>

                                <input
                                    type="text"
                                    id="joinDate"
                                    class="form-control"
                                    value="Januari 2026"
                                    disabled
                                >
                            </div>

                        </div>

                        <div class="form-actions">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="resetProfileForm()"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Batal
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle"></i>
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>

                <div class="security-card">

                    <div class="card-heading">
                        <div class="card-heading-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        <div>
                            <h2>Keamanan Akun</h2>
                            <p>Perbarui password untuk menjaga keamanan akunmu.</p>
                        </div>
                    </div>

                    <div class="security-note">
                        <i class="bi bi-info-circle-fill"></i>

                        <p>
                            Gunakan password yang kuat dan tidak mudah ditebak.
                            Jangan membagikan password kepada orang lain.
                        </p>
                    </div>

                    <form id="passwordForm" novalidate>

                        <div class="form-grid">

                            <div class="form-group full">
                                <label for="currentPassword">
                                    Password Saat Ini <span class="required">*</span>
                                </label>

                                <div class="input-password">
                                    <input
                                        type="password"
                                        id="currentPassword"
                                        class="form-control"
                                        required
                                        autocomplete="current-password"
                                        maxlength="100"
                                        placeholder="Masukkan password saat ini"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        data-target="currentPassword"
                                        aria-label="Tampilkan password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                <small class="field-error" id="currentPasswordError"></small>
                            </div>

                            <div class="form-group">
                                <label for="newPassword">
                                    Password Baru <span class="required">*</span>
                                </label>

                                <div class="input-password">
                                    <input
                                        type="password"
                                        id="newPassword"
                                        class="form-control"
                                        required
                                        autocomplete="new-password"
                                        maxlength="100"
                                        placeholder="Minimal 8 karakter"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        data-target="newPassword"
                                        aria-label="Tampilkan password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                <small class="field-error" id="newPasswordError"></small>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">
                                    Konfirmasi Password <span class="required">*</span>
                                </label>

                                <div class="input-password">
                                    <input
                                        type="password"
                                        id="confirmPassword"
                                        class="form-control"
                                        required
                                        autocomplete="new-password"
                                        maxlength="100"
                                        placeholder="Ulangi password baru"
                                    >

                                    <button
                                        type="button"
                                        class="toggle-password"
                                        data-target="confirmPassword"
                                        aria-label="Tampilkan password"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                <small class="field-error" id="confirmPasswordError"></small>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="resetPasswordForm()"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shield-check"></i>
                                Ubah Password
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>
</main>

<div
    class="modal-backdrop"
    id="confirmModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="logoutTitle"
>
    <div class="modal-card">

        <div class="modal-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>

        <h3 id="logoutTitle">Keluar dari Akun?</h3>

        <p>
            Apakah kamu yakin ingin mengakhiri sesi dan keluar dari akun KosHaven?
        </p>

        <div class="modal-actions">
            <button
                class="btn btn-secondary"
                type="button"
                onclick="closeLogoutModal()"
            >
                Batal
            </button>

            <button
                class="btn btn-danger"
                type="button"
                onclick="confirmLogout()"
            >
                Ya, Keluar
            </button>
        </div>

    </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
    const PROFILE_KEY = 'koshaven_penghuni_profil';

    const defaultProfile = {
        name: 'Andi Pratama',
        email: 'andi@email.com',
        phone: '081234567890',
        gender: '',
        address: '',
        room: 'A-01',
        joinDate: 'Januari 2026',
        photo: ''
    };

    let profile = loadProfile();
    let selectedPhoto = profile.photo || '';
    let toastTimer = null;

    // DATA PROFIL

    function loadProfile() {
        try {
            const saved = localStorage.getItem(PROFILE_KEY);

            if (!saved) {
                return { ...defaultProfile };
            }

            const parsed = JSON.parse(saved);

            if (!parsed || typeof parsed !== 'object' || Array.isArray(parsed)) {
                return { ...defaultProfile };
            }

            return {
                ...defaultProfile,
                ...parsed
            };

        } catch (error) {
            console.error('Gagal membaca data profil:', error);
            return { ...defaultProfile };
        }
    }

    function getInitials(name) {
        const words = String(name || 'Penghuni')
            .trim()
            .split(/\s+/)
            .filter(Boolean);

        return words
            .slice(0, 2)
            .map(word => word.charAt(0).toUpperCase())
            .join('') || 'P';
    }

    function renderAvatar(element, photo, name) {
        if (!element) return;

        element.replaceChildren();

        if (photo) {
            const image = document.createElement('img');

            image.src = photo;
            image.alt = 'Foto profil ' + name;

            image.onerror = function() {
                element.textContent = getInitials(name);
            };

            element.appendChild(image);
        } else {
            element.textContent = getInitials(name);
        }
    }

    function renderProfile() {
        document.getElementById('displayName').textContent = profile.name;
        document.getElementById('displayEmail').textContent = profile.email;
        document.getElementById('displayRoom').textContent = profile.room;
        document.getElementById('displayJoinDate').textContent = profile.joinDate;

        document.getElementById('sidebarName').textContent = profile.name;

        document.getElementById('fullName').value = profile.name;
        document.getElementById('email').value = profile.email;
        document.getElementById('phone').value = profile.phone;
        document.getElementById('gender').value = profile.gender;
        document.getElementById('address').value = profile.address;
        document.getElementById('room').value = profile.room;
        document.getElementById('joinDate').value = profile.joinDate;

        renderAvatar(
            document.getElementById('profileAvatar'),
            profile.photo,
            profile.name
        );

        renderAvatar(
            document.getElementById('sidebarAvatar'),
            profile.photo,
            profile.name
        );

        renderAvatar(
            document.getElementById('topbarAvatar'),
            profile.photo,
            profile.name
        );
    }

    function saveProfile(data) {
        try {
            localStorage.setItem(PROFILE_KEY, JSON.stringify(data));

            profile = data;
            selectedPhoto = data.photo || '';

            renderProfile();

            return true;

        } catch (error) {
            console.error('Gagal menyimpan profil:', error);

            showToast(
                'Penyimpanan gagal. Ukuran foto mungkin terlalu besar.',
                true
            );

            return false;
        }
    }

    // VALIDASI PROFIL

    function clearErrors(ids) {
        ids.forEach(id => {
            const errorElement = document.getElementById(id + 'Error');

            if (errorElement) {
                errorElement.textContent = '';
            }
        });
    }

    function setError(id, message) {
        const errorElement = document.getElementById(id + 'Error');

        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function validateProfile() {
        clearErrors([
            'name',
            'email',
            'phone',
            'gender',
            'address'
        ]);

        const name = document.getElementById('fullName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const gender = document.getElementById('gender').value.trim();
        const address = document.getElementById('address').value.trim();

        let valid = true;

        if (name.length < 3) {
            setError('name', 'Nama lengkap minimal 3 karakter.');
            valid = false;
        } else if (name.length > 80) {
            setError('name', 'Nama maksimal 80 karakter.');
            valid = false;
        } else if (!/^[\p{L}\p{M} .'-]+$/u.test(name)) {
            setError('name', 'Nama hanya boleh berisi huruf dan tanda baca yang sesuai.');
            valid = false;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

        if (!emailPattern.test(email)) {
            setError('email', 'Masukkan alamat email yang valid.');
            valid = false;
        }

        const cleanPhone = phone.replace(/[\s-]/g, '');

        if (!/^(\+62|62|0)[0-9]{8,13}$/.test(cleanPhone)) {
            setError('phone', 'Masukkan nomor telepon Indonesia yang valid.');
            valid = false;
        }

        if (gender.length > 20) {
            setError('gender', 'Jenis kelamin maksimal 20 karakter.');
            valid = false;
        }

        if (address.length > 180) {
            setError('address', 'Alamat maksimal 180 karakter.');
            valid = false;
        }

        return valid;
    }

    document.getElementById('profileForm').addEventListener('submit', function(event) {
        event.preventDefault();

        if (!validateProfile()) {
            showToast('Periksa kembali data yang belum sesuai.', true);
            return;
        }

        const updatedProfile = {
            ...profile,
            name: document.getElementById('fullName').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            gender: document.getElementById('gender').value.trim(),
            address: document.getElementById('address').value.trim(),
            photo: selectedPhoto
        };

        if (saveProfile(updatedProfile)) {
            showToast('Informasi profil berhasil diperbarui.');
            clearErrors(['name', 'email', 'phone', 'gender', 'address']);
        }
    });

    function resetProfileForm() {
        renderProfile();

        clearErrors([
            'name',
            'email',
            'phone',
            'gender',
            'address'
        ]);

        document.getElementById('photoInput').value = '';

        showToast('Perubahan profil dibatalkan.');
    }

    // FOTO PROFIL

    document.getElementById('photoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (!file) return;

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            showToast('Format foto harus JPG, PNG, atau WEBP.', true);
            this.value = '';
            return;
        }

        if (file.size > 1024 * 1024) {
            showToast('Ukuran foto maksimal 1 MB.', true);
            this.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            const image = new Image();

            image.onload = function() {
                selectedPhoto = e.target.result;

                renderAvatar(
                    document.getElementById('profileAvatar'),
                    selectedPhoto,
                    profile.name
                );

                showToast('Foto siap disimpan. Klik Simpan Perubahan.');
            };

            image.onerror = function() {
                showToast('File gambar tidak dapat dibaca.', true);
            };

            image.src = e.target.result;
        };

        reader.onerror = function() {
            showToast('Gagal membaca file gambar.', true);
        };

        reader.readAsDataURL(file);
    });

    // TAMPILKAN / SEMBUNYIKAN PASSWORD

    const passwordFields = [
        'currentPassword',
        'newPassword',
        'confirmPassword'
    ];

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');

            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';

            icon.className = isHidden
                ? 'bi bi-eye-slash'
                : 'bi bi-eye';

            this.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    });

    // VALIDASI PASSWORD

    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        event.preventDefault();

        clearErrors(passwordFields);

        const current = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmation = document.getElementById('confirmPassword').value;

        let valid = true;

        if (!current) {
            setError('currentPassword', 'Password saat ini wajib diisi.');
            valid = false;
        }

        if (newPassword.length < 8) {
            setError('newPassword', 'Password baru minimal 8 karakter.');
            valid = false;
        } else if (newPassword.length > 100) {
            setError('newPassword', 'Password maksimal 100 karakter.');
            valid = false;
        } else if (!/[A-Za-z]/.test(newPassword) || !/[0-9]/.test(newPassword)) {
            setError('newPassword', 'Password harus mengandung huruf dan angka.');
            valid = false;
        }

        if (newPassword === current && current) {
            setError('newPassword', 'Password baru harus berbeda dari password lama.');
            valid = false;
        }

        if (!confirmation) {
            setError('confirmPassword', 'Konfirmasi password wajib diisi.');
            valid = false;
        } else if (confirmation !== newPassword) {
            setError('confirmPassword', 'Konfirmasi password tidak cocok.');
            valid = false;
        }

        if (!valid) {
            showToast('Periksa kembali data password.', true);
            return;
        }

        /*
         * DEMO FRONTEND:
         * Password belum disimpan atau diubah.
         * Perubahan password sebenarnya harus diproses
         * melalui Laravel menggunakan Hash dan verifikasi
         * password pengguna yang sedang login.
         */

        showToast('Validasi berhasil. Fitur ubah password perlu dihubungkan ke Laravel.');

        this.reset();
        clearErrors(passwordFields);

        document.querySelectorAll('.toggle-password').forEach(button => {
            const input = document.getElementById(button.dataset.target);

            input.type = 'password';

            button.querySelector('i').className = 'bi bi-eye';

            button.setAttribute('aria-label', 'Tampilkan password');
        });
    });

    function resetPasswordForm() {
        document.getElementById('passwordForm').reset();

        clearErrors(passwordFields);

        document.querySelectorAll('.toggle-password').forEach(button => {
            const input = document.getElementById(button.dataset.target);

            input.type = 'password';

            button.querySelector('i').className = 'bi bi-eye';

            button.setAttribute('aria-label', 'Tampilkan password');
        });

        showToast('Form password berhasil direset.');
    }

    // TOAST NOTIFICATION

    function showToast(message, isError = false) {
        const toast = document.getElementById('toast');

        toast.textContent = message;
        toast.classList.toggle('error', isError);
        toast.style.display = 'block';

        clearTimeout(toastTimer);

        toastTimer = setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    // LOGOUT

    function logout() {
        document.getElementById('confirmModal').classList.add('show');
        syncBodyScrollLock();
    }

    function closeLogoutModal() {
        document.getElementById('confirmModal').classList.remove('show');
        syncBodyScrollLock();
    }

    function confirmLogout() {
        window.location.href = "{{ route('login') }}";
    }

    // SIDEBAR RESPONSIVE

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menuToggle');
    const confirmModal = document.getElementById('confirmModal');

    function syncBodyScrollLock() {
        const sidebarOpen = sidebar.classList.contains('show');
        const modalOpen = confirmModal.classList.contains('show');

        document.body.classList.toggle(
            'sidebar-open',
            sidebarOpen && window.innerWidth <= 850
        );

        document.body.classList.toggle('modal-open', modalOpen);
    }

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');

        menuToggle.setAttribute('aria-expanded', 'true');

        syncBodyScrollLock();
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');

        menuToggle.setAttribute('aria-expanded', 'false');

        syncBodyScrollLock();
    }

    menuToggle.addEventListener('click', () => {
        sidebar.classList.contains('show')
            ? closeSidebar()
            : openSidebar();
    });

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            closeSidebar();
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 850) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeSidebar();
            closeLogoutModal();
        }
    });

    confirmModal.addEventListener('click', event => {
        if (event.target === confirmModal) {
            closeLogoutModal();
        }
    });

    // TANGGAL

    document.getElementById('currentDate').textContent =
        new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date());

    // INISIALISASI

    renderProfile();
</script>

@vite('resources/js/app.js')

</body>
</html>
