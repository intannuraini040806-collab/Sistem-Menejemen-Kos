<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Penghuni - KosHaven</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #191D22;
            --primary-light: #242A31;
            --primary-deep: #12161B;
            --surface: #242A31;
            --surface-light: #2D343D;
            --surface-hover: #323B45;
            --gold: #C6A477;
            --gold-light: #E0C49B;
            --silver: #929DA8;
            --silver-light: #BBC4CD;
            --background: #171B20;
            --white: #F1F0EC;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;
            --border: rgba(187,196,205,.13);
            --green: #91AE9B;
            --red: #D58F8F;
            --orange: #D9B77F;
            --blue: #9CB8D1;
            --shadow: 0 12px 35px rgba(0,0,0,.16);
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
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        button, input, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 2px solid var(--gold);
            outline-offset: 3px;
        }

        .app {
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 255px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background: var(--primary-deep);
            color: white;
            padding: 22px 14px 14px;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.2) transparent;
            border-right: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 7px 20px;
            border-bottom: 1px solid var(--border);
        }

        .brand-icon {
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 11px;
            background: linear-gradient(145deg, var(--gold-light), var(--gold));
            display: grid;
            place-items: center;
            font-size: 19px;
            color: var(--primary-deep);
            box-shadow: 0 5px 16px rgba(198,164,119,.17);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
            letter-spacing: .3px;
            color: var(--white);
        }

        .brand-subtitle {
            color: var(--gold);
            font-size: 8px;
            letter-spacing: 2px;
            margin-top: 2px;
        }

        .menu-label {
            color: var(--muted-dark);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 22px 10px 10px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar-menu a {
            color: rgba(241,240,236,.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: .2s;
        }

        .sidebar-menu a i {
            font-size: 15px;
            width: 17px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,.06);
            color: var(--white);
        }

        .sidebar-menu a.active {
            background: rgba(198,164,119,.12);
            border-left-color: var(--gold);
            color: var(--gold-light);
            font-weight: 700;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 13px;
            border-top: 1px solid var(--border);
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 7px 13px;
        }

        .sidebar-profile-avatar {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            border-radius: 50%;
            background: linear-gradient(145deg, var(--gold-light), var(--gold));
            color: var(--primary-deep);
            display: grid;
            place-items: center;
            font-size: 13px;
            font-weight: 800;
        }

        .sidebar-profile-name {
            font-size: 11px;
            font-weight: 700;
            color: var(--white);
        }

        .sidebar-profile-role {
            font-size: 9px;
            color: var(--muted-dark);
            margin-top: 3px;
        }

        .sidebar-bottom .logout-link {
            width: 100%;
            color: rgba(241,240,236,.75);
            text-decoration: none;
            display: flex;
            gap: 11px;
            align-items: center;
            padding: 11px 12px;
            font-size: 11px;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
            border: 1px solid transparent;
            transition: .2s;
        }

        .sidebar-bottom .logout-link:hover {
            background: rgba(213,143,143,.1);
            border-color: rgba(213,143,143,.2);
            color: var(--red);
        }

        /* MAIN */

        .main {
            margin-left: 255px;
            min-height: 100vh;
        }

        .topbar {
            min-height: 76px;
            padding: 0 35px;
            background: rgba(25,29,34,.94);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-location {
            font-size: 12px;
            color: var(--muted);
        }

        .page-location strong {
            color: var(--gold-light);
            font-weight: 700;
        }

        .page-location span {
            color: var(--muted-dark);
            margin: 0 5px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .date-display {
            font-size: 12px;
            color: var(--muted);
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 1px solid var(--border);
            padding-left: 16px;
        }

        .profile-avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            background: var(--surface-light);
            border: 1px solid rgba(198,164,119,.35);
            color: var(--gold-light);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 14px;
        }

        .profile-info strong {
            display: block;
            font-size: 12px;
            color: var(--white);
        }

        .profile-info span {
            display: block;
            font-size: 10px;
            color: var(--muted);
            margin-top: 2px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--gold-light);
            font-size: 24px;
        }

        .overlay {
            display: none;
        }

        /* CONTENT */

        .content {
            padding: 32px 35px 45px;
            max-width: 1600px;
            margin: auto;
        }

        .welcome {
            background:
                radial-gradient(circle at 88% 10%, rgba(198,164,119,.13), transparent 27%),
                linear-gradient(115deg, #242A31, #191D22 75%);
            border: 1px solid rgba(198,164,119,.22);
            border-radius: 15px;
            padding: 29px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 29px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .welcome::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 1px solid rgba(198,164,119,.15);
            border-radius: 50%;
            right: 65px;
            top: -135px;
            pointer-events: none;
        }

        .welcome::before {
            content: "";
            position: absolute;
            width: 145px;
            height: 145px;
            border: 1px solid rgba(198,164,119,.09);
            border-radius: 50%;
            right: 15px;
            bottom: -105px;
            pointer-events: none;
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .welcome-text small {
            color: var(--gold);
            letter-spacing: 1.8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .welcome-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            margin: 8px 0;
            color: var(--white);
        }

        .welcome-text p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.8;
            max-width: 570px;
        }

        .welcome-icon {
            position: relative;
            z-index: 1;
            width: 65px;
            height: 65px;
            flex-shrink: 0;
            border-radius: 16px;
            background: rgba(198,164,119,.1);
            border: 1px solid rgba(198,164,119,.23);
            color: var(--gold-light);
            display: grid;
            place-items: center;
            font-size: 30px;
        }

        /* STATISTICS */

        .section-heading {
            margin-bottom: 17px;
        }

        .section-heading h2 {
            font-size: 15px;
            font-weight: 800;
            color: var(--white);
        }

        .section-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 29px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 19px;
            box-shadow: var(--shadow);
            min-width: 0;
            transition: transform .2s ease, border-color .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.35);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 600;
        }

        .stat-icon {
            width: 37px;
            height: 37px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            font-size: 17px;
            flex-shrink: 0;
        }

        .stat-icon.gold {
            color: var(--gold-light);
            background: rgba(198,164,119,.13);
        }

        .stat-icon.green {
            color: var(--green);
            background: rgba(145,174,155,.12);
        }

        .stat-icon.red {
            color: var(--red);
            background: rgba(213,143,143,.12);
        }

        .stat-icon.blue {
            color: var(--blue);
            background: rgba(156,184,209,.12);
        }

        .stat-number {
            font-size: 27px;
            font-weight: 800;
            margin-top: 13px;
            letter-spacing: -.5px;
            color: var(--white);
        }

        .stat-description {
            font-size: 10px;
            color: var(--muted-dark);
            margin-top: 4px;
        }

        /* TABLE */

        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            padding: 21px 23px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        .table-title h2 {
            font-size: 15px;
            font-weight: 800;
            color: var(--white);
        }

        .table-title p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            border: 1px solid var(--gold);
            color: #191D22;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .2s;
            box-shadow: 0 5px 14px rgba(198,164,119,.12);
        }

        .btn-primary:hover {
            background: #E7CDA7;
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(198,164,119,.2);
        }

        .btn-primary:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .table-tools {
            padding: 17px 23px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--border);
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 340px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-dark);
            font-size: 14px;
        }

        .search-box input {
            width: 100%;
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 12px 0 36px;
            font-size: 11px;
            outline: none;
            background: var(--primary);
            color: var(--white);
            transition: .2s;
        }

        .search-box input::placeholder {
            color: var(--muted-dark);
        }

        .search-box input:focus,
        .filter-select:focus,
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .filter-select {
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 30px 0 12px;
            font-size: 11px;
            color: var(--white);
            outline: none;
            background: var(--primary);
            min-width: 145px;
            cursor: pointer;
        }

        .filter-select option,
        .form-control option {
            background: var(--surface);
            color: var(--white);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead {
            background: #20262D;
        }

        th {
            padding: 15px 16px;
            color: var(--silver);
            text-align: left;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .6px;
            white-space: nowrap;
        }

        td {
            padding: 15px 16px;
            border-top: 1px solid var(--border);
            font-size: 11px;
            vertical-align: middle;
            color: var(--muted);
        }

        tbody tr {
            transition: background .2s ease;
        }

        tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        .number-cell {
            color: var(--muted-dark);
            width: 45px;
        }

        .resident-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 190px;
        }

        .resident-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(198,164,119,.13);
            border: 1px solid rgba(198,164,119,.2);
            color: var(--gold-light);
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .resident-info strong {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 4px;
        }

        .resident-info span {
            display: block;
            color: var(--muted-dark);
            font-size: 10px;
            word-break: break-word;
        }

        .room-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(198,164,119,.12);
            border: 1px solid rgba(198,164,119,.17);
            color: var(--gold-light);
            border-radius: 5px;
            padding: 6px 9px;
            font-weight: 700;
            font-size: 10px;
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status.active {
            background: rgba(145,174,155,.13);
            color: var(--green);
        }

        .status.inactive {
            background: rgba(213,143,143,.13);
            color: var(--red);
        }

        .status.pending {
            background: rgba(217,183,127,.13);
            color: var(--orange);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }

        .action-btn {
            width: 31px;
            height: 31px;
            border: 1px solid var(--border);
            background: var(--primary);
            border-radius: 7px;
            display: grid;
            place-items: center;
            font-size: 13px;
            transition: .2s;
        }

        .action-btn.edit {
            color: var(--blue);
        }

        .action-btn.edit:hover {
            background: rgba(156,184,209,.12);
            border-color: rgba(156,184,209,.3);
        }

        .action-btn.delete {
            color: var(--red);
        }

        .action-btn.delete:hover {
            background: rgba(213,143,143,.12);
            border-color: rgba(213,143,143,.3);
        }

        .empty-state {
            text-align: center;
            padding: 45px 15px;
            color: var(--muted);
        }

        .empty-state i {
            display: block;
            font-size: 31px;
            margin-bottom: 12px;
            color: var(--gold);
        }

        .empty-state strong {
            display: block;
            color: var(--white);
            font-size: 13px;
            margin-bottom: 6px;
        }

        .empty-state span {
            font-size: 11px;
            color: var(--muted);
        }

        .table-footer {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            font-size: 10px;
            color: var(--muted);
        }

        /* ALERT */

        .alert {
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.6;
        }

        .alert.success {
            background: rgba(145,174,155,.1);
            color: var(--green);
            border: 1px solid rgba(145,174,155,.22);
        }

        .alert.error {
            background: rgba(213,143,143,.1);
            color: var(--red);
            border: 1px solid rgba(213,143,143,.22);
        }

        .alert ul {
            padding-left: 17px;
            margin-top: 5px;
        }

        .alert-close {
            margin-left: auto;
            border: none;
            background: transparent;
            color: inherit;
            font-size: 17px;
            flex-shrink: 0;
        }

        .password-info {
            margin-top: 10px;
            padding: 12px;
            background: rgba(0,0,0,.15);
            border: 1px solid var(--border);
            border-radius: 7px;
            overflow-wrap: anywhere;
        }

        /* MODAL */

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(5,8,11,.78);
            backdrop-filter: blur(5px);
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            overflow-y: auto;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 570px;
            max-height: 92vh;
            overflow-y: auto;
            background: var(--surface);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 14px;
            box-shadow: 0 25px 70px rgba(0,0,0,.4);
            animation: modalIn .2s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 21px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            color: var(--white);
        }

        .modal-header p {
            color: var(--muted);
            font-size: 10px;
            margin-top: 5px;
            line-height: 1.6;
        }

        .modal-close {
            width: 33px;
            height: 33px;
            flex-shrink: 0;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: var(--primary);
            color: var(--silver-light);
            font-size: 15px;
            transition: .2s;
        }

        .modal-close:hover {
            color: var(--red);
            border-color: rgba(213,143,143,.3);
        }

        .modal-body {
            padding: 22px 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
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
            margin-bottom: 7px;
            color: var(--silver-light);
        }

        .required {
            color: var(--red);
        }

        .form-control {
            width: 100%;
            height: 41px;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 0 11px;
            outline: none;
            font-size: 11px;
            background: var(--primary);
            color: var(--white);
            transition: .2s;
        }

        .form-control::placeholder {
            color: var(--muted-dark);
        }

        .form-control:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .form-help {
            font-size: 10px;
            color: var(--muted);
            line-height: 1.6;
            margin-top: 6px;
        }

        .form-error {
            display: block;
            color: var(--red);
            font-size: 10px;
            margin-top: 5px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 17px 24px;
            border-top: 1px solid var(--border);
        }

        .btn-secondary {
            border: 1px solid var(--border);
            background: var(--primary);
            color: var(--silver-light);
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-secondary:hover {
            background: var(--surface-light);
            color: var(--white);
        }

        .btn-danger {
            border: 1px solid var(--red);
            background: var(--red);
            color: #191D22;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 700;
        }

        .room-note {
            background: rgba(198,164,119,.08);
            border: 1px solid rgba(198,164,119,.2);
            color: var(--gold-light);
            padding: 11px 13px;
            border-radius: 7px;
            font-size: 10px;
            line-height: 1.7;
            margin-top: 17px;
        }

        .room-note i {
            margin-right: 5px;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content {
                padding: 25px 23px 35px;
            }

            .topbar {
                padding: 0 23px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 110;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 105;
                background: rgba(0,0,0,.65);
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .topbar {
                min-height: 65px;
                padding: 0 17px;
            }

            .date-display {
                display: none;
            }

            .content {
                padding: 22px 16px 30px;
            }

            .welcome {
                padding: 23px 20px;
            }

            .welcome-text h1 {
                font-size: 24px;
            }

            .welcome-icon {
                width: 52px;
                height: 52px;
                font-size: 24px;
            }

            .table-header,
            .table-tools {
                padding: 16px;
            }

            .search-box {
                max-width: none;
                flex-basis: 100%;
            }

            .filter-select {
                flex: 1;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .stat-card {
                padding: 13px;
            }

            .stat-number {
                font-size: 22px;
            }

            .stat-label {
                font-size: 10px;
            }

            .stat-icon {
                width: 31px;
                height: 31px;
                font-size: 14px;
            }

            .welcome-icon {
                display: none;
            }

            .welcome-text h1 {
                font-size: 22px;
            }

            .welcome-text p {
                font-size: 11px;
            }

            .profile-info {
                display: none;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .modal-overlay {
                padding: 10px;
                align-items: flex-start;
            }

            .modal {
                margin: auto 0;
                max-height: calc(100vh - 20px);
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 17px;
                padding-right: 17px;
            }

            .table-header {
                align-items: flex-start;
            }

            .table-header .btn-primary {
                width: 100%;
            }

            .table-tools {
                align-items: stretch;
            }

            .filter-select {
                width: 100%;
            }

            .topbar-right {
                gap: 8px;
            }

            .page-location {
                font-size: 11px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }

        /* LOGOUT MODAL - SIDEBAR DATA PENGHUNI */
        .sidebar-bottom .kh-logout-component-wrapper {
            width: 100%;
            margin-top: 0;
        }

        .sidebar-bottom .kh-logout-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 11px;
            padding: 11px 12px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
            color: rgba(241,240,236,.75);
            text-align: left;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            cursor: pointer;
            transition: .2s;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            background: rgba(213,143,143,.1);
            border-color: rgba(213,143,143,.2);
            color: var(--red);
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 15px;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

<div class="app">

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

        <div class="menu-label">MENU UTAMA</div>

        <nav class="sidebar-menu">

            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.pengguna.index') }}">
                <i class="bi bi-person-gear"></i>
                Manajemen Pengguna
            </a>

            <a href="{{ route('admin.kamar.index') }}">
                <i class="bi bi-door-open"></i>
                Data Kamar
            </a>

            <a href="{{ route('admin.booking.index') }}">
                <i class="bi bi-journal-check"></i>
                Booking Kos
            </a>

            <a href="{{ route('admin.penghuni.index') }}" class="active" aria-current="page">
                <i class="bi bi-people"></i>
                Data Penghuni
            </a>

            <a href="{{ route('admin.petugas.index') }}">
                <i class="bi bi-person-badge"></i>
                Data Petugas
            </a>

        </nav>

        <div class="menu-label">KEUANGAN</div>

        <nav class="sidebar-menu">

            <a href="{{ route('admin.tagihan.index') }}">
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

        <div class="menu-label">PENGATURAN</div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.profil.index') }}">
                <i class="bi bi-person-circle"></i>
                Profil Admin
            </a>
        </nav>

        <div class="sidebar-bottom">

            <div class="sidebar-profile">
                <div class="sidebar-profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div>
                    <div class="sidebar-profile-name">Administrator</div>
                    <div class="sidebar-profile-role">Admin KosHaven</div>
                </div>
            </div>

            <div class="kh-logout-component-wrapper">
                @include('components.logout-modal')
            </div>

        </div>

    </aside>

    <div class="overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>


    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button class="menu-toggle"
                        type="button"
                        onclick="toggleSidebar()"
                        aria-label="Buka menu"
                        aria-expanded="false"
                        id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div class="page-location">
                    Admin <span>/</span> <strong>Data Penghuni</strong>
                </div>

            </div>

            <div class="topbar-right">

                <div class="date-display" id="currentDate"></div>

                <div class="profile-mini">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="profile-info">
                        <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                        <span>Administrator</span>
                    </div>
                </div>

            </div>

        </header>


        <!-- CONTENT -->
        <section class="content">

            @if(session('success'))
                <div class="alert success">
                    <i class="bi bi-check-circle-fill"></i>

                    <div style="flex:1;">
                        <strong>{{ session('success') }}</strong>

                        @if(session('temporary_password'))
                            <div class="password-info">
                                <strong>Informasi akun penghuni baru</strong>
                                <p style="margin-top:7px;">
                                    Email:
                                    <strong>{{ session('temporary_email') }}</strong>
                                </p>
                                <p style="margin-top:5px;">
                                    Password sementara:
                                    <strong>{{ session('temporary_password') }}</strong>
                                </p>
                                <p style="margin-top:7px;">
                                    Simpan informasi ini dan sampaikan kepada penghuni melalui cara yang aman.
                                </p>
                            </div>
                        @endif
                    </div>

                    <button type="button" class="alert-close"
                            onclick="this.parentElement.remove()"
                            aria-label="Tutup notifikasi">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif


            @if(session('error'))
                <div class="alert error">
                    <i class="bi bi-exclamation-circle-fill"></i>

                    <div style="flex:1;">
                        {{ session('error') }}
                    </div>

                    <button type="button" class="alert-close"
                            onclick="this.parentElement.remove()"
                            aria-label="Tutup notifikasi">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif


            @if($errors->any())
                <div class="alert error">
                    <i class="bi bi-exclamation-triangle-fill"></i>

                    <div style="flex:1;">
                        <strong>Periksa kembali data yang kamu masukkan:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif


            <!-- WELCOME -->
            <div class="welcome">

                <div class="welcome-text">
                    <small>ADMINISTRATION / RESIDENTS</small>

                    <h1>Data Penghuni</h1>

                    <p>
                        Kelola informasi penghuni, data kamar, dan status tinggal
                        seluruh penghuni KosHaven dengan lebih mudah.
                    </p>
                </div>

                <div class="welcome-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

            </div>


            <!-- STATISTICS -->
            <div class="section-heading">
                <h2>Ringkasan Penghuni</h2>
                <p>Informasi keseluruhan data penghuni KosHaven.</p>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Penghuni</span>
                        <div class="stat-icon gold">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>

                    <div class="stat-number">
                        {{ number_format($totalPenghuni ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="stat-description">
                        Seluruh akun penghuni
                    </div>
                </div>


                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Penghuni Aktif</span>
                        <div class="stat-icon green">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                    </div>

                    <div class="stat-number">
                        {{ number_format($penghuniAktif ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="stat-description">
                        Memiliki booking disetujui
                    </div>
                </div>


                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Penghuni Nonaktif</span>
                        <div class="stat-icon red">
                            <i class="bi bi-person-x-fill"></i>
                        </div>
                    </div>

                    <div class="stat-number">
                        {{ number_format($penghuniNonaktif ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="stat-description">
                        Tidak memiliki booking aktif
                    </div>
                </div>


                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Kamar Terisi</span>
                        <div class="stat-icon blue">
                            <i class="bi bi-door-closed-fill"></i>
                        </div>
                    </div>

                    <div class="stat-number">
                        {{ number_format($kamarTerisi ?? 0, 0, ',', '.') }}
                    </div>

                    <div class="stat-description">
                        Kamar dengan status terisi
                    </div>
                </div>

            </div>


            <!-- TABLE -->
            <div class="table-card">

                <div class="table-header">

                    <div class="table-title">
                        <h2>Daftar Penghuni</h2>
                        <p>Data akun dan informasi tempat tinggal penghuni.</p>
                    </div>

                    <button type="button" class="btn-primary" onclick="openAddModal()">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Penghuni
                    </button>

                </div>


                <!-- SEARCH & FILTER -->
                <div class="table-tools">

                    <div class="search-box">
                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            id="searchInput"
                            placeholder="Cari nama, email, nomor kamar..."
                            autocomplete="off"
                        >
                    </div>

                    <select id="statusFilter" class="filter-select">
                        <option value="semua">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>

                </div>


                <!-- TABLE DATA -->
                <div class="table-responsive">

                    <table id="residentTable">

                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INFORMASI PENGHUNI</th>
                                <th>NO. TELEPON</th>
                                <th>KAMAR</th>
                                <th>TANGGAL MASUK</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody id="residentTableBody">

                            @forelse($penghuni as $index => $item)

                                @php
                                    $statusClass = $item->status === 'aktif'
                                        ? 'active'
                                        : ($item->booking_status ? 'inactive' : 'pending');

                                    $initial = strtoupper(substr($item->name, 0, 1));

                                    $tanggalMasuk = $item->tanggal_masuk
                                        ? \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d M Y')
                                        : '-';
                                @endphp

                                <tr
                                    class="resident-row"
                                    data-search="{{ strtolower($item->name . ' ' . $item->email . ' ' . ($item->phone ?? '') . ' ' . $item->nomor_kamar) }}"
                                    data-status="{{ $item->status }}"
                                >

                                    <td class="number-cell">
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        <div class="resident-info">

                                            <div class="resident-avatar">
                                                {{ $initial }}
                                            </div>

                                            <div>
                                                <strong>{{ $item->name }}</strong>
                                                <span>{{ $item->email }}</span>
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        {{ $item->phone ?: '-' }}
                                    </td>

                                    <td>
                                        @if($item->nomor_kamar !== '-')
                                            <span class="room-badge">
                                                <i class="bi bi-door-open"></i>
                                                {{ $item->nomor_kamar }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted);">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $tanggalMasuk }}
                                    </td>

                                    <td>
                                        <span class="status {{ $statusClass }}">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">

                                            <button
                                                type="button"
                                                class="action-btn edit"
                                                title="Edit penghuni"
                                                aria-label="Edit penghuni {{ $item->name }}"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                data-email="{{ $item->email }}"
                                                data-phone="{{ $item->phone }}"
                                                data-room="{{ $item->nomor_kamar }}"
                                                data-date="{{ $item->tanggal_masuk }}"
                                                data-status="{{ $item->status }}"
                                                onclick="openEditModal(this)"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            @if($item->status === 'aktif')
                                                <button
                                                    type="button"
                                                    class="action-btn checkout"
                                                    style="background:rgba(198,164,119,.14);color:#E0C49B;border:1px solid rgba(198,164,119,.32);width:auto;padding:0 10px;gap:5px;font-size:11px;font-weight:600;"
                                                    title="Check-out / Keluar Kos"
                                                    aria-label="Check-out penghuni {{ $item->name }}"
                                                    data-id="{{ $item->id }}"
                                                    data-name="{{ $item->name }}"
                                                    data-room="{{ $item->nomor_kamar }}"
                                                    onclick="openCheckoutModal(this)"
                                                >
                                                    <i class="bi bi-box-arrow-right"></i>
                                                    <span>Check-out</span>
                                                </button>
                                            @endif

                                            <form
                                                action="{{ route('admin.penghuni.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirmDelete(this)"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn delete"
                                                    title="Hapus penghuni"
                                                    aria-label="Hapus penghuni {{ $item->name }}"
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
                                            <i class="bi bi-people"></i>
                                            <strong>Belum ada data penghuni</strong>
                                            <span>Data penghuni akan muncul setelah tersedia di database.</span>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                            <tr id="searchEmpty" style="display:none;">
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-search"></i>
                                        <strong>Data tidak ditemukan</strong>
                                        <span>Coba gunakan kata kunci atau filter status yang berbeda.</span>
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="table-footer" id="tableCount">
                    Menampilkan {{ $penghuni->count() }} data penghuni.
                </div>

            </div>

        </section>

    </main>

</div>


<!-- MODAL TAMBAH / EDIT PENGHUNI -->

<div class="modal-overlay" id="residentModal">

    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <form
            id="residentForm"
            action="{{ route('admin.penghuni.store') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="methodField"
                value="PUT"
                disabled
            >

            <div class="modal-header">

                <div>
                    <h3 id="modalTitle">Tambah Penghuni</h3>

                    <p id="modalSubtitle">
                        Masukkan informasi akun dan tempat tinggal penghuni.
                    </p>
                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeModal()"
                    aria-label="Tutup modal"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>


            <div class="modal-body">

                <div class="form-grid">

                    <div class="form-group full">
                        <label for="name">
                            Nama Lengkap <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="Masukkan nama lengkap"
                            maxlength="255"
                            minlength="3"
                            autocomplete="name"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label for="email">
                            Alamat Email <span class="required">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="nama@email.com"
                            maxlength="255"
                            autocomplete="email"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label for="phone">
                            Nomor Telepon
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="form-control"
                            placeholder="08xxxxxxxxxx"
                            maxlength="20"
                            pattern="[0-9+() -]{8,20}"
                            title="Masukkan nomor telepon yang valid."
                            autocomplete="tel"
                        >
                    </div>


                    <div class="form-group full">
                        <label for="room">
                            Nomor Kamar <span class="required">*</span>
                        </label>

                        <select
                            id="room"
                            name="room"
                            class="form-control"
                            required
                        >
                            <option value="">Pilih kamar</option>

                            @foreach($kamars as $kamar)
                                <option
                                    value="{{ $kamar->nomor_kamar }}"
                                    data-status="{{ $kamar->status }}"
                                >
                                    {{ $kamar->nomor_kamar }}
                                    -
                                    {{ ucfirst($kamar->tipe) }}
                                    -
                                    Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                                    @if($kamar->status === 'maintenance')
                                        (Maintenance)
                                    @elseif($kamar->status === 'terisi')
                                        (Terisi)
                                    @else
                                        (Tersedia)
                                    @endif
                                </option>
                            @endforeach

                        </select>

                        <div class="form-help">
                            Pilih kamar yang akan ditempati. Kapasitas kamar akan diperiksa oleh sistem.
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="joinDate">
                            Tanggal Masuk <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="joinDate"
                            name="joinDate"
                            class="form-control"
                            required
                        >
                    </div>


                    <div class="form-group">
                        <label for="status">
                            Status Penghuni <span class="required">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-control"
                            required
                        >
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                </div>


                <div class="room-note">
                    <i class="bi bi-info-circle"></i>
                    Akun baru akan mendapatkan password sementara yang dibuat otomatis oleh sistem. Data login dapat disampaikan kepada penghuni secara aman.
                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-primary"
                    id="submitButton"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Penghuni
                </button>

            </div>

        </form>

    </div>

</div>


<!-- MODAL CHECK-OUT / KELUAR KOS -->

<div class="modal-overlay" id="checkoutModal">

    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle" style="max-width:480px;">

        <form id="checkoutForm" method="POST" action="">
            @csrf
            @method('PATCH')

            <div class="modal-header">
                <div>
                    <h3 id="checkoutModalTitle" style="font-family:'Playfair Display',serif;">Check-out / Keluar Kos</h3>
                    <p id="checkoutModalSubtitle">Konfirmasi penghentian sewa dan pengembalian status kamar.</p>
                </div>

                <button
                    type="button"
                    class="modal-close"
                    onclick="closeCheckoutModal()"
                    aria-label="Tutup modal check-out"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="room-note" style="margin-bottom:16px;background:rgba(198,164,119,.1);border-color:rgba(198,164,119,.28);color:#E0C49B;">
                    <i class="bi bi-door-open"></i>
                    <span>Penghuni: <strong id="checkoutResidentName">-</strong> (Kamar <strong id="checkoutResidentRoom">-</strong>). Pastikan seluruh tagihan telah lunas sebelum check-out.</span>
                </div>

                <div class="form-grid" style="grid-template-columns:1fr;">
                    <div class="form-group">
                        <label for="checkoutDate">Tanggal Keluar <span style="color:#D58F8F;">*</span></label>
                        <input
                            type="date"
                            id="checkoutDate"
                            name="tanggal_keluar"
                            class="form-control"
                            value="{{ now()->toDateString() }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="checkoutReason">Alasan Keluar (Opsional)</label>
                        <textarea
                            id="checkoutReason"
                            name="alasan_keluar"
                            class="form-control"
                            rows="3"
                            maxlength="500"
                            style="height:auto;padding:10px 12px;resize:vertical;"
                            placeholder="Contoh: Masa studi selesai, pindah kerja, atau alasan lainnya..."
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeCheckoutModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-primary"
                    id="checkoutSubmitBtn"
                >
                    <i class="bi bi-box-arrow-right"></i>
                    Konfirmasi Check-out
                </button>
            </div>
        </form>

    </div>

</div>


<script>
    /* TANGGAL TOPBAR */

    const currentDateElement = document.getElementById('currentDate');

    currentDateElement.textContent = new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date());


    /* SIDEBAR RESPONSIVE */

    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const menuToggle = document.getElementById('menuToggle');

    function toggleSidebar() {
        const isOpen = sidebar.classList.contains('open');

        if (isOpen) {
            closeSidebar();
        } else {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('show');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');

        if (!modal.classList.contains('show')) {
            document.body.style.overflow = '';
        }
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });


    /* MODAL */

    const modal = document.getElementById('residentModal');
    const residentForm = document.getElementById('residentForm');

    const methodField = document.getElementById('methodField');

    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const submitButton = document.getElementById('submitButton');

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const roomInput = document.getElementById('room');
    const dateInput = document.getElementById('joinDate');
    const statusInput = document.getElementById('status');

    const storeUrl = @json(route('admin.penghuni.store'));
    const updateUrl = @json(url('/admin/penghuni'));
    const checkoutModal = document.getElementById('checkoutModal');
    const checkoutForm = document.getElementById('checkoutForm');
    const checkoutResidentName = document.getElementById('checkoutResidentName');
    const checkoutResidentRoom = document.getElementById('checkoutResidentRoom');
    const checkoutDateInput = document.getElementById('checkoutDate');
    const checkoutReasonInput = document.getElementById('checkoutReason');

    function openCheckoutModal(button) {
        const id = button.dataset.id;
        checkoutForm.action = updateUrl + '/' + encodeURIComponent(id) + '/checkout';
        checkoutResidentName.textContent = button.dataset.name || '-';
        checkoutResidentRoom.textContent = button.dataset.room || '-';
        checkoutDateInput.value = @json(now()->toDateString());
        checkoutReasonInput.value = '';
        checkoutModal.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => checkoutDateInput.focus(), 100);
    }

    function closeCheckoutModal() {
        checkoutModal.classList.remove('show');
        if (!modal.classList.contains('show') && !sidebar.classList.contains('open')) {
            document.body.style.overflow = '';
        }
    }

    checkoutModal.addEventListener('click', function(event) {
        if (event.target === checkoutModal) {
            closeCheckoutModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && checkoutModal.classList.contains('show')) {
            closeCheckoutModal();
        }
    });

    function openAddModal() {
        residentForm.reset();

        residentForm.action = storeUrl;

        methodField.disabled = true;

        modalTitle.textContent = 'Tambah Penghuni';

        modalSubtitle.textContent =
            'Masukkan informasi akun dan tempat tinggal penghuni.';

        submitButton.disabled = false;
        submitButton.innerHTML =
            '<i class="bi bi-check-lg"></i> Simpan Penghuni';

        statusInput.value = 'aktif';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => nameInput.focus(), 100);
    }


    function openEditModal(button) {
        const id = button.dataset.id;

        residentForm.reset();

        residentForm.action =
            updateUrl + '/' + encodeURIComponent(id);

        methodField.disabled = false;

        modalTitle.textContent = 'Edit Data Penghuni';

        modalSubtitle.textContent =
            'Perbarui informasi akun dan tempat tinggal penghuni.';

        submitButton.disabled = false;
        submitButton.innerHTML =
            '<i class="bi bi-check-lg"></i> Simpan Perubahan';

        nameInput.value = button.dataset.name || '';
        emailInput.value = button.dataset.email || '';
        phoneInput.value = button.dataset.phone || '';
        roomInput.value = button.dataset.room || '';
        dateInput.value = button.dataset.date || '';
        statusInput.value = button.dataset.status || 'nonaktif';

        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        setTimeout(() => nameInput.focus(), 100);
    }


    function closeModal() {
        modal.classList.remove('show');

        if (!sidebar.classList.contains('open')) {
            document.body.style.overflow = '';
        }
    }


    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });


    /* PENCARIAN DAN FILTER */

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    const residentRows = Array.from(
        document.querySelectorAll('.resident-row')
    );

    const searchEmpty = document.getElementById('searchEmpty');
    const tableCount = document.getElementById('tableCount');

    function filterResidents() {
        const keyword = searchInput.value.trim().toLowerCase();
        const selectedStatus = statusFilter.value;

        let visibleCount = 0;

        residentRows.forEach(function(row) {
            const searchText = row.dataset.search || '';
            const rowStatus = row.dataset.status || '';

            const matchesSearch = searchText.includes(keyword);

            const matchesStatus =
                selectedStatus === 'semua' ||
                selectedStatus === rowStatus;

            const visible = matchesSearch && matchesStatus;

            row.style.display = visible ? '' : 'none';

            if (visible) {
                visibleCount++;
            }
        });

        if (residentRows.length > 0) {
            searchEmpty.style.display =
                visibleCount === 0 ? '' : 'none';
        }

        tableCount.textContent =
            'Menampilkan ' + visibleCount + ' dari ' +
            residentRows.length + ' data penghuni.';
    }

    searchInput.addEventListener('input', filterResidents);
    statusFilter.addEventListener('change', filterResidents);


    /* KONFIRMASI HAPUS */

    function confirmDelete(form) {
        return confirm(
            'Apakah kamu yakin ingin menghapus akun penghuni ini?\n\n' +
            'Akun yang memiliki riwayat booking tidak dapat dihapus agar ' +
            'riwayat transaksi tetap tersimpan.'
        );
    }


    /* VALIDASI FORM TAMBAH / EDIT */

    residentForm.addEventListener('submit', function(event) {
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const date = dateInput.value;
        const room = roomInput.value;

        if (name.length < 3) {
            event.preventDefault();
            alert('Nama penghuni minimal terdiri dari 3 karakter.');
            nameInput.focus();
            return;
        }

        if (!emailInput.validity.valid || email === '') {
            event.preventDefault();
            alert('Masukkan alamat email yang valid.');
            emailInput.focus();
            return;
        }

        if (phone && !/^[0-9+() -]{8,20}$/.test(phone)) {
            event.preventDefault();
            alert('Format nomor telepon tidak valid.');
            phoneInput.focus();
            return;
        }

        if (!room) {
            event.preventDefault();
            alert('Silakan pilih kamar terlebih dahulu.');
            roomInput.focus();
            return;
        }

        if (!date) {
            event.preventDefault();
            alert('Tanggal masuk wajib diisi.');
            dateInput.focus();
            return;
        }

        const selectedDate = new Date(date + 'T00:00:00');

        if (Number.isNaN(selectedDate.getTime())) {
            event.preventDefault();
            alert('Tanggal masuk tidak valid.');
            dateInput.focus();
            return;
        }

        submitButton.disabled = true;

        submitButton.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    });


    /* TUTUP SIDEBAR DAN MODAL DENGAN ESCAPE */

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (modal.classList.contains('show')) {
                closeModal();
            } else {
                closeSidebar();
            }
        }
    });


    /* CEGAH FORM TERKIRIM BERULANG */

    window.addEventListener('pageshow', function() {
        submitButton.disabled = false;

        if (methodField.disabled) {
            submitButton.innerHTML =
                '<i class="bi bi-check-lg"></i> Simpan Penghuni';
        } else {
            submitButton.innerHTML =
                '<i class="bi bi-check-lg"></i> Simpan Perubahan';
        }
    });

</script>

</body>
</html>