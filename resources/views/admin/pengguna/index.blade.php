
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manajemen Pengguna - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-hover: #303842;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --ivory: #F4F0E8;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(188, 198, 207, .13);
            --green: #91AE9B;
            --green-bg: rgba(112, 158, 126, .13);
            --yellow: #D9B77F;
            --yellow-bg: rgba(217, 183, 127, .13);
            --blue: #9CB8D8;
            --blue-bg: rgba(121, 157, 198, .14);
            --red: #D58F8F;
            --red-bg: rgba(213, 143, 143, .13);
            --shadow: 0 15px 40px rgba(0, 0, 0, .17);
            --radius: 14px;
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

        body, button, input, select {
            font-family: 'DM Sans', sans-serif;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 255px;
            height: 100vh;
            height: 100dvh;
            background: var(--bg-deep);
            color: var(--text);
            padding: 27px 18px 20px;
            display: flex;
            flex-direction: column;
            z-index: 1000;

            /* Navigasi sidebar dapat di-scroll */
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(198, 164, 119, .35) transparent;

            border-right: 1px solid var(--border);
            transition: transform .2s ease-out;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(198, 164, 119, .35);
            border-radius: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 25px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: linear-gradient(145deg, var(--gold-light), var(--gold));
            display: grid;
            place-items: center;
            color: var(--bg-deep);
            font-size: 21px;
            flex-shrink: 0;
            box-shadow: 0 5px 18px rgba(198, 164, 119, .16);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 700;
            color: var(--ivory);
        }

        .brand-subtitle {
            font-size: 10px;
            letter-spacing: 2px;
            color: var(--gold);
            margin-top: 2px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.6px;
            color: var(--muted-dark);
            padding: 23px 12px 10px;
            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-shrink: 0;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border-radius: 9px;
            color: var(--muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: background .16s ease, color .16s ease;
            flex-shrink: 0;
        }

        .nav-menu a i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, .055);
            color: var(--ivory);
        }

        .nav-menu a.active {
            background: rgba(198, 164, 119, .12);
            color: var(--gold-light);
            border-left: 3px solid var(--gold);
            padding-left: 11px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
            flex-shrink: 0;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 15px 10px;
            margin-bottom: 12px;
            border-top: 1px solid var(--border);
        }

        .sidebar-profile-avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, var(--gold-light), var(--gold));
            color: var(--bg-deep);
            font-size: 14px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .sidebar-profile-name {
            color: var(--ivory);
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .sidebar-profile-role {
            color: var(--muted-dark);
            font-size: 10px;
            margin-top: 3px;
        }

        /* LOGOUT MODAL - SIDEBAR MANAJEMEN PENGGUNA */
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
            border: 1px solid transparent;
            border-radius: 9px;
            background: rgba(213, 143, 143, .08);
            color: #E2B2B2;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            cursor: pointer;
            transition: background .16s ease, border-color .16s ease;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            background: rgba(213, 143, 143, .15);
            border-color: rgba(213, 143, 143, .2);
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 17px;
            flex-shrink: 0;
        }

        /* MAIN */
        .main {
            margin-left: 255px;
            min-height: 100vh;
            padding: 28px 35px 45px;
            width: calc(100% - 255px);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 34px;
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
            color: var(--gold-light);
            width: 40px;
            height: 40px;
            border-radius: 9px;
            cursor: pointer;
            font-size: 20px;
            flex-shrink: 0;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted-dark);
            margin-bottom: 5px;
        }

        .breadcrumb span {
            color: var(--gold);
            margin: 0 5px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            color: var(--ivory);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -.3px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 11px;
            flex-shrink: 0;
        }

        .admin-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--surface-light);
            border: 1px solid rgba(198, 164, 119, .35);
            color: var(--gold-light);
            display: grid;
            place-items: center;
            font-weight: 800;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--ivory);
        }

        .admin-role {
            color: var(--muted-dark);
            font-size: 11px;
            margin-top: 3px;
        }

        /* WELCOME */
        .welcome {
            margin-bottom: 25px;
            padding: 25px 27px;
            border: 1px solid rgba(198, 164, 119, .2);
            border-radius: var(--radius);
            background:
                radial-gradient(ellipse at 95% 0%, rgba(198, 164, 119, .13), transparent 42%),
                linear-gradient(115deg, #252C33, #20262D);
            position: relative;
            overflow: hidden;
        }

        .welcome::after {
            content: '';
            position: absolute;
            right: 35px;
            top: -45px;
            width: 150px;
            height: 150px;
            border: 1px solid rgba(198, 164, 119, .12);
            border-radius: 50%;
            box-shadow: 0 0 0 18px rgba(198, 164, 119, .025),
                        0 0 0 38px rgba(198, 164, 119, .02);
            pointer-events: none;
        }

        .welcome h2 {
            font-family: 'Playfair Display', serif;
            color: var(--ivory);
            font-size: 23px;
            margin-bottom: 7px;
            position: relative;
            z-index: 1;
        }

        .welcome p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
            max-width: 650px;
            position: relative;
            z-index: 1;
        }

        /* ALERT */
        .alert {
            padding: 14px 17px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert-success {
            background: var(--green-bg);
            border: 1px solid rgba(145, 174, 155, .25);
            color: #B9D5C2;
        }

        .alert-danger {
            background: var(--red-bg);
            border: 1px solid rgba(213, 143, 143, .25);
            color: #E8B3B3;
        }

        .alert ul {
            padding-left: 18px;
            margin-top: 5px;
        }

        /* STATISTIK */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: linear-gradient(145deg, #292F37, #232930);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 20px;
            box-shadow: var(--shadow);
            min-width: 0;
            transition: border-color .16s ease;
        }

        .stat-card:hover {
            border-color: rgba(198, 164, 119, .3);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 17px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
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

        .stat-icon.green {
            background: var(--green-bg);
            color: var(--green);
        }

        .stat-icon.gold {
            background: var(--yellow-bg);
            color: var(--gold-light);
        }

        .stat-number {
            color: var(--ivory);
            font-size: 28px;
            font-weight: 800;
            overflow-wrap: anywhere;
            letter-spacing: -.5px;
        }

        .stat-description {
            color: var(--muted-dark);
            font-size: 11px;
            margin-top: 5px;
        }

        /* KONTEN */
        .content-card {
            background: #242A31;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            min-width: 0;
        }

        .card-heading {
            padding: 22px 23px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .card-heading h3 {
            color: var(--ivory);
            font-size: 16px;
            font-weight: 800;
        }

        .card-heading p {
            font-size: 11px;
            color: var(--muted-dark);
            margin-top: 5px;
        }

        .btn-primary {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid rgba(224, 196, 155, .25);
            border-radius: 8px;
            background: linear-gradient(135deg, #D7B88D, #B99160);
            color: #191D22;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: filter .16s ease, box-shadow .16s ease;
            white-space: nowrap;
        }

        .btn-primary:hover {
            box-shadow: 0 5px 14px rgba(198, 164, 119, .17);
            filter: brightness(1.06);
        }

        .btn-primary:disabled {
            cursor: not-allowed;
            opacity: .6;
            box-shadow: none;
        }

        .toolbar {
            display: flex;
            gap: 12px;
            padding: 18px 23px;
            flex-wrap: wrap;
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
            color: var(--muted-dark);
        }

        .search-box input {
            width: 100%;
            height: 42px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 13px 0 38px;
            outline: none;
            font-size: 12px;
            color: var(--text);
            background: #1D2329;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .search-box input::placeholder,
        .form-group input::placeholder {
            color: #737E88;
        }

        .search-box input:focus,
        .toolbar select:focus,
        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198, 164, 119, .11);
        }

        .toolbar select {
            height: 42px;
            min-width: 150px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            background: #1D2329;
            outline: none;
            font-size: 12px;
        }

        .toolbar select option,
        .form-group select option {
            background: #242A31;
            color: var(--text);
        }

        .btn-filter {
            min-height: 42px;
            border: 1px solid var(--border);
            background: #303740;
            border-radius: 8px;
            padding: 0 15px;
            color: var(--silver-light);
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            text-decoration: none;
            transition: background .16s ease, border-color .16s ease, color .16s ease;
        }

        .btn-filter:hover {
            background: #39424C;
            border-color: rgba(198, 164, 119, .3);
            color: var(--gold-light);
        }

        /* TABEL */
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        thead {
            background: #1E242B;
        }

        th {
            color: var(--silver);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .7px;
            text-align: left;
            padding: 15px 17px;
            white-space: nowrap;
        }

        td {
            padding: 15px 17px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            vertical-align: middle;
            color: #D5D9DC;
        }

        tbody tr {
            transition: background .14s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, .025);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 180px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(198, 164, 119, .13);
            border: 1px solid rgba(198, 164, 119, .2);
            color: var(--gold-light);
            font-weight: 800;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 700;
            color: var(--ivory);
        }

        .user-email {
            color: var(--muted-dark);
            font-size: 10px;
            margin-top: 4px;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .role-admin {
            background: var(--yellow-bg);
            color: var(--gold-light);
            border: 1px solid rgba(217, 183, 127, .2);
        }

        .role-petugas {
            background: var(--blue-bg);
            color: var(--blue);
            border: 1px solid rgba(156, 184, 216, .2);
        }

        .role-penghuni {
            background: var(--green-bg);
            color: #A8CCB3;
            border: 1px solid rgba(145, 174, 155, .2);
        }

        .action-group {
            display: flex;
            gap: 7px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: 1px solid transparent;
            border-radius: 7px;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: 14px;
            transition: background .15s ease, border-color .15s ease;
        }

        .edit-btn {
            background: var(--blue-bg);
            color: var(--blue);
            border-color: rgba(156, 184, 216, .12);
        }

        .edit-btn:hover {
            background: rgba(121, 157, 198, .24);
        }

        .delete-btn {
            background: var(--red-bg);
            color: var(--red);
            border-color: rgba(213, 143, 143, .12);
        }

        .delete-btn:hover {
            background: rgba(213, 143, 143, .23);
        }

        .empty-state {
            padding: 48px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state i {
            display: block;
            font-size: 38px;
            margin-bottom: 13px;
            color: var(--silver);
        }

        .empty-state strong {
            color: var(--ivory);
        }

        .pagination-wrap {
            padding: 17px 23px;
            border-top: 1px solid var(--border);
            overflow-x: auto;
        }

        .pagination-wrap nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination-wrap p {
            color: var(--muted-dark);
            font-size: 11px;
        }

        .pagination-wrap nav > div:last-child {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination-wrap a,
        .pagination-wrap span[aria-current="page"] span,
        .pagination-wrap span[aria-disabled="true"] span {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--silver-light);
            text-decoration: none;
            font-size: 11px;
            background: #2D343D;
        }

        .pagination-wrap a:hover {
            border-color: var(--gold);
            color: var(--gold-light);
        }

        .pagination-wrap span[aria-current="page"] span {
            background: var(--gold);
            color: var(--bg-deep);
            border-color: var(--gold);
        }

        .pagination-wrap span[aria-disabled="true"] span {
            color: #65717C;
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(5, 8, 12, .76);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            overflow-y: auto;
        }

        .modal-overlay.show {
            display: flex;
            animation: overlayIn .16s ease-out;
        }

        @keyframes overlayIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            background: #252C33;
            width: 100%;
            max-width: 510px;
            border: 1px solid rgba(198, 164, 119, .2);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, .4);
            margin: auto;
            max-height: calc(100vh - 36px);
            max-height: calc(100dvh - 36px);
            overflow-y: auto;
            animation: modalIn .17s ease-out;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 20px 23px;
            background: linear-gradient(110deg, #303842, #242A31);
            border-bottom: 1px solid var(--border);
            color: var(--ivory);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
        }

        .modal-close {
            width: 33px;
            height: 33px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: rgba(255,255,255,.04);
            color: var(--silver-light);
            font-size: 17px;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: background .15s ease, color .15s ease;
        }

        .modal-close:hover {
            background: var(--red-bg);
            color: var(--red);
        }

        .modal-body {
            padding: 23px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            margin-bottom: 16px;
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--silver-light);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 43px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 12px;
            outline: none;
            font-size: 12px;
            color: var(--text);
            background: #1C2228;
            min-width: 0;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .form-help {
            color: var(--muted-dark);
            font-size: 10px;
            margin-top: 7px;
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding-top: 8px;
            flex-wrap: wrap;
        }

        .btn-cancel {
            border: 1px solid var(--border);
            background: #303740;
            color: var(--silver-light);
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            transition: background .15s ease;
        }

        .btn-cancel:hover {
            background: #3A424C;
        }

        .overlay-backdrop {
            display: none;
        }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .main {
                padding: 25px 22px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 15px 0 40px rgba(0,0,0,.3);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .overlay-backdrop.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.62);
                z-index: 900;
                backdrop-filter: blur(2px);
            }

            .main {
                margin-left: 0;
                padding: 22px 18px 35px;
                width: 100%;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 17px 13px 30px;
            }

            .topbar {
                margin-bottom: 23px;
            }

            .topbar-left {
                gap: 10px;
            }

            .page-title {
                font-size: 22px;
            }

            .breadcrumb {
                font-size: 10px;
            }

            .admin-info > div:last-child {
                display: none;
            }

            .welcome {
                padding: 20px;
                margin-bottom: 18px;
            }

            .welcome h2 {
                font-size: 20px;
            }

            .welcome p {
                font-size: 12px;
            }

            .stats {
                gap: 10px;
                margin-bottom: 18px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 24px;
            }

            .card-heading {
                align-items: flex-start;
                padding: 17px;
            }

            .card-heading h3 {
                font-size: 14px;
            }

            .card-heading p {
                max-width: 230px;
                line-height: 1.5;
            }

            .card-heading .btn-primary {
                padding: 10px;
                font-size: 0;
                min-width: 39px;
                min-height: 39px;
            }

            .card-heading .btn-primary i {
                font-size: 15px;
            }

            .toolbar {
                padding: 14px 16px;
                gap: 9px;
            }

            .search-box {
                flex-basis: 100%;
                min-width: 100%;
            }

            .toolbar select {
                flex: 1;
                min-width: 0;
            }

            .btn-filter {
                padding: 0 11px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-group.full {
                grid-column: auto;
            }

            .modal-body {
                padding: 18px;
            }

            .modal-header {
                padding: 17px 18px;
            }

            .pagination-wrap {
                padding: 15px;
            }
        }

        @media (max-width: 400px) {
            .stats {
                grid-template-columns: 1fr 1fr;
            }

            .stat-label {
                font-size: 10px;
            }

            .stat-number {
                font-size: 21px;
            }

            .stat-icon {
                width: 31px;
                height: 31px;
            }

            .admin-avatar {
                width: 36px;
                height: 36px;
            }

            .menu-toggle {
                width: 36px;
                height: 36px;
            }

            .page-title {
                font-size: 19px;
            }

            .card-heading {
                gap: 8px;
            }

            .card-heading p {
                font-size: 10px;
            }

            .welcome::after {
                right: -65px;
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

@php
    $admin = auth()->user();

    $roleLabels = [
        'admin' => 'Admin',
        'petugas' => 'Petugas',
        'penghuni' => 'Penghuni',
    ];
@endphp

<!-- SIDEBAR -->
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
        <a href="{{ route('admin.dashboard') }}" data-page-transition>
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.pengguna.index') }}" class="active">
            <i class="bi bi-person-gear"></i>
            Manajemen Pengguna
        </a>

        <a href="{{ route('admin.kamar.index') }}" data-page-transition>
            <i class="bi bi-door-open"></i>
            Data Kamar
        </a>

        <a href="{{ route('admin.booking.index') }}" data-page-transition>
            <i class="bi bi-journal-check"></i>
            Booking Kos
        </a>

        <a href="{{ route('admin.penghuni.index') }}" data-page-transition>
            <i class="bi bi-people"></i>
            Data Penghuni
        </a>

        <a href="{{ route('admin.petugas.index') }}" data-page-transition>
            <i class="bi bi-person-badge"></i>
            Data Petugas
        </a>
    </nav>

    <div class="nav-label">KEUANGAN</div>

    <nav class="nav-menu">
        <a href="{{ route('admin.tagihan.index') }}" data-page-transition>
            <i class="bi bi-receipt"></i>
            Tagihan Bulanan
        </a>

        <a href="{{ route('admin.pembayaran.index') }}" data-page-transition>
            <i class="bi bi-wallet2"></i>
            Pembayaran
        </a>

        <a href="{{ route('admin.laporan.index') }}" data-page-transition>
            <i class="bi bi-file-earmark-bar-graph"></i>
            Laporan
        </a>
    </nav>

    <div class="nav-label">PENGATURAN</div>

    <nav class="nav-menu">
        <a href="{{ route('admin.profil.index') }}" data-page-transition>
            <i class="bi bi-person-circle"></i>
            Profil Admin
        </a>
    </nav>

    <div class="sidebar-bottom">

        <div class="sidebar-profile">
            <div class="sidebar-profile-avatar">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-profile-name">{{ $admin->name ?? 'Administrator' }}</div>
                <div class="sidebar-profile-role">Admin KosHaven</div>
            </div>
        </div>

        <div class="kh-logout-component-wrapper">
            @include('components.logout-modal')
        </div>

    </div>
</aside>

<div class="overlay-backdrop" id="sidebarBackdrop"></div>

<!-- MAIN CONTENT -->
<main class="main" data-page-enter>

    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" type="button"
                    aria-label="Buka navigasi"
                    aria-expanded="false"
                    aria-controls="sidebar">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <div class="breadcrumb">Admin <span>/</span> Manajemen Pengguna</div>
                <h1 class="page-title">Manajemen Pengguna</h1>
            </div>
        </div>

        <div class="admin-info">
            <div class="admin-avatar">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="admin-name">{{ $admin->name ?? 'Administrator' }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
    </header>

    <section class="welcome" data-scroll-reveal>
        <h2>Kelola Akun Pengguna</h2>
        <p>
            Kelola akun Admin, Petugas, dan Penghuni yang terdaftar
            dalam sistem manajemen KosHaven.
        </p>
    </section>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Data belum dapat disimpan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- STATISTIK -->
    <section class="stats" data-scroll-reveal>

        <div class="stat-card" data-motion-card>
            <div class="stat-top">
                <span class="stat-label">Total Akun</span>
                <span class="stat-icon green">
                    <i class="bi bi-people-fill"></i>
                </span>
            </div>
            <div class="stat-number">{{ number_format($ringkasan['total']) }}</div>
            <div class="stat-description">Seluruh akun terdaftar</div>
        </div>

        <div class="stat-card" data-motion-card>
            <div class="stat-top">
                <span class="stat-label">Administrator</span>
                <span class="stat-icon gold">
                    <i class="bi bi-shield-lock-fill"></i>
                </span>
            </div>
            <div class="stat-number">{{ number_format($ringkasan['admin']) }}</div>
            <div class="stat-description">Akun dengan role Admin</div>
        </div>

        <div class="stat-card" data-motion-card>
            <div class="stat-top">
                <span class="stat-label">Petugas</span>
                <span class="stat-icon green">
                    <i class="bi bi-person-badge-fill"></i>
                </span>
            </div>
            <div class="stat-number">{{ number_format($ringkasan['petugas']) }}</div>
            <div class="stat-description">Akun dengan role Petugas</div>
        </div>

        <div class="stat-card" data-motion-card>
            <div class="stat-top">
                <span class="stat-label">Penghuni</span>
                <span class="stat-icon gold">
                    <i class="bi bi-house-check-fill"></i>
                </span>
            </div>
            <div class="stat-number">{{ number_format($ringkasan['penghuni']) }}</div>
            <div class="stat-description">Akun dengan role Penghuni</div>
        </div>

    </section>

    <!-- DAFTAR PENGGUNA -->
    <section class="content-card" data-scroll-reveal>

        <div class="card-heading">
            <div>
                <h3>Daftar Akun Pengguna</h3>
                <p>Data akun yang tersimpan di database KosHaven.</p>
            </div>

            <button type="button" class="btn-primary" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i>
                Tambah Pengguna
            </button>
        </div>

        <!-- SEARCH DAN FILTER -->
        <form action="{{ route('admin.pengguna.index') }}" method="GET" class="toolbar">

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, email, atau nomor HP..."
                    aria-label="Cari pengguna"
                >
            </div>

            <select name="role" aria-label="Filter role">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="penghuni" {{ request('role') === 'penghuni' ? 'selected' : '' }}>Penghuni</option>
            </select>

            <button type="submit" class="btn-filter">
                <i class="bi bi-funnel"></i>
                Filter
            </button>

            @if(request()->filled('search') || request()->filled('role'))
                <a href="{{ route('admin.pengguna.index') }}" class="btn-filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>
            @endif

        </form>

        <!-- TABEL PENGGUNA -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>NAMA PENGGUNA</th>
                        <th>EMAIL</th>
                        <th>NOMOR HP</th>
                        <th>ROLE</th>
                        <th>TERDAFTAR</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengguna as $index => $user)
                        <tr>
                            <td>{{ $pengguna->firstItem() + $index }}</td>

                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">ID Akun: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>{{ $user->phone ?: '-' }}</td>

                            <td>
                                <span class="role-badge role-{{ $user->role }}">
                                    {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                </span>
                            </td>

                            <td>
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                            </td>

                            <td>
                                <div class="action-group">

                                    <button
                                        type="button"
                                        class="action-btn edit-btn"
                                        title="Edit akun"
                                        aria-label="Edit akun {{ $user->name }}"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}"
                                        data-role="{{ $user->role }}"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form
                                        action="{{ route('admin.pengguna.destroy', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus akun ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                            title="Hapus akun"
                                            aria-label="Hapus akun {{ $user->name }}"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-person-x"></i>
                                    <strong>Data pengguna tidak ditemukan</strong>
                                    <p style="margin-top:6px;font-size:11px;">
                                        Coba ubah kata kunci pencarian atau filter role.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if($pengguna->hasPages())
            <div class="pagination-wrap">
                {{ $pengguna->links() }}
            </div>
        @endif

    </section>

</main>

<!-- MODAL TAMBAH / EDIT PENGGUNA -->
<div class="modal-overlay" id="userModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="modal-header">
            <h3 id="modalTitle">Tambah Pengguna</h3>

            <button type="button" class="modal-close"
                    onclick="closeModal()" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="userForm" action="{{ route('admin.pengguna.store') }}" method="POST">
            @csrf

            <div id="methodField"></div>

            <input type="hidden" name="user_id" id="editUserId" value="{{ old('user_id') }}">

            <div class="modal-body">

                <div class="form-group">
                    <label for="name">Nama Lengkap *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        minlength="3"
                        maxlength="100"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email *</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        maxlength="255"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-grid">

                    <div class="form-group">
                        <label for="phone">Nomor HP</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            maxlength="20"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                            inputmode="tel"
                        >
                    </div>

                    <div class="form-group">
                        <label for="role">Role Pengguna *</label>
                        <select name="role" id="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="penghuni" {{ old('role') === 'penghuni' ? 'selected' : '' }}>Penghuni</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label for="password">
                        Password <span id="passwordRequired">*</span>
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        maxlength="72"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                    >

                    <div class="form-help" id="passwordHelp">
                        Password wajib diisi untuk akun baru.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary" id="submitButton">
                        <i class="bi bi-check-lg"></i>
                        Simpan Pengguna
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const methodField = document.getElementById('methodField');
    const editUserId = document.getElementById('editUserId');

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const roleInput = document.getElementById('role');
    const passwordInput = document.getElementById('password');

    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById('submitButton');
    const passwordRequired = document.getElementById('passwordRequired');
    const passwordHelp = document.getElementById('passwordHelp');

    const storeUrl = @json(route('admin.pengguna.store'));
    const penggunaBaseUrl = @json(url('/admin/pengguna'));

    function openAddModal() {
        userForm.reset();

        userForm.action = storeUrl;
        methodField.innerHTML = '';
        editUserId.value = '';

        modalTitle.textContent = 'Tambah Pengguna';
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Simpan Pengguna';

        passwordInput.required = true;
        passwordInput.value = '';
        passwordRequired.style.display = 'inline';
        passwordHelp.textContent = 'Password wajib diisi untuk akun baru.';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => nameInput.focus(), 80);
    }

    function openEditModal(button) {
        const id = button.dataset.id;

        if (!id) {
            alert('ID pengguna tidak ditemukan.');
            return;
        }

        userForm.reset();

        userForm.action = penggunaBaseUrl + '/' + encodeURIComponent(id);
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        editUserId.value = id;

        nameInput.value = button.dataset.name || '';
        emailInput.value = button.dataset.email || '';
        phoneInput.value = button.dataset.phone || '';
        roleInput.value = button.dataset.role || '';

        passwordInput.value = '';
        passwordInput.required = false;

        passwordRequired.style.display = 'none';
        passwordHelp.textContent = 'Kosongkan password jika tidak ingin menggantinya.';

        modalTitle.textContent = 'Edit Pengguna';
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Simpan Perubahan';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => nameInput.focus(), 80);
    }

    function closeModal() {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Tutup modal ketika area luar modal diklik.
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Tutup modal dengan tombol Escape.
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }

        if (
            event.key === 'Escape' &&
            sidebar.classList.contains('open') &&
            window.innerWidth <= 850
        ) {
            closeSidebar();
        }
    });

    // NAVIGASI SIDEBAR RESPONSIF.
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarBackdrop.classList.add('show');
        menuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarBackdrop.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');

        if (!modal.classList.contains('show')) {
            document.body.style.overflow = '';
        }
    }

    menuToggle.addEventListener('click', function() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    sidebarBackdrop.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 850) {
                closeSidebar();
            }
        });
    });

    // Pastikan sidebar kembali normal saat layar diperbesar.
    window.addEventListener('resize', function() {
        if (window.innerWidth > 850) {
            sidebar.classList.remove('open');
            sidebarBackdrop.classList.remove('show');
            menuToggle.setAttribute('aria-expanded', 'false');

            if (!modal.classList.contains('show')) {
                document.body.style.overflow = '';
            }
        }
    });

    // Cegah pengiriman form berulang kali.
    userForm.addEventListener('submit', function(event) {
        if (!userForm.checkValidity()) {
            event.preventDefault();
            userForm.reportValidity();
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    });

    // Buka kembali modal apabila validasi server gagal.
    @if($errors->any())
        @if(old('_method') === 'PUT' && old('user_id'))
            userForm.action = penggunaBaseUrl + '/' + encodeURIComponent(@json(old('user_id')));
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            editUserId.value = @json(old('user_id'));

            modalTitle.textContent = 'Edit Pengguna';
            passwordInput.required = false;
            passwordRequired.style.display = 'none';
            passwordHelp.textContent = 'Kosongkan password jika tidak ingin menggantinya.';
            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Simpan Perubahan';
        @else
            userForm.action = storeUrl;
            methodField.innerHTML = '';
            editUserId.value = '';

            modalTitle.textContent = 'Tambah Pengguna';
            passwordInput.required = true;
            passwordRequired.style.display = 'inline';
            passwordHelp.textContent = 'Password wajib diisi untuk akun baru.';
            submitButton.innerHTML = '<i class="bi bi-check-lg"></i> Simpan Pengguna';
        @endif

        submitButton.disabled = false;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => nameInput.focus(), 80);
    @endif
</script>

@vite('resources/js/app.js')

</body>
</html>
