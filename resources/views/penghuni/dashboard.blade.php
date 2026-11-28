<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Penghuni - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #C6A477;
            --primary-light: #E0C49B;
            --primary-soft: rgba(198,164,119,.13);
            --background: #191D22;
            --surface: #242A31;
            --surface-2: #2D343D;
            --surface-3: #363E48;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.14);
            --silver: #BBC4CD;
            --danger: #D58F8F;
            --green: #91AE9B;
            --yellow: #D9B77F;
            --blue: #9BB5D1;
            --shadow: 0 12px 34px rgba(0,0,0,.18);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 95px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
        }

        /* SIDEBAR */

        .sidebar {
            width: 255px;
            height: 100vh;
            height: 100dvh;
            background: #12161B;
            color: var(--text);
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 17px 20px;
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
            width: 41px;
            height: 41px;
            background: var(--primary-soft);
            color: var(--primary-light);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-light);
            letter-spacing: -.5px;
        }

        .brand span {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.25px;
            color: var(--muted-dark);
            margin-top: 4px;
        }

        .menu-label {
            font-size: 9px;
            color: var(--muted-dark);
            letter-spacing: 1.5px;
            padding: 25px 13px 12px;
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
            padding: 12px 14px;
            border-radius: 8px;
            color: #AEB7C0;
            font-size: 12px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease, border-color .2s ease;
            border-left: 3px solid transparent;
        }

        .menu a i {
            font-size: 17px;
            width: 19px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(198,164,119,.12);
            color: var(--primary-light);
            border-left-color: var(--primary);
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding-top: 16px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 8px;
            min-width: 0;
        }

        .user-avatar {
            width: 39px;
            height: 39px;
            background: linear-gradient(135deg, #E0C49B, #A98B62);
            color: #191D22;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .user-info > div:last-child {
            min-width: 0;
        }

        .user-info strong {
            display: block;
            font-size: 11px;
            color: var(--text);
            overflow-wrap: anywhere;
        }

        .user-info small {
            color: var(--muted-dark);
            font-size: 10px;
        }

        /* LOGOUT MODAL TRIGGER */

        .logout-component-wrapper {
            width: 100%;
            margin-top: 3px;
        }

        .logout-component-wrapper .kh-logout-trigger {
            width: 100%;
            justify-content: flex-start;
            padding: 12px 14px;
            color: #AEB7C0;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
        }

        .logout-component-wrapper .kh-logout-trigger:hover {
            color: #D58F8F;
            background: rgba(213,143,143,.1);
            border-color: rgba(213,143,143,.12);
            transform: none;
        }

        .logout-component-wrapper .kh-logout-trigger svg {
            width: 17px;
            height: 17px;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MAIN */

        .main {
            margin-left: 255px;
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
            justify-content: space-between;
            align-items: center;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 50;
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
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--border);
            background: var(--surface);
            width: 39px;
            height: 39px;
            border-radius: 9px;
            font-size: 21px;
            color: var(--primary-light);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification {
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--silver);
            cursor: pointer;
            position: relative;
            transition: .2s ease;
            flex-shrink: 0;
        }

        .notification:hover {
            border-color: rgba(198,164,119,.45);
            color: var(--primary-light);
        }

        .notification span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--primary);
            position: absolute;
            top: 6px;
            right: 6px;
        }

        .notification-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .notification .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: #D58F8F;
            color: #191D22;
            border: 2px solid var(--background);
            font-size: 9px;
            font-weight: 800;
        }

        .notification .notification-count[hidden] {
            display: none;
        }

        .notification-panel {
            position: absolute;
            top: calc(100% + 13px);
            right: 0;
            z-index: 120;
            width: min(380px, calc(100vw - 30px));
            max-height: min(520px, 75vh);
            overflow: hidden;
            display: none;
            flex-direction: column;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: 0 18px 50px rgba(0,0,0,.35);
        }

        .notification-panel.open {
            display: flex;
        }

        .notification-head {
            padding: 16px 17px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }

        .notification-head strong {
            color: var(--text);
            font-size: 13px;
        }

        .notification-head button {
            color: var(--primary-light);
            background: none;
            border: 0;
            font-size: 10px;
            cursor: pointer;
        }

        .notification-list {
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 16px;
            color: inherit;
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            transition: background .2s ease;
        }

        .notification-item:hover {
            background: rgba(255,255,255,.035);
        }

        .notification-item.unread {
            background: rgba(198,164,119,.055);
        }

        .notification-item-icon {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(198,164,119,.13);
            color: var(--primary-light);
            font-size: 16px;
        }

        .notification-item-copy {
            min-width: 0;
            flex: 1;
        }

        .notification-item-copy strong {
            display: block;
            color: var(--text);
            font-size: 11px;
            margin-bottom: 4px;
        }

        .notification-item-copy p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.55;
            margin: 0 0 6px;
            overflow-wrap: anywhere;
        }

        .notification-item-copy small {
            color: var(--muted-dark);
            font-size: 9px;
        }

        .notification-empty {
            padding: 30px 18px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        .notification-empty i {
            display: block;
            color: var(--primary-light);
            font-size: 25px;
            margin-bottom: 8px;
        }

        .notification-loading {
            padding: 22px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width:600px) {
            .notification-panel {
                right: -4px;
            }
        }

        .content {
            max-width: 1600px;
            margin: auto;
            padding: 32px 35px;
            min-width: 0;
        }

        /* WELCOME */

        .welcome {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 27px;
            gap: 15px;
        }

        .welcome h1 {
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            color: var(--text);
            overflow-wrap: anywhere;
            line-height: 1.3;
        }

        .welcome p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 7px;
            line-height: 1.6;
        }

        .date-label {
            padding: 11px 15px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--silver);
            font-size: 11px;
            white-space: nowrap;
        }

        .date-label i {
            color: var(--primary);
            margin-right: 5px;
        }

        /* STATISTICS */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 21px;
            position: relative;
            overflow: hidden;
            min-width: 0;
            transition: border-color .2s ease, transform .2s ease;
        }

        .stat-card:hover {
            border-color: rgba(198,164,119,.35);
            transform: translateY(-2px);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(198,164,119,.06);
            right: -28px;
            top: -32px;
            pointer-events: none;
        }

        .stat-icon {
            width: 41px;
            height: 41px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--primary-soft);
            color: var(--primary-light);
            border: 1px solid rgba(198,164,119,.12);
            border-radius: 9px;
            font-size: 19px;
            margin-bottom: 17px;
        }

        .stat-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            color: var(--text);
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
            overflow-wrap: anywhere;
        }

        .stat-card p {
            font-size: 11px;
            color: var(--muted);
        }

        /* PANEL */

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 23px;
            margin-bottom: 21px;
            min-width: 0;
            box-shadow: 0 5px 20px rgba(0,0,0,.07);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .panel-heading h3 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: var(--text);
        }

        .panel-heading a {
            color: var(--primary-light);
            font-size: 11px;
            font-weight: 700;
            transition: color .2s ease;
        }

        .panel-heading a:hover {
            color: var(--text);
        }

        /* BILL */

        .bill-card {
            background: linear-gradient(120deg, #2D343D, #272E36);
            border: 1px solid rgba(198,164,119,.18);
            border-radius: 10px;
            padding: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .bill-label {
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 8px;
        }

        .bill-amount {
            color: var(--primary-light);
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 8px;
            overflow-wrap: anywhere;
        }

        .bill-period {
            color: var(--muted);
            font-size: 11px;
        }

        .bill-status {
            text-align: right;
            flex-shrink: 0;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }

        .pending {
            color: #D9B77F;
            background: rgba(217,183,127,.13);
            border: 1px solid rgba(217,183,127,.15);
        }

        .paid {
            color: #91AE9B;
            background: rgba(145,174,155,.13);
            border: 1px solid rgba(145,174,155,.15);
        }

        .overdue,
        .rejected {
            color: #D58F8F;
            background: rgba(213,143,143,.13);
            border: 1px solid rgba(213,143,143,.15);
        }

        .due-date {
            margin-top: 12px;
            color: var(--muted);
            font-size: 11px;
        }

        .pay-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            padding: 11px 17px;
            background: var(--primary);
            color: #191D22;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid var(--primary);
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .pay-button:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
        }

        /* ROOM */

        .room-card {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 22px;
            align-items: center;
        }

        .room-image {
            width: 100%;
            height: 145px;
            object-fit: cover;
            border-radius: 9px;
            background: var(--surface-2);
            border: 1px solid var(--border);
        }

        .room-details {
            min-width: 0;
        }

        .room-details h4 {
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .room-details p {
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 9px;
            overflow-wrap: anywhere;
            line-height: 1.5;
        }

        .room-details p i {
            color: var(--primary);
            margin-right: 5px;
        }

        .room-features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 14px;
            margin-top: 15px;
        }

        .room-features span {
            font-size: 10px;
            color: var(--silver);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .room-features i {
            color: var(--primary-light);
        }

        /* GRID */

        .section-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .section-grid .panel {
            height: 100%;
        }

        /* FACILITIES */

        .facility-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 11px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 12px;
            border-radius: 8px;
            min-width: 0;
            transition: border-color .2s ease;
        }

        .facility-item:hover {
            border-color: rgba(198,164,119,.3);
        }

        .facility-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            background: var(--primary-soft);
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .facility-item > div:last-child {
            min-width: 0;
        }

        .facility-item strong {
            display: block;
            color: var(--text);
            font-size: 10px;
            overflow-wrap: anywhere;
        }

        .facility-item small {
            color: var(--muted-dark);
            font-size: 9px;
        }

        /* PROFILE */

        .profile-list {
            display: flex;
            flex-direction: column;
        }

        .profile-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
        }

        .profile-item:last-child {
            border-bottom: none;
        }

        .profile-item span {
            color: var(--muted);
            flex-shrink: 0;
        }

        .profile-item strong {
            color: var(--silver);
            text-align: right;
            overflow-wrap: anywhere;
            min-width: 0;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            scrollbar-width: thin;
            scrollbar-color: var(--surface-3) transparent;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: var(--surface-3);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 570px;
        }

        th {
            background: var(--surface-2);
            color: var(--silver);
            font-size: 10px;
            text-align: left;
            padding: 13px 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            color: var(--muted);
            white-space: nowrap;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        /* EMPTY STATE */

        .empty-state {
            text-align: center;
            padding: 28px 15px;
            color: var(--muted);
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .empty-state i {
            display: block;
            font-size: 29px;
            color: var(--primary-light);
            margin-bottom: 10px;
        }

        .empty-state strong {
            display: block;
            color: var(--text);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 10px;
            line-height: 1.7;
        }

        /* FOOTER */

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 10px;
            padding: 15px 0 5px;
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .content {
                padding: 28px 25px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .section-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .section-grid .panel {
                height: auto;
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 12px 0 35px rgba(0,0,0,.3);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.62);
                backdrop-filter: blur(2px);
                -webkit-backdrop-filter: blur(2px);
                z-index: 90;
            }

            .sidebar-overlay.show {
                display: block;
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

        @media (max-width: 600px) {
            .topbar {
                height: 68px;
                padding: 0 16px;
            }

            .topbar h2 {
                font-size: 17px;
            }

            .topbar p {
                display: none;
            }

            .content {
                padding: 23px 15px;
            }

            .welcome {
                align-items: flex-start;
                flex-direction: column;
                gap: 13px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .welcome p {
                font-size: 11px;
            }

            .date-label {
                font-size: 10px;
                padding: 9px 12px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 17px;
            }

            .stat-icon {
                margin-bottom: 12px;
            }

            .stat-card h3 {
                font-size: 21px;
            }

            .bill-card {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px;
            }

            .bill-status {
                text-align: left;
                width: 100%;
                padding-top: 14px;
                border-top: 1px solid var(--border);
            }

            .bill-amount {
                font-size: 24px;
            }

            .room-card {
                grid-template-columns: 1fr;
                gap: 17px;
            }

            .room-image {
                height: 190px;
            }

            .facility-grid {
                grid-template-columns: 1fr;
            }

            .panel {
                padding: 17px;
                margin-bottom: 15px;
            }

            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }

            .panel-heading h3 {
                font-size: 17px;
            }

            .profile-item {
                flex-wrap: wrap;
                gap: 5px;
            }

            .profile-item strong {
                text-align: left;
                width: 100%;
            }

            .section-grid {
                gap: 0;
            }
        }

        @media (max-width: 360px) {
            .content {
                padding-left: 11px;
                padding-right: 11px;
            }

            .panel {
                padding: 14px;
            }

            .brand-name {
                font-size: 22px;
            }

            .bill-amount {
                font-size: 21px;
            }

            .topbar h2 {
                font-size: 15px;
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

    @php
        $namaPenghuni = $user->name ?? 'Penghuni';

        $inisial = collect(preg_split('/\s+/', trim($namaPenghuni)))
            ->filter()
            ->take(2)
            ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
            ->implode('') ?: 'P';

        $formatRupiah = function ($jumlah) {
            return 'Rp' . number_format((int) $jumlah, 0, ',', '.');
        };

        $formatTanggal = function ($tanggal) {
            return $tanggal
                ? \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('d F Y')
                : '-';
        };

        $formatPeriode = function ($periode) {
            try {
                return \Illuminate\Support\Carbon::createFromFormat('Y-m', $periode)
                    ->translatedFormat('F Y');
            } catch (\Throwable $e) {
                return $periode ?? '-';
            }
        };

        $statusTagihan = [
            'belum_dibayar' => ['Belum Dibayar', 'pending'],
            'menunggu_verifikasi' => ['Menunggu Verifikasi', 'pending'],
            'lunas' => ['Lunas', 'paid'],
            'terlambat' => ['Terlambat', 'overdue'],
        ];

        $statusPembayaran = [
            'menunggu_verifikasi' => ['Menunggu Verifikasi', 'pending'],
            'disetujui' => ['Disetujui', 'paid'],
            'ditolak' => ['Ditolak', 'rejected'],
        ];

        $statusTagihanSaatIni = $tagihanUtama
            ? ($statusTagihan[$tagihanUtama->status] ?? ['Tidak diketahui', 'pending'])
            : null;

        $fasilitasIkon = [
            'wifi' => 'bi-wifi',
            'internet' => 'bi-wifi',
            'ac' => 'bi-snow',
            'pendingin ruangan' => 'bi-snow',
            'kamar mandi dalam' => 'bi-droplet',
            'kamar mandi' => 'bi-droplet',
            'lemari' => 'bi-door-closed',
            'kasur' => 'bi-house',
            'meja' => 'bi-table',
            'kursi' => 'bi-chair',
            'televisi' => 'bi-tv',
            'tv' => 'bi-tv',
            'parkir' => 'bi-car-front',
            'cctv' => 'bi-camera-video',
            'dapur' => 'bi-cup-hot',
            'dapur bersama' => 'bi-cup-hot',
            'air bersih' => 'bi-droplet',
            'laundry' => 'bi-basket',
        ];
    @endphp

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-house-heart-fill"></i>
            </div>

            <div>
                <div class="brand-name">KosHaven.</div>
            </div>
        </div>

        <div class="menu-label">MENU PENGHUNI</div>

        <nav class="menu">
            <a href="{{ route('penghuni.dashboard') }}" class="active" aria-current="page">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('penghuni.kamar.index') }}">
                <i class="bi bi-door-open"></i>
                Kamar Saya
            </a>

            <a href="{{ route('penghuni.tagihan.index') }}">
                <i class="bi bi-receipt"></i>
                Tagihan Bulanan
            </a>

            <a href="{{ route('penghuni.riwayat.index') }}">
                <i class="bi bi-clock-history"></i>
                Riwayat Pembayaran
            </a>

            <a href="{{ route('penghuni.fasilitas.index') }}">
                <i class="bi bi-house-check"></i>
                Fasilitas Kos
            </a>

            <a href="{{ route('penghuni.profil.index') }}">
                <i class="bi bi-person-circle"></i>
                Profil Saya
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="user-info">
                <div class="user-avatar">{{ $inisial }}</div>

                <div>
                    <strong>{{ $namaPenghuni }}</strong>
                    <small>Penghuni KosHaven</small>
                </div>
            </div>

            <!-- TOMBOL LOGOUT DENGAN MODAL -->
            <div class="logout-component-wrapper">
                @include('components.logout-modal')
            </div>

        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Buka menu" aria-expanded="false" id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h2>Dashboard Penghuni</h2>
                    <p>Informasi kamar dan pembayaran kos</p>
                </div>

            </div>

            <div class="notification-wrap">
                <button class="notification" type="button" id="notificationToggle"
                    aria-label="Buka notifikasi" aria-expanded="false" aria-controls="notificationPanel">
                    <i class="bi bi-bell"></i>
                    <span class="notification-count" id="notificationCount" hidden>0</span>
                </button>

                <section class="notification-panel" id="notificationPanel" aria-label="Daftar notifikasi">
                    <div class="notification-head">
                        <strong>Notifikasi</strong>
                        <button type="button" id="markAllNotificationsRead">Tandai semua dibaca</button>
                    </div>

                    <div class="notification-list" id="notificationList">
                        <div class="notification-loading">Memuat notifikasi...</div>
                    </div>
                </section>
            </div>

        </header>

        <div class="content" id="dashboard">

            <!-- WELCOME -->
            <section class="welcome">

                <div>
                    <h1>Halo, {{ $namaPenghuni }}!</h1>
                    <p>Selamat datang kembali di Dashboard Penghuni KosHaven.</p>
                </div>

                <div class="date-label" id="currentDate">
                    <i class="bi bi-calendar3"></i>
                    Memuat tanggal...
                </div>

            </section>

            <!-- STATISTIK -->
            <section class="stats">

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-door-open"></i>
                    </div>

                    <h3>{{ $kamar?->nomor_kamar ?? 'Belum ada' }}</h3>
                    <p>Nomor Kamar</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <h3>
                        {{ $tagihanUtama ? $formatRupiah($tagihanUtama->jumlah) : 'Belum ada' }}
                    </h3>

                    <p>Tagihan Bulan Ini</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <h3>
                        {{ $tagihanUtama ? $formatTanggal($tagihanUtama->tanggal_jatuh_tempo) : '-' }}
                    </h3>

                    <p>Batas Pembayaran</p>
                </div>

            </section>

            <!-- TAGIHAN -->
            <section class="panel" id="tagihan">

                <div class="panel-heading">
                    <h3>Tagihan Bulanan</h3>
                    <a href="{{ route('penghuni.riwayat.index') }}">Riwayat Pembayaran</a>
                </div>

                @if ($tagihanUtama)

                    <div class="bill-card">

                        <div>
                            <p class="bill-label">
                                Total tagihan periode {{ $formatPeriode($tagihanUtama->periode) }}
                            </p>

                            <h2 class="bill-amount">
                                {{ $formatRupiah($tagihanUtama->jumlah) }}
                            </h2>

                            <p class="bill-period">
                                <i class="bi bi-calendar3"></i>
                                Periode {{ $formatPeriode($tagihanUtama->periode) }}
                            </p>
                        </div>

                        <div class="bill-status">

                            <span class="status {{ $statusTagihanSaatIni[1] }}">
                                {{ $statusTagihanSaatIni[0] }}
                            </span>

                            <p class="due-date">
                                <i class="bi bi-clock"></i>
                                Jatuh tempo:
                                {{ $formatTanggal($tagihanUtama->tanggal_jatuh_tempo) }}
                            </p>

                            <a href="{{ route('penghuni.tagihan.index') }}" class="pay-button">
                                <i class="bi bi-wallet2"></i>
                                Lihat Informasi Tagihan
                            </a>

                        </div>

                    </div>

                @else

                    <div class="empty-state">
                        <i class="bi bi-receipt"></i>
                        <strong>Belum Ada Tagihan</strong>
                        <p>Tagihan pembayaran akan ditampilkan di sini setelah tersedia.</p>
                    </div>

                @endif

            </section>

            <!-- KAMAR -->
            <section class="panel" id="kamar">

                <div class="panel-heading">
                    <h3>Informasi Kamar Saya</h3>

                    @if ($bookingAktif && $kamar)
                        <span class="status paid">Sedang Ditempati</span>
                    @else
                        <span class="status pending">Belum Memiliki Kamar Aktif</span>
                    @endif
                </div>

                @if ($bookingAktif && $kamar)

                    <div class="room-card">

                        @if ($kamar->foto)

                            <img
                                src="{{ asset('storage/' . $kamar->foto) }}"
                                alt="Foto {{ $kamar->nomor_kamar }}"
                                class="room-image"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80';"
                            >

                        @else

                            <img
                                src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80"
                                alt="Interior kamar kos"
                                class="room-image"
                            >

                        @endif

                        <div class="room-details">

                            <h4>Kamar {{ $kamar->nomor_kamar }}</h4>

                            <p>
                                <i class="bi bi-geo-alt"></i>
                                KosHaven
                            </p>

                            <p>
                                <i class="bi bi-cash"></i>
                                Harga sewa: {{ $formatRupiah($kamar->harga) }} / bulan
                            </p>

                            <p>
                                <i class="bi bi-calendar3"></i>
                                Tanggal masuk: {{ $formatTanggal($bookingAktif->tanggal_masuk) }}
                            </p>

                            <p>
                                <i class="bi bi-house-check"></i>
                                Status kamar:
                                {{ $kamar->status === 'maintenance' ? 'Maintenance' : ($kamar->status === 'terisi' ? 'Terisi' : 'Tersedia') }}
                            </p>

                            <div class="room-features">

                                <span>
                                    <i class="bi bi-people"></i>
                                    Kapasitas {{ $kamar->kapasitas }} orang
                                </span>

                                <span>
                                    <i class="bi bi-droplet"></i>
                                    {{ $kamar->jenis_kamar_mandi === 'dalam_kamar' ? 'Kamar Mandi Dalam' : 'Kamar Mandi Bersama' }}
                                </span>

                                @if (!empty($fasilitasKamar))

                                    @foreach (array_slice($fasilitasKamar, 0, 5) as $fasilitas)

                                        @php
                                            $namaFasilitas = is_array($fasilitas)
                                                ? ($fasilitas['nama'] ?? $fasilitas['name'] ?? 'Fasilitas')
                                                : $fasilitas;

                                            $namaFasilitas = is_string($namaFasilitas)
                                                ? $namaFasilitas
                                                : 'Fasilitas';

                                            $keyFasilitas = \Illuminate\Support\Str::lower($namaFasilitas);
                                            $iconFasilitas = 'bi-check-circle';

                                            foreach ($fasilitasIkon as $kataKunci => $ikon) {
                                                if (str_contains($keyFasilitas, $kataKunci)) {
                                                    $iconFasilitas = $ikon;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <span>
                                            <i class="bi {{ $iconFasilitas }}"></i>
                                            {{ $namaFasilitas }}
                                        </span>

                                    @endforeach

                                @endif

                            </div>

                        </div>

                    </div>

                @else

                    <div class="empty-state">
                        <i class="bi bi-door-open"></i>
                        <strong>Belum Ada Kamar Aktif</strong>
                        <p>
                            Informasi kamar akan muncul setelah booking kamu disetujui oleh Admin atau Petugas.
                        </p>
                    </div>

                @endif

            </section>

            <!-- RIWAYAT PEMBAYARAN -->
            <section class="panel" id="riwayat">

                <div class="panel-heading">
                    <h3>Riwayat Pembayaran</h3>
                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Tanggal Bayar</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($riwayatPembayaran as $pembayaran)

                                @php
                                    $statusBayar = $statusPembayaran[$pembayaran->status]
                                        ?? ['Tidak diketahui', 'pending'];

                                    $namaMetode = $pembayaran->metode_pembayaran === 'transfer'
                                        ? 'Transfer Bank'
                                        : 'Tunai';
                                @endphp

                                <tr>

                                    <td>
                                        {{ $pembayaran->tagihan
                                            ? $formatPeriode($pembayaran->tagihan->periode)
                                            : '-' }}
                                    </td>

                                    <td>
                                        {{ $formatTanggal($pembayaran->tanggal_pembayaran) }}
                                    </td>

                                    <td>
                                        {{ $formatRupiah($pembayaran->jumlah_bayar) }}
                                    </td>

                                    <td>{{ $namaMetode }}</td>

                                    <td>
                                        <span class="status {{ $statusBayar[1] }}">
                                            {{ $statusBayar[0] }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" style="text-align:center; padding:30px; color:#A9B0B8;">
                                        Belum ada riwayat pembayaran.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

            <!-- FASILITAS DAN PROFIL -->
            <section class="section-grid">

                <!-- FASILITAS -->
                <div class="panel" id="fasilitas">

                    <div class="panel-heading">
                        <h3>Fasilitas Kamar</h3>
                    </div>

                    @if ($kamar && !empty($fasilitasKamar))

                        <div class="facility-grid">

                            @foreach ($fasilitasKamar as $fasilitas)

                                @php
                                    $namaFasilitas = is_array($fasilitas)
                                        ? ($fasilitas['nama'] ?? $fasilitas['name'] ?? 'Fasilitas')
                                        : $fasilitas;

                                    $namaFasilitas = is_string($namaFasilitas)
                                        ? $namaFasilitas
                                        : 'Fasilitas';

                                    $keyFasilitas = \Illuminate\Support\Str::lower($namaFasilitas);
                                    $iconFasilitas = 'bi-check-circle';

                                    foreach ($fasilitasIkon as $kataKunci => $ikon) {
                                        if (str_contains($keyFasilitas, $kataKunci)) {
                                            $iconFasilitas = $ikon;
                                            break;
                                        }
                                    }
                                @endphp

                                <div class="facility-item">

                                    <div class="facility-icon">
                                        <i class="bi {{ $iconFasilitas }}"></i>
                                    </div>

                                    <div>
                                        <strong>{{ $namaFasilitas }}</strong>
                                        <small>Fasilitas kamar</small>
                                    </div>

                                </div>

                            @endforeach

                            <div class="facility-item">

                                <div class="facility-icon">
                                    <i class="bi bi-droplet"></i>
                                </div>

                                <div>
                                    <strong>
                                        {{ $kamar->jenis_kamar_mandi === 'dalam_kamar'
                                            ? 'Kamar Mandi Dalam'
                                            : 'Kamar Mandi Bersama' }}
                                    </strong>
                                    <small>Jenis kamar mandi</small>
                                </div>

                            </div>

                        </div>

                    @elseif ($kamar)

                        <div class="empty-state">
                            <i class="bi bi-house-check"></i>
                            <strong>Belum Ada Data Fasilitas</strong>
                            <p>Data fasilitas untuk kamar ini belum ditambahkan.</p>
                        </div>

                    @else

                        <div class="empty-state">
                            <i class="bi bi-house"></i>
                            <strong>Fasilitas Belum Tersedia</strong>
                            <p>Fasilitas akan ditampilkan setelah kamu memiliki kamar aktif.</p>
                        </div>

                    @endif

                </div>

                <!-- PROFIL -->
                <div class="panel" id="profil">

                    <div class="panel-heading">
                        <h3>Profil Penghuni</h3>
                    </div>

                    <div class="profile-list">

                        <div class="profile-item">
                            <span>Nama Lengkap</span>
                            <strong>{{ $user->name }}</strong>
                        </div>

                        <div class="profile-item">
                            <span>Email</span>
                            <strong>{{ $user->email }}</strong>
                        </div>

                        <div class="profile-item">
                            <span>Nomor Telepon</span>
                            <strong>{{ $user->phone ?: '-' }}</strong>
                        </div>

                        <div class="profile-item">
                            <span>Nomor Kamar</span>
                            <strong>{{ $kamar?->nomor_kamar ?? '-' }}</strong>
                        </div>

                        <div class="profile-item">
                            <span>Status Penghuni</span>
                            <strong>
                                {{ $bookingAktif ? 'Aktif' : 'Belum Aktif' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </section>

            <div class="footer">
                © {{ date('Y') }} KosHaven. Sistem Manajemen Kos.
            </div>

        </div>

    </main>

    <script>
        // SIDEBAR
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('show');

            if (isOpen) {
                closeSidebar();
            } else {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
                menuToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        // NOTIFIKASI PENGHUNI
        const notificationToggle = document.getElementById('notificationToggle');
        const notificationPanel = document.getElementById('notificationPanel');
        const notificationList = document.getElementById('notificationList');
        const notificationCount = document.getElementById('notificationCount');
        const markAllNotificationsRead = document.getElementById('markAllNotificationsRead');

        const notificationUrl = @json(route('penghuni.notifications.index'));
        const notificationReadUrl = @json(url('/penghuni/notifications'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function escapeNotificationHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]));
        }

        function updateNotificationCount(count) {
            const safeCount = Math.max(0, Number(count) || 0);

            notificationCount.textContent = safeCount > 99 ? '99+' : safeCount;
            notificationCount.hidden = safeCount === 0;
        }

        async function loadNotifications() {
            notificationList.innerHTML =
                '<div class="notification-loading">Memuat notifikasi...</div>';

            try {
                const response = await fetch(notificationUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil notifikasi.');
                }

                const result = await response.json();

                updateNotificationCount(result.unread_count);

                if (!result.notifications.length) {
                    notificationList.innerHTML =
                        '<div class="notification-empty"><i class="bi bi-bell-slash"></i>Belum ada notifikasi.<br>Informasi terbaru akan muncul di sini.</div>';

                    return;
                }

                notificationList.innerHTML = result.notifications.map(item => {
                    const title = escapeNotificationHtml(item.title);
                    const message = escapeNotificationHtml(item.message);
                    const icon = /^[a-z0-9-]+$/.test(item.icon || '')
                        ? item.icon
                        : 'bi-bell';

                    const href = escapeNotificationHtml(
                        item.url || @json(route('penghuni.dashboard'))
                    );

                    return `<a class="notification-item ${item.read ? '' : 'unread'}"
                        href="${href}" data-notification-id="${escapeNotificationHtml(item.id)}">
                        <span class="notification-item-icon"><i class="bi ${icon}"></i></span>
                        <span class="notification-item-copy">
                            <strong>${title}</strong>
                            <p>${message}</p>
                            <small>${escapeNotificationHtml(item.created_at || '')}</small>
                        </span>
                    </a>`;
                }).join('');

            } catch (error) {
                notificationList.innerHTML =
                    '<div class="notification-empty">Notifikasi belum dapat dimuat. Coba buka kembali.</div>';
            }
        }

        async function markNotificationRead(id) {
            const response = await fetch(
                `${notificationReadUrl}/${encodeURIComponent(id)}/read`,
                {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                }
            );

            if (!response.ok) {
                throw new Error('Gagal memperbarui notifikasi.');
            }
        }

        notificationToggle?.addEventListener('click', async () => {
            const willOpen = !notificationPanel.classList.contains('open');

            notificationPanel.classList.toggle('open', willOpen);
            notificationToggle.setAttribute('aria-expanded', String(willOpen));

            if (willOpen) {
                await loadNotifications();
            }
        });

        notificationList?.addEventListener('click', async event => {
            const link = event.target.closest('[data-notification-id]');

            if (!link) return;

            event.preventDefault();

            try {
                await markNotificationRead(link.dataset.notificationId);
            } catch (error) {
                // Tetap lanjutkan navigasi jika pembaruan status gagal.
            }

            window.location.href = link.href;
        });

        markAllNotificationsRead?.addEventListener('click', async () => {
            try {
                const response = await fetch(
                    `${notificationReadUrl}/read-all`,
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal memperbarui notifikasi.');
                }

                await loadNotifications();

            } catch (error) {
                notificationList.insertAdjacentHTML(
                    'afterbegin',
                    '<div class="notification-empty">Gagal menandai notifikasi. Silakan coba lagi.</div>'
                );
            }
        });

        document.addEventListener('click', event => {
            if (!event.target.closest('.notification-wrap')) {
                notificationPanel?.classList.remove('open');
                notificationToggle?.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                notificationPanel?.classList.remove('open');
                notificationToggle?.setAttribute('aria-expanded', 'false');
            }
        });

        loadNotifications();

        // TANGGAL
        function updateDate() {
            const today = new Date();
            const dateElement = document.getElementById('currentDate');

            if (!dateElement) return;

            const formattedDate = today.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            dateElement.innerHTML =
                '<i class="bi bi-calendar3"></i> ' + formattedDate;
        }

        updateDate();

        // MENU SIDEBAR
        const menuLinks = document.querySelectorAll('.menu a');

        menuLinks.forEach(link => {
            link.addEventListener('click', function () {
                menuLinks.forEach(item => {
                    item.classList.remove('active');
                    item.removeAttribute('aria-current');
                });

                this.classList.add('active');
                this.setAttribute('aria-current', 'page');

                if (window.innerWidth <= 850) {
                    closeSidebar();
                }
            });
        });

        // TUTUP SIDEBAR DENGAN ESCAPE
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const logoutModal = document.getElementById('khLogoutModal');

                // Biarkan komponen logout menangani Escape sendiri.
                if (logoutModal && logoutModal.classList.contains('is-visible')) {
                    return;
                }

                // Tutup notifikasi.
                notificationPanel?.classList.remove('open');
                notificationToggle?.setAttribute('aria-expanded', 'false');

                // Tutup sidebar.
                closeSidebar();
            }
        });

        // PASTIKAN SIDEBAR KEMBALI NORMAL SAAT LAYAR DIPERBESAR
        window.addEventListener('resize', function() {
            if (window.innerWidth > 850) {
                closeSidebar();
            }
        });
    </script>

</body>
</html>