
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">
    <title>Riwayat Pembayaran - KosHaven</title>

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
            --sidebar-width: 255px;
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

        body.sidebar-open,
        body.modal-open {
            overflow: hidden;
        }

        button, input, select {
            font-family: inherit;
        }

        button {
            cursor: pointer;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 3px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* SIDEBAR */

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #12161B;
            color: var(--text);
            position: fixed;
            top: 0;
            left: 0;
            padding: 27px 18px 20px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform .3s ease;
            overflow-y: auto;
            border-right: 1px solid var(--border);
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

        .user-info strong {
            display: block;
            font-size: 11px;
            color: var(--text);
        }

        .user-info small {
            color: var(--muted-dark);
            font-size: 10px;
        }

        .logout-component-wrapper {
            width: 100%;
            margin-top: 3px;
        }

        .logout-component-wrapper .kh-logout-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            padding: 12px 14px;
            color: #AEB7C0;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-align: left;
            transition: background-color .15s ease, color .15s ease;
        }

        .logout-component-wrapper .kh-logout-trigger:hover {
            color: var(--danger);
            background: rgba(213,143,143,.1);
            border-color: rgba(213,143,143,.12);
        }

        .logout-component-wrapper .kh-logout-trigger i,
        .logout-component-wrapper .kh-logout-trigger svg {
            width: 17px;
            height: 17px;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MAIN */

        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            background: rgba(25,29,34,.94);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(14px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar h2 {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            color: var(--text);
            font-weight: 600;
        }

        .topbar p {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .menu-toggle {
            display: none;
            border: none;
            background: none;
            font-size: 23px;
            color: var(--primary-light);
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
            position: relative;
            transition: .2s;
        }

        .notification:hover {
            color: var(--primary-light);
            border-color: rgba(198,164,119,.45);
            background: var(--primary-soft);
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

        .content {
            max-width: 1600px;
            margin: auto;
            padding: 35px;
        }

        /* HEADING */

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
        }

        .page-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--text);
            font-weight: 600;
        }

        .page-heading p {
            color: var(--muted);
            font-size: 13px;
            margin-top: 8px;
            line-height: 1.7;
            max-width: 650px;
        }

        /* STATISTICS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 23px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 20px;
            min-width: 0;
            transition: .25s;
            box-shadow: var(--shadow);
        }

        .stat-card:hover {
            border-color: rgba(198,164,119,.35);
            transform: translateY(-2px);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--primary-soft);
            color: var(--primary-light);
            border: 1px solid rgba(198,164,119,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: rgba(145,174,155,.11);
            color: var(--green);
            border-color: rgba(145,174,155,.15);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: rgba(155,181,209,.11);
            color: var(--blue);
            border-color: rgba(155,181,209,.15);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: rgba(213,143,143,.11);
            color: var(--danger);
            border-color: rgba(213,143,143,.15);
        }

        .stat-card > span {
            color: var(--muted);
            font-size: 11px;
        }

        .stat-card h3 {
            color: var(--text);
            font-size: 21px;
            margin-top: 8px;
            overflow-wrap: anywhere;
            font-weight: 700;
        }

        .stat-card small {
            color: var(--muted-dark);
            font-size: 10px;
            display: block;
            margin-top: 6px;
            line-height: 1.5;
        }

        /* INFORMATION */

        .info-box {
            display: flex;
            gap: 13px;
            padding: 17px;
            background: rgba(198,164,119,.08);
            border: 1px solid rgba(198,164,119,.22);
            border-radius: 10px;
            margin-bottom: 23px;
        }

        .info-box i {
            color: var(--primary-light);
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-box strong {
            display: block;
            font-size: 12px;
            color: var(--primary-light);
            margin-bottom: 5px;
        }

        .info-box p {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.7;
        }

        /* PANEL */

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 24px;
            margin-bottom: 22px;
            min-width: 0;
            box-shadow: var(--shadow);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 21px;
        }

        .panel-heading h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            color: var(--text);
            font-weight: 600;
        }

        .panel-heading p {
            color: var(--muted);
            font-size: 11px;
            margin-top: 6px;
        }

        /* FILTERS */

        .filter-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .search-box {
            position: relative;
            width: 270px;
            max-width: 100%;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-dark);
            font-size: 13px;
            pointer-events: none;
        }

        .search-box input {
            width: 100%;
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--text);
            border-radius: 8px;
            padding: 11px 12px 11px 37px;
            font-size: 11px;
            outline: none;
            transition: .2s;
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
            border: 1px solid var(--border);
            background: var(--surface-2);
            border-radius: 8px;
            padding: 11px 12px;
            font-size: 11px;
            color: var(--text);
            outline: none;
            min-width: 150px;
            cursor: pointer;
            transition: .2s;
        }

        .filter-select option {
            background: var(--surface-2);
            color: var(--text);
        }

        .filter-left,
        .filter-right {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        /* TABLE */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 9px;
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
            min-width: 850px;
        }

        th {
            background: var(--surface-2);
            color: var(--silver);
            font-size: 10px;
            text-align: left;
            padding: 15px 14px;
            font-weight: 700;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        td {
            padding: 16px 14px;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            vertical-align: middle;
            color: var(--muted);
        }

        tbody tr {
            transition: background .2s;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(198,164,119,.045);
        }

        .transaction-period strong {
            display: block;
            color: var(--text);
            font-size: 12px;
            font-weight: 600;
        }

        .transaction-period small {
            color: var(--muted-dark);
            font-size: 10px;
            display: block;
            margin-top: 5px;
        }

        .amount {
            font-weight: 700;
            color: var(--primary-light);
            white-space: nowrap;
        }

        .method {
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
            color: var(--muted);
        }

        .method i {
            color: var(--primary);
            font-size: 15px;
        }

        .status {
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .status.paid {
            color: var(--green);
            background: rgba(145,174,155,.12);
            border: 1px solid rgba(145,174,155,.16);
        }

        .status.waiting {
            color: var(--blue);
            background: rgba(155,181,209,.12);
            border: 1px solid rgba(155,181,209,.16);
        }

        .status.rejected {
            color: var(--danger);
            background: rgba(213,143,143,.12);
            border: 1px solid rgba(213,143,143,.16);
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .action-btn {
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--silver);
            padding: 8px 11px;
            border-radius: 7px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
            transition: .2s;
        }

        .action-btn:hover {
            background: var(--primary-soft);
            color: var(--primary-light);
            border-color: rgba(198,164,119,.35);
        }

        .action-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 45px 15px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .empty-state i {
            display: block;
            font-size: 38px;
            margin-bottom: 13px;
            color: var(--muted-dark);
        }

        .empty-state strong {
            display: block;
            color: var(--text);
            font-size: 14px;
            margin-bottom: 6px;
        }

        /* TRANSACTION SUMMARY */

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 13px;
        }

        .summary-item {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 17px;
            min-width: 0;
            transition: .2s;
        }

        .summary-item:hover {
            border-color: rgba(198,164,119,.3);
        }

        .summary-item span {
            display: block;
            color: var(--muted);
            font-size: 10px;
            margin-bottom: 8px;
        }

        .summary-item strong {
            font-size: 14px;
            color: var(--primary-light);
            overflow-wrap: anywhere;
        }

        /* MODAL */

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.72);
            backdrop-filter: blur(5px);
            z-index: 200;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 18px;
            overflow-y: auto;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 540px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 26px;
            max-height: calc(100vh - 36px);
            overflow-y: auto;
            box-shadow: 0 20px 70px rgba(0,0,0,.4);
            animation: modalShow .2s ease;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            color: var(--text);
            font-size: 21px;
        }

        .modal-close {
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--silver);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 16px;
            transition: .2s;
        }

        .modal-close:hover {
            color: var(--danger);
            border-color: rgba(213,143,143,.35);
        }

        .receipt-header {
            text-align: center;
            padding: 15px 0 20px;
            border-bottom: 1px dashed rgba(187,196,205,.25);
            margin-bottom: 17px;
        }

        .receipt-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--primary-soft);
            border: 1px solid rgba(198,164,119,.25);
            color: var(--primary-light);
            margin: 0 auto 11px;
            font-size: 22px;
        }

        .receipt-header h4 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--primary-light);
        }

        .receipt-header p {
            font-size: 10px;
            color: var(--muted);
            margin-top: 5px;
        }

        .receipt-detail {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 16px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
        }

        .receipt-row:first-child {
            padding-top: 2px;
        }

        .receipt-row:last-child {
            border-bottom: none;
            padding-bottom: 2px;
        }

        .receipt-row span {
            color: var(--muted);
            flex-shrink: 0;
        }

        .receipt-row strong {
            color: var(--text);
            text-align: right;
            overflow-wrap: anywhere;
        }

        .receipt-total {
            margin-top: 15px;
            padding: 16px;
            background: var(--primary-soft);
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 9px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .receipt-total span {
            font-size: 11px;
            color: var(--muted);
        }

        .receipt-total strong {
            color: var(--primary-light);
            font-size: 17px;
        }

        .rejection-note {
            margin-top: 14px;
            padding: 14px;
            border-radius: 8px;
            background: rgba(213,143,143,.1);
            border: 1px solid rgba(213,143,143,.2);
            color: var(--danger);
            font-size: 11px;
            line-height: 1.7;
        }

        .rejection-note.pending-note {
            background: rgba(155,181,209,.1);
            border-color: rgba(155,181,209,.2);
            color: var(--blue);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            margin-top: 21px;
        }

        .modal-btn {
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--text);
            padding: 11px 17px;
            border-radius: 7px;
            font-size: 11px;
            transition: .2s;
        }

        .modal-btn:hover {
            border-color: rgba(198,164,119,.4);
            color: var(--primary-light);
        }

        .modal-btn.primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #191D22;
            font-weight: 700;
        }

        .modal-btn.primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            color: #191D22;
        }

        /* TOAST */

        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            max-width: calc(100% - 30px);
            width: 350px;
            padding: 16px 18px;
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 12px 35px rgba(0,0,0,.35);
            display: flex;
            align-items: flex-start;
            gap: 11px;
            z-index: 300;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: .25s;
        }

        .toast.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .toast i {
            color: var(--primary-light);
            font-size: 18px;
        }

        .toast strong {
            display: block;
            font-size: 12px;
            margin-bottom: 4px;
            color: var(--text);
        }

        .toast p {
            font-size: 10px;
            color: var(--muted);
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            color: var(--muted-dark);
            font-size: 10px;
            padding: 18px 0 5px;
        }

        /* PRINT */

        @media print {
            @page {
                margin: 15mm;
            }

            body {
                background: white !important;
                color: #222 !important;
            }

            body * {
                visibility: hidden !important;
            }

            #detailModal,
            #detailModal * {
                visibility: visible !important;
            }

            #detailModal {
                position: absolute;
                inset: 0;
                display: block !important;
                background: white !important;
                padding: 0;
                backdrop-filter: none;
            }

            #detailModal .modal {
                max-width: 100%;
                max-height: none;
                box-shadow: none;
                border: none;
                padding: 15px;
                overflow: visible;
                background: white !important;
                color: #222 !important;
            }

            #detailModal .modal-header,
            #detailModal .modal-actions {
                display: none !important;
            }

            .receipt-header h4,
            .receipt-row strong,
            .receipt-total strong {
                color: #222 !important;
            }

            .receipt-header p,
            .receipt-row span,
            .receipt-total span {
                color: #555 !important;
            }

            .receipt-detail,
            .receipt-total {
                background: white !important;
                border: 1px solid #ddd !important;
            }

            .receipt-logo {
                background: #eee !important;
                color: #333 !important;
                border: 1px solid #ddd !important;
            }

            .receipt-row {
                border-bottom: 1px solid #ddd !important;
            }

            .rejection-note {
                color: #333 !important;
                background: #f5f5f5 !important;
                border: 1px solid #ddd !important;
            }
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1000px) {
            .content {
                padding: 28px 24px;
            }

            .topbar {
                padding: 0 24px;
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 15px 0 40px rgba(0,0,0,.35);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.65);
                z-index: 90;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .topbar {
                padding: 0 25px;
            }
        }

        @media (max-width: 580px) {
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

            .page-heading h1 {
                font-size: 24px;
            }

            .page-heading p {
                font-size: 12px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 11px;
            }

            .stat-card {
                padding: 17px;
            }

            .stat-card h3 {
                font-size: 20px;
            }

            .panel {
                padding: 17px;
            }

            .panel-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .filter-row {
                align-items: stretch;
                flex-direction: column;
            }

            .filter-left,
            .filter-right {
                width: 100%;
            }

            .search-box {
                width: 100%;
            }

            .filter-select {
                flex: 1;
                min-width: 0;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .modal {
                padding: 19px;
            }

            .modal-actions {
                flex-direction: column-reverse;
            }

            .modal-btn {
                width: 100%;
            }

            .toast {
                right: 15px;
                bottom: 15px;
            }
        }

        @media (max-width: 360px) {
            .content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .panel {
                padding: 14px;
            }

            .stat-card {
                padding: 15px;
            }

            .receipt-row {
                font-size: 10px;
            }

            .receipt-total strong {
                font-size: 14px;
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
            </div>
        </div>

        <div class="menu-label">MENU PENGHUNI</div>

        <nav class="menu" aria-label="Navigasi penghuni">

            <a href="{{ route('penghuni.dashboard') }}">
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

            <a href="{{ route('penghuni.riwayat.index') }}" class="active" aria-current="page">
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
                <div class="user-avatar">{{ $akunInfo['inisial'] ?? 'P' }}</div>

                <div>
                    <strong>{{ $akunInfo['nama'] ?? auth()->user()?->name ?? 'Penghuni' }}</strong>
                    <small>Penghuni KosHaven</small>
                </div>
            </div>

            <div class="logout-component-wrapper">
                @include('components.logout-modal')
            </div>

        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button
                    class="menu-toggle"
                    id="menuToggle"
                    type="button"
                    aria-label="Buka menu"
                    aria-expanded="false"
                    aria-controls="sidebar"
                >
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h2>Riwayat Pembayaran</h2>
                    <p>Pantau seluruh transaksi pembayaran kos</p>
                </div>

            </div>

            <button
                class="notification"
                type="button"
                onclick="showNotification()"
                aria-label="Notifikasi"
            >
                <i class="bi bi-bell"></i>
                <span></span>
            </button>

        </header>

        <div class="content">

            <!-- PAGE HEADING -->
            <section class="page-heading">
                <div>
                    <h1>Riwayat Pembayaran</h1>
                    <p>
                        Lihat seluruh transaksi pembayaran sewa kos beserta status
                        dan detail pembayarannya.
                    </p>
                </div>
            </section>

            <!-- STATISTICS -->
            <section class="stats-grid">

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>

                    <span>Total Transaksi</span>
                    <h3 id="totalTransactions">0</h3>
                    <small>Jumlah transaksi yang tercatat</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>

                    <span>Pembayaran Berhasil</span>
                    <h3 id="successfulPayments">Rp0</h3>
                    <small>Total pembayaran berstatus lunas</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>

                    <span>Menunggu Konfirmasi</span>
                    <h3 id="pendingPayments">0</h3>
                    <small>Transaksi yang sedang diperiksa</small>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>

                    <span>Pembayaran Ditolak</span>
                    <h3 id="rejectedPayments">0</h3>
                    <small>Transaksi yang perlu diperiksa kembali</small>
                </div>

            </section>

            <!-- INFORMATION -->
            <div class="info-box">
                <i class="bi bi-info-circle-fill"></i>

                <div>
                    <strong>Informasi Riwayat Pembayaran</strong>
                    <p>
                        Riwayat pembayaran akan diperbarui sesuai status pemeriksaan
                        petugas. Transaksi yang berstatus Lunas dapat dicetak sebagai
                        bukti pembayaran.
                    </p>
                </div>
            </div>

            <!-- HISTORY TABLE -->
            <section class="panel">

                <div class="panel-heading">
                    <div>
                        <h3>Daftar Transaksi</h3>
                        <p>Seluruh transaksi pembayaran yang pernah kamu lakukan.</p>
                    </div>
                </div>

                <div class="filter-row">

                    <div class="filter-left">
                        <div class="search-box">
                            <i class="bi bi-search"></i>

                            <input
                                type="search"
                                id="searchTransaction"
                                placeholder="Cari periode atau metode..."
                                aria-label="Cari transaksi"
                            >
                        </div>
                    </div>

                    <div class="filter-right">

                        <select class="filter-select" id="statusFilter" aria-label="Filter status">
                            <option value="all">Semua Status</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>

                        <select class="filter-select" id="monthFilter" aria-label="Filter bulan">
                            <option value="all">Semua Bulan</option>
                            <option value="2026-11">November 2026</option>
                            <option value="2026-10">Oktober 2026</option>
                            <option value="2026-09">September 2026</option>
                            <option value="2026-08">Agustus 2026</option>
                        </select>

                    </div>

                </div>

                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Periode Tagihan</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="transactionTableBody"></tbody>
                    </table>

                </div>

            </section>

            <!-- SUMMARY -->
            <section class="panel">

                <div class="panel-heading">
                    <div>
                        <h3>Informasi Akun Pembayaran</h3>
                        <p>Informasi penghuni yang tercatat pada transaksi pembayaran.</p>
                    </div>
                </div>

                <div class="summary-grid">

                    <div class="summary-item">
                        <span>Nama Penghuni</span>
                        <strong>{{ $akunInfo['nama'] ?? auth()->user()?->name ?? 'Penghuni' }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>Nomor Kamar</span>
                        <strong>{{ $akunInfo['nomor_kamar'] ?? 'Belum ada kamar' }}</strong>
                    </div>

                    <div class="summary-item">
                        <span>Biaya Sewa Bulanan</span>
                        <strong>Rp {{ number_format((int) ($akunInfo['biaya_sewa'] ?? 0), 0, ',', '.') }}</strong>
                    </div>

                </div>

            </section>

            <footer class="footer">
                © 2026 KosHaven. Sistem Manajemen Kos.
            </footer>

        </div>

    </main>

    <!-- DETAIL TRANSACTION MODAL -->
    <div
        class="modal-overlay"
        id="detailModal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="detailTitle"
        aria-hidden="true"
    >

        <div class="modal">

            <div class="modal-header">
                <h3 id="detailTitle">Detail Transaksi</h3>

                <button
                    class="modal-close"
                    type="button"
                    onclick="closeModal()"
                    aria-label="Tutup"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div id="receiptContent">

                <div class="receipt-header">
                    <div class="receipt-logo">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>

                    <h4>KosHaven.</h4>
                    <p>Bukti Riwayat Pembayaran Kos</p>
                </div>

                <div class="receipt-detail" id="receiptDetail"></div>

                <div class="receipt-total">
                    <span>Total Pembayaran</span>
                    <strong id="receiptTotal">Rp0</strong>
                </div>

                <div id="rejectionContainer"></div>

            </div>

            <div class="modal-actions">

                <button class="modal-btn" type="button" onclick="closeModal()">
                    Tutup
                </button>

                <button
                    class="modal-btn primary"
                    type="button"
                    id="printButton"
                    onclick="printReceipt()"
                >
                    <i class="bi bi-receipt-cutoff"></i>
                    Lihat Kuitansi
                </button>

            </div>

        </div>

    </div>

    <!-- TOAST -->
    <div class="toast" id="toast" role="status" aria-live="polite">
        <i class="bi bi-check-circle-fill"></i>

        <div>
            <strong id="toastTitle">Informasi</strong>
            <p id="toastMessage">Tidak ada informasi baru.</p>
        </div>
    </div>

    <script>
        /* ==========================================
           SIDEBAR
        ========================================== */

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');

        function openSidebar() {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.classList.add('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Tutup menu');
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('sidebar-open');

            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Buka menu');
        }

        menuToggle.addEventListener('click', function () {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        sidebarOverlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.menu a').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 850) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 850) {
                closeSidebar();
            }
        });

        /* ==========================================
           KEYBOARD
        ========================================== */

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const logoutModal = document.getElementById('khLogoutModal');

                // Biarkan komponen logout menangani Escape sendiri.
                if (logoutModal && logoutModal.classList.contains('is-visible')) {
                    return;
                }

                closeSidebar();
                closeModal();
            }

            if (event.key === 'Tab' && detailModal.classList.contains('show')) {
                const focusable = detailModal.querySelectorAll(
                    'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled])'
                );

                if (!focusable.length) return;

                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        /* ==========================================
           TOAST
        ========================================== */

        let toastTimer;

        function showToast(title, message) {
            const toast = document.getElementById('toast');

            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            toast.classList.add('show');

            clearTimeout(toastTimer);

            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3500);
        }

        function showNotification() {
            showToast('Informasi', 'Belum ada notifikasi baru.');
        }

        /* ==========================================
           DATA TRANSAKSI DARI BACKEND LARAVEL
        ========================================== */

        const akunInfo = @json($akunInfo ?? ['nama' => auth()->user()?->name ?? 'Penghuni', 'nomor_kamar' => 'Belum ada kamar', 'biaya_sewa' => 0]);
        let bills = @json($transactions ?? []);

        /* ==========================================
           FORMAT DATA
        ========================================== */

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(Number(number) || 0);
        }

        function formatDate(dateString) {
            if (!dateString) return '-';

            const date = new Date(dateString + 'T00:00:00');

            if (Number.isNaN(date.getTime())) {
                return '-';
            }

            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        function escapeHTML(value) {
            return String(value ?? '').replace(/[&<>"']/g, character => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[character]);
        }

        function getStatusClass(status) {
            const classes = {
                'Lunas': 'paid',
                'Menunggu Konfirmasi': 'waiting',
                'Ditolak': 'rejected'
            };

            return classes[status] || 'waiting';
        }

        function getMethodIcon(method) {
            if (method === 'Transfer Bank') {
                return 'bi-bank';
            }

            if (method === 'Tunai') {
                return 'bi-cash-stack';
            }

            return 'bi-wallet2';
        }

        function isTransaction(bill) {
            return [
                'Lunas',
                'Menunggu Konfirmasi',
                'Ditolak'
            ].includes(bill.status);
        }

        /* ==========================================
           STATISTICS
        ========================================== */

        function renderStatistics() {
            const transactions = bills.filter(isTransaction);

            const successful = transactions
                .filter(bill => bill.status === 'Lunas')
                .reduce((total, bill) => total + Number(bill.amount), 0);

            const pending = transactions
                .filter(bill => bill.status === 'Menunggu Konfirmasi')
                .length;

            const rejected = transactions
                .filter(bill => bill.status === 'Ditolak')
                .length;

            document.getElementById('totalTransactions').textContent =
                transactions.length;

            document.getElementById('successfulPayments').textContent =
                formatRupiah(successful);

            document.getElementById('pendingPayments').textContent =
                pending;

            document.getElementById('rejectedPayments').textContent =
                rejected;
        }

        /* ==========================================
           RENDER TABLE
        ========================================== */

        function renderTransactions() {
            const tableBody = document.getElementById('transactionTableBody');

            const search = document
                .getElementById('searchTransaction')
                .value
                .toLowerCase()
                .trim();

            const statusFilter = document.getElementById('statusFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;

            const transactions = bills
                .filter(isTransaction)
                .filter(bill => {
                    const searchText = [
                        bill.period,
                        bill.paymentMethod,
                        bill.proofName
                    ].join(' ').toLowerCase();

                    const matchesSearch = searchText.includes(search);

                    const matchesStatus =
                        statusFilter === 'all' ||
                        bill.status === statusFilter;

                    const matchesMonth =
                        monthFilter === 'all' ||
                        bill.month === monthFilter;

                    return matchesSearch && matchesStatus && matchesMonth;
                })
                .sort((a, b) => {
                    const dateA = a.paymentDate || '';
                    const dateB = b.paymentDate || '';

                    return dateB.localeCompare(dateA);
                });

            if (transactions.length === 0) {
                const hasAnyTransaction = bills.some(isTransaction);

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="bi bi-receipt"></i>

                                <strong>
                                    ${hasAnyTransaction
                                        ? 'Transaksi tidak ditemukan'
                                        : 'Belum Ada Riwayat Pembayaran'}
                                </strong>

                                <span>
                                    ${hasAnyTransaction
                                        ? 'Coba ubah kata kunci atau filter pencarian.'
                                        : 'Transaksi pembayaranmu akan muncul di halaman ini setelah pembayaran dikirim.'}
                                </span>
                            </div>
                        </td>
                    </tr>
                `;

                return;
            }

            tableBody.innerHTML = transactions.map((bill, index) => {
                const status = bill.status;

                return `
                    <tr>
                        <td>${index + 1}</td>

                        <td>
                            <div class="transaction-period">
                                <strong>${escapeHTML(bill.period)}</strong>
                                <small>Kamar ${escapeHTML(bill.room || akunInfo.nomor_kamar || '-')}</small>
                            </div>
                        </td>

                        <td>${formatDate(bill.paymentDate)}</td>

                        <td class="amount">
                            ${formatRupiah(bill.amount)}
                        </td>

                        <td>
                            <div class="method">
                                <i class="bi ${getMethodIcon(bill.paymentMethod)}"></i>
                                ${escapeHTML(bill.paymentMethod || '-')}
                            </div>
                        </td>

                        <td>
                            <span class="status ${getStatusClass(status)}">
                                ${status === 'Lunas'
                                    ? '<i class="bi bi-check-circle"></i>'
                                    : status === 'Ditolak'
                                        ? '<i class="bi bi-x-circle"></i>'
                                        : '<i class="bi bi-clock"></i>'}
                                ${escapeHTML(status)}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <button
                                    class="action-btn"
                                    type="button"
                                    onclick="showDetail(${Number(bill.id)})"
                                    aria-label="Lihat detail transaksi ${escapeHTML(bill.period)}"
                                >
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        /* ==========================================
           DETAIL TRANSACTION
        ========================================== */

        let selectedTransaction = null;
        let lastFocusedElement = null;

        function showDetail(id) {
            const bill = bills.find(item => Number(item.id) === Number(id));

            if (!bill || !isTransaction(bill)) {
                showToast('Data tidak ditemukan', 'Transaksi tidak tersedia.');
                return;
            }

            selectedTransaction = bill;

            document.getElementById('receiptDetail').innerHTML = `
                <div class="receipt-row">
                    <span>Nomor Transaksi</span>
                    <strong>${escapeHTML(bill.invoiceNumber || ('KH-' + String(bill.id).padStart(5, '0')))}</strong>
                </div>

                <div class="receipt-row">
                    <span>Nama Penghuni</span>
                    <strong>${escapeHTML(akunInfo.nama || 'Penghuni')}</strong>
                </div>

                <div class="receipt-row">
                    <span>Nomor Kamar</span>
                    <strong>${escapeHTML(bill.room || akunInfo.nomor_kamar || '-')}</strong>
                </div>

                <div class="receipt-row">
                    <span>Periode Tagihan</span>
                    <strong>${escapeHTML(bill.period)}</strong>
                </div>

                <div class="receipt-row">
                    <span>Tanggal Pembayaran</span>
                    <strong>${formatDate(bill.paymentDate)}</strong>
                </div>

                <div class="receipt-row">
                    <span>Metode Pembayaran</span>
                    <strong>${escapeHTML(bill.paymentMethod || '-')}</strong>
                </div>

                <div class="receipt-row">
                    <span>Bukti Pembayaran</span>
                    <strong>${bill.proofUrl
                        ? `<a href="${escapeHTML(bill.proofUrl)}" target="_blank" rel="noopener noreferrer" style="color:var(--gold-light);text-decoration:underline;">Lihat Bukti <i class="bi bi-box-arrow-up-right"></i></a>`
                        : 'Tidak tersedia'}</strong>
                </div>

                <div class="receipt-row">
                    <span>Status Transaksi</span>
                    <strong>${escapeHTML(bill.status)}</strong>
                </div>

                ${bill.receiptNumber ? `
                    <div class="receipt-row">
                        <span>Nomor Kuitansi</span>
                        <strong>${escapeHTML(bill.receiptNumber)}</strong>
                    </div>
                ` : ''}

                ${bill.verifikator ? `
                    <div class="receipt-row">
                        <span>Diverifikasi Oleh</span>
                        <strong>${escapeHTML(bill.verifikator)}</strong>
                    </div>
                ` : ''}

                ${bill.note ? `
                    <div class="receipt-row">
                        <span>Catatan</span>
                        <strong>${escapeHTML(bill.note)}</strong>
                    </div>
                ` : ''}
            `;

            document.getElementById('receiptTotal').textContent =
                formatRupiah(bill.amount);

            const rejectionContainer =
                document.getElementById('rejectionContainer');

            if (bill.status === 'Ditolak') {
                rejectionContainer.innerHTML = `
                    <div class="rejection-note">
                        <strong>Informasi Penolakan</strong><br>
                        ${escapeHTML(
                            bill.rejectionReason ||
                            'Pembayaran belum disetujui. Silakan periksa kembali tagihan.'
                        )}
                    </div>
                `;
            } else if (bill.status === 'Menunggu Konfirmasi') {
                rejectionContainer.innerHTML = `
                    <div class="rejection-note pending-note">
                        Pembayaran sedang menunggu pemeriksaan petugas.
                        Bukti ini belum menjadi tanda pembayaran lunas.
                    </div>
                `;
            } else {
                rejectionContainer.innerHTML = '';
            }

            const printButton = document.getElementById('printButton');

            printButton.style.display =
                bill.status === 'Lunas' ? 'inline-flex' : 'none';

            openModal();
        }

        /* ==========================================
           MODAL CONTROL
        ========================================== */

        const detailModal = document.getElementById('detailModal');

        function openModal() {
            lastFocusedElement = document.activeElement;

            detailModal.classList.add('show');
            detailModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');

            detailModal.querySelector('.modal-close').focus();
        }

        function closeModal() {
            if (!detailModal.classList.contains('show')) return;

            detailModal.classList.remove('show');
            detailModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');

            if (
                lastFocusedElement &&
                typeof lastFocusedElement.focus === 'function'
            ) {
                lastFocusedElement.focus();
            }
        }

        detailModal.addEventListener('click', function (event) {
            if (event.target === detailModal) {
                closeModal();
            }
        });

        /* ==========================================
           PRINT RECEIPT
        ========================================== */

        function printReceipt() {
            if (!selectedTransaction) {
                showToast('Gagal membuka kuitansi', 'Data transaksi tidak ditemukan.');
                return;
            }

            if (selectedTransaction.status !== 'Lunas' || !selectedTransaction.receiptUrl) {
                showToast(
                    'Kuitansi belum tersedia',
                    'Kuitansi terbit setelah pembayaran diverifikasi petugas.'
                );
                return;
            }

            window.open(selectedTransaction.receiptUrl, '_blank', 'noopener');
        }

        /* ==========================================
           FILTER EVENTS
        ========================================== */

        document
            .getElementById('searchTransaction')
            .addEventListener('input', renderTransactions);

        document
            .getElementById('statusFilter')
            .addEventListener('change', renderTransactions);

        document
            .getElementById('monthFilter')
            .addEventListener('change', renderTransactions);

        /* ==========================================
           INITIALIZE
        ========================================== */

        function renderAll() {
            renderStatistics();
            renderTransactions();
        }

        renderAll();

        /*
         * Memperbarui tampilan jika data tagihan berubah
         * dari tab browser lain.
         */
        window.addEventListener('storage', function (event) {
            if (event.key === STORAGE_KEY) {
                bills = getBills();
                renderAll();
            }
        });

    </script>

</body>
</html>
