
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Admin - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --green: #191D22;
            --green-light: #242A31;
            --green-dark: #12161B;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --cream: #F4F0E8;
            --white: #242A31;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(188,198,207,.13);
            --surface: #242A31;
            --surface-light: #2D343D;
            --silver: #BBC4CD;
            --shadow: 0 12px 35px rgba(0,0,0,.16);
            --shadow-soft: 0 5px 20px rgba(0,0,0,.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: auto !important;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--green-dark);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        button, select {
            font: inherit;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }


        /* SIDEBAR */

        .sidebar {
            width: 235px;
            background: linear-gradient(180deg, #20262D 0%, #171B20 100%);
            color: white;
            padding: 0 13px 13px;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 300;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.18) transparent;
            border-right: 1px solid rgba(255,255,255,.07);
            transition: transform .38s cubic-bezier(.22,1,.36,1);
            perspective: 900px;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.2);
            border-radius: 10px;
        }

        .brand {
            padding: 22px 12px 24px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            font-weight: 700;
            color: #F4F0E8;
            line-height: 1.2;
            letter-spacing: -.8px;
        }

        .brand-name span {
            color: var(--gold);
        }

        .brand small {
            display: block;
            color: #929DA8;
            font-size: 9px;
            letter-spacing: 1.5px;
            line-height: 1.6;
            margin-top: 7px;
        }

        .menu-label {
            color: #82909D;
            font-size: 9px;
            letter-spacing: 1.5px;
            font-weight: 800;
            padding: 23px 12px 11px;
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
            isolation: isolate;
            text-decoration: none;
            color: #BBC4CD;
            padding: 11px 12px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.45;
            min-height: 43px;
            border: 1px solid transparent;
            transform: translateZ(0);
            transform-origin: center;
            transition:
                transform .25s cubic-bezier(.2,.8,.2,1),
                background .25s ease,
                color .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .nav-menu a::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(110deg, rgba(198,164,119,.12), transparent 75%);
            opacity: 0;
            z-index: -1;
            transition: opacity .25s ease;
        }

        .nav-menu a i {
            font-size: 15px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            color: #929DA8;
            transition: transform .25s ease, color .25s ease;
        }

        .nav-menu a span {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .nav-menu a:hover {
            background: rgba(255,255,255,.065);
            color: var(--gold-light);
            border-color: rgba(198,164,119,.18);
            transform: perspective(500px) translate3d(4px,-2px,8px);
            box-shadow: 0 7px 16px rgba(0,0,0,.18);
        }

        .nav-menu a:hover::before {
            opacity: 1;
        }

        .nav-menu a:hover i {
            color: var(--gold);
            transform: translateX(2px) scale(1.08);
        }

        .nav-menu a:active {
            transform: perspective(500px) translate3d(2px,1px,-3px) scale(.97);
            box-shadow: inset 0 3px 7px rgba(0,0,0,.25);
        }

        .nav-menu a.active {
            background: linear-gradient(115deg, rgba(198,164,119,.19), rgba(198,164,119,.055));
            color: #F4F0E8;
            border: 1px solid rgba(198,164,119,.26);
            box-shadow:
                inset 3px 0 0 var(--gold),
                0 5px 15px rgba(0,0,0,.13);
        }

        .nav-menu a.active i {
            color: var(--gold-light);
        }

        .nav-menu a.active::after {
            content: "";
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--gold);
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 0 0 10px rgba(198,164,119,.7);
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 10px;
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.1);
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #E0C49B, #A98555);
            color: #191D22;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(198,164,119,.2);
        }

        .profile-info {
            min-width: 0;
        }

        .profile-info strong {
            display: block;
            font-size: 10px;
            color: #F1F0EC;
            font-weight: 700;
            white-space: nowrap;
        }

        .profile-info span {
            display: block;
            font-size: 9px;
            color: #929DA8;
            margin-top: 3px;
        }

        .sidebar-bottom {
            padding: 9px 9px 0;
            flex-shrink: 0;
        }

        .sidebar-bottom form {
            width: 100%;
        }

        .sidebar-bottom button {
            width: 100%;
            background: none;
            border: 0;
            text-align: left;
            color: #BBC4CD;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 11px 3px;
            cursor: pointer;
            font-family: inherit;
            border-radius: 8px;
            transition: .25s ease;
        }

        .sidebar-bottom button:hover {
            color: var(--gold-light);
            background: rgba(255,255,255,.05);
            padding-left: 9px;
        }

        .sidebar-bottom button:active {
            transform: scale(.97);
        }

        .sidebar-bottom i {
            font-size: 15px;
            width: 18px;
            text-align: center;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MAIN */

        .main {
            margin-left: 235px;
            width: calc(100% - 235px);
            min-width: 0;
            padding: 32px 38px 45px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 29px;
        }

        .topbar h1 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            color: #F1F0EC;
            letter-spacing: -.5px;
        }

        .topbar p {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 11px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            color: #E8E6E0;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #3C4651, #252C34);
            color: var(--gold-light);
            font-size: 18px;
            border: 1px solid rgba(198,164,119,.25);
            flex-shrink: 0;
        }

        .mobile-toggle {
            display: none;
            border: 1px solid rgba(198,164,119,.3);
            background: linear-gradient(145deg, #303943, #20262D);
            color: var(--gold-light);
            border-radius: 10px;
            width: 42px;
            height: 42px;
            font-size: 19px;
            cursor: pointer;
            flex-shrink: 0;
            place-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,.2);
            transition: .2s ease;
        }

        .mobile-toggle:active {
            transform: translateY(2px) scale(.96);
            box-shadow: inset 0 3px 6px rgba(0,0,0,.25);
        }

        /* WELCOME */

        .welcome {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 88% 10%, rgba(198,164,119,.18), transparent 30%),
                linear-gradient(115deg, #2D343D, #1E242B 75%);
            color: white;
            padding: 29px 31px;
            border-radius: 16px;
            margin-bottom: 27px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border: 1px solid rgba(198,164,119,.19);
            box-shadow: var(--shadow);
        }

        .welcome::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border: 1px solid rgba(198,164,119,.12);
            border-radius: 50%;
            right: 60px;
            top: -100px;
            pointer-events: none;
        }

        .welcome h2 {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            margin-bottom: 8px;
            color: #F4F0E8;
        }

        .welcome p {
            color: #B7C0C8;
            font-size: 12px;
            line-height: 1.7;
        }

        .welcome-icon {
            font-size: 47px;
            color: var(--gold);
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 5px 13px rgba(198,164,119,.2));
        }

        /* SHARED CARDS */

        .filter-card, .panel, .stat-card {
            background: linear-gradient(145deg, #292F37, #222830);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-soft);
        }

        .filter-card {
            padding: 21px 23px;
            margin-bottom: 25px;
        }

        .filter-title {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 9px;
            color: #E9E7E1;
        }

        .filter-title i {
            color: var(--gold);
        }

        .filter-row {
            display: flex;
            align-items: end;
            gap: 13px;
            flex-wrap: wrap;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-width: 145px;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 700;
            color: #B4BDC5;
        }

        .form-group select {
            width: 100%;
            height: 43px;
            border: 1px solid rgba(188,198,207,.17);
            border-radius: 9px;
            padding: 0 12px;
            font-family: inherit;
            font-size: 12px;
            color: #F1F0EC;
            background: #1D232A;
            outline: none;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-group select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .form-group select option {
            background: #242A31;
            color: #F1F0EC;
        }

        .btn {
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
            border-radius: 9px;
            padding: 11px 17px;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease,
                border-color .2s ease;
            min-height: 43px;
            white-space: nowrap;
        }

        .btn:focus-visible,
        .nav-menu a:focus-visible,
        .mobile-toggle:focus-visible {
            outline: 2px solid var(--gold-light);
            outline-offset: 3px;
        }

        .btn-primary {
            background: linear-gradient(145deg, #D2B184, #AD895D);
            color: #191D22;
            box-shadow: 0 4px 12px rgba(198,164,119,.15);
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #E0C49B, #C6A477);
            transform: translateY(-2px);
            box-shadow: 0 8px 17px rgba(198,164,119,.2);
        }

        .btn-gold {
            background: #34312B;
            color: var(--gold-light);
            border-color: rgba(198,164,119,.24);
        }

        .btn-gold:hover {
            background: #423A30;
            transform: translateY(-2px);
            box-shadow: 0 7px 16px rgba(0,0,0,.2);
        }

        .btn:active {
            transform: translateY(2px) scale(.97);
            box-shadow: inset 0 3px 7px rgba(0,0,0,.25);
        }

        /* SECTION HEADINGS */

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 28px 0 15px;
        }

        .section-heading h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            color: #EAE7DF;
        }

        .section-heading span {
            font-size: 11px;
            color: var(--muted);
            text-align: right;
        }

        /* STATS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap: 15px;
        }

        .stat-card {
            padding: 20px;
            min-width: 0;
            position: relative;
            overflow: hidden;
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(198,164,119,.045);
            right: -43px;
            bottom: -48px;
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(198,164,119,.28);
            box-shadow: 0 12px 25px rgba(0,0,0,.2);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 17px;
        }

        .stat-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            font-size: 18px;
            flex-shrink: 0;
        }

        .icon-green {
            background: rgba(145,174,155,.13);
            color: #91AE9B;
        }

        .icon-gold {
            background: rgba(198,164,119,.14);
            color: var(--gold-light);
        }

        .icon-blue {
            background: rgba(146,169,193,.14);
            color: #A8BDD2;
        }

        .icon-red {
            background: rgba(213,143,143,.13);
            color: #D58F8F;
        }

        .stat-label {
            color: #A9B0B8;
            font-size: 11px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: #F1F0EC;
            margin-bottom: 7px;
            overflow-wrap: anywhere;
            letter-spacing: -.5px;
        }

        .stat-note {
            font-size: 10px;
            color: #929DA8;
            line-height: 1.6;
        }

        /* REPORT PANELS */

        .report-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 18px;
        }

        .panel {
            padding: 23px;
            min-width: 0;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 21px;
        }

        .panel-header h3 {
            font-size: 14px;
            color: #F1F0EC;
            font-weight: 700;
        }

        .panel-header span {
            font-size: 10px;
            color: var(--muted);
            text-align: right;
        }

        /* CHART */

        .chart-area {
            height: 235px;
            display: flex;
            align-items: end;
            justify-content: space-around;
            gap: 9px;
            padding: 12px 5px 0;
            border-bottom: 1px solid rgba(188,198,207,.16);
            background: repeating-linear-gradient(
                to bottom,
                transparent 0,
                transparent 53px,
                rgba(188,198,207,.075) 54px
            );
            overflow-x: auto;
            overflow-y: hidden;
        }

        .chart-column {
            height: 100%;
            flex: 1 0 27px;
            min-width: 22px;
            display: flex;
            flex-direction: column;
            justify-content: end;
            align-items: center;
            gap: 8px;
        }

        .chart-bar {
            width: min(35px,75%);
            min-height: 3px;
            background: linear-gradient(180deg, #E0C49B, #A98555);
            border-radius: 7px 7px 0 0;
            transform-origin: bottom;
            transform: scaleY(0);
            opacity: .85;
            box-shadow: 0 0 12px rgba(198,164,119,.1);
            transition: transform .9s cubic-bezier(.16,1,.3,1), opacity .3s;
        }

        .chart-bar.is-visible {
            transform: scaleY(1);
            opacity: 1;
        }

        .chart-column:hover .chart-bar {
            filter: brightness(1.2);
        }

        .chart-month {
            font-size: 10px;
            color: #A9B0B8;
            padding-bottom: 9px;
            white-space: nowrap;
        }

        .chart-value {
            font-size: 9px;
            color: #929DA8;
            white-space: nowrap;
        }

        .legend {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 17px;
            font-size: 10px;
            color: #A9B0B8;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 8px rgba(198,164,119,.35);
        }

        /* PAYMENT SUMMARY */

        .payment-summary {
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding-top: 5px;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            gap: 10px;
        }

        .payment-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #D5D8D9;
        }

        .payment-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-green { background: #91AE9B; }
        .dot-yellow { background: #D9B77F; }
        .dot-red { background: #D58F8F; }

        .payment-count {
            font-weight: 800;
            color: #F1F0EC;
        }

        .progress-track {
            width: 100%;
            height: 8px;
            border-radius: 10px;
            background: #3A424C;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            width: 0;
            border-radius: 10px;
            transition: width 1.1s cubic-bezier(.16,1,.3,1);
        }

        .fill-green { background: linear-gradient(90deg,#638B72,#91AE9B); }
        .fill-yellow { background: linear-gradient(90deg,#A98555,#D9B77F); }
        .fill-red { background: linear-gradient(90deg,#A96C6C,#D58F8F); }

        /* TABLE */

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 680px;
        }

        th {
            text-align: left;
            background: #303741;
            color: #B9C1C8;
            font-size: 10px;
            font-weight: 700;
            padding: 14px 13px;
            white-space: nowrap;
        }

        td {
            padding: 15px 13px;
            border-bottom: 1px solid rgba(188,198,207,.1);
            font-size: 11px;
            vertical-align: middle;
            color: #D6D8D9;
        }

        tbody tr {
            transition: background .2s ease;
        }

        tbody tr:hover {
            background: rgba(198,164,119,.045);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-paid {
            background: rgba(145,174,155,.13);
            color: #A7C8B0;
            border: 1px solid rgba(145,174,155,.16);
        }

        .status-pending {
            background: rgba(217,183,127,.13);
            color: #E0C49B;
            border: 1px solid rgba(217,183,127,.16);
        }

        .status-late {
            background: rgba(213,143,143,.13);
            color: #E5A6A6;
            border: 1px solid rgba(213,143,143,.16);
        }

        .status-rejected {
            background: rgba(175,148,203,.13);
            color: #C6A9E2;
            border: 1px solid rgba(175,148,203,.16);
        }

        .empty-message {
            text-align: center;
            color: var(--muted);
            padding: 35px 20px;
            font-size: 12px;
        }

        .empty-message i {
            color: var(--gold);
        }

        .report-footer {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-top: 26px;
            color: #84909B;
            font-size: 10px;
            padding-top: 17px;
            border-top: 1px solid var(--border);
        }

        .data-notice {
            margin-top: 15px;
            padding: 13px 15px;
            border-radius: 9px;
            background: rgba(198,164,119,.075);
            border: 1px solid rgba(198,164,119,.14);
            color: #C9B28E;
            font-size: 11px;
            line-height: 1.7;
        }

        .data-notice i {
            color: var(--gold);
            margin-right: 5px;
        }

        /* TABLET */

        @media(max-width:1100px) {
            .main {
                padding-left: 25px;
                padding-right: 25px;
            }

            .stats-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
            }

            .report-grid {
                grid-template-columns: 1fr;
            }
        }

        /* MOBILE SIDEBAR */

        @media(max-width:768px) {
            .sidebar {
                width: min(290px,86vw);
                transform: translateX(-105%);
                box-shadow: 12px 0 35px rgba(0,0,0,.35);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.63);
                backdrop-filter: blur(3px);
                z-index: 250;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .mobile-toggle {
                display: grid;
            }
        }

        /* MOBILE CONTENT */

        @media(max-width:760px) {
            .main {
                padding: 22px 16px 35px;
            }

            .topbar {
                gap: 10px;
                margin-bottom: 23px;
            }

            .topbar h1 {
                font-size: 24px;
            }

            .topbar p {
                font-size: 10px;
            }

            .admin-info {
                gap: 7px;
            }

            .admin-info span {
                display: none;
            }

            .avatar {
                width: 36px;
                height: 36px;
            }

            .welcome {
                padding: 22px 20px;
            }

            .welcome h2 {
                font-size: 20px;
            }

            .welcome p {
                font-size: 11px;
            }

            .welcome-icon {
                font-size: 34px;
            }

            .filter-card {
                padding: 18px;
            }

            .filter-row {
                align-items: stretch;
            }

            .form-group {
                flex-basis: 100%;
                min-width: 100%;
            }

            .filter-row .btn {
                width: 100%;
            }

            .stats-grid {
                gap: 11px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 18px;
            }

            .stat-label {
                font-size: 10px;
            }

            .stat-note {
                font-size: 9px;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
            }

            .section-heading h3 {
                font-size: 18px;
            }

            .section-heading span {
                text-align: left;
            }

            .panel {
                padding: 17px;
            }

            .chart-area {
                gap: 6px;
            }

            .report-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media(max-width:380px) {
            .main {
                padding-left: 12px;
                padding-right: 12px;
            }

            .stats-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
                gap: 8px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 15px;
            }

            .stat-value {
                font-size: 15px;
            }

            .welcome-icon {
                display: none;
            }

            .panel {
                padding: 14px;
            }
        }

        /* PRINT */

        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        @media print {
            body {
                background: white !important;
                color: #222 !important;
                font-size: 10px;
            }

            .kh-page-cover,
            .sidebar,
            .sidebar-overlay,
            .mobile-toggle,
            .filter-card,
            .admin-info,
            .print-button {
                display: none !important;
            }

            .layout {
                display: block;
                min-height: 0;
            }

            .main {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .topbar {
                margin-bottom: 15px;
            }

            .topbar h1,
            .section-heading h3,
            .panel-header h3,
            .stat-value {
                color: #222 !important;
            }

            .topbar p,
            .section-heading span,
            .panel-header span,
            .stat-label,
            .stat-note,
            td {
                color: #555 !important;
            }

            .welcome {
                background: white !important;
                color: #222 !important;
                border: 1px solid #ddd;
                padding: 15px 18px;
                margin-bottom: 15px;
                box-shadow: none;
            }

            .welcome h2 {
                color: #222 !important;
            }

            .welcome p {
                color: #555 !important;
            }

            .welcome-icon {
                color: #A98555 !important;
            }

            .section-heading {
                margin: 16px 0 9px;
            }

            .stats-grid {
                grid-template-columns: repeat(4,1fr) !important;
                gap: 8px;
            }

            .stat-card,
            .panel {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                break-inside: avoid;
            }

            .stat-card {
                padding: 12px;
            }

            .report-grid {
                grid-template-columns: 1.5fr 1fr !important;
                gap: 10px;
            }

            .panel {
                padding: 13px;
            }

            .chart-area {
                height: 170px;
                overflow: hidden;
            }

            .chart-bar {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .table-wrap {
                overflow: visible;
            }

            table {
                min-width: 0;
                width: 100%;
            }

            th, td {
                padding: 7px;
                font-size: 9px;
            }

            th {
                background: #eee !important;
                color: #333 !important;
            }

            .report-footer {
                margin-top: 15px;
            }

            .data-notice {
                display: none !important;
            }

            * {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        @media(prefers-reduced-motion:reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }

            .chart-bar {
                transform: scaleY(1);
            }
        }
    </style>
</head>

<body>


<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-name">Kos<span>Haven</span></div>
            <small>BOARDING HOUSE MANAGEMENT</small>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" data-page-transition>
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.pengguna.index') }}" data-page-transition>
                <i class="bi bi-person-gear"></i>
                <span>Manajemen Pengguna</span>
            </a>

            <a href="{{ route('admin.kamar.index') }}" data-page-transition>
                <i class="bi bi-door-closed"></i>
                <span>Data Kamar</span>
            </a>

            <a href="{{ route('admin.booking.index') }}" data-page-transition>
                <i class="bi bi-calendar-check"></i>
                <span>Booking</span>
            </a>

            <a href="{{ route('admin.penghuni.index') }}" data-page-transition>
                <i class="bi bi-people"></i>
                <span>Data Penghuni</span>
            </a>

            <a href="{{ route('admin.petugas.index') }}" data-page-transition>
                <i class="bi bi-person-badge"></i>
                <span>Data Petugas</span>
            </a>

            <a href="{{ route('admin.pengguna.index') }}" data-page-transition>
                <i class="bi bi-person-gear"></i>
                <span>Data Pengguna</span>
            </a>
        </nav>

        <div class="menu-label">KEUANGAN &amp; LAINNYA</div>

        <nav class="nav-menu">
            <a href="{{ route('admin.tagihan.index') }}" data-page-transition>
                <i class="bi bi-receipt"></i>
                <span>Tagihan</span>
            </a>

            <a href="{{ route('admin.pembayaran.index') }}" data-page-transition>
                <i class="bi bi-wallet"></i>
                <span>Pembayaran</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
               class="active"
               aria-current="page">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>

            <a href="{{ route('admin.profil.index') }}" data-page-transition>
                <i class="bi bi-person-circle"></i>
                <span>Profil Admin</span>
            </a>
        </nav>

        <div class="sidebar-profile">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>

            <div class="profile-info">
                <strong>Admin KosHaven</strong>
                <span>Administrator</span>
            </div>
        </div>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST"
                  onsubmit="return confirmLogout()">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN -->
    <main class="main" data-page-enter>

        <header class="topbar">
            <div style="display:flex;align-items:center;gap:13px;min-width:0">
                <button
                    class="mobile-toggle"
                    id="mobileToggle"
                    type="button"
                    onclick="toggleSidebar()"
                    aria-label="Buka navigasi"
                    aria-controls="sidebar"
                    aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h1 data-reveal-words>Laporan</h1>
                    <p>Rekap dan informasi pengelolaan KosHaven</p>
                </div>
            </div>

            <div class="admin-info">
                <div class="avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </header>

        <section class="welcome" data-scroll-reveal>
            <div>
                <h2>Laporan Pengelolaan Kos</h2>
                <p>Pantau pendapatan, pembayaran, kamar, dan penghuni dalam satu halaman.</p>
            </div>
            <i class="bi bi-file-earmark-bar-graph welcome-icon"></i>
        </section>

        <!-- FILTER PERIODE -->
        <section class="filter-card" data-scroll-reveal>
            <div class="filter-title">
                <i class="bi bi-funnel"></i>
                Filter Periode Laporan
            </div>

            <form action="{{ route('admin.laporan.index') }}"
                  method="GET"
                  class="filter-row">

                <div class="form-group">
                    <label for="monthFilter">Bulan</label>
                    <select id="monthFilter" name="bulan">
                        <option value="all" {{ $bulan === 'all' ? 'selected' : '' }}>
                            Semua Bulan
                        </option>
                        @foreach([
                            '01'=>'Januari',
                            '02'=>'Februari',
                            '03'=>'Maret',
                            '04'=>'April',
                            '05'=>'Mei',
                            '06'=>'Juni',
                            '07'=>'Juli',
                            '08'=>'Agustus',
                            '09'=>'September',
                            '10'=>'Oktober',
                            '11'=>'November',
                            '12'=>'Desember'
                        ] as $nomor => $nama)
                            <option value="{{ $nomor }}"
                                {{ $bulan === $nomor ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="yearFilter">Tahun</label>
                    <select id="yearFilter" name="tahun">
                        @for($year = now()->year - 5; $year <= now()->year + 1; $year++)
                            <option value="{{ $year }}"
                                {{ (int)$tahun === $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                    Terapkan
                </button>

                <button class="btn btn-gold print-button"
                        type="button"
                        onclick="printReport()">
                    <i class="bi bi-printer"></i>
                    Cetak Laporan
                </button>
            </form>
        </section>

        <!-- RINGKASAN -->
        <div class="section-heading" data-scroll-reveal>
            <h3>Ringkasan Laporan</h3>
            <span id="periodLabel">
                {{ $bulan === 'all'
                    ? 'Semua Bulan'
                    : \Carbon\Carbon::createFromDate($tahun, (int)$bulan, 1)->translatedFormat('F')
                }}
                {{ $tahun }}
            </span>
        </div>

        <section class="stats-grid" data-scroll-reveal>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Total Pendapatan</span>
                    <div class="stat-icon icon-green">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="stat-value">
                    Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
                <div class="stat-note">Total pembayaran yang sudah disetujui pada periode</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Lunas</span>
                    <div class="stat-icon icon-gold">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanLunas) }}</div>
                <div class="stat-note">Tagihan dengan status lunas</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Pending</span>
                    <div class="stat-icon icon-blue">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanTertunda) }}</div>
                <div class="stat-note">Tagihan belum dibayar atau menunggu verifikasi</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Pembayaran Terlambat</span>
                    <div class="stat-icon icon-red">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanTerlambat) }}</div>
                <div class="stat-note">Tagihan dengan status terlambat</div>
            </div>

        </section>

        <!-- ANALISIS -->
        <div class="section-heading" data-scroll-reveal>
            <h3>Analisis Pembayaran</h3>
            <span>Data berdasarkan periode terpilih</span>
        </div>

        <section class="report-grid" data-scroll-reveal>

            <div class="panel" data-motion-card>
                <div class="panel-header">
                    <h3>Grafik Pendapatan</h3>
                    <span>Dalam Rupiah</span>
                </div>

                <div class="chart-area" id="incomeChart"></div>

                <div class="legend">
                    <span class="legend-dot"></span>
                    Pendapatan pembayaran lunas
                </div>
            </div>

            <div class="panel" data-motion-card>
                <div class="panel-header">
                    <h3>Status Tagihan</h3>
                    <span>{{ number_format($totalTagihan) }} tagihan</span>
                </div>

                <div class="payment-summary">

                    <div>
                        <div class="payment-item">
                            <div class="payment-left">
                                <span class="payment-dot dot-green"></span>
                                <span>Lunas</span>
                            </div>
                            <span class="payment-count">{{ $persentaseLunas }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill fill-green"
                                 data-progress="{{ max(0, min(100, (float)$persentaseLunas)) }}"></div>
                        </div>
                    </div>

                    <div>
                        <div class="payment-item">
                            <div class="payment-left">
                                <span class="payment-dot dot-yellow"></span>
                                <span>Pending</span>
                            </div>
                            <span class="payment-count">{{ $persentaseTertunda }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill fill-yellow"
                                 data-progress="{{ max(0, min(100, (float)$persentaseTertunda)) }}"></div>
                        </div>
                    </div>

                    <div>
                        <div class="payment-item">
                            <div class="payment-left">
                                <span class="payment-dot dot-red"></span>
                                <span>Terlambat</span>
                            </div>
                            <span class="payment-count">{{ $persentaseTerlambat }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill fill-red"
                                 data-progress="{{ max(0, min(100, (float)$persentaseTerlambat)) }}"></div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <!-- REKAP KAMAR DAN PENGHUNI -->
        <div class="section-heading" data-scroll-reveal>
            <h3>Rekap Kamar dan Penghuni</h3>
            <span>Ringkasan data operasional</span>
        </div>

        <section class="stats-grid" data-scroll-reveal>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Total Kamar</span>
                    <div class="stat-icon icon-blue">
                        <i class="bi bi-door-closed"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalKamar) }}</div>
                <div class="stat-note">Jumlah kamar terdaftar</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Kamar Terisi</span>
                    <div class="stat-icon icon-green">
                        <i class="bi bi-house-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($kamarTerisi) }}</div>
                <div class="stat-note">Kamar sedang ditempati</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Kamar Kosong</span>
                    <div class="stat-icon icon-gold">
                        <i class="bi bi-house"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($kamarTersedia) }}</div>
                <div class="stat-note">Kamar tersedia untuk penghuni</div>
            </div>

            <div class="stat-card" data-motion-card>
                <div class="stat-top">
                    <span class="stat-label">Total Penghuni</span>
                    <div class="stat-icon icon-red">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalPenghuniAktif) }}</div>
                <div class="stat-note">Penghuni dengan booking disetujui</div>
            </div>

        </section>

        <!-- RINCIAN TRANSAKSI -->
        <div class="section-heading" data-scroll-reveal>
            <h3>Rincian Transaksi Pembayaran</h3>
            <span>Daftar transaksi berdasarkan filter</span>
        </div>

        <section class="panel" data-scroll-reveal>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penghuni</th>
                            <th>Kamar</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pembayaran as $index => $item)
                            @php
                                $statusLabel = match($item->status) {
                                    'disetujui' => 'Lunas',
                                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                    'ditolak' => 'Ditolak',
                                    default => ucfirst(str_replace('_', ' ', $item->status ?? '-'))
                                };

                                $statusClass = match($item->status) {
                                    'disetujui' => 'status-paid',
                                    'menunggu_verifikasi' => 'status-pending',
                                    'ditolak' => 'status-rejected',
                                    default => 'status-pending'
                                };
                            @endphp

                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_penghuni ?? 'Penghuni tidak ditemukan' }}</td>
                                <td>{{ $item->nomor_kamar ?? '-' }}</td>
                                <td>
                                    {{ $item->tanggal_laporan
                                        ? \Carbon\Carbon::parse($item->tanggal_laporan)->translatedFormat('d M Y')
                                        : '-'
                                    }}
                                </td>
                                <td>{{ ucfirst($item->metode ?? '-') }}</td>
                                <td>
                                    Rp{{ number_format($item->jumlah_bayar ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="status {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-message">
                                    <i class="bi bi-inbox" style="font-size:22px;display:block;margin-bottom:8px"></i>
                                    Tidak ada transaksi pembayaran pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="data-notice">
            <i class="bi bi-info-circle"></i>
            Laporan ini mengambil data langsung dari database KosHaven.
            Ringkasan tagihan mengikuti periode tagihan, sedangkan pendapatan
            dan rincian transaksi mengikuti tanggal pembayaran.
        </div>

        <div class="report-footer">
            <span>KosHaven - Sistem Manajemen Kos</span>
            <span>
                Dicetak pada:
                {{ now()->translatedFormat('d F Y, H:i') }}
            </span>
        </div>

    </main>
</div>

<script>
    /* SIDEBAR RESPONSIVE */

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleButton = document.getElementById('mobileToggle');

    function toggleSidebar() {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    function openSidebar() {
        if (window.innerWidth > 768) return;

        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.classList.add('sidebar-open');

        toggleButton.setAttribute('aria-expanded', 'true');
        toggleButton.setAttribute('aria-label', 'Tutup navigasi');
        toggleButton.innerHTML = '<i class="bi bi-x-lg"></i>';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.classList.remove('sidebar-open');

        if (toggleButton) {
            toggleButton.setAttribute('aria-expanded', 'false');
            toggleButton.setAttribute('aria-label', 'Buka navigasi');
            toggleButton.innerHTML = '<i class="bi bi-list"></i>';
        }
    }

    overlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', closeSidebar);
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeSidebar();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });

    function confirmLogout() {
        return confirm('Yakin ingin keluar dari halaman admin?');
    }

    /* GRAFIK PENDAPATAN DARI DATABASE */

    const chartLabels = @json($chartLabels);
    const chartValues = @json($chartData);

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(Number(value) || 0);
    }

    function renderChart() {
        const chart = document.getElementById('incomeChart');

        if (
            !Array.isArray(chartLabels) ||
            !Array.isArray(chartValues) ||
            chartLabels.length === 0
        ) {
            chart.innerHTML = `
                <div style="width:100%;text-align:center;color:#A9B0B8;font-size:12px;margin:auto">
                    Belum ada data grafik pada periode ini.
                </div>
            `;
            return;
        }

        const maxValue = Math.max(...chartValues.map(Number), 1);

        chart.innerHTML = chartLabels.map((label, index) => {
            const value = Number(chartValues[index]) || 0;

            const height = value > 0
                ? Math.max(4, (value / maxValue) * 145)
                : 3;

            const valueLabel = value >= 1000000
                ? (value / 1000000).toFixed(1) + 'jt'
                : value >= 1000
                    ? (value / 1000).toFixed(0) + 'rb'
                    : value > 0
                        ? String(value)
                        : '';

            const safeLabel = String(label).replace(/[&<>"']/g, char => ({
                '&':'&amp;',
                '<':'&lt;',
                '>':'&gt;',
                '"':'&quot;',
                "'":'&#039;'
            })[char]);

            return `
                <div class="chart-column">
                    <span class="chart-value">${valueLabel}</span>
                    <div
                        class="chart-bar"
                        data-height="${height}"
                        title="${formatRupiah(value)}">
                    </div>
                    <span class="chart-month">${safeLabel}</span>
                </div>
            `;
        }).join('');

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                chart.querySelectorAll('.chart-bar').forEach((bar, index) => {
                    const height = Number(bar.dataset.height) || 3;
                    bar.style.height = height + 'px';

                    setTimeout(() => {
                        bar.classList.add('is-visible');
                    }, index * 65 + 80);
                });
            });
        });
    }

    /* ANIMASI PROGRESS STATUS */

    function animateProgress() {
        document.querySelectorAll('.progress-fill').forEach((bar, index) => {
            const target = Number(bar.dataset.progress) || 0;

            setTimeout(() => {
                bar.style.width = Math.max(0, Math.min(100, target)) + '%';
            }, 200 + index * 140);
        });
    }

    /* CETAK LAPORAN */

    function printReport() {
        closeSidebar();
        window.print();
    }

    /* INISIALISASI */

    document.addEventListener('DOMContentLoaded', () => {
        renderChart();
        animateProgress();
    });
</script>

@vite(['resources/js/app.js'])

</body>
</html>
