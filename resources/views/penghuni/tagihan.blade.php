
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tagihan Bulanan - KosHaven</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        button, input, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            padding: 27px 18px 20px;
            background: #12161B;
            border-right: 1px solid var(--border);
            transition: transform .3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 9px;
            margin-bottom: 43px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            color: #191D22;
            background: var(--primary);
            font-size: 21px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .brand-name span {
            color: var(--primary);
        }

        .nav-label {
            padding: 0 11px;
            margin: 0 0 13px;
            color: var(--muted-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 7px;
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
            transition: .2s ease;
        }

        .nav-link i {
            width: 19px;
            font-size: 17px;
        }

        .nav-link:hover {
            color: var(--text);
            background: rgba(255,255,255,.045);
        }

        .nav-link.active {
            color: var(--primary-light);
            background: var(--primary-soft);
            font-weight: 600;
        }

        .nav-link.active i {
            color: var(--primary);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 8px 3px;
        }

        .avatar {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--primary-light);
            background: var(--surface-3);
            font-weight: 700;
        }

        .profile-info {
            min-width: 0;
        }

        .profile-info strong {
            display: block;
            overflow: hidden;
            color: var(--text);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-info span {
            color: var(--muted-dark);
            font-size: 11px;
        }

        .main {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .topbar {
            height: 76px;
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 38px;
            background: rgba(25,29,34,.91);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(15px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-context small {
            display: block;
            margin-bottom: 3px;
            color: var(--muted-dark);
            font-size: 11px;
        }

        .page-context strong {
            font-size: 14px;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-date {
            color: var(--muted);
            font-size: 12px;
        }

        .mobile-menu {
            display: none;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            background: var(--surface);
            font-size: 19px;
        }

        .content {
            width: 100%;
            max-width: 1500px;
            padding: 35px 38px 50px;
            margin: 0 auto;
        }

        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 27px;
        }

        .eyebrow {
            margin-bottom: 9px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .page-heading h1 {
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
            font-size: clamp(27px, 3vw, 35px);
            font-weight: 600;
            letter-spacing: -.6px;
        }

        .page-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .heading-icon {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border: 1px solid rgba(198,164,119,.23);
            border-radius: 14px;
            color: var(--primary);
            background: var(--primary-soft);
            font-size: 21px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 25px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            padding: 21px 22px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .summary-card::after {
            width: 95px;
            height: 95px;
            position: absolute;
            right: -28px;
            bottom: -39px;
            border: 1px solid rgba(198,164,119,.12);
            border-radius: 50%;
            content: "";
        }

        .summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 17px;
        }

        .summary-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
        }

        .summary-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            color: var(--primary);
            background: var(--primary-soft);
            font-size: 16px;
        }

        .summary-value {
            margin-bottom: 5px;
            font-size: clamp(19px, 2vw, 25px);
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .summary-note {
            color: var(--muted-dark);
            font-size: 11px;
        }

        .notice {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 16px 18px;
            margin-bottom: 25px;
            border: 1px solid rgba(155,181,209,.18);
            border-radius: 11px;
            background: rgba(155,181,209,.07);
        }

        .notice i {
            margin-top: 1px;
            color: var(--blue);
            font-size: 18px;
        }

        .notice strong {
            display: block;
            margin-bottom: 4px;
            color: var(--text);
            font-size: 12px;
        }

        .notice p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .panel {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 21px 23px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 600;
        }

        .panel-subtitle {
            margin-top: 5px;
            color: var(--muted-dark);
            font-size: 11px;
        }

        .filter-area {
            display: grid;
            grid-template-columns: minmax(190px, 1.5fr) minmax(145px, .8fr) minmax(145px, .8fr);
            gap: 11px;
            padding: 17px 23px;
            border-bottom: 1px solid var(--border);
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 13px;
            color: var(--muted-dark);
            transform: translateY(-50%);
        }

        .form-control {
            width: 100%;
            height: 41px;
            padding: 0 13px;
            outline: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            background: var(--surface-2);
            font-size: 12px;
            transition: border .2s ease;
        }

        .search-box .form-control {
            padding-left: 37px;
        }

        .form-control:focus {
            border-color: rgba(198,164,119,.65);
        }

        .form-control::placeholder {
            color: var(--muted-dark);
        }

        select.form-control {
            color-scheme: dark;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .bill-table {
            width: 100%;
            min-width: 690px;
            border-collapse: collapse;
        }

        .bill-table th {
            padding: 14px 18px;
            color: var(--muted-dark);
            background: rgba(255,255,255,.018);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .7px;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .bill-table td {
            padding: 16px 18px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            vertical-align: middle;
        }

        .bill-table tbody tr {
            transition: background .2s ease;
        }

        .bill-table tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        .bill-month {
            color: var(--text);
            font-weight: 600;
        }

        .bill-code {
            display: block;
            margin-top: 4px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        .bill-amount {
            color: var(--text);
            font-weight: 700;
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            content: "";
        }

        .status-paid {
            color: var(--green);
            background: rgba(145,174,155,.12);
        }

        .status-pending {
            color: var(--yellow);
            background: rgba(217,183,127,.12);
        }

        .status-overdue {
            color: var(--danger);
            background: rgba(213,143,143,.12);
        }

        .status-unknown {
            color: var(--silver);
            background: rgba(187,196,205,.10);
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 11px;
            border: 1px solid rgba(198,164,119,.3);
            border-radius: 7px;
            color: var(--primary-light);
            background: var(--primary-soft);
            font-size: 11px;
            font-weight: 600;
            transition: .2s ease;
        }

        .btn-detail:hover {
            border-color: var(--primary);
            background: rgba(198,164,119,.2);
        }

        .empty-state {
            padding: 55px 20px !important;
            color: var(--muted-dark) !important;
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 12px;
            color: var(--primary);
            font-size: 31px;
        }

        .empty-state strong {
            display: block;
            margin-bottom: 5px;
            color: var(--text);
            font-size: 13px;
        }

        .empty-state span {
            font-size: 11px;
        }

        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 22px;
            border-top: 1px solid var(--border);
        }

        .table-count {
            color: var(--muted-dark);
            font-size: 11px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--muted);
            background: var(--surface-2);
            font-size: 11px;
        }

        .page-btn.active {
            border-color: var(--primary);
            color: #191D22;
            background: var(--primary);
            font-weight: 700;
        }

        .page-btn:disabled {
            cursor: not-allowed;
            opacity: .4;
        }

        .overlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgba(0,0,0,.68);
            backdrop-filter: blur(5px);
        }

        .overlay.show {
            display: flex;
        }

        .modal {
            width: 100%;
            max-width: 490px;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: var(--surface);
            box-shadow: 0 25px 70px rgba(0,0,0,.4);
            animation: modalIn .2s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 600;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
            background: var(--surface-2);
            font-size: 17px;
        }

        .modal-body {
            padding: 22px;
        }

        .detail-highlight {
            padding: 17px;
            margin-bottom: 18px;
            border: 1px solid rgba(198,164,119,.2);
            border-radius: 10px;
            background: var(--primary-soft);
            text-align: center;
        }

        .detail-highlight span {
            display: block;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 11px;
        }

        .detail-highlight strong {
            color: var(--primary-light);
            font-size: 25px;
            font-weight: 700;
        }

        .detail-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .detail-row span {
            color: var(--muted);
        }

        .detail-row strong {
            color: var(--text);
            text-align: right;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 16px 22px;
            border-top: 1px solid var(--border);
        }

        .btn {
            min-height: 39px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s ease;
        }

        .btn-primary {
            color: #191D22;
            background: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-secondary {
            border-color: var(--border);
            color: var(--muted);
            background: var(--surface-2);
        }

        .btn-secondary:hover {
            color: var(--text);
            background: var(--surface-3);
        }

        .method-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 13px;
        }

        .method-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface-2);
        }

        .method-item i {
            color: var(--primary);
            font-size: 19px;
        }

        .method-item strong {
            display: block;
            margin-bottom: 3px;
            color: var(--text);
            font-size: 12px;
        }

        .method-item small {
            color: var(--muted-dark);
            font-size: 10px;
        }

        .payment-warning {
            padding: 12px;
            margin-top: 15px;
            border: 1px solid rgba(217,183,127,.2);
            border-radius: 8px;
            color: var(--yellow);
            background: rgba(217,183,127,.07);
            font-size: 11px;
            line-height: 1.6;
        }

        .btn-disabled {
            cursor: not-allowed;
            opacity: .45;
        }

        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 300;
            max-width: calc(100vw - 40px);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 17px;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            background: var(--surface-2);
            box-shadow: var(--shadow);
            font-size: 12px;
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: .25s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast i {
            color: var(--primary);
            font-size: 17px;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 1100px) {
            .content {
                padding-right: 25px;
                padding-left: 25px;
            }

            .topbar {
                padding-right: 25px;
                padding-left: 25px;
            }

            .summary-card {
                padding: 18px;
            }
        }

        @media (max-width: 850px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-backdrop.show {
                position: fixed;
                inset: 0;
                z-index: 90;
                display: block;
                background: rgba(0,0,0,.55);
            }

            .main {
                margin-left: 0;
            }

            .mobile-menu {
                display: inline-flex;
            }

            .summary-grid {
                gap: 12px;
            }

            .filter-area {
                grid-template-columns: 1fr 1fr;
            }

            .search-box {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 580px) {
            .topbar {
                height: 65px;
                padding: 0 17px;
            }

            .topbar-date {
                display: none;
            }

            .content {
                padding: 26px 16px 35px;
            }

            .page-heading {
                margin-bottom: 21px;
            }

            .page-heading h1 {
                font-size: 27px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .summary-card {
                padding: 16px 18px;
            }

            .summary-top {
                margin-bottom: 10px;
            }

            .summary-value {
                font-size: 22px;
            }

            .panel-header {
                align-items: flex-start;
                padding: 18px;
            }

            .filter-area {
                grid-template-columns: 1fr;
                padding: 15px 17px;
            }

            .search-box {
                grid-column: auto;
            }

            .table-footer {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 17px;
            }

            .pagination {
                align-self: flex-end;
            }

            .notice {
                padding: 13px;
            }

            .overlay {
                align-items: flex-end;
                padding: 0;
            }

            .modal {
                max-width: 100%;
                max-height: 88vh;
                border-radius: 16px 16px 0 0;
            }

            .toast {
                right: 15px;
                bottom: 15px;
            }
        }

        @media (max-width: 360px) {
            .content {
                padding-right: 12px;
                padding-left: 12px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .heading-icon {
                width: 40px;
                height: 40px;
            }

            .topbar {
                padding-right: 12px;
                padding-left: 12px;
            }

            .modal-body {
                padding: 17px;
            }

            .modal-header,
            .modal-footer {
                padding-right: 17px;
                padding-left: 17px;
            }
        }
    </style>
</head>

<body>

@php
    /*
    |--------------------------------------------------------------------------
    | Menyiapkan data tagihan dari Controller
    |--------------------------------------------------------------------------
    | Menggunakan beberapa alternatif nama kolom agar tampilan tetap
    | kompatibel dengan struktur model tagihan yang umum digunakan.
    */

    $daftarTagihan = collect($tagihans ?? [])->map(function ($item, $index) {
        $jumlah = data_get($item, 'jumlah')
            ?? data_get($item, 'total')
            ?? data_get($item, 'nominal')
            ?? data_get($item, 'jumlah_tagihan')
            ?? 0;

        $tanggalJatuhTempo = data_get($item, 'tanggal_jatuh_tempo')
            ?? data_get($item, 'jatuh_tempo')
            ?? data_get($item, 'tanggal_tempo');

        $tanggalBayar = data_get($item, 'tanggal_bayar');

        $statusAsli = strtolower(trim((string) (
            data_get($item, 'status') ?? 'belum dibayar'
        )));

        if (in_array($statusAsli, ['lunas', 'dibayar', 'paid', 'success', 'berhasil'])) {
            $status = 'lunas';
        } elseif (in_array($statusAsli, ['terlambat', 'overdue', 'telat'])) {
            $status = 'terlambat';
        } else {
            $status = 'belum dibayar';

            if ($tanggalJatuhTempo && strtotime($tanggalJatuhTempo) < strtotime(date('Y-m-d'))) {
                $status = 'terlambat';
            }
        }

        $bulan = data_get($item, 'bulan')
            ?? data_get($item, 'periode')
            ?? null;

        $tahun = data_get($item, 'tahun')
            ?? null;

        if (!$bulan && $tanggalJatuhTempo) {
            $bulan = date('F', strtotime($tanggalJatuhTempo));
        }

        if (!$tahun && $tanggalJatuhTempo) {
            $tahun = date('Y', strtotime($tanggalJatuhTempo));
        }

        return [
            'id' => data_get($item, 'id', $index + 1),
            'kode' => data_get($item, 'kode_tagihan')
                ?? data_get($item, 'nomor_tagihan')
                ?? ('TAG-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)),
            'bulan' => $bulan ?: '-',
            'tahun' => $tahun ?: '',
            'jumlah' => (float) $jumlah,
            'jatuh_tempo' => $tanggalJatuhTempo,
            'tanggal_bayar' => $tanggalBayar,
            'status' => $status,
            'keterangan' => data_get($item, 'keterangan') ?? '-',
            'metode' => data_get($item, 'metode_pembayaran')
                ?? data_get($item, 'metode')
                ?? '-',
        ];
    });

    $totalTagihan = $daftarTagihan->sum('jumlah');
    $totalLunas = $daftarTagihan->where('status', 'lunas')->sum('jumlah');
    $totalBelumLunas = $daftarTagihan
        ->whereIn('status', ['belum dibayar', 'terlambat'])
        ->sum('jumlah');

    $jumlahBelumLunas = $daftarTagihan
        ->whereIn('status', ['belum dibayar', 'terlambat'])
        ->count();

    $tagihanJson = $daftarTagihan->values();
@endphp


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

        <a href="{{ route('penghuni.tagihan.index') }}" class="nav-link active" aria-current="page">
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
        <a href="{{ route('penghuni.profil.index') }}" class="nav-link" data-page-transition>
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

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<main class="main">
    <header class="topbar">
        <div class="topbar-left">
            <button class="mobile-menu" id="mobileMenu" type="button" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="page-context">
                <small>Area Penghuni</small>
                <strong>Tagihan Bulanan</strong>
            </div>
        </div>

        <div class="topbar-right">
            <span class="topbar-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </header>

    <section class="content">

        <div class="page-heading">
            <div>
                <div class="eyebrow">Informasi Keuangan</div>
                <h1>Tagihan Bulanan</h1>
                <p>
                    Pantau tagihan sewa kos dan informasi pembayaran bulanan
                    Anda melalui halaman ini.
                </p>
            </div>

            <div class="heading-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-top">
                    <span class="summary-label">Total Tagihan</span>
                    <div class="summary-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                </div>

                <div class="summary-note">Akumulasi seluruh tagihan Anda</div>
            </div>

            <div class="summary-card">
                <div class="summary-top">
                    <span class="summary-label">Sudah Dibayar</span>
                    <div class="summary-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalLunas, 0, ',', '.') }}
                </div>

                <div class="summary-note">Total tagihan yang telah lunas</div>
            </div>

            <div class="summary-card">
                <div class="summary-top">
                    <span class="summary-label">Belum Dibayar</span>
                    <div class="summary-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}
                </div>

                <div class="summary-note">
                    {{ $jumlahBelumLunas }} tagihan masih perlu diselesaikan
                </div>
            </div>
        </div>

        <div class="notice">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <strong>Informasi Pembayaran</strong>
                <p>
                    Silakan periksa nominal dan tanggal jatuh tempo pada setiap
                    tagihan. Pastikan pembayaran dilakukan sesuai informasi
                    yang diberikan oleh pengelola kos.
                </p>
            </div>
        </div>

        <section class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Daftar Tagihan</div>
                    <div class="panel-subtitle">
                        Informasi seluruh tagihan bulanan Anda
                    </div>
                </div>
            </div>

            <div class="filter-area">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        class="form-control"
                        id="searchInput"
                        placeholder="Cari tagihan atau bulan..."
                        autocomplete="off"
                    >
                </div>

                <select class="form-control" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="belum dibayar">Belum Dibayar</option>
                    <option value="terlambat">Terlambat</option>
                </select>

                <select class="form-control" id="monthFilter">
                    <option value="">Semua Bulan</option>
                    @foreach ($daftarTagihan->pluck('bulan')->filter()->unique() as $bulan)
                        <option value="{{ strtolower($bulan) }}">
                            {{ $bulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="table-wrap">
                <table class="bill-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Periode Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="billTableBody">
                        @forelse ($daftarTagihan as $index => $tagihan)
                            <tr
                                class="bill-row"
                                data-id="{{ $tagihan['id'] }}"
                                data-code="{{ strtolower($tagihan['kode']) }}"
                                data-month="{{ strtolower($tagihan['bulan']) }}"
                                data-status="{{ $tagihan['status'] }}"
                            >
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <span class="bill-month">
                                        {{ $tagihan['bulan'] }} {{ $tagihan['tahun'] }}
                                    </span>
                                    <span class="bill-code">
                                        {{ $tagihan['kode'] }}
                                    </span>
                                </td>

                                <td>
                                    <span class="bill-amount">
                                        Rp {{ number_format($tagihan['jumlah'], 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    {{ $tagihan['jatuh_tempo']
                                        ? \Carbon\Carbon::parse($tagihan['jatuh_tempo'])->translatedFormat('d F Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if ($tagihan['status'] === 'lunas')
                                        <span class="status status-paid">Lunas</span>
                                    @elseif ($tagihan['status'] === 'terlambat')
                                        <span class="status status-overdue">Terlambat</span>
                                    @else
                                        <span class="status status-pending">Belum Dibayar</span>
                                    @endif
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn-detail"
                                        onclick="showDetail({{ $index }})"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-receipt"></i>
                                    <strong>Belum Ada Tagihan</strong>
                                    <span>Tagihan bulanan Anda akan ditampilkan di sini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="table-count" id="tableCount">
                    Menampilkan {{ $daftarTagihan->count() }} tagihan
                </div>

                <div class="pagination" id="pagination"></div>
            </div>
        </section>

    </section>
</main>

<!-- MODAL DETAIL TAGIHAN -->
<div class="overlay" id="detailModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Detail Tagihan</h3>
            <button class="modal-close" type="button" onclick="closeModal('detailModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="modal-body">
            <div class="detail-highlight">
                <span>Total Tagihan</span>
                <strong id="detailAmount">Rp 0</strong>
            </div>

            <div class="detail-list">
                <div class="detail-row">
                    <span>Kode Tagihan</span>
                    <strong id="detailCode">-</strong>
                </div>

                <div class="detail-row">
                    <span>Periode</span>
                    <strong id="detailPeriod">-</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Jatuh Tempo</span>
                    <strong id="detailDueDate">-</strong>
                </div>

                <div class="detail-row">
                    <span>Status</span>
                    <strong id="detailStatus">-</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Pembayaran</span>
                    <strong id="detailPaidDate">-</strong>
                </div>

                <div class="detail-row">
                    <span>Metode Pembayaran</span>
                    <strong id="detailMethod">-</strong>
                </div>

                <div class="detail-row">
                    <span>Keterangan</span>
                    <strong id="detailDescription">-</strong>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" onclick="closeModal('detailModal')">
                Tutup
            </button>

            <button class="btn btn-primary" type="button" id="payButton" onclick="openPaymentModal()">
                <i class="bi bi-wallet2"></i>
                Bayar Tagihan
            </button>
        </div>
    </div>
</div>

<!-- MODAL METODE PEMBAYARAN -->
<div class="overlay" id="paymentModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Metode Pembayaran</h3>
            <button class="modal-close" type="button" onclick="closeModal('paymentModal')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="modal-body">
            <p style="color:var(--muted);font-size:12px;line-height:1.7;">
                Berikut metode pembayaran yang disediakan oleh pengelola kos.
                Silakan pilih metode yang tersedia.
            </p>

            <div class="method-list" id="paymentMethodList">
                <div class="method-item">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <strong>Memuat metode pembayaran...</strong>
                        <small>Mohon tunggu sebentar</small>
                    </div>
                </div>
            </div>

            <div class="payment-warning">
                <i class="bi bi-exclamation-triangle"></i>
                Fitur pengiriman pembayaran belum terhubung ke sistem backend.
                Silakan hubungi pengelola kos untuk menyelesaikan pembayaran.
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" onclick="closeModal('paymentModal')">
                Tutup
            </button>

            <button class="btn btn-primary btn-disabled" type="button" disabled>
                Kirim Pembayaran
            </button>
        </div>
    </div>
</div>

<div class="toast" id="toast">
    <i class="bi bi-info-circle"></i>
    <span id="toastMessage">Informasi</span>
</div>

<script>
    /* =========================================================
       DATA TAGIHAN
    ========================================================= */

    const tagihanData = @json($tagihanJson);

    let currentTagihanIndex = null;
    let currentPage = 1;
    const rowsPerPage = 7;

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const monthFilter = document.getElementById('monthFilter');
    const tableBody = document.getElementById('billTableBody');
    const tableCount = document.getElementById('tableCount');
    const pagination = document.getElementById('pagination');

    function formatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function formatTanggal(value) {
        if (!value) return '-';

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) return '-';

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        }).format(date);
    }

    function statusLabel(status) {
        if (status === 'lunas') return 'Lunas';
        if (status === 'terlambat') return 'Terlambat';
        if (status === 'belum dibayar') return 'Belum Dibayar';

        return 'Tidak Diketahui';
    }

    function statusClass(status) {
        if (status === 'lunas') return 'status-paid';
        if (status === 'terlambat') return 'status-overdue';
        if (status === 'belum dibayar') return 'status-pending';

        return 'status-unknown';
    }

    /* =========================================================
       FILTER DAN PENCARIAN
    ========================================================= */

    function getFilteredBills() {
        const keyword = searchInput.value.trim().toLowerCase();
        const selectedStatus = statusFilter.value;
        const selectedMonth = monthFilter.value;

        return tagihanData.filter(item => {
            const searchText = `${item.kode} ${item.bulan} ${item.tahun}`.toLowerCase();

            const matchSearch = searchText.includes(keyword);
            const matchStatus = !selectedStatus || item.status === selectedStatus;
            const matchMonth = !selectedMonth ||
                String(item.bulan).toLowerCase() === selectedMonth;

            return matchSearch && matchStatus && matchMonth;
        });
    }

    function renderTable() {
        const filtered = getFilteredBills();
        const totalPages = Math.max(1, Math.ceil(filtered.length / rowsPerPage));

        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * rowsPerPage;
        const visibleItems = filtered.slice(start, start + rowsPerPage);

        if (visibleItems.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="empty-state">
                        <i class="bi bi-search"></i>
                        <strong>Tagihan Tidak Ditemukan</strong>
                        <span>Coba ubah kata kunci atau filter pencarian Anda.</span>
                    </td>
                </tr>
            `;
        } else {
            tableBody.innerHTML = visibleItems.map((item, index) => {
                const originalIndex = tagihanData.findIndex(
                    bill => String(bill.id) === String(item.id)
                );

                return `
                    <tr>
                        <td>${start + index + 1}</td>

                        <td>
                            <span class="bill-month">
                                ${escapeHTML(item.bulan)} ${escapeHTML(item.tahun)}
                            </span>
                            <span class="bill-code">
                                ${escapeHTML(item.kode)}
                            </span>
                        </td>

                        <td>
                            <span class="bill-amount">
                                ${formatRupiah(item.jumlah)}
                            </span>
                        </td>

                        <td>${formatTanggal(item.jatuh_tempo)}</td>

                        <td>
                            <span class="status ${statusClass(item.status)}">
                                ${statusLabel(item.status)}
                            </span>
                        </td>

                        <td>
                            <button
                                type="button"
                                class="btn-detail"
                                onclick="showDetail(${originalIndex})"
                            >
                                <i class="bi bi-eye"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        tableCount.textContent = filtered.length
            ? `Menampilkan ${visibleItems.length} dari ${filtered.length} tagihan`
            : 'Tidak ada tagihan yang ditemukan';

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = '';

        const prev = document.createElement('button');
        prev.type = 'button';
        prev.className = 'page-btn';
        prev.innerHTML = '<i class="bi bi-chevron-left"></i>';
        prev.disabled = currentPage === 1;
        prev.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        pagination.appendChild(prev);

        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');

            button.type = 'button';
            button.className = 'page-btn' + (page === currentPage ? ' active' : '');
            button.textContent = page;

            button.addEventListener('click', () => {
                currentPage = page;
                renderTable();
            });

            pagination.appendChild(button);
        }

        const next = document.createElement('button');
        next.type = 'button';
        next.className = 'page-btn';
        next.innerHTML = '<i class="bi bi-chevron-right"></i>';
        next.disabled = currentPage === totalPages;
        next.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        pagination.appendChild(next);
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

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    statusFilter.addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });

    monthFilter.addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });

    /* =========================================================
       MODAL DETAIL TAGIHAN
    ========================================================= */

    function showDetail(index) {
        const item = tagihanData[index];

        if (!item) {
            showToast('Data tagihan tidak ditemukan.');
            return;
        }

        currentTagihanIndex = index;

        document.getElementById('detailAmount').textContent =
            formatRupiah(item.jumlah);

        document.getElementById('detailCode').textContent =
            item.kode || '-';

        document.getElementById('detailPeriod').textContent =
            `${item.bulan || '-'} ${item.tahun || ''}`.trim();

        document.getElementById('detailDueDate').textContent =
            formatTanggal(item.jatuh_tempo);

        document.getElementById('detailStatus').textContent =
            statusLabel(item.status);

        document.getElementById('detailPaidDate').textContent =
            formatTanggal(item.tanggal_bayar);

        document.getElementById('detailMethod').textContent =
            item.metode || '-';

        document.getElementById('detailDescription').textContent =
            item.keterangan || '-';

        const payButton = document.getElementById('payButton');

        if (item.status === 'lunas') {
            payButton.style.display = 'none';
        } else {
            payButton.style.display = 'inline-flex';
        }

        openModal('detailModal');
    }

    /* =========================================================
       METODE PEMBAYARAN
    ========================================================= */

    const METHOD_KEY = 'koshaven_payment_methods';

    function getPaymentMethods() {
        try {
            const stored = localStorage.getItem(METHOD_KEY);

            if (!stored) return [];

            const parsed = JSON.parse(stored);

            if (!Array.isArray(parsed)) return [];

            return parsed.filter(method => {
                return method &&
                    typeof method === 'object' &&
                    method.name &&
                    method.active !== false &&
                    method.status !== 'nonaktif';
            });
        } catch (error) {
            console.error('Gagal membaca metode pembayaran:', error);
            return [];
        }
    }

    function renderPaymentMethods() {
        const container = document.getElementById('paymentMethodList');
        const methods = getPaymentMethods();

        if (methods.length === 0) {
            container.innerHTML = `
                <div class="method-item">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <strong>Belum Ada Metode Pembayaran</strong>
                        <small>Silakan hubungi pengelola kos untuk informasi pembayaran.</small>
                    </div>
                </div>
            `;
            return;
        }

        const icons = {
            qris: 'bi-qr-code',
            transfer: 'bi-bank',
            ewallet: 'bi-phone',
            cash: 'bi-cash-stack'
        };

        container.innerHTML = methods.map(method => {
            const type = String(method.type || method.category || '').toLowerCase();
            const icon = icons[type] || 'bi-wallet2';

            return `
                <div class="method-item">
                    <i class="bi ${icon}"></i>
                    <div>
                        <strong>${escapeHTML(method.name)}</strong>
                        <small>${escapeHTML(method.description || method.account || 'Metode pembayaran tersedia')}</small>
                    </div>
                </div>
            `;
        }).join('');
    }

    function openPaymentModal() {
        if (currentTagihanIndex === null) return;

        const item = tagihanData[currentTagihanIndex];

        if (!item || item.status === 'lunas') {
            showToast('Tagihan ini sudah lunas.');
            return;
        }

        renderPaymentMethods();
        closeModal('detailModal');
        openModal('paymentModal');
    }

    /* =========================================================
       MODAL DAN NOTIFIKASI
    ========================================================= */

    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');

        const anotherOpen = document.querySelector('.overlay.show');

        if (!anotherOpen) {
            document.body.style.overflow = '';
        }
    }

    document.querySelectorAll('.overlay').forEach(overlay => {
        overlay.addEventListener('click', event => {
            if (event.target === overlay) {
                closeModal(overlay.id);
            }
        });
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.overlay.show').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });

    let toastTimeout;

    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');

        toastMessage.textContent = message;
        toast.classList.add('show');

        clearTimeout(toastTimeout);

        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    /* =========================================================
       RESPONSIVE SIDEBAR
    ========================================================= */

    const sidebar = document.getElementById('sidebar');
    const mobileMenu = document.getElementById('mobileMenu');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarBackdrop.classList.add('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarBackdrop.classList.remove('show');
    }

    mobileMenu.addEventListener('click', () => {
        if (sidebar.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    sidebarBackdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth > 850) {
            closeSidebar();
        }
    });

    /* =========================================================
       INISIALISASI
    ========================================================= */

    renderTable();
</script>

</body>
</html>
