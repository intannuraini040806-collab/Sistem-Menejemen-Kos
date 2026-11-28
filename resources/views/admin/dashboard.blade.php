
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">

    <title>Dashboard Admin - KosHaven</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg: #191D22;
            --bg-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-soft: #363E48;
            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --silver-soft: rgba(185,195,205,.12);
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --gold-soft: rgba(198,164,119,.13);
            --ivory: #F4F0E8;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --green: #91AE9B;
            --yellow: #D9B77F;
            --red: #D58F8F;
            --border: rgba(198,164,119,.15);
            --border-strong: rgba(198,164,119,.32);
            --shadow: 0 14px 38px rgba(0,0,0,.25);
            --shadow-hover: 0 18px 38px rgba(0,0,0,.30);
            --sidebar-width: 270px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: auto;
            overflow-x: hidden;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 85% 5%, rgba(198,164,119,.09), transparent 27%),
                radial-gradient(circle at 5% 80%, rgba(146,157,168,.07), transparent 30%),
                var(--bg);
        }

        button, input, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
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
            display: flex;
            flex-direction: column;
            padding: 25px 17px;
            background: linear-gradient(180deg, #15191E 0%, #1D232A 100%);
            border-right: 1px solid var(--border);
            transition: transform .25s ease;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #626D78 transparent;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 10px 28px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            flex-shrink: 0;
        }

        .brand-logo {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 14px;
            color: #191D22;
            font-size: 21px;
            background: linear-gradient(135deg, #E0C49B, #B99360);
            box-shadow: 0 6px 18px rgba(198,164,119,.2);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            color: var(--ivory);
            letter-spacing: .2px;
        }

        .brand-subtitle {
            color: var(--muted-dark);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-label {
            margin: 25px 10px 12px;
            color: var(--muted-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            border-radius: 10px;
            border-left: 3px solid transparent;
            transition: color .2s ease, background-color .2s ease, border-color .2s ease;
        }

        .sidebar-nav a i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav a:hover {
            color: var(--ivory);
            background: rgba(255,255,255,.055);
        }

        .sidebar-nav a.active {
            color: var(--gold-light);
            background: linear-gradient(110deg, rgba(198,164,119,.19), rgba(198,164,119,.06));
            border-left-color: var(--gold);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
            flex-shrink: 0;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .admin-avatar {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            color: #191D22;
            background: linear-gradient(135deg, #E0C49B, #B99360);
            font-weight: 800;
            border-radius: 50%;
        }

        .admin-info {
            min-width: 0;
            flex: 1;
        }

        .admin-info strong {
            display: block;
            color: var(--ivory);
            font-size: 12px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-info span {
            color: var(--muted-dark);
            font-size: 11px;
        }

        /* SHARED LOGOUT COMPONENT */
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
            color: #D58F8F;
            background: rgba(213,143,143,.07);
            border: 1px solid rgba(213,143,143,.12);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            color: #E5AAAA;
            background: rgba(213,143,143,.15);
            border-color: rgba(213,143,143,.25);
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 16px;
            flex-shrink: 0;
        }

        /* MAIN CONTENT */

        .main-content {
            width: calc(100% - var(--sidebar-width));
            min-width: 0;
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            padding: 28px 35px 35px;
            animation: dashboardEnter .65s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes dashboardEnter {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* TOPBAR */

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
            gap: 14px;
            min-width: 0;
        }

        .page-title {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
        }

        .page-subtitle {
            margin-top: 4px;
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .date-display {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            color: var(--muted);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 12px;
        }

        .date-display i {
            color: var(--gold);
        }

        .icon-button {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            position: relative;
            flex-shrink: 0;
            color: var(--silver-light);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 17px;
            transition: color .2s ease, border-color .2s ease, background-color .2s ease;
        }

        .icon-button:hover {
            color: var(--gold-light);
            border-color: var(--gold);
        }

        .notification-dot {
            width: 7px;
            height: 7px;
            position: absolute;
            top: 9px;
            right: 9px;
            background: var(--gold);
            border-radius: 50%;
        }

        .mobile-toggle {
            display: none;
        }

        /* WELCOME */

        .welcome-card {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            min-height: 190px;
            padding: 30px 34px;
            margin-bottom: 25px;
            overflow: hidden;
            background:
                radial-gradient(circle at 85% 40%, rgba(198,164,119,.18), transparent 35%),
                linear-gradient(115deg, #303943, #222830 65%, #292D32);
            border: 1px solid var(--border-strong);
            border-radius: 19px;
            box-shadow: var(--shadow);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            width: 260px;
            height: 260px;
            right: 5%;
            top: -130px;
            border: 1px solid rgba(224,196,155,.15);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            width: 190px;
            height: 190px;
            right: 10%;
            top: -95px;
            border: 1px solid rgba(224,196,155,.12);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .welcome-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .welcome-title {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(25px, 3vw, 34px);
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .welcome-title span {
            color: var(--gold-light);
        }

        .welcome-description {
            max-width: 520px;
            margin-top: 10px;
            color: #B8C0C8;
            font-size: 13px;
            line-height: 1.8;
        }

        .welcome-date {
            position: relative;
            z-index: 1;
            min-width: 155px;
            padding: 17px;
            text-align: center;
            background: rgba(18,22,27,.72);
            border: 1px solid rgba(224,196,155,.2);
            border-radius: 14px;
        }

        .welcome-date i {
            display: block;
            margin-bottom: 8px;
            color: var(--gold-light);
            font-size: 23px;
        }

        .welcome-date span {
            color: var(--muted);
            font-size: 11px;
        }

        .welcome-date strong {
            display: block;
            margin-top: 5px;
            color: var(--ivory);
            font-size: 13px;
        }

        /* SECTION */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 30px 0 17px;
        }

        .section-heading h2 {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 600;
        }

        .section-heading p {
            margin-top: 4px;
            color: var(--muted-dark);
            font-size: 11px;
        }

        .section-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--gold-light);
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            transition: color .2s ease;
        }

        .section-link:hover {
            color: var(--ivory);
        }

        /* STATISTICS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
        }

        .stat-card {
            position: relative;
            min-width: 0;
            padding: 20px;
            overflow: hidden;
            background: linear-gradient(145deg, #2B323A, #222830);
            border: 1px solid rgba(185,195,205,.12);
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--border-strong);
            box-shadow: var(--shadow-hover);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            width: 110px;
            height: 110px;
            right: -45px;
            bottom: -55px;
            border-radius: 50%;
            background: var(--card-glow, rgba(198,164,119,.1));
            pointer-events: none;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: var(--gold-light);
            background: var(--gold-soft);
            border: 1px solid rgba(198,164,119,.17);
            border-radius: 12px;
            font-size: 18px;
        }

        .stat-card:nth-child(2) .stat-icon {
            color: var(--silver-light);
            background: var(--silver-soft);
        }

        .stat-card:nth-child(3) .stat-icon {
            color: var(--yellow);
            background: rgba(217,183,127,.12);
        }

        .stat-card:nth-child(4) .stat-icon {
            color: var(--green);
            background: rgba(145,174,155,.12);
        }

        .stat-value {
            margin-top: 17px;
            color: var(--ivory);
            font-size: clamp(23px, 2.2vw, 29px);
            font-weight: 800;
            letter-spacing: -.7px;
            overflow-wrap: anywhere;
            font-variant-numeric: tabular-nums;
        }

        .stat-note {
            margin-top: 7px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        /* CHARTS */

        .charts-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.65fr) minmax(280px, 1fr);
            gap: 18px;
        }

        .panel {
            min-width: 0;
            padding: 21px;
            background: linear-gradient(145deg, #2B323A, #222830);
            border: 1px solid rgba(185,195,205,.12);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }

        .panel-title {
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 600;
        }

        .panel-description {
            margin-top: 5px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        .chart-filter {
            max-width: 120px;
            padding: 8px 10px;
            color: var(--gold-light);
            background: #20262D;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            font-size: 11px;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 260px;
        }

        .room-chart-container {
            position: relative;
            height: 220px;
            max-width: 280px;
            margin: auto;
        }

        .room-legend {
            display: grid;
            gap: 11px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            color: var(--muted);
            font-size: 11px;
        }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .legend-item strong {
            color: var(--ivory);
            font-size: 12px;
            font-variant-numeric: tabular-nums;
        }

        /* INCOME */

        .income-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 25px;
            margin-top: 18px;
            background: linear-gradient(110deg, rgba(198,164,119,.14), rgba(198,164,119,.035)), #252B32;
            border: 1px solid var(--border-strong);
            border-radius: 15px;
        }

        .income-label {
            color: var(--muted);
            font-size: 11px;
        }

        .income-value {
            margin-top: 7px;
            color: var(--gold-light);
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 800;
            overflow-wrap: anywhere;
            font-variant-numeric: tabular-nums;
        }

        .income-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: var(--gold-light);
            background: var(--gold-soft);
            border: 1px solid var(--border-strong);
            border-radius: 15px;
            font-size: 23px;
        }

        /* ROOM SUMMARY */

        .room-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 13px;
        }

        .room-summary-item {
            min-width: 0;
            padding: 17px;
            background: var(--surface);
            border: 1px solid rgba(185,195,205,.1);
            border-radius: 12px;
        }

        .room-summary-item span {
            color: var(--muted);
            font-size: 10px;
        }

        .room-summary-item strong {
            display: block;
            margin-top: 8px;
            color: var(--ivory);
            font-size: 22px;
            font-variant-numeric: tabular-nums;
        }

        /* ACTIVITY */

        .activity-list {
            display: flex;
            flex-direction: column;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(185,195,205,.09);
        }

        .activity-item:last-child {
            border-bottom: 0;
        }

        .activity-icon {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            color: var(--gold-light);
            background: var(--gold-soft);
            border-radius: 11px;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-content strong {
            display: block;
            color: var(--ivory);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .activity-content p {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .activity-time {
            display: block;
            margin-top: 6px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        /* STATUS */

        .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-lunas,
        .status-disetujui {
            color: var(--green);
            background: rgba(145,174,155,.12);
        }

        .status-menunggu,
        .status-belum_dibayar,
        .status-terlambat {
            color: var(--yellow);
            background: rgba(217,183,127,.12);
        }

        .status-ditolak {
            color: var(--red);
            background: rgba(213,143,143,.12);
        }

        /* TABLE */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            overscroll-behavior-x: contain;
            scrollbar-width: thin;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .payment-table th {
            padding: 13px 14px;
            color: var(--gold-light);
            background: rgba(185,195,205,.07);
            text-align: left;
            font-size: 10px;
            font-weight: 700;
        }

        .payment-table th:first-child {
            border-radius: 8px 0 0 8px;
        }

        .payment-table th:last-child {
            border-radius: 0 8px 8px 0;
        }

        .payment-table td {
            padding: 14px;
            color: var(--muted);
            border-bottom: 1px solid rgba(185,195,205,.09);
            font-size: 11px;
        }

        .payment-table tbody tr {
            transition: background-color .2s ease;
        }

        .payment-table tbody tr:hover {
            background: rgba(198,164,119,.055);
        }

        .payment-table td:first-child {
            color: var(--ivory);
            font-weight: 600;
        }

        .empty-state {
            padding: 30px 15px !important;
            color: var(--muted-dark) !important;
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 8px;
            font-size: 25px;
        }

        /* FOOTER */

        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid rgba(185,195,205,.1);
            color: var(--muted-dark);
            font-size: 10px;
        }

        .footer strong {
            color: var(--gold-light);
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* OVERLAY */

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(0,0,0,.65);
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .main-content {
                padding: 25px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .charts-grid {
                grid-template-columns: minmax(0, 1.4fr) minmax(250px, 1fr);
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 15px 0 40px rgba(0,0,0,.3);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .mobile-toggle {
                display: grid;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .room-chart-container {
                max-width: 250px;
            }
        }

        @media (max-width: 600px) {
            .main-content {
                padding: 19px 15px 25px;
            }

            .topbar {
                margin-bottom: 22px;
            }

            .topbar-left {
                gap: 10px;
            }

            .page-title {
                font-size: 21px;
            }

            .page-subtitle {
                font-size: 10px;
                line-height: 1.5;
            }

            .date-display {
                display: none;
            }

            .welcome-card {
                align-items: flex-start;
                flex-direction: column;
                padding: 23px 20px;
            }

            .welcome-title {
                font-size: 26px;
            }

            .welcome-description {
                font-size: 12px;
            }

            .welcome-date {
                display: flex;
                align-items: center;
                gap: 10px;
                width: 100%;
                text-align: left;
                padding: 11px 13px;
            }

            .welcome-date i {
                margin: 0;
            }

            .welcome-date strong {
                margin: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 11px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 22px;
            }

            .stat-icon {
                width: 34px;
                height: 34px;
                font-size: 15px;
            }

            .panel {
                padding: 16px;
            }

            .chart-container {
                height: 230px;
            }

            .room-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .income-card {
                padding: 17px;
            }

            .footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .activity-item {
                gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .main-content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .topbar-actions {
                gap: 7px;
            }

            .welcome-title {
                font-size: 23px;
            }

            .section-heading h2 {
                font-size: 17px;
            }

            .section-heading p {
                font-size: 10px;
            }

            .panel-header {
                flex-wrap: wrap;
            }

            .chart-filter {
                max-width: 100%;
            }
        }

        @media (max-width: 360px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .topbar-actions {
                gap: 7px;
            }

            .stat-card {
                padding: 18px;
            }
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

        /* ACCESSIBILITY */

        button:focus-visible,
        a:focus-visible,
        select:focus-visible {
            outline: 2px solid var(--gold-light);
            outline-offset: 3px;
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

<div class="app-layout">

    <!-- SIDEBAR OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-logo">
                <i class="bi bi-house-heart-fill"></i>
            </div>

            <div>
                <div class="brand-name">KosHaven</div>
                <div class="brand-subtitle">Management System</div>
            </div>
        </div>

        <div class="sidebar-label">Menu Utama</div>

        <nav class="sidebar-nav">

            <a href="{{ route('admin.dashboard') }}" class="active" aria-current="page">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.pengguna.index') }}" data-page-transition>
                <i class="bi bi-people"></i>
                Manajemen Pengguna
            </a>

            <a href="{{ route('admin.kamar.index') }}" data-page-transition>
                <i class="bi bi-door-open"></i>
                Data Kamar
            </a>

            <a href="{{ route('admin.booking.index') }}" data-page-transition>
                <i class="bi bi-calendar-check"></i>
                Booking Kos
            </a>

            <a href="{{ route('admin.penghuni.index') }}" data-page-transition>
                <i class="bi bi-person-vcard"></i>
                Data Penghuni
            </a>

            <a href="{{ route('admin.petugas.index') }}" data-page-transition>
                <i class="bi bi-person-badge"></i>
                Data Petugas
            </a>

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

        <div class="sidebar-label">Pengaturan</div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.profil.index') }}" data-page-transition>
                <i class="bi bi-gear"></i>
                Profil Admin
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="admin-profile">
                <div class="admin-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="admin-info">
                    <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                    <span>Administrator</span>
                </div>

                <i class="bi bi-three-dots-vertical" style="color:var(--muted-dark)"></i>
            </div>

            <div class="kh-logout-component-wrapper">
                @include('components.logout-modal')
            </div>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content" data-page-enter>

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button class="icon-button mobile-toggle"
                        type="button"
                        onclick="toggleSidebar()"
                        aria-label="Buka menu navigasi"
                        aria-controls="sidebar"
                        aria-expanded="false"
                        id="mobileToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h1 class="page-title">Dashboard Admin</h1>
                    <p class="page-subtitle">
                        Selamat datang di pusat pengelolaan KosHaven.
                    </p>
                </div>

            </div>

            <div class="topbar-actions">

                <div class="date-display">
                    <i class="bi bi-calendar3"></i>
                    <span id="currentDate"></span>
                </div>

                <button class="icon-button"
                        type="button"
                        onclick="showNotification()"
                        aria-label="Notifikasi">
                    <i class="bi bi-bell"></i>
                    <span class="notification-dot"></span>
                </button>

            </div>

        </header>

        <!-- WELCOME -->
        <section class="welcome-card">

            <div class="welcome-content">

                <div class="welcome-eyebrow">
                    <i class="bi bi-stars"></i>
                    KOSHAVEN MANAGEMENT
                </div>

                <h2 class="welcome-title">
                    Halo, {{ auth()->user()->name ?? 'Administrator' }}!
                    <br>
                    Selamat datang di <span>KosHaven.</span>
                </h2>

                <p class="welcome-description">
                    Kelola seluruh aktivitas kos dengan lebih mudah,
                    mulai dari data kamar, penghuni, tagihan, hingga
                    pembayaran dalam satu dashboard.
                </p>

            </div>

            <div class="welcome-date">
                <i class="bi bi-calendar2-week"></i>
                <span>Hari ini</span>
                <strong id="welcomeDate"></strong>
            </div>

        </section>

        <!-- STATISTICS -->
        <div class="section-heading">
            <div>
                <h2>Ringkasan Dashboard</h2>
                <p>Informasi utama pengelolaan kos</p>
            </div>
        </div>

        <section class="stats-grid">

            <article class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Kamar</span>
                    <div class="stat-icon">
                        <i class="bi bi-door-open"></i>
                    </div>
                </div>

                <div class="stat-value" data-count-up="{{ (int) ($totalKamar ?? 0) }}">
                    {{ number_format($totalKamar ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">
                    <i class="bi bi-buildings"></i>
                    Seluruh kamar terdaftar
                </div>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Penghuni</span>
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>

                <div class="stat-value" data-count-up="{{ (int) ($totalPenghuni ?? 0) }}">
                    {{ number_format($totalPenghuni ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">
                    <i class="bi bi-person-check"></i>
                    Penghuni aktif
                </div>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Tagihan Belum Lunas</span>
                    <div class="stat-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>

                <div class="stat-value" data-count-up="{{ (int) ($totalTagihanBelumLunas ?? 0) }}">
                    {{ number_format($totalTagihanBelumLunas ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">
                    <i class="bi bi-clock-history"></i>
                    Menunggu pembayaran
                </div>
            </article>

            <article class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Diterima</span>
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <div class="stat-value" data-count-up="{{ (int) ($totalPembayaranDiterima ?? 0) }}">
                    {{ number_format($totalPembayaranDiterima ?? 0, 0, ',', '.') }}
                </div>

                <div class="stat-note">
                    <i class="bi bi-check-circle"></i>
                    Pembayaran disetujui
                </div>
            </article>

        </section>

        <!-- CHART SECTION -->
        <div class="section-heading">
            <div>
                <h2>Analisis Keuangan & Kamar</h2>
                <p>Pantau perkembangan pembayaran dan kondisi kamar</p>
            </div>
        </div>

        <section class="charts-grid">

            <!-- PAYMENT CHART -->
            <div class="panel">

                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Grafik Pembayaran</h3>
                        <p class="panel-description">
                            Perbandingan pembayaran dan tagihan
                        </p>
                    </div>

                    <select class="chart-filter"
                            id="paymentFilter"
                            aria-label="Periode grafik pembayaran">
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                </div>

                <div class="chart-container">
                    <canvas id="paymentChart"></canvas>
                </div>

            </div>

            <!-- ROOM CHART -->
            <div class="panel">

                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Status Kamar</h3>
                        <p class="panel-description">
                            Ringkasan kondisi kamar saat ini
                        </p>
                    </div>
                </div>

                <div class="room-chart-container">
                    <canvas id="roomChart"></canvas>
                </div>

                <div class="room-legend">

                    <div class="legend-item">
                        <div class="legend-left">
                            <span class="legend-dot" style="background:#929DA8"></span>
                            Kamar Terisi
                        </div>
                        <strong>{{ $kamarTerisi ?? 0 }}</strong>
                    </div>

                    <div class="legend-item">
                        <div class="legend-left">
                            <span class="legend-dot" style="background:#C6A477"></span>
                            Kamar Tersedia
                        </div>
                        <strong>{{ $kamarTersedia ?? 0 }}</strong>
                    </div>

                    <div class="legend-item">
                        <div class="legend-left">
                            <span class="legend-dot" style="background:#59636F"></span>
                            Maintenance
                        </div>
                        <strong>{{ $kamarMaintenance ?? 0 }}</strong>
                    </div>

                </div>

            </div>

        </section>

        <!-- INCOME -->
        <section class="income-card">

            <div>
                <div class="income-label">
                    <i class="bi bi-graph-up-arrow"></i>
                    Total Pendapatan Diterima
                </div>

                <div class="income-value"
                     data-count-up="{{ (float) ($totalPendapatan ?? 0) }}"
                     data-count-prefix="Rp "
                     data-count-currency>
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div class="income-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

        </section>

        <!-- ROOM SUMMARY -->
        <div class="section-heading">
            <div>
                <h2>Ringkasan Kamar</h2>
                <p>Informasi ketersediaan kamar kos</p>
            </div>

            <a href="{{ route('admin.kamar.index') }}" class="section-link" data-page-transition>
                Lihat semua
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <section class="room-summary-grid">

            <div class="room-summary-item">
                <span>Total Kamar</span>
                <strong data-count-up="{{ (int) ($totalKamar ?? 0) }}">
                    {{ $totalKamar ?? 0 }}
                </strong>
            </div>

            <div class="room-summary-item">
                <span>Kamar Terisi</span>
                <strong style="color:var(--silver-light)"
                        data-count-up="{{ (int) ($kamarTerisi ?? 0) }}">
                    {{ $kamarTerisi ?? 0 }}
                </strong>
            </div>

            <div class="room-summary-item">
                <span>Kamar Tersedia</span>
                <strong style="color:var(--gold-light)"
                        data-count-up="{{ (int) ($kamarTersedia ?? 0) }}">
                    {{ $kamarTersedia ?? 0 }}
                </strong>
            </div>

            <div class="room-summary-item">
                <span>Maintenance</span>
                <strong style="color:var(--muted)"
                        data-count-up="{{ (int) ($kamarMaintenance ?? 0) }}">
                    {{ $kamarMaintenance ?? 0 }}
                </strong>
            </div>

        </section>

        <!-- RECENT ACTIVITY -->
        <div class="section-heading">
            <div>
                <h2>Aktivitas Terbaru</h2>
                <p>Aktivitas terakhir dalam sistem KosHaven</p>
            </div>
        </div>

        <section class="panel">

            <div class="activity-list">

                @forelse(($aktivitasTerbaru ?? []) as $aktivitas)

                    <div class="activity-item">

                        <div class="activity-icon">
                            @if(($aktivitas['jenis'] ?? '') === 'pembayaran')
                                <i class="bi bi-wallet2"></i>
                            @elseif(($aktivitas['jenis'] ?? '') === 'booking')
                                <i class="bi bi-calendar-check"></i>
                            @else
                                <i class="bi bi-activity"></i>
                            @endif
                        </div>

                        <div class="activity-content">

                            <strong>
                                {{ $aktivitas['nama'] ?? 'Aktivitas sistem' }}
                            </strong>

                            <p>
                                {{ $aktivitas['keterangan'] ?? '-' }}
                            </p>

                            <span class="activity-time">
                                <i class="bi bi-clock"></i>
                                {{ !empty($aktivitas['created_at'])
                                    ? \Carbon\Carbon::parse($aktivitas['created_at'])->diffForHumans()
                                    : '-' }}
                            </span>

                        </div>

                        @if(!empty($aktivitas['status']))
                            <span class="status status-{{ strtolower($aktivitas['status']) }}">
                                {{ str_replace('_', ' ', ucfirst($aktivitas['status'])) }}
                            </span>
                        @endif

                    </div>

                @empty

                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        Belum ada aktivitas terbaru.
                    </div>

                @endforelse

            </div>

        </section>

        <!-- RECENT PAYMENTS -->
        <div class="section-heading">
            <div>
                <h2>Pembayaran Terbaru</h2>
                <p>Daftar transaksi pembayaran penghuni</p>
            </div>

            <a href="{{ route('admin.pembayaran.index') }}" class="section-link" data-page-transition>
                Lihat semua
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <section class="panel">

            <div class="table-wrapper">

                <table class="payment-table">

                    <thead>
                        <tr>
                            <th>Nama Penghuni</th>
                            <th>Nomor Kamar</th>
                            <th>Periode</th>
                            <th>Jumlah Bayar</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse(($pembayaranTerbaru ?? []) as $pembayaran)

                            <tr>

                                <td>
                                    {{ $pembayaran->nama_penghuni ?? '-' }}
                                </td>

                                <td>
                                    {{ $pembayaran->nomor_kamar ?? '-' }}
                                </td>

                                <td>
                                    {{ $pembayaran->periode ?? '-' }}
                                </td>

                                <td>
                                    Rp {{ number_format($pembayaran->jumlah_bayar ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ !empty($pembayaran->tanggal_pembayaran)
                                        ? \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @php
                                        $statusPembayaran = strtolower(
                                            $pembayaran->status ?? 'menunggu_verifikasi'
                                        );

                                        $statusClass = match($statusPembayaran) {
                                            'disetujui' => 'status-disetujui',
                                            'lunas' => 'status-lunas',
                                            'ditolak' => 'status-ditolak',
                                            default => 'status-menunggu',
                                        };
                                    @endphp

                                    <span class="status {{ $statusClass }}">
                                        {{ str_replace('_', ' ', ucfirst($statusPembayaran)) }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-receipt"></i>
                                    Belum ada data pembayaran.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

        <!-- FOOTER -->
        <footer class="footer">
            <span>
                © {{ date('Y') }} <strong>KosHaven</strong>.
                All rights reserved.
            </span>

            <span>Smart Boarding House Management System</span>
        </footer>

    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ==========================================
           PREFERENSI ANIMASI
        ========================================== */

        const prefersReducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        /* ==========================================
           SIDEBAR
        ========================================== */

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileToggle = document.getElementById('mobileToggle');

        window.toggleSidebar = function () {
            if (!sidebar || !sidebarOverlay) return;

            const isOpen = sidebar.classList.toggle('open');

            sidebarOverlay.classList.toggle('show', isOpen);

            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', String(isOpen));
            }

            document.body.style.overflow = isOpen ? 'hidden' : '';
        };

        window.closeSidebar = function () {
            if (!sidebar || !sidebarOverlay) return;

            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');

            if (mobileToggle) {
                mobileToggle.setAttribute('aria-expanded', 'false');
            }

            document.body.style.overflow = '';
        };

        window.addEventListener('resize', function () {
            if (window.innerWidth > 900) {
                window.closeSidebar();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                window.closeSidebar();
            }
        });

        document.querySelectorAll('.sidebar-nav a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    window.closeSidebar();
                }
            });
        });

        /* ==========================================
           NOTIFICATION
        ========================================== */

        window.showNotification = function () {
            alert('Belum ada notifikasi baru.');
        };

        /* ==========================================
           DATE
        ========================================== */

        const today = new Date();

        const dateOptions = {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };

        const formattedDate = today.toLocaleDateString('id-ID', dateOptions);

        const currentDateElement = document.getElementById('currentDate');
        const welcomeDateElement = document.getElementById('welcomeDate');

        if (currentDateElement) {
            currentDateElement.textContent = formattedDate;
        }

        if (welcomeDateElement) {
            welcomeDateElement.textContent = formattedDate;
        }

        /* ==========================================
           COUNT UP ANIMATION
           Angka akan bergerak dari 0 ke nilai asli.
        ========================================== */

        function formatNumber(value) {
            return Math.round(value).toLocaleString('id-ID');
        }

        function animateCounter(element) {
            if (!element || element.dataset.countAnimated === 'true') {
                return;
            }

            const target = Number(element.dataset.countUp || 0);

            if (!Number.isFinite(target)) {
                return;
            }

            element.dataset.countAnimated = 'true';

            const prefix = element.dataset.countPrefix || '';
            const duration = prefersReducedMotion ? 0 : 1500;

            if (duration === 0) {
                element.textContent = prefix + formatNumber(target);
                return;
            }

            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Ease-out cubic: cepat di awal, melambat di akhir.
                const easedProgress = 1 - Math.pow(1 - progress, 3);
                const currentValue = target * easedProgress;

                element.textContent = prefix + formatNumber(currentValue);

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = prefix + formatNumber(target);
                }
            }

            requestAnimationFrame(updateCounter);
        }

        const counterElements = document.querySelectorAll('[data-count-up]');

        if ('IntersectionObserver' in window) {
            const counterObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.35
            });

            counterElements.forEach(function (element) {
                counterObserver.observe(element);
            });
        } else {
            counterElements.forEach(animateCounter);
        }

        /* ==========================================
           DATA GRAFIK DARI LARAVEL
        ========================================== */

        const paymentData = {
            6: {
                labels: @json($chart6Bulan['labels'] ?? []),
                pembayaran: @json($chart6Bulan['pembayaran'] ?? []),
                tagihan: @json($chart6Bulan['tagihan'] ?? [])
            },
            12: {
                labels: @json($chart12Bulan['labels'] ?? []),
                pembayaran: @json($chart12Bulan['pembayaran'] ?? []),
                tagihan: @json($chart12Bulan['tagihan'] ?? [])
            }
        };

        const roomData = [
            {{ (int) ($kamarTerisi ?? 0) }},
            {{ (int) ($kamarTersedia ?? 0) }},
            {{ (int) ($kamarMaintenance ?? 0) }}
        ];

        /* ==========================================
           CHART.JS CONFIGURATION
        ========================================== */

        if (typeof Chart !== 'undefined') {

            Chart.defaults.font.family = "'DM Sans', sans-serif";
            Chart.defaults.color = '#A9B0B8';

            const chartAnimationDuration = prefersReducedMotion ? 0 : 1400;

            /* ======================================
               PAYMENT CHART
               Bar tumbuh dari bawah ke atas.
            ====================================== */

            const paymentCanvas = document.getElementById('paymentChart');

            let paymentChart = null;

            if (paymentCanvas) {

                const initialPaymentData = paymentData[6] || {
                    labels: [],
                    pembayaran: [],
                    tagihan: []
                };

                paymentChart = new Chart(paymentCanvas, {
                    type: 'bar',

                    data: {
                        labels: initialPaymentData.labels,

                        datasets: [
                            {
                                label: 'Pembayaran',
                                data: initialPaymentData.pembayaran,
                                backgroundColor: '#C6A477',
                                borderColor: '#E0C49B',
                                borderWidth: 1,
                                borderRadius: 6,
                                maxBarThickness: 25
                            },
                            {
                                label: 'Tagihan',
                                data: initialPaymentData.tagihan,
                                backgroundColor: '#929DA8',
                                borderColor: '#BBC4CD',
                                borderWidth: 1,
                                borderRadius: 6,
                                maxBarThickness: 25
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        animation: {
                            duration: chartAnimationDuration,
                            easing: 'easeOutQuart'
                        },

                        animations: {
                            y: {
                                duration: chartAnimationDuration,
                                easing: 'easeOutQuart',
                                from: 0
                            },
                            colors: {
                                duration: prefersReducedMotion ? 0 : 900
                            }
                        },

                        interaction: {
                            mode: 'index',
                            intersect: false
                        },

                        plugins: {
                            legend: {
                                position: 'bottom',

                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 7,
                                    padding: 20,
                                    color: '#B9C3CD',
                                    font: {
                                        size: 10
                                    }
                                }
                            },

                            tooltip: {
                                backgroundColor: '#12161B',
                                titleColor: '#E0C49B',
                                bodyColor: '#F1F0EC',
                                borderColor: 'rgba(198,164,119,.3)',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 9,

                                callbacks: {
                                    label: function (context) {
                                        return context.dataset.label + ': Rp ' +
                                            Number(context.raw || 0).toLocaleString('id-ID');
                                    }
                                }
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#A9B0B8',
                                    font: {
                                        size: 10
                                    }
                                },
                                border: {
                                    color: 'rgba(185,195,205,.12)'
                                }
                            },

                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(185,195,205,.09)'
                                },
                                ticks: {
                                    color: '#A9B0B8',
                                    font: {
                                        size: 10
                                    },
                                    callback: function (value) {
                                        return 'Rp ' + Number(value).toLocaleString('id-ID');
                                    }
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            /* ======================================
               FILTER PAYMENT CHART
               Update tetap menggunakan animasi.
            ====================================== */

            const paymentFilter = document.getElementById('paymentFilter');

            if (paymentFilter && paymentChart) {

                paymentFilter.addEventListener('change', function () {

                    const period = this.value;
                    const selectedData = paymentData[period];

                    if (!selectedData) {
                        return;
                    }

                    paymentChart.data.labels = selectedData.labels;
                    paymentChart.data.datasets[0].data = selectedData.pembayaran;
                    paymentChart.data.datasets[1].data = selectedData.tagihan;

                    paymentChart.update();
                });
            }

            /* ======================================
               ROOM DOUGHNUT CHART
               Mengisi lingkaran sampai nilai aslinya.
               Tidak ada animasi putar tanpa akhir.
            ====================================== */

            const roomCanvas = document.getElementById('roomChart');

            if (roomCanvas) {

                new Chart(roomCanvas, {
                    type: 'doughnut',

                    data: {
                        labels: [
                            'Terisi',
                            'Tersedia',
                            'Maintenance'
                        ],

                        datasets: [{
                            data: roomData,

                            backgroundColor: [
                                '#929DA8',
                                '#C6A477',
                                '#59636F'
                            ],

                            borderColor: '#242A31',
                            borderWidth: 4,
                            hoverOffset: 5
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        rotation: -90,
                        circumference: 360,

                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: prefersReducedMotion ? 0 : 1600,
                            easing: 'easeOutQuart'
                        },

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#12161B',
                                titleColor: '#E0C49B',
                                bodyColor: '#F1F0EC',
                                borderColor: 'rgba(198,164,119,.3)',
                                borderWidth: 1,
                                padding: 11,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }

        } else {
            console.error(
                'Chart.js gagal dimuat. Periksa koneksi internet atau CDN Chart.js.'
            );
        }

    });
</script>

</body>
</html>
