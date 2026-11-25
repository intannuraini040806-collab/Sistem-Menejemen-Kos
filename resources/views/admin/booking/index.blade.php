
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Kos - KosHaven</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #191D22;
            --primary-light: #2D343D;
            --primary-soft: #363E48;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --background: #12161B;
            --white: #242A31;
            --surface: #2D343D;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.13);
            --success: #91AE9B;
            --danger: #D58F8F;
            --warning: #D9B77F;
            --shadow: 0 12px 35px rgba(0,0,0,.16);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: auto !important; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body.no-scroll { overflow: hidden; }

        button, input, select, textarea { font: inherit; }
        button { cursor: pointer; }
        a { text-decoration: none; color: inherit; }

        /* PAGE TRANSITION */
        .kh-page-cover {
            position: fixed;
            inset: 0;
            z-index: 5000;
            pointer-events: none;
            background: var(--gold);
            clip-path: inset(0 0 100% 0);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 270px;
            height: 100vh;
            background: #191D22;
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform .3s ease;
            border-right: 1px solid rgba(187,196,205,.10);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.15) transparent;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.15);
            border-radius: 10px;
        }

        .brand {
            min-height: 146px;
            padding: 30px;
            border-bottom: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: -.7px;
            color: #F4F0E8;
        }

        .brand-name span { color: var(--gold); }

        .brand-subtitle {
            color: var(--muted);
            font-size: 11px;
            letter-spacing: 1.7px;
            line-height: 1.7;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .sidebar-menu { padding: 17px 16px 20px; }

        .menu-label {
            color: var(--muted-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 12px 14px;
            margin: 0 0 9px;
            text-transform: uppercase;
        }

        .menu-list { display: flex; flex-direction: column; gap: 5px; }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 52px;
            padding: 12px 15px;
            border-radius: 9px;
            border-left: 3px solid transparent;
            color: #B9C0C7;
            font-size: 13px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease;
        }

        .menu-link i {
            width: 20px;
            flex-shrink: 0;
            text-align: center;
            font-size: 18px;
            color: var(--silver);
        }

        .menu-link:hover {
            background: rgba(255,255,255,.055);
            color: white;
        }

        .menu-link.active {
            background: rgba(198,164,119,.12);
            border-left-color: var(--gold);
            color: var(--gold-light);
        }

        .menu-link.active i { color: var(--gold); }

        .sidebar-bottom {
            margin-top: auto;
            padding: 0 16px 18px;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 17px 13px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .profile-avatar {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, #C6A477, #92734E);
            display: grid;
            place-items: center;
            color: #191D22;
            font-size: 15px;
            font-weight: 700;
        }

        .profile-info { min-width: 0; }

        .profile-info strong {
            display: block;
            font-size: 12px;
            color: white;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 155px;
        }

        .profile-info small { color: var(--muted); font-size: 10px; }
        .logout-form { margin-top: 10px; }

        .logout-button {
            border: 0;
            background: transparent;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 14px;
            width: 100%;
            font-size: 13px;
            border-radius: 9px;
            transition: .2s;
        }

        .logout-button i { font-size: 18px; }

        .logout-button:hover {
            background: rgba(213,143,143,.10);
            color: var(--danger);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.65);
            z-index: 900;
            backdrop-filter: blur(3px);
        }

        .sidebar-overlay.show { display: block; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 270px;
            min-height: 100vh;
            padding: 27px 35px 45px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .topbar-left { display: flex; align-items: center; gap: 13px; }

        .mobile-menu-button {
            display: none;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--gold);
            width: 40px;
            height: 40px;
            border-radius: 9px;
            font-size: 20px;
        }

        .breadcrumb { font-size: 12px; color: var(--muted); }
        .breadcrumb strong { color: var(--gold); }

        .topbar-date {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-date i { color: var(--gold); }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 27px;
        }

        .page-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 31px;
            color: #F1F0EC;
            margin-bottom: 7px;
            letter-spacing: -.4px;
        }

        .page-heading p { color: var(--muted); font-size: 13px; }

        /* BUTTON */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 8px;
            padding: 11px 17px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
            white-space: nowrap;
        }

        .btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        .btn-primary {
            background: linear-gradient(135deg, #C6A477, #A9875B);
            color: #191D22;
            box-shadow: 0 5px 15px rgba(198,164,119,.13);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #E0C49B, #C6A477);
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--silver-light);
        }

        .btn-outline:hover {
            background: #363E48;
            border-color: rgba(198,164,119,.4);
            color: var(--gold-light);
        }

        .btn-danger {
            background: rgba(213,143,143,.13);
            color: var(--danger);
            border: 1px solid rgba(213,143,143,.15);
        }

        .btn-danger:hover { background: rgba(213,143,143,.22); }

        /* STATISTIK */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: transform .25s, border-color .25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.35);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 75px;
            height: 75px;
            right: -25px;
            bottom: -35px;
            border-radius: 50%;
            background: rgba(198,164,119,.045);
            pointer-events: none;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            gap: 8px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            font-size: 17px;
            flex-shrink: 0;
        }

        .stat-icon.total { background: rgba(146,157,168,.15); color: var(--silver-light); }
        .stat-icon.waiting { background: rgba(217,183,127,.14); color: var(--warning); }
        .stat-icon.approved { background: rgba(145,174,155,.14); color: var(--success); }
        .stat-icon.rejected { background: rgba(213,143,143,.14); color: var(--danger); }

        .stat-card small { color: var(--muted); font-size: 11px; }

        .stat-card h2 {
            color: #F1F0EC;
            font-size: 27px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        /* TABEL BOOKING */
        .table-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            padding: 21px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .table-header h3 {
            font-family: 'Playfair Display', serif;
            color: #F1F0EC;
            font-size: 19px;
        }

        .table-header p { color: var(--muted); font-size: 11px; margin-top: 5px; }

        .filter-area { display: flex; align-items: center; gap: 9px; }
        .search-box { position: relative; }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-dark);
        }

        .search-box input {
            width: 215px;
            padding: 10px 12px 10px 34px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            font-size: 11px;
            color: var(--text);
            background: #191D22;
            transition: .2s;
        }

        .search-box input::placeholder { color: var(--muted-dark); }

        .search-box input:focus,
        .filter-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.08);
        }

        .filter-select {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            outline: none;
            background: #191D22;
            font-size: 11px;
        }

        .filter-select option { background: #242A31; color: var(--text); }

        .reset-button {
            border: 0;
            background: transparent;
            color: var(--gold);
            font-size: 11px;
            font-weight: 600;
            padding: 8px;
        }

        .reset-button:hover { color: var(--gold-light); }

        .table-responsive { width: 100%; overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 780px;
        }

        thead { background: #1E242B; }

        th {
            padding: 15px 17px;
            text-align: left;
            color: var(--silver);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .7px;
            font-weight: 700;
            white-space: nowrap;
        }

        td {
            padding: 16px 17px;
            border-top: 1px solid var(--border);
            font-size: 11px;
            color: var(--muted);
            vertical-align: middle;
        }

        tbody tr { transition: background .2s; }
        tbody tr:hover { background: rgba(255,255,255,.025); }

        .booking-code { color: var(--gold-light); font-weight: 700; white-space: nowrap; }
        .tenant-name { display: block; color: var(--text); font-weight: 600; margin-bottom: 4px; }
        .tenant-email { display: block; color: var(--muted-dark); font-size: 10px; }

        .room-badge {
            background: rgba(146,157,168,.13);
            color: var(--silver-light);
            padding: 5px 9px;
            border-radius: 5px;
            font-weight: 700;
            border: 1px solid rgba(146,157,168,.12);
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-menunggu { background: rgba(217,183,127,.13); color: var(--warning); }
        .status-disetujui { background: rgba(145,174,155,.14); color: var(--success); }
        .status-ditolak { background: rgba(213,143,143,.14); color: var(--danger); }
        .status-dibatalkan { background: rgba(146,157,168,.13); color: var(--silver); }
        .status-selesai { background: rgba(139,158,204,.14); color: #A9BCEB; }

        .action-buttons { display: flex; align-items: center; gap: 5px; }
        .action-buttons form { display: inline-flex; }

        .icon-btn {
            width: 30px;
            height: 30px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: #2D343D;
            color: var(--silver-light);
            display: grid;
            place-items: center;
            font-size: 13px;
            transition: .2s;
        }

        .icon-btn:hover {
            background: var(--gold);
            color: #191D22;
            border-color: var(--gold);
        }

        .icon-btn.danger:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: #191D22;
        }

        .empty-state { text-align: center; padding: 45px 15px; color: var(--muted); }
        .empty-state i { display: block; font-size: 35px; margin-bottom: 12px; color: var(--silver); }
        .empty-state strong { display: block; color: var(--text); font-size: 13px; margin-bottom: 6px; }
        .empty-state p { font-size: 11px; }

        .table-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .table-info { color: var(--muted); font-size: 11px; }
        .pagination-wrap nav { display: flex; align-items: center; gap: 4px; }
        .pagination-wrap nav > div:first-child { display: none; }

        .pagination-wrap nav > div:last-child > span,
        .pagination-wrap nav > div:last-child > a { display: inline-flex; align-items: center; gap: 5px; }

        .pagination-wrap nav span span,
        .pagination-wrap nav span a,
        .pagination-wrap nav a { font-size: 11px; }

        .pagination-wrap nav a,
        .pagination-wrap nav span[aria-current] span {
            padding: 7px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--silver-light);
        }

        .pagination-wrap nav a:hover { border-color: var(--gold); color: var(--gold); }

        .pagination-wrap nav span[aria-current] span {
            background: var(--gold);
            color: #191D22;
            border-color: var(--gold);
        }

        .pagination-wrap svg { width: 13px; height: 13px; }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(8,11,14,.78);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 2000;
            overflow-y: auto;
        }

        .modal-overlay.show { display: flex; }

        .modal {
            background: #242A31;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 550px;
            border-radius: 14px;
            box-shadow: 0 20px 70px rgba(0,0,0,.4);
            overflow: hidden;
            margin: auto;
            animation: modalIn .22s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 23px;
            border-bottom: 1px solid var(--border);
            background: #292F37;
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            color: var(--gold-light);
            font-size: 19px;
        }

        .modal-close {
            border: 1px solid var(--border);
            background: #363E48;
            color: var(--silver-light);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-size: 17px;
            transition: .2s;
        }

        .modal-close:hover { background: rgba(213,143,143,.15); color: var(--danger); }

        .modal-body { padding: 22px 23px; max-height: 70vh; overflow-y: auto; }

        .modal-footer {
            padding: 16px 23px;
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            background: #292F37;
        }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            color: var(--silver-light);
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .form-group label span { color: var(--danger); }

        .form-control {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 11px 12px;
            outline: none;
            color: var(--text);
            background: #191D22;
            font-size: 12px;
            transition: .2s;
        }

        .form-control::placeholder { color: var(--muted-dark); }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.09);
        }

        .form-control:disabled { background: #363E48; cursor: not-allowed; }
        .form-control[readonly] { color: var(--muted); background: #20262D; }
        .form-control option { background: #242A31; color: var(--text); }

        textarea.form-control { resize: vertical; min-height: 85px; }

        .form-hint { color: var(--muted-dark); font-size: 10px; margin-top: 6px; line-height: 1.5; }
        .form-error { color: var(--danger); font-size: 10px; margin-top: 6px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }

        .detail-section-title {
            color: var(--gold);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
            margin: 18px 0 12px;
            padding-bottom: 9px;
            border-bottom: 1px solid var(--border);
        }

        .detail-section-title:first-child { margin-top: 0; }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .detail-item small { display: block; color: var(--muted-dark); font-size: 10px; margin-bottom: 5px; }

        .detail-item strong {
            display: block;
            color: var(--text);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .detail-note {
            background: #191D22;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            color: var(--silver-light);
            font-size: 11px;
            line-height: 1.7;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        /* TOAST */
        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            background: #2D343D;
            border: 1px solid var(--border);
            color: white;
            padding: 14px 19px;
            border-radius: 9px;
            font-size: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,.3);
            z-index: 3000;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: calc(100% - 40px);
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px);
            transition: .25s;
        }

        .toast.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .toast.success i { color: var(--success); }
        .toast.error i { color: var(--danger); }

        /* ANIMASI HALAMAN */
        [data-page-enter] { will-change: opacity, transform; }
        [data-motion-card] { will-change: transform; }
        .stat-card, .table-card { transform-origin: center top; }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .main-content { padding: 25px 23px 40px; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

            .table-header { align-items: flex-start; flex-direction: column; }
            .filter-area { width: 100%; flex-wrap: wrap; }
            .search-box { flex: 1; min-width: 180px; }
            .search-box input { width: 100%; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 270px; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .main-content { margin-left: 0; padding: 20px 17px 35px; }

            .mobile-menu-button { display: grid; place-items: center; }
            .topbar { margin-bottom: 27px; }

            .page-heading { align-items: flex-start; flex-direction: column; }
            .page-heading h1 { font-size: 27px; }
            .page-heading .btn { width: 100%; }
            .topbar-date { font-size: 10px; }

            .table-header { padding: 18px; }
            .filter-area { align-items: stretch; }
            .search-box { flex-basis: 100%; }
            .filter-select { flex: 1; }
            .reset-button { white-space: nowrap; }
        }

        @media (max-width: 480px) {
            .main-content { padding: 17px 12px 30px; }
            .stats-grid { gap: 10px; }
            .stat-card { padding: 14px; }
            .stat-card h2 { font-size: 22px; }
            .stat-card small { font-size: 10px; }
            .stat-icon { width: 32px; height: 32px; font-size: 15px; }
            .breadcrumb { font-size: 10px; }

            .topbar-date {
                max-width: 125px;
                text-align: right;
                line-height: 1.5;
            }

            .form-row, .detail-grid { grid-template-columns: 1fr; gap: 0; }
            .modal-overlay { padding: 10px; }

            .modal-header, .modal-body, .modal-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .modal-footer .btn { flex: 1; }

            .table-footer { align-items: flex-start; flex-direction: column; }
            .pagination-wrap { max-width: 100%; overflow-x: auto; }
            .toast { right: 12px; bottom: 12px; }
        }

        @media (max-width: 360px) {
            .stats-grid { grid-template-columns: 1fr; }
            .stat-card { padding: 17px; }
            .filter-select { min-width: 0; }
            .topbar-left { gap: 8px; }
            .mobile-menu-button { width: 36px; height: 36px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>

    <div class="kh-page-cover" data-page-cover aria-hidden="true"></div>

    {{-- SIDEBAR ADMIN --}}
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-name">Kos<span>Haven</span></div>
            <div class="brand-subtitle">
                Boarding House<br>
                Management
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>

            <nav class="menu-list">
                <a href="{{ route('admin.dashboard') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.pengguna.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-person-gear"></i>
                    <span>Manajemen Pengguna</span>
                </a>

                <a href="{{ route('admin.kamar.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-door-open"></i>
                    <span>Data Kamar</span>
                </a>

                <a href="{{ route('admin.booking.index') }}" class="menu-link active" aria-current="page">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking</span>
                </a>

                <a href="{{ route('admin.penghuni.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-people"></i>
                    <span>Data Penghuni</span>
                </a>

                <a href="{{ route('admin.petugas.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-person-badge"></i>
                    <span>Data Petugas</span>
                </a>

                <a href="{{ route('admin.pengguna.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-person-gear"></i>
                    <span>Data Pengguna</span>
                </a>
            </nav>

            <div class="menu-label" style="margin-top: 24px;">
                Keuangan & Lainnya
            </div>

            <nav class="menu-list">
                <a href="{{ route('admin.tagihan.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-receipt"></i>
                    <span>Tagihan</span>
                </a>

                <a href="{{ route('admin.pembayaran.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-wallet2"></i>
                    <span>Pembayaran</span>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Laporan</span>
                </a>

                <a href="{{ route('admin.profil.index') }}" class="menu-link" data-page-transition>
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Admin</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <div class="sidebar-profile">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="profile-info">
                    <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                    <small>Administrator</small>
                </div>
            </div>

            <form action="{{ route('logout') }}"
                  method="POST"
                  class="logout-form"
                  onsubmit="return confirm('Yakin ingin keluar dari akun?')">
                @csrf

                <button type="submit" class="logout-button">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- MAIN CONTENT --}}
    <main class="main-content" data-page-enter>

        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-menu-button"
                        id="mobileMenuButton"
                        type="button"
                        onclick="toggleSidebar()"
                        aria-label="Buka menu"
                        aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <div class="breadcrumb">
                    Dashboard / <strong>Booking</strong>
                </div>
            </div>

            <div class="topbar-date">
                <i class="bi bi-calendar3"></i>
                <span id="currentDate"></span>
            </div>
        </header>

        {{-- PAGE HEADING --}}
        <section class="page-heading" data-scroll-reveal>
            <div>
                <h1>Manajemen Booking</h1>
                <p>Kelola permintaan pemesanan kamar KosHaven.</p>
            </div>

            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i>
                Tambah Booking
            </button>
        </section>

        {{-- STATISTIK --}}
        <section class="stats-grid" data-scroll-reveal>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <small>Total Booking</small>
                    <div class="stat-icon total">
                        <i class="bi bi-calendar2-week"></i>
                    </div>
                </div>
                <h2 data-count-to="{{ (int) $totalBooking }}">0</h2>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <small>Menunggu Persetujuan</small>
                    <div class="stat-icon waiting">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <h2 data-count-to="{{ (int) $waitingBooking }}">0</h2>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <small>Booking Disetujui</small>
                    <div class="stat-icon approved">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <h2 data-count-to="{{ (int) $approvedBooking }}">0</h2>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <small>Booking Ditolak</small>
                    <div class="stat-icon rejected">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
                <h2 data-count-to="{{ (int) $rejectedBooking }}">0</h2>
            </div>

        </section>

        {{-- TABEL BOOKING --}}
        <section class="table-card" data-scroll-reveal>

            <div class="table-header">
                <div>
                    <h3>Daftar Booking</h3>
                    <p>Data pemesanan kamar yang tersimpan dalam sistem.</p>
                </div>

                <form action="{{ route('admin.booking.index') }}"
                      method="GET"
                      class="filter-area"
                      id="filterForm">

                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input
                            type="search"
                            name="search"
                            id="searchBooking"
                            placeholder="Cari nama, email, atau kamar..."
                            value="{{ request('search') }}"
                            maxlength="100"
                            autocomplete="off"
                        >
                    </div>

                    <select name="status" id="filterStatus" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                        <option value="dibatalkan" @selected(request('status') === 'dibatalkan')>Dibatalkan</option>
                        <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                    </select>

                    <button type="button" class="reset-button" onclick="resetFilters()">
                        Reset
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Penghuni</th>
                            <th>Kamar</th>
                            <th>Tanggal Booking</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="bookingTableBody">
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    <span class="booking-code">
                                        BKG-{{ $booking->created_at?->format('Y') ?? date('Y') }}-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="tenant-name">
                                        {{ $booking->user?->name ?? 'Penghuni tidak ditemukan' }}
                                    </span>
                                    <span class="tenant-email">
                                        {{ $booking->user?->email ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="room-badge">
                                        {{ $booking->kamar?->nomor_kamar ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $booking->tanggal_booking
                                        ? \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    {{ $booking->tanggal_masuk
                                        ? \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @php
                                        $statusClass = match($booking->status) {
                                            'menunggu' => 'status-menunggu',
                                            'disetujui' => 'status-disetujui',
                                            'ditolak' => 'status-ditolak',
                                            'dibatalkan' => 'status-dibatalkan',
                                            'selesai' => 'status-selesai',
                                            default => 'status-menunggu',
                                        };

                                        $statusLabel = ucfirst($booking->status);
                                    @endphp

                                    <span class="status {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <button
                                            type="button"
                                            class="icon-btn"
                                            title="Lihat Detail"
                                            aria-label="Lihat detail booking"
                                            onclick="showDetail({{ $booking->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if($booking->status === 'menunggu')
                                            <form action="{{ route('admin.booking.approve', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Setujui booking ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="icon-btn"
                                                        title="Setujui Booking"
                                                        aria-label="Setujui booking">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <button
                                                type="button"
                                                class="icon-btn danger"
                                                title="Tolak Booking"
                                                aria-label="Tolak booking"
                                                onclick="openRejectModal({{ $booking->id }}, @js($booking->user?->name ?? 'Penghuni'))">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif

                                        @if(in_array($booking->status, ['menunggu', 'ditolak', 'dibatalkan']))
                                            <form action="{{ route('admin.booking.destroy', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus data booking ini? Data yang dihapus tidak dapat dikembalikan.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="icon-btn danger"
                                                        title="Hapus Booking"
                                                        aria-label="Hapus booking">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <strong>Data booking tidak ditemukan</strong>
                                        <p>
                                            @if(request()->hasAny(['search', 'status']))
                                                Coba ubah kata kunci pencarian atau filter status.
                                            @else
                                                Belum ada data booking yang tersimpan.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="table-info">
                    Menampilkan {{ $bookings->firstItem() ?? 0 }}
                    - {{ $bookings->lastItem() ?? 0 }}
                    dari {{ $bookings->total() }} booking
                </div>

                <div class="pagination-wrap">
                    {{ $bookings->links() }}
                </div>
            </div>
        </section>
    </main>

    {{-- MODAL TAMBAH BOOKING --}}
    <div class="modal-overlay" id="addModal" aria-hidden="true">
        <div class="modal">
            <div class="modal-header">
                <h3>Tambah Booking Baru</h3>
                <button type="button"
                        class="modal-close"
                        onclick="closeModal('addModal')"
                        aria-label="Tutup">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <form action="{{ route('admin.booking.store') }}"
                  method="POST"
                  id="bookingForm">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="bookingUser">Pilih Penghuni <span>*</span></label>

                        <select name="user_id" id="bookingUser" class="form-control" required>
                            <option value="">-- Pilih akun penghuni --</option>

                            @foreach($penghunis as $penghuni)
                                <option
                                    value="{{ $penghuni->id }}"
                                    data-email="{{ $penghuni->email }}"
                                    data-phone="{{ $penghuni->phone }}"
                                    @selected(old('user_id') == $penghuni->id)
                                >
                                    {{ $penghuni->name }} - {{ $penghuni->email }}
                                </option>
                            @endforeach
                        </select>

                        <div class="form-hint">
                            Pilih akun penghuni yang sudah terdaftar di KosHaven.
                        </div>

                        @error('user_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Penghuni</label>
                            <input type="email"
                                   id="bookingEmail"
                                   class="form-control"
                                   readonly
                                   placeholder="Email penghuni">
                        </div>

                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="text"
                                   id="bookingPhone"
                                   class="form-control"
                                   readonly
                                   placeholder="Nomor telepon">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bookingRoom">Pilih Kamar <span>*</span></label>

                        <select name="kamar_id" id="bookingRoom" class="form-control" required>
                            <option value="">-- Pilih kamar --</option>

                            @foreach($kamars as $kamar)
                                @php
                                    $bookingPending = \App\Models\Booking::where('kamar_id', $kamar->id)
                                        ->where('status', 'menunggu')
                                        ->count();

                                    $sisaKapasitas = $kamar->kapasitas
                                        - $kamar->jumlah_penghuni
                                        - $bookingPending;

                                    $kamarTersedia = $kamar->status !== 'maintenance'
                                        && $sisaKapasitas > 0;
                                @endphp

                                <option
                                    value="{{ $kamar->id }}"
                                    data-capacity="{{ $kamar->kapasitas }}"
                                    data-occupied="{{ $kamar->jumlah_penghuni }}"
                                    data-pending="{{ $bookingPending }}"
                                    @disabled(!$kamarTersedia)
                                    @selected(old('kamar_id') == $kamar->id)
                                >
                                    {{ $kamar->nomor_kamar }}
                                    - {{ ucfirst($kamar->tipe) }}
                                    - Rp{{ number_format($kamar->harga, 0, ',', '.') }}

                                    @if(!$kamarTersedia)
                                        (Tidak tersedia)
                                    @else
                                        (Sisa {{ $sisaKapasitas }} tempat)
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <div class="form-hint">
                            Kamar penuh dan kamar maintenance tidak dapat dipilih.
                        </div>

                        @error('kamar_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bookingDate">Tanggal Booking <span>*</span></label>
                            <input
                                type="date"
                                name="tanggal_booking"
                                id="bookingDate"
                                class="form-control"
                                value="{{ old('tanggal_booking', now()->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required
                            >

                            @error('tanggal_booking')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bookingMoveDate">Tanggal Masuk <span>*</span></label>
                            <input
                                type="date"
                                name="tanggal_masuk"
                                id="bookingMoveDate"
                                class="form-control"
                                value="{{ old('tanggal_masuk') }}"
                                min="{{ old('tanggal_booking', now()->format('Y-m-d')) }}"
                                required
                            >

                            @error('tanggal_masuk')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bookingNote">Catatan Tambahan</label>
                        <textarea
                            name="catatan"
                            id="bookingNote"
                            class="form-control"
                            maxlength="500"
                            placeholder="Masukkan catatan jika diperlukan..."
                        >{{ old('catatan') }}</textarea>

                        <div class="form-hint">Maksimal 500 karakter.</div>

                        @error('catatan')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addModal')">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary" id="saveBookingButton">
                        <i class="bi bi-check-lg"></i>
                        Simpan Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DETAIL BOOKING --}}
    <div class="modal-overlay" id="detailModal" aria-hidden="true">
        <div class="modal">
            <div class="modal-header">
                <h3>Detail Booking</h3>
                <button type="button"
                        class="modal-close"
                        onclick="closeModal('detailModal')"
                        aria-label="Tutup">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="modal-body" id="bookingDetailContent">
                <div class="empty-state">
                    <i class="bi bi-hourglass-split"></i>
                    <strong>Memuat data booking...</strong>
                </div>
            </div>

            <div class="modal-footer" id="detailModalActions">
                <button type="button" class="btn btn-outline" onclick="closeModal('detailModal')">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL TOLAK BOOKING --}}
    <div class="modal-overlay" id="rejectModal" aria-hidden="true">
        <div class="modal">
            <div class="modal-header">
                <h3>Tolak Booking</h3>
                <button type="button"
                        class="modal-close"
                        onclick="closeModal('rejectModal')"
                        aria-label="Tutup">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <form method="POST" id="rejectForm">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <p id="rejectDescription"
                       style="font-size:12px;color:var(--muted);margin-bottom:17px;">
                        Masukkan alasan penolakan booking.
                    </p>

                    <div class="form-group">
                        <label for="rejectReason">Alasan Penolakan <span>*</span></label>
                        <textarea
                            name="alasan_penolakan"
                            id="rejectReason"
                            class="form-control"
                            minlength="5"
                            maxlength="1000"
                            required
                            placeholder="Tuliskan alasan penolakan minimal 5 karakter..."
                        ></textarea>

                        <div class="form-hint">
                            Minimal 5 dan maksimal 1000 karakter.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('rejectModal')">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle"></i>
                        Tolak Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast" id="toastMessage" role="status" aria-live="polite">
        <i class="bi bi-check-circle-fill" id="toastIcon"></i>
        <span id="toastText"></span>
    </div>

    <script>
        'use strict';

        const bookingRoutes = {
            show: @json(route('admin.booking.show', ['booking' => '__ID__'])),
            reject: @json(route('admin.booking.reject', ['booking' => '__ID__'])),
            approve: @json(route('admin.booking.approve', ['booking' => '__ID__']))
        };

        let toastTimer = null;
        let lastFocusedElement = null;
        let searchTimer = null;
        let detailRequestController = null;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        // UTILITAS
        function escapeHTML(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(character) {
                const entities = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };

                return entities[character];
            });
        }

        function formatDate(value) {
            if (!value) return '-';

            const date = new Date(value + 'T00:00:00');

            if (Number.isNaN(date.getTime())) return '-';

            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function getStatusClass(status) {
            const classes = {
                menunggu: 'status-menunggu',
                disetujui: 'status-disetujui',
                ditolak: 'status-ditolak',
                dibatalkan: 'status-dibatalkan',
                selesai: 'status-selesai'
            };

            return classes[String(status || '').toLowerCase()] || 'status-menunggu';
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastMessage');
            const text = document.getElementById('toastText');
            const icon = document.getElementById('toastIcon');

            if (!toast || !text || !icon) return;

            text.textContent = message;
            toast.classList.remove('success', 'error');
            toast.classList.add(type);

            icon.className = type === 'error'
                ? 'bi bi-exclamation-circle-fill'
                : 'bi bi-check-circle-fill';

            toast.classList.add('show');

            clearTimeout(toastTimer);

            toastTimer = setTimeout(function() {
                toast.classList.remove('show');
            }, 3500);
        }

        // ANIMASI ANGKA STATISTIK
        function animateBookingCounters() {
            const counters = document.querySelectorAll('[data-count-to]');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            counters.forEach(function(counter) {
                const target = Number(counter.dataset.countTo);

                if (!Number.isFinite(target) || target < 0) {
                    counter.textContent = '0';
                    return;
                }

                if (reducedMotion) {
                    counter.textContent = Math.round(target).toLocaleString('id-ID');
                    return;
                }

                const duration = 1100;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const currentValue = Math.round(target * eased);

                    counter.textContent = currentValue.toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = Math.round(target).toLocaleString('id-ID');
                    }
                }

                requestAnimationFrame(updateCounter);
            });
        }

        // FILTER DAN PENCARIAN
        const searchInput = document.getElementById('searchBooking');
        const filterStatus = document.getElementById('filterStatus');
        const filterForm = document.getElementById('filterForm');

        searchInput?.addEventListener('input', function() {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function() {
                filterForm.requestSubmit();
            }, 500);
        });

        filterStatus?.addEventListener('change', function() {
            filterForm.requestSubmit();
        });

        function resetFilters() {
            window.location.href = @json(route('admin.booking.index'));
        }

        // MODAL
        function openModal(modalId) {
            const modal = document.getElementById(modalId);

            if (!modal) return;

            lastFocusedElement = document.activeElement;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('no-scroll');

            const focusTarget = modal.querySelector(
                'input:not([readonly]):not([type="hidden"]), select, textarea, button'
            );

            if (focusTarget) {
                setTimeout(() => focusTarget.focus(), 50);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);

            if (!modal) return;

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            if (modalId === 'detailModal' && detailRequestController) {
                detailRequestController.abort();
                detailRequestController = null;
            }

            if (!document.querySelector('.modal-overlay.show')) {
                document.body.classList.remove('no-scroll');

                if (lastFocusedElement &&
                    typeof lastFocusedElement.focus === 'function') {
                    lastFocusedElement.focus();
                }
            }
        }

        document.querySelectorAll('.modal-overlay').forEach(function(modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const opened = document.querySelector('.modal-overlay.show');

                if (opened) {
                    closeModal(opened.id);
                } else {
                    closeSidebar();
                }
            }
        });

        // FORM TAMBAH BOOKING
        const bookingForm = document.getElementById('bookingForm');
        const bookingUser = document.getElementById('bookingUser');
        const bookingDateInput = document.getElementById('bookingDate');
        const bookingMoveDate = document.getElementById('bookingMoveDate');

        function updateTenantInformation() {
            const selected = bookingUser.options[bookingUser.selectedIndex];

            document.getElementById('bookingEmail').value =
                selected?.dataset.email || '';

            document.getElementById('bookingPhone').value =
                selected?.dataset.phone || '';
        }

        bookingUser.addEventListener('change', updateTenantInformation);

        function getLocalDateString() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        function openAddModal() {
            bookingForm.reset();
            updateTenantInformation();

            const today = getLocalDateString();

            bookingDateInput.value = today;
            bookingDateInput.max = today;
            bookingMoveDate.min = today;

            document.getElementById('saveBookingButton').disabled = false;
            document.getElementById('saveBookingButton').innerHTML =
                '<i class="bi bi-check-lg"></i> Simpan Booking';

            openModal('addModal');
        }

        bookingDateInput.addEventListener('change', function() {
            bookingMoveDate.min = this.value;

            if (bookingMoveDate.value && bookingMoveDate.value < this.value) {
                bookingMoveDate.value = this.value;
            }
        });

        bookingForm.addEventListener('submit', function(event) {
            const submitButton = document.getElementById('saveBookingButton');

            if (!bookingForm.checkValidity()) {
                event.preventDefault();
                bookingForm.reportValidity();
                return;
            }

            const selectedRoom = document.getElementById('bookingRoom');
            const bookingDate = bookingDateInput.value;
            const moveDate = bookingMoveDate.value;
            const today = getLocalDateString();

            if (!bookingUser.value) {
                event.preventDefault();
                showToast('Silakan pilih penghuni terlebih dahulu.', 'error');
                bookingUser.focus();
                return;
            }

            if (!selectedRoom.value || selectedRoom.selectedOptions[0]?.disabled) {
                event.preventDefault();
                showToast('Silakan pilih kamar yang masih tersedia.', 'error');
                selectedRoom.focus();
                return;
            }

            if (bookingDate > today) {
                event.preventDefault();
                showToast('Tanggal booking tidak boleh di masa depan.', 'error');
                bookingDateInput.focus();
                return;
            }

            if (moveDate < bookingDate) {
                event.preventDefault();
                showToast('Tanggal masuk tidak boleh sebelum tanggal booking.', 'error');
                bookingMoveDate.focus();
                return;
            }

            if (submitButton.disabled) {
                event.preventDefault();
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML =
                '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        });

        // DETAIL BOOKING
        async function showDetail(id) {
            const content = document.getElementById('bookingDetailContent');
            const actions = document.getElementById('detailModalActions');

            if (detailRequestController) {
                detailRequestController.abort();
            }

            detailRequestController = new AbortController();

            content.innerHTML = `
                <div class="empty-state">
                    <i class="bi bi-hourglass-split"></i>
                    <strong>Memuat data booking...</strong>
                </div>
            `;

            actions.innerHTML = `
                <button type="button" class="btn btn-outline"
                    onclick="closeModal('detailModal')">Tutup</button>
            `;

            openModal('detailModal');

            try {
                const url = bookingRoutes.show.replace(
                    '__ID__',
                    encodeURIComponent(id)
                );

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: detailRequestController.signal
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil detail booking.');
                }

                const result = await response.json();

                if (!result.success || !result.data) {
                    throw new Error('Data booking tidak ditemukan.');
                }

                const item = result.data;
                const status = String(item.status || '').toLowerCase();

                content.innerHTML = `
                    <div class="detail-section-title">Informasi Booking</div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>ID Booking</small>
                            <strong>#${escapeHTML(item.id)}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Status Booking</small>
                            <span class="status ${getStatusClass(status)}">
                                ${escapeHTML(status.charAt(0).toUpperCase() + status.slice(1))}
                            </span>
                        </div>

                        <div class="detail-item">
                            <small>Tanggal Booking</small>
                            <strong>${formatDate(item.tanggal_booking)}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Rencana Tanggal Masuk</small>
                            <strong>${formatDate(item.tanggal_masuk)}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Tanggal Keluar</small>
                            <strong>${formatDate(item.tanggal_keluar)}</strong>
                        </div>
                    </div>

                    <div class="detail-section-title">Informasi Penghuni</div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>Nama Lengkap</small>
                            <strong>${escapeHTML(item.nama_penghuni || '-')}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Email</small>
                            <strong>${escapeHTML(item.email || '-')}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Nomor Telepon</small>
                            <strong>${escapeHTML(item.telepon || '-')}</strong>
                        </div>
                    </div>

                    <div class="detail-section-title">Informasi Kamar</div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>Nomor Kamar</small>
                            <strong>${escapeHTML(item.nomor_kamar || '-')}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Tipe Kamar</small>
                            <strong>${escapeHTML(item.tipe_kamar || '-')}</strong>
                        </div>

                        <div class="detail-item">
                            <small>Harga Kamar</small>
                            <strong>${item.harga_kamar !== null && item.harga_kamar !== undefined
                                ? 'Rp' + Number(item.harga_kamar).toLocaleString('id-ID')
                                : '-'}</strong>
                        </div>
                    </div>

                    <div class="detail-section-title">Catatan</div>

                    <div class="detail-note">
                        ${escapeHTML(item.catatan || 'Tidak ada catatan tambahan.')}
                    </div>

                    ${item.alasan_penolakan ? `
                        <div class="detail-section-title">Alasan Penolakan</div>
                        <div class="detail-note">${escapeHTML(item.alasan_penolakan)}</div>
                    ` : ''}
                `;

                if (status === 'menunggu') {
                    const approveUrl = bookingRoutes.approve.replace(
                        '__ID__',
                        encodeURIComponent(item.id)
                    );

                    actions.innerHTML = `
                        <button type="button" class="btn btn-outline"
                            onclick="closeModal('detailModal')">Tutup</button>

                        <button type="button"
                            class="btn btn-danger"
                            id="detailRejectButton">
                            Tolak
                        </button>

                        <form action="${escapeHTML(approveUrl)}"
                              method="POST"
                              onsubmit="return confirm('Setujui booking ini?')">
                            <input type="hidden" name="_token" value="${escapeHTML(csrfToken)}">
                            <input type="hidden" name="_method" value="PATCH">

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i>
                                Setujui Booking
                            </button>
                        </form>
                    `;

                    // Event listener terpisah agar nama penghuni tidak disisipkan
                    // langsung ke dalam atribut onclick.
                    document.getElementById('detailRejectButton')
                        .addEventListener('click', function() {
                            const tenantName = String(item.nama_penghuni || 'Penghuni');
                            closeModal('detailModal');
                            openRejectModal(item.id, tenantName);
                        });
                } else {
                    actions.innerHTML = `
                        <button type="button" class="btn btn-outline"
                            onclick="closeModal('detailModal')">Tutup</button>
                    `;
                }

            } catch (error) {
                if (error.name === 'AbortError') return;

                console.error(error);

                content.innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Gagal memuat detail booking</strong>
                        <p>Silakan coba kembali.</p>
                    </div>
                `;

                showToast('Gagal mengambil detail booking.', 'error');
            }
        }

        // TOLAK BOOKING
        function openRejectModal(id, name) {
            const form = document.getElementById('rejectForm');

            form.action = bookingRoutes.reject.replace(
                '__ID__',
                encodeURIComponent(id)
            );

            document.getElementById('rejectDescription').textContent =
                'Masukkan alasan penolakan untuk booking atas nama ' + String(name || 'Penghuni') + '.';

            document.getElementById('rejectReason').value = '';

            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="bi bi-x-circle"></i> Tolak Booking';

            openModal('rejectModal');
        }

        document.getElementById('rejectForm').addEventListener('submit', function(event) {
            const reasonField = document.getElementById('rejectReason');
            const reason = reasonField.value.trim();

            if (reason.length < 5 || reason.length > 1000) {
                event.preventDefault();
                showToast('Alasan penolakan harus 5–1000 karakter.', 'error');
                reasonField.focus();
                return;
            }

            const submitButton = this.querySelector('button[type="submit"]');

            if (submitButton.disabled) {
                event.preventDefault();
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML =
                '<i class="bi bi-hourglass-split"></i> Memproses...';
        });

        // SIDEBAR MOBILE
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');

            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('show');

            document.getElementById('mobileMenuButton')
                .setAttribute('aria-expanded', 'true');

            document.body.classList.add('no-scroll');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menuButton = document.getElementById('mobileMenuButton');

            if (sidebar) sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('show');

            if (menuButton) {
                menuButton.setAttribute('aria-expanded', 'false');
            }

            if (!document.querySelector('.modal-overlay.show')) {
                document.body.classList.remove('no-scroll');
            }
        }

        document.querySelectorAll('.sidebar .menu-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // TANGGAL HEADER
        function updateDate() {
            const element = document.getElementById('currentDate');

            if (!element) return;

            element.textContent = new Date().toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        // NOTIFIKASI LARAVEL
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @elseif(session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        // INISIALISASI
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            updateTenantInformation();
            animateBookingCounters();

            @if($errors->any())
                openModal('addModal');
            @endif
        });
    </script>

</body>
</html>
