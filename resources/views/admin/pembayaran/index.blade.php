
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    :root {
            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-soft: #363E48;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --gold-soft: rgba(198, 164, 119, .14);
            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --ivory: #F4F0E8;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(198, 164, 119, .15);
            --border-subtle: rgba(185, 195, 205, .12);
            --border-strong: rgba(198, 164, 119, .32);
            --success: #91AE9B;
            --success-bg: rgba(145, 174, 155, .14);
            --warning: #D9B77F;
            --warning-bg: rgba(217, 183, 127, .14);
            --danger: #D58F8F;
            --danger-bg: rgba(213, 143, 143, .14);
            --shadow: 0 14px 38px rgba(0, 0, 0, .25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background:
                radial-gradient(circle at 85% 5%, rgba(198, 164, 119, .08), transparent 27%),
                radial-gradient(circle at 5% 80%, rgba(146, 157, 168, .06), transparent 30%),
                var(--bg);
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

        button, input, select, textarea {
            font-family: inherit;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        /* SIDEBAR */
        .sidebar {
            width: 255px;
            height: 100vh;
            height: 100dvh;
            background: linear-gradient(180deg, #15191E 0%, #1D232A 100%);
            border-right: 1px solid var(--border);
            color: var(--text);
            position: fixed;
            top: 0;
            left: 0;
            padding: 27px 18px 20px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            transition: transform .3s ease;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .2) transparent;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 12px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            flex-shrink: 0;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #E0C49B, #B99360);
            color: #191D22;
            border-radius: 11px;
            font-size: 19px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -.5px;
            color: var(--ivory);
        }

        .brand-name span {
            color: var(--gold-light);
        }

        .brand small {
            display: block;
            font-size: 9px;
            letter-spacing: 1.5px;
            color: var(--muted-dark);
            margin-top: 5px;
        }

        .menu-label {
            font-size: 9px;
            color: var(--muted-dark);
            letter-spacing: 1.6px;
            padding: 25px 13px 12px;
            font-weight: 800;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border-radius: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            transition: .22s ease;
            position: relative;
        }

        .menu a i {
            font-size: 17px;
            width: 19px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, .055);
            color: var(--ivory);
            transform: translateX(2px);
        }

        .menu a.active {
            background: linear-gradient(100deg, rgba(198, 164, 119, .18), rgba(198, 164, 119, .05));
            color: var(--gold-light);
            border: 1px solid rgba(198, 164, 119, .16);
        }

        .menu a.active::before {
            content: "";
            position: absolute;
            left: -1px;
            top: 9px;
            bottom: 9px;
            width: 3px;
            border-radius: 0 4px 4px 0;
            background: var(--gold);
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding-top: 16px;
            flex-shrink: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 8px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #E0C49B, #A98B62);
            color: #191D22;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
        }

        .admin-info strong {
            display: block;
            font-size: 12px;
            color: var(--ivory);
        }

        .admin-info small {
            color: var(--muted-dark);
            font-size: 10px;
        }

        .logout {
            width: 100%;
            border: 1px solid rgba(213, 143, 143, .14);
            background: rgba(213, 143, 143, .07);
            color: var(--danger);
            text-align: left;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 12px;
            border-radius: 8px;
            transition: .2s;
        }

        .logout:hover {
            background: rgba(213, 143, 143, .16);
        }

        /* MAIN */
        .main {
            margin-left: 255px;
            min-height: 100vh;
            min-width: 0;
        }

        .topbar {
            min-height: 76px;
            background: rgba(25, 29, 34, .88);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 35px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar h2 {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            color: var(--ivory);
            font-weight: 700;
        }

        .topbar p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
            font-size: 21px;
            color: var(--ivory);
            cursor: pointer;
            padding: 6px 9px;
        }

        .content {
            padding: 32px 35px;
            max-width: 1600px;
            margin: auto;
            min-width: 0;
        }

        .welcome {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 27px;
        }

        .welcome h1 {
            font-family: 'Playfair Display', serif;
            font-size: 29px;
            color: var(--ivory);
            letter-spacing: -.5px;
        }

        .welcome p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.7;
        }

        .date-label {
            padding: 11px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--muted);
            font-size: 11px;
            white-space: nowrap;
        }

        .date-label i {
            color: var(--gold);
            margin-right: 6px;
        }

        /* STATISTIK */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
            width: 100%;
            min-width: 0;
        }

        .stat-card {
            background: linear-gradient(145deg, #2B323A, #222830);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 22px;
            transition: .25s ease;
            min-width: 0;
            overflow: hidden;
            position: relative;
            box-shadow: var(--shadow);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            right: -35px;
            bottom: -55px;
            border-radius: 50%;
            background: rgba(198, 164, 119, .09);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-strong);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--gold-soft);
            color: var(--gold-light);
            border: 1px solid rgba(198, 164, 119, .2);
            border-radius: 11px;
            font-size: 19px;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: var(--success-bg);
            color: var(--success);
            border-color: rgba(145, 174, 155, .22);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: var(--warning-bg);
            color: var(--warning);
            border-color: rgba(217, 183, 127, .22);
        }

        .stat-card h3 {
            font-size: 26px;
            color: var(--ivory);
            margin-bottom: 6px;
            overflow-wrap: anywhere;
            font-weight: 800;
            letter-spacing: -.7px;
            font-variant-numeric: tabular-nums;
        }

        .stat-card:first-child h3 {
            white-space: nowrap;
            overflow-wrap: normal;
            font-size: clamp(16px, 2vw, 25px);
            letter-spacing: -.8px;
            line-height: 1.35;
            max-width: 100%;
        }

        .stat-card p {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* PANEL DAN TABEL */
        .panel {
            background: linear-gradient(145deg, #2B323A, #222830);
            border: 1px solid var(--border-subtle);
            border-radius: 15px;
            padding: 24px;
            box-shadow: var(--shadow);
            min-width: 0;
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .panel-heading h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            color: var(--ivory);
        }

        .filters {
            display: grid;
            grid-template-columns: minmax(180px, 1.5fr) minmax(145px, 1fr) minmax(140px, 1fr) auto auto;
            gap: 10px;
            margin-bottom: 21px;
            align-items: center;
        }

        .search-box {
            position: relative;
            min-width: 0;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-dark);
            font-size: 13px;
        }

        .search-box input,
        .filters select,
        .filters input[type="month"] {
            width: 100%;
            height: 43px;
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 0 12px;
            background: var(--bg-deep);
            color: var(--text);
            outline: none;
            font-size: 11px;
            min-width: 0;
            transition: .2s;
            color-scheme: dark;
        }

        .search-box input::placeholder {
            color: var(--muted-dark);
        }

        .search-box input {
            padding-left: 37px;
        }

        .search-box input:focus,
        .filters select:focus,
        .filters input[type="month"]:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198, 164, 119, .14);
        }

        .filter-button {
            height: 43px;
            padding: 0 17px;
            border: 1px solid var(--gold);
            border-radius: 8px;
            background: linear-gradient(135deg, #E0C49B, #B99360);
            color: #191D22;
            cursor: pointer;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
            transition: .2s;
        }

        .filter-button:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
        }

        .reset-filter {
            height: 43px;
            padding: 0 13px;
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            background: var(--surface-light);
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 11px;
            white-space: nowrap;
            transition: .2s;
        }

        .reset-filter:hover {
            background: var(--surface-soft);
            color: var(--ivory);
            border-color: var(--gold);
        }

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            background: rgba(18, 22, 27, .35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: rgba(185, 195, 205, .07);
            color: var(--gold-light);
            font-size: 10px;
            text-align: left;
            padding: 15px 14px;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: .3px;
        }

        td {
            padding: 15px 14px;
            border-bottom: 1px solid rgba(185, 195, 205, .08);
            font-size: 11px;
            vertical-align: middle;
            color: var(--muted);
        }

        td strong {
            color: var(--ivory);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background .18s;
        }

        tbody tr:hover {
            background: rgba(198, 164, 119, .06);
        }

        .resident-name {
            font-weight: 700;
            color: var(--ivory);
        }

        .resident-email {
            display: block;
            color: var(--muted-dark);
            font-size: 10px;
            margin-top: 4px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
            display: inline-block;
            white-space: nowrap;
            letter-spacing: .1px;
        }

        .status-paid {
            color: var(--success);
            background: var(--success-bg);
        }

        .status-waiting {
            color: var(--warning);
            background: var(--warning-bg);
        }

        .status-rejected {
            color: var(--danger);
            background: var(--danger-bg);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }

        .icon-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-subtle);
            border-radius: 7px;
            background: var(--surface-light);
            color: var(--silver-light);
            cursor: pointer;
            transition: .2s;
        }

        .icon-btn:hover {
            background: var(--gold-soft);
            border-color: var(--gold);
            color: var(--gold-light);
            transform: translateY(-1px);
        }

        .icon-btn.verify {
            color: var(--success);
        }

        .icon-btn.verify:hover {
            background: var(--success-bg);
            border-color: var(--success);
        }

        .empty-note {
            text-align: center;
            color: var(--muted-dark);
            padding: 38px 20px;
            font-size: 12px;
            line-height: 1.8;
        }

        .empty-note i {
            font-size: 25px;
            color: var(--muted-dark);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 19px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        .pagination {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .page-btn {
            min-width: 31px;
            height: 31px;
            padding: 0 8px;
            border: 1px solid var(--border-subtle);
            background: var(--surface-light);
            color: var(--text);
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            transition: .2s;
        }

        .page-btn:hover:not(.disabled):not(.active) {
            border-color: var(--gold);
            color: var(--gold-light);
        }

        .page-btn.active {
            background: var(--gold);
            border-color: var(--gold);
            color: #191D22;
            font-weight: 800;
        }

        .page-btn.disabled {
            opacity: .4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 10px;
            padding: 28px 0 5px;
        }

        /* NOTIFIKASI */
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 11px;
            line-height: 1.7;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-bg);
            border: 1px solid rgba(145, 174, 155, .25);
        }

        .alert-danger {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid rgba(213, 143, 143, .25);
        }

        .alert ul {
            padding-left: 18px;
            margin-top: 5px;
        }

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 13, 17, .75);
            backdrop-filter: blur(5px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .modal-overlay.show {
            display: flex;
            animation: modalFade .2s ease;
        }

        @keyframes modalFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(145deg, #2B323A, #222830);
            border: 1px solid var(--border-strong);
            border-radius: 15px;
            padding: 25px;
            max-height: 90vh;
            max-height: 90dvh;
            overflow-y: auto;
            box-shadow: 0 20px 65px rgba(0, 0, 0, .45);
            animation: modalUp .25s ease;
        }

        @keyframes modalUp {
            from { opacity: 0; transform: translateY(12px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            color: var(--ivory);
            font-size: 21px;
        }

        .close-modal {
            width: 34px;
            height: 34px;
            border: 1px solid var(--border-subtle);
            border-radius: 7px;
            background: var(--surface-light);
            font-size: 21px;
            line-height: 1;
            color: var(--muted);
            cursor: pointer;
            transition: .2s;
        }

        .close-modal:hover {
            color: var(--danger);
            background: var(--danger-bg);
            border-color: rgba(213, 143, 143, .3);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(185, 195, 205, .09);
            font-size: 11px;
            line-height: 1.6;
        }

        .detail-row span:first-child {
            color: var(--muted);
            flex-shrink: 0;
        }

        .detail-row strong {
            text-align: right;
            color: var(--ivory);
            overflow-wrap: anywhere;
            font-weight: 700;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 22px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 11px 16px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #E0C49B, #B99360);
            color: #191D22;
            font-weight: 800;
        }

        .btn-primary:hover {
            filter: brightness(1.06);
        }

        .btn-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(213, 143, 143, .28);
        }

        .btn-danger:hover {
            background: rgba(213, 143, 143, .22);
        }

        .btn-light {
            background: var(--surface-light);
            color: var(--muted);
            border: 1px solid var(--border-subtle);
        }

        .btn-light:hover {
            background: var(--surface-soft);
            color: var(--ivory);
        }

        .proof-link {
            color: var(--gold-light);
            text-decoration: underline;
            font-weight: 700;
        }

        .proof-link:hover {
            color: var(--ivory);
        }

        .rejection-form {
            width: 100%;
            margin-top: 16px;
            padding: 16px;
            background: var(--bg-deep);
            border: 1px solid var(--border);
            border-radius: 9px;
        }

        .rejection-form label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: var(--ivory);
            margin-bottom: 9px;
        }

        .rejection-form textarea {
            width: 100%;
            min-height: 90px;
            resize: vertical;
            padding: 11px;
            border: 1px solid var(--border-subtle);
            border-radius: 7px;
            font-size: 11px;
            color: var(--text);
            background: var(--surface);
            outline: none;
        }

        .rejection-form textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198, 164, 119, .14);
        }

        .rejection-form button {
            margin-top: 10px;
        }

        /* SIDEBAR MOBILE */
        .sidebar-overlay {
            display: none;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-deep);
        }

        ::-webkit-scrollbar-thumb {
            background: #626D78;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold);
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .content { padding: 28px 25px; }
            .topbar { padding: 12px 25px; }
            .filters { grid-template-columns: 1.3fr 1fr 1fr auto; }
            .stat-card { padding: 18px; }
            .stat-card:first-child h3 { font-size: clamp(15px, 1.8vw, 22px); }
        }

        @media (max-width: 1000px) {
            .filters { grid-template-columns: 1fr 1fr; }
            .search-box { grid-column: 1 / -1; }
            .stats { gap: 12px; }
            .stat-card { padding: 16px; }
            .stat-card:first-child h3 { font-size: clamp(14px, 2vw, 20px); }
        }

        @media (max-width: 850px) {
            .sidebar {
                width: min(285px, 85vw);
                transform: translateX(-105%);
                box-shadow: 8px 0 25px rgba(0, 0, 0, .4);
            }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .65);
                z-index: 999;
            }
            .main { margin-left: 0; }
            .menu-toggle { display: block; }
        }

        @media (max-width: 650px) {
            .stats { grid-template-columns: 1fr; gap: 12px; }
            .stat-card { padding: 18px; }
            .stat-card h3 { font-size: 22px; }
            .stat-card:first-child h3 { font-size: clamp(19px, 5vw, 23px); white-space: nowrap; }
            .table-footer { flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 550px) {
            .topbar { min-height: 68px; padding: 10px 16px; }
            .topbar h2 { font-size: 17px; }
            .topbar p { display: none; }
            .content { padding: 23px 15px; }
            .welcome { flex-direction: column; align-items: flex-start; }
            .welcome h1 { font-size: 24px; }
            .welcome p { font-size: 11px; line-height: 1.7; }
            .date-label { font-size: 10px; padding: 9px 12px; }
            .stat-card { padding: 16px; }
            .stat-card:first-child h3 { font-size: clamp(19px, 5vw, 23px); letter-spacing: -.5px; }
            .panel { padding: 16px; }
            .panel-heading h3 { font-size: 17px; }
            .filters { grid-template-columns: 1fr; }
            .search-box { grid-column: auto; }
            .filter-button, .reset-filter { width: 100%; }
            .pagination { width: 100%; }
            .modal { padding: 19px; }
            .modal-actions .btn { flex: 1; }
            .detail-row { gap: 10px; }
            .detail-row span:first-child { max-width: 42%; }
        }

        @media (max-width: 360px) {
            .content { padding-left: 12px; padding-right: 12px; }
            .stat-card:first-child h3 { font-size: 18px; letter-spacing: -.7px; }
            .panel { padding: 13px; }
            .modal { padding: 15px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
            }
        }
</style>
</head>

<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

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

    <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" data-page-transition>
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.pengguna.index') }}" data-page-transition>
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

    <div class="menu-label">KEUANGAN</div>

    <nav class="menu">
        <a href="{{ route('admin.tagihan.index') }}" data-page-transition>
            <i class="bi bi-receipt"></i>
            Tagihan Bulanan
        </a>

        <a href="{{ route('admin.pembayaran.index') }}" class="active" aria-current="page">
            <i class="bi bi-wallet2"></i>
            Pembayaran
        </a>

        <a href="{{ route('admin.laporan.index') }}" data-page-transition>
            <i class="bi bi-file-earmark-bar-graph"></i>
            Laporan
        </a>
    </nav>

    <div class="menu-label">PENGATURAN</div>

    <nav class="menu">
        <a href="{{ route('admin.profil.index') }}" data-page-transition>
            <i class="bi bi-person-circle"></i>
            Profil Admin
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="admin-info">
            <div class="admin-avatar">A</div>
            <div>
                <strong>Administrator</strong>
                <small>Admin KosHaven</small>
            </div>
        </div>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout" type="button" onclick="logoutAdmin()">
                <i class="bi bi-box-arrow-right"></i>
                Keluar
            </button>
        </form>
    </div>

</aside>

<main class="main" data-page-enter>

    <header class="topbar">
        <div class="topbar-left">

            <button
                class="menu-toggle"
                id="mobileToggle"
                type="button"
                onclick="toggleSidebar()"
                aria-label="Buka navigasi"
                aria-expanded="false"
                aria-controls="sidebar"
            >
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h2>Data Pembayaran</h2>
                <p>Pengelolaan pembayaran penghuni KosHaven</p>
            </div>

        </div>
    </header>

    <div class="content">

        <section class="welcome" data-scroll-reveal>
            <div>
                <h1>Data Pembayaran</h1>
                <p>Kelola dan verifikasi pembayaran kos dari para penghuni.</p>
            </div>

            <div class="date-label" id="currentDate">
                <i class="bi bi-calendar3"></i>
                Memuat tanggal...
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Terjadi kesalahan:</strong>
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
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <h3>Rp{{ number_format($totalDiterima ?? 0, 0, ',', '.') }}</h3>
                <p>Total Pembayaran Diterima</p>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>

                <h3>{{ number_format($jumlahTerverifikasi ?? 0, 0, ',', '.') }}</h3>
                <p>Pembayaran Terverifikasi</p>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>

                <h3>{{ number_format($jumlahMenunggu ?? 0, 0, ',', '.') }}</h3>
                <p>Menunggu Verifikasi</p>
            </div>

        </section>

        <!-- DAFTAR PEMBAYARAN -->

        <section class="panel" data-scroll-reveal>

            <div class="panel-heading">
                <h3>Daftar Pembayaran</h3>
            </div>

            <form
                class="filters"
                method="GET"
                action="{{ route('admin.pembayaran.index') }}"
            >

                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="search"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama penghuni atau kamar..."
                        autocomplete="off"
                        aria-label="Cari pembayaran"
                    >
                </div>

                <select
                    id="statusFilter"
                    name="status"
                    aria-label="Filter status pembayaran"
                >
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi" @selected(request('status') === 'menunggu_verifikasi')>
                        Menunggu Verifikasi
                    </option>
                    <option value="disetujui" @selected(request('status') === 'disetujui')>
                        Diterima
                    </option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>
                        Ditolak
                    </option>
                </select>

                <input
                    type="month"
                    id="monthFilter"
                    name="bulan"
                    value="{{ request('bulan') }}"
                    aria-label="Filter bulan pembayaran"
                >

                <button class="filter-button" type="submit">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status', 'bulan']))
                    <a
                        href="{{ route('admin.pembayaran.index') }}"
                        class="reset-filter"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filter
                    </a>
                @endif

            </form>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Penghuni</th>
                            <th>Kamar</th>
                            <th>Periode</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="paymentTable">

                        @forelse($pembayarans as $pembayaran)

                            @php
                                $namaPenghuni = $pembayaran->user?->name ?? 'Penghuni tidak ditemukan';
                                $emailPenghuni = $pembayaran->user?->email ?? '-';
                                $nomorKamar = $pembayaran->tagihan?->booking?->kamar?->nomor_kamar ?? '-';
                                $periode = $pembayaran->tagihan?->periode ?? '-';

                                $statusLabel = match($pembayaran->status) {
                                    'disetujui' => 'Diterima',
                                    'ditolak' => 'Ditolak',
                                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                    default => 'Tidak diketahui',
                                };

                                $statusClass = match($pembayaran->status) {
                                    'disetujui' => 'status-paid',
                                    'ditolak' => 'status-rejected',
                                    default => 'status-waiting',
                                };

                                $metodeLabel = match($pembayaran->metode_pembayaran) {
                                    'transfer' => 'Transfer Bank',
                                    'tunai' => 'Tunai',
                                    default => ucfirst($pembayaran->metode_pembayaran ?? '-'),
                                };
                            @endphp

                            <tr>
                                <td>
                                    <span class="resident-name">
                                        {{ $namaPenghuni }}
                                    </span>
                                    <span class="resident-email">
                                        {{ $emailPenghuni }}
                                    </span>
                                </td>

                                <td>{{ $nomorKamar }}</td>

                                <td>{{ $periode }}</td>

                                <td>
                                    {{ $pembayaran->tanggal_pembayaran
                                        ? $pembayaran->tanggal_pembayaran->format('d/m/Y')
                                        : '-' }}
                                </td>

                                <td>{{ $metodeLabel }}</td>

                                <td>
                                    <strong>
                                        Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="status {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">

                                        <button
                                            class="icon-btn"
                                            type="button"
                                            title="Detail"
                                            aria-label="Lihat detail pembayaran"
                                            onclick="showDetail('paymentModal{{ $pembayaran->id }}')"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if($pembayaran->status === 'menunggu_verifikasi')
                                            <button
                                                class="icon-btn verify"
                                                type="button"
                                                title="Verifikasi"
                                                aria-label="Verifikasi pembayaran"
                                                onclick="showDetail('paymentModal{{ $pembayaran->id }}')"
                                            >
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="empty-note">
                                    <i class="bi bi-inbox"></i>
                                    <br>
                                    Belum ada data pembayaran yang ditemukan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="table-footer">

                <span>
                    Menampilkan
                    {{ $pembayarans->firstItem() ?? 0 }}-{{ $pembayarans->lastItem() ?? 0 }}
                    dari {{ $pembayarans->total() }} data
                </span>

                <div class="pagination">

                    @if($pembayarans->onFirstPage())
                        <span class="page-btn disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a
                            href="{{ $pembayarans->previousPageUrl() }}"
                            class="page-btn"
                            aria-label="Halaman sebelumnya"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @if($pembayarans->lastPage() > 1)
                        @foreach($pembayarans->getUrlRange(
                            max(1, $pembayarans->currentPage() - 2),
                            min($pembayarans->lastPage(), $pembayarans->currentPage() + 2)
                        ) as $page => $url)

                            <a
                                href="{{ $url }}"
                                class="page-btn {{ $pembayarans->currentPage() === $page ? 'active' : '' }}"
                                @if($pembayarans->currentPage() === $page)
                                    aria-current="page"
                                @endif
                            >
                                {{ $page }}
                            </a>

                        @endforeach
                    @endif

                    @if($pembayarans->hasMorePages())
                        <a
                            href="{{ $pembayarans->nextPageUrl() }}"
                            class="page-btn"
                            aria-label="Halaman berikutnya"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-btn disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif

                </div>

            </div>

        </section>

        <div class="footer">
            © 2026 KosHaven. Sistem Manajemen Kos.
        </div>

    </div>
</main>

<!-- MODAL DETAIL PEMBAYARAN -->

@foreach($pembayarans as $pembayaran)

    @php
        $namaPenghuni = $pembayaran->user?->name ?? 'Penghuni tidak ditemukan';
        $emailPenghuni = $pembayaran->user?->email ?? '-';
        $nomorKamar = $pembayaran->tagihan?->booking?->kamar?->nomor_kamar ?? '-';

        $statusLabel = match($pembayaran->status) {
            'disetujui' => 'Diterima',
            'ditolak' => 'Ditolak',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            default => 'Tidak diketahui',
        };

        $statusClass = match($pembayaran->status) {
            'disetujui' => 'status-paid',
            'ditolak' => 'status-rejected',
            default => 'status-waiting',
        };

        $metodeLabel = match($pembayaran->metode_pembayaran) {
            'transfer' => 'Transfer Bank',
            'tunai' => 'Tunai',
            default => ucfirst($pembayaran->metode_pembayaran ?? '-'),
        };
    @endphp

    <div
        class="modal-overlay"
        id="paymentModal{{ $pembayaran->id }}"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalTitle{{ $pembayaran->id }}"
    >
        <div class="modal">

            <div class="modal-header">
                <h3 id="modalTitle{{ $pembayaran->id }}">
                    Detail Pembayaran
                </h3>

                <button
                    class="close-modal"
                    type="button"
                    onclick="closeModal('paymentModal{{ $pembayaran->id }}')"
                    aria-label="Tutup detail"
                >
                    &times;
                </button>
            </div>

            <div class="detail-row">
                <span>Nama Penghuni</span>
                <strong>{{ $namaPenghuni }}</strong>
            </div>

            <div class="detail-row">
                <span>Email</span>
                <strong>{{ $emailPenghuni }}</strong>
            </div>

            <div class="detail-row">
                <span>Nomor Kamar</span>
                <strong>{{ $nomorKamar }}</strong>
            </div>

            <div class="detail-row">
                <span>Periode Tagihan</span>
                <strong>{{ $pembayaran->tagihan?->periode ?? '-' }}</strong>
            </div>

            <div class="detail-row">
                <span>Tanggal Pembayaran</span>
                <strong>
                    {{ $pembayaran->tanggal_pembayaran
                        ? $pembayaran->tanggal_pembayaran->format('d/m/Y')
                        : '-' }}
                </strong>
            </div>

            <div class="detail-row">
                <span>Metode Pembayaran</span>
                <strong>{{ $metodeLabel }}</strong>
            </div>

            <div class="detail-row">
                <span>Jumlah Pembayaran</span>
                <strong>
                    Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                </strong>
            </div>

            <div class="detail-row">
                <span>Status</span>
                <strong>
                    <span class="status {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </strong>
            </div>

            <div class="detail-row">
                <span>Bukti Pembayaran</span>
                <strong>
                    @if($pembayaran->bukti_pembayaran)
                        <a
                            href="{{ route('pembayaran.bukti', $pembayaran) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="proof-link"
                        >
                            Lihat Bukti
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    @else
                        Belum ada bukti
                    @endif
                </strong>
            </div>

            <div class="detail-row">
                <span>Diverifikasi Oleh</span>
                <strong>
                    {{ $pembayaran->verifikator?->name ?? '-' }}
                </strong>
            </div>

            <div class="detail-row">
                <span>Tanggal Verifikasi</span>
                <strong>
                    {{ $pembayaran->tanggal_verifikasi
                        ? $pembayaran->tanggal_verifikasi->format('d/m/Y H:i')
                        : '-' }}
                </strong>
            </div>

            <div class="detail-row">
                <span>Catatan</span>
                <strong>{{ $pembayaran->catatan ?: '-' }}</strong>
            </div>

            @if($pembayaran->status === 'disetujui')
                <div class="detail-row">
                    <span>Kuitansi</span>
                    <strong>
                        <a
                            href="{{ route('kuitansi.show', $pembayaran) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="proof-link"
                        >
                            {{ $pembayaran->nomor_kuitansi ?: 'Lihat Kuitansi' }}
                            <i class="bi bi-receipt-cutoff"></i>
                        </a>
                    </strong>
                </div>
            @endif

            <div class="modal-actions">

                <button
                    class="btn btn-light"
                    type="button"
                    onclick="closeModal('paymentModal{{ $pembayaran->id }}')"
                >
                    Tutup
                </button>

                @if($pembayaran->status === 'menunggu_verifikasi')

                    <form
                        method="POST"
                        action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}"
                        onsubmit="return confirm('Verifikasi pembayaran ini?')"
                    >
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-check-circle"></i>
                            Verifikasi
                        </button>
                    </form>

                @endif

            </div>

            @if($pembayaran->status === 'menunggu_verifikasi')

                <form
                    class="rejection-form"
                    method="POST"
                    action="{{ route('admin.pembayaran.tolak', $pembayaran->id) }}"
                    onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')"
                >
                    @csrf
                    @method('PATCH')

                    <label for="catatan{{ $pembayaran->id }}">
                        Alasan Penolakan
                    </label>

                    <textarea
                        id="catatan{{ $pembayaran->id }}"
                        name="catatan"
                        minlength="5"
                        maxlength="1000"
                        required
                        placeholder="Tuliskan alasan penolakan pembayaran..."
                    >{{ old('catatan') }}</textarea>

                    @error('catatan')
                        <small style="color:#B76565;display:block;margin-top:5px;">
                            {{ $message }}
                        </small>
                    @enderror

                    <button class="btn btn-danger" type="submit">
                        <i class="bi bi-x-circle"></i>
                        Tolak Pembayaran
                    </button>
                </form>

            @endif

        </div>
    </div>

@endforeach

<script>
    /* =========================================
       TANGGAL DASHBOARD
    ========================================= */

    function updateCurrentDate() {
        const dateElement = document.getElementById('currentDate');

        if (!dateElement) return;

        dateElement.innerHTML =
            '<i class="bi bi-calendar3"></i> ' +
            new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
    }

    /* =========================================
       DETAIL PEMBAYARAN
    ========================================= */

    let activeModalId = null;

    function showDetail(modalId) {
        const modal = document.getElementById(modalId);

        if (!modal) return;

        if (activeModalId) {
            closeModal(activeModalId);
        }

        activeModalId = modalId;

        modal.classList.add('show');
        document.body.classList.add('modal-open');

        const closeButton = modal.querySelector('.close-modal');

        if (closeButton) {
            closeButton.focus();
        }
    }

    function closeModal(modalId = activeModalId) {
        if (!modalId) return;

        const modal = document.getElementById(modalId);

        if (modal) {
            modal.classList.remove('show');
        }

        activeModalId = null;

        if (!document.querySelector('.modal-overlay.show')) {
            document.body.classList.remove('modal-open');
        }
    }

    /* =========================================
       SIDEBAR RESPONSIVE
    ========================================= */

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');

        if (sidebar.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    function openSidebar() {
        if (window.innerWidth > 850) return;

        document.getElementById('sidebar').classList.add('show');
        document.getElementById('sidebarOverlay').classList.add('show');

        document.getElementById('mobileToggle').setAttribute(
            'aria-expanded',
            'true'
        );

        document.getElementById('mobileToggle').setAttribute(
            'aria-label',
            'Tutup navigasi'
        );

        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('mobileToggle');

        if (sidebar) sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');

        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Buka navigasi');
        }

        document.body.classList.remove('sidebar-open');
    }

    /* =========================================
       LOGOUT
    ========================================= */

    function logoutAdmin() {
        const confirmation = confirm(
            'Yakin ingin keluar dari halaman admin?'
        );

        if (!confirmation) return;

        document.getElementById('logoutForm').submit();
    }

    /* =========================================
       EVENT LISTENERS
    ========================================= */

    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function() {
            closeSidebar();
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSidebar();

            if (activeModalId) {
                closeModal(activeModalId);
            }
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 850) {
            closeSidebar();
        }
    });

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal(this.id);
            }
        });
    });

    /* =========================================
       INISIALISASI HALAMAN
    ========================================= */

    document.addEventListener('DOMContentLoaded', function() {
        updateCurrentDate();
    });
</script>

</body>
</html>
