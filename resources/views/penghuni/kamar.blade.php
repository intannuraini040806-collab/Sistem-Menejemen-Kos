@php
    $user = auth()->user();

    $namaPenghuni = $user?->name ?? 'Penghuni';
    $inisial = collect(explode(' ', trim($namaPenghuni)))
        ->filter()
        ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
        ->take(2)
        ->implode('');

    $formatRupiah = fn ($nominal) => 'Rp ' . number_format((float) $nominal, 0, ',', '.');

    $fotoKamar = $kamar?->foto
        ? asset('storage/' . $kamar->foto)
        : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85';

    $namaTipeKamar = fn ($tipe) => match ($tipe) {
        'single' => 'Single',
        'double' => 'Double',
        default => ucfirst($tipe ?? '-'),
    };

    $jenisKamarMandi = fn ($jenis) => match ($jenis) {
        'dalam_kamar' => 'Kamar mandi dalam',
        'bersama' => 'Kamar mandi bersama',
        default => '-',
    };

    $tanggalMasuk = $bookingAktif?->tanggal_masuk;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">

    <title>Kamar Saya - KosHaven</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* PALET WARNA SAMA DENGAN DASHBOARD PENGHUNI */
            --primary: #C6A477;
            --primary-light: #E0C49B;
            --primary-soft: rgba(198, 164, 119, .13);

            --background: #191D22;
            --sidebar: #12161B;

            --surface: #242A31;
            --surface-2: #2D343D;
            --surface-3: #363E48;

            --text: #F1F0EC;
            --muted: #A9B0B8;
            --muted-dark: #7E8994;

            --border: rgba(187, 196, 205, .14);
            --silver: #BBC4CD;

            --danger: #D58F8F;
            --green: #91AE9B;
            --yellow: #D9B77F;
            --blue: #9BB5D1;

            --shadow: 0 12px 34px rgba(0, 0, 0, .18);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: auto;
            color-scheme: dark;
        }

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        button, input, textarea, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            width: 255px;
            height: 100vh;
            height: 100dvh;
            padding: 25px 17px 20px;
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(198,164,119,.35) transparent;
            background: var(--sidebar);
            color: var(--text);
            border-right: 1px solid var(--border);
            transition: transform .2s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: rgba(198,164,119,.35);
        }

        .brand {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 11px;
            padding: 0 11px 24px;
            border-bottom: 1px solid var(--border);
        }

        .brand-icon {
            display: flex;
            width: 41px;
            height: 41px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--primary-soft);
            color: var(--primary-light);
            font-size: 20px;
            border: 1px solid rgba(198,164,119,.2);
        }

        .brand-name {
            color: var(--primary-light);
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .brand-subtitle {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 1.25px;
            color: var(--muted-dark);
            margin-top: 4px;
        }

        .nav-label {
            flex-shrink: 0;
            padding: 25px 13px 12px;
            color: var(--muted-dark);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-menu {
            display: flex;
            flex-shrink: 0;
            flex-direction: column;
            gap: 5px;
        }

        .nav-menu a {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border-radius: 8px;
            color: #AEB7C0;
            font-size: 12px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: background .2s ease, color .2s ease, border-color .2s ease;
        }

        .nav-menu a i {
            flex-shrink: 0;
            width: 19px;
            text-align: center;
            font-size: 17px;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: rgba(198,164,119,.12);
            color: var(--primary-light);
            border-left-color: var(--primary);
        }

        .sidebar-bottom {
            flex-shrink: 0;
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding-top: 16px;
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 8px;
            min-width: 0;
        }

        .avatar {
            display: flex;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #E0C49B, #A98B62);
            color: #191D22;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
        }

        .profile-name {
            overflow: hidden;
            color: var(--text);
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-role {
            margin-top: 2px;
            color: var(--muted-dark);
            font-size: 10px;
        }

        /* SHARED LOGOUT COMPONENT */
        .logout-component-wrapper {
            width: 100%;
            margin-top: 3px;
        }

        .logout-component-wrapper .kh-logout-trigger {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: transparent;
            color: #AEB7C0;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-align: left;
            transition: background .2s ease, color .2s ease;
        }

        .logout-component-wrapper .kh-logout-trigger:hover {
            background: rgba(213,143,143,.1);
            border-color: rgba(213,143,143,.12);
            color: var(--danger);
        }

        .logout-component-wrapper .kh-logout-trigger i,
        .logout-component-wrapper .kh-logout-trigger svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            font-size: 17px;
        }

        /* MAIN CONTENT */
        .main {
            min-height: 100vh;
            margin-left: 255px;
            background: var(--background);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            min-height: 76px;
            align-items: center;
            justify-content: space-between;
            padding: 15px 35px;
            border-bottom: 1px solid var(--border);
            background: rgba(25,29,34,.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-title {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            font-weight: 600;
        }

        .topbar-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .menu-toggle {
            display: none;
            width: 39px;
            height: 39px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--surface);
            color: var(--primary);
            font-size: 19px;
        }

        .menu-toggle:hover {
            background: var(--surface-2);
        }

        .topbar-date {
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-date i {
            margin-right: 5px;
            color: var(--primary);
        }

        .content {
            width: 100%;
            max-width: 1600px;
            padding: 32px 35px 45px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 27px;
        }

        .eyebrow {
            margin-bottom: 8px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .page-heading h1 {
            color: var(--text);
            font-size: clamp(25px, 3vw, 33px);
            font-weight: 600;
        }

        .page-heading p {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border: 1px solid transparent;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-active,
        .status-available {
            border-color: rgba(145,174,155,.2);
            background: rgba(145,174,155,.13);
            color: var(--green);
        }

        .status-pending {
            border-color: rgba(217,183,127,.2);
            background: rgba(217,183,127,.13);
            color: var(--yellow);
        }

        .status-unavailable {
            border-color: rgba(213,143,143,.2);
            background: rgba(213,143,143,.13);
            color: var(--danger);
        }

        /* ALERT */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px 17px;
            margin-bottom: 22px;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 13px;
            line-height: 1.7;
        }

        .alert i {
            flex-shrink: 0;
            margin-top: 1px;
            font-size: 18px;
        }

        .alert-success {
            border-color: rgba(145,174,155,.2);
            background: rgba(145,174,155,.1);
            color: var(--green);
        }

        .alert-error {
            border-color: rgba(213,143,143,.22);
            background: rgba(213,143,143,.1);
            color: var(--danger);
        }

        .alert-info {
            border-color: rgba(198,164,119,.2);
            background: var(--primary-soft);
            color: var(--primary-light);
        }

        .alert strong {
            color: inherit;
        }

        /* SECTION */
        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin: 30px 0 17px;
        }

        .section-heading h2 {
            color: var(--text);
            font-size: 21px;
        }

        .section-heading p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        /* PENGELOMPOKAN KAMAR BERDASARKAN LANTAI DAN TIPE */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .room-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            box-shadow: var(--shadow);
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        }

        .room-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.35);
            box-shadow: 0 16px 38px rgba(0,0,0,.24);
        }


        .room-floor-badge {
            position: absolute;
            left: 14px;
            top: 14px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 11px;
            border: 1px solid rgba(224, 196, 155, .42);
            border-radius: 999px;
            background: rgba(18, 22, 27, .88);
            color: var(--primary-light);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .02em;
            backdrop-filter: blur(8px);
        }

        .room-image-wrap {
            position: relative;
            height: 185px;
            background: var(--surface-2);
        }

        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .room-image-wrap .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(25,29,34,.92);
            backdrop-filter: blur(8px);
        }

        .room-card-body {
            padding: 18px;
        }

        .room-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .room-number {
            color: var(--text);
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
        }

        .room-type {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .room-price {
            color: var(--primary-light);
            font-size: 16px;
            font-weight: 800;
            text-align: right;
        }

        .room-price small {
            display: block;
            margin-top: 3px;
            color: var(--muted-dark);
            font-size: 10px;
            font-weight: 500;
        }

        .room-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            padding: 14px 0;
            margin-top: 13px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .room-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .room-meta i {
            color: var(--primary);
            font-size: 14px;
        }

        .room-description {
            display: -webkit-box;
            overflow: hidden;
            min-height: 36px;
            margin: 12px 0 15px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* BUTTON */
        .button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            transition: background .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
        }

        .button:active {
            transform: scale(.98);
        }

        .button-primary {
            background: var(--primary);
            color: #191D22;
        }

        .button-primary:hover {
            background: var(--primary-light);
            color: #191D22;
        }

        .button-outline {
            border-color: var(--border);
            background: var(--surface-2);
            color: var(--text);
        }

        .button-outline:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
            color: var(--primary-light);
        }

        .button-gold {
            background: var(--primary);
            color: #191D22;
        }

        .button-gold:hover {
            background: var(--primary-light);
        }

        .button-full {
            width: 100%;
        }

        .room-card-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 48px 25px;
            border: 1px dashed rgba(187,196,205,.25);
            border-radius: 12px;
            background: var(--surface);
            text-align: center;
        }

        .empty-icon {
            display: grid;
            width: 65px;
            height: 65px;
            place-items: center;
            margin: 0 auto 17px;
            border: 1px solid rgba(198,164,119,.18);
            border-radius: 50%;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 27px;
        }

        .empty-state h3 {
            color: var(--text);
            font-size: 21px;
        }

        .empty-state p {
            max-width: 430px;
            margin: 9px auto 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        /* PENDING BOOKING */
        .pending-card {
            overflow: hidden;
            border: 1px solid rgba(217,183,127,.2);
            border-radius: 12px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .pending-banner {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 19px 22px;
            border-bottom: 1px solid rgba(217,183,127,.15);
            background: rgba(217,183,127,.09);
        }

        .pending-banner-icon {
            display: grid;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid rgba(217,183,127,.2);
            border-radius: 10px;
            background: var(--surface-2);
            color: var(--yellow);
            font-size: 20px;
        }

        .pending-banner h3 {
            color: var(--yellow);
            font-size: 18px;
        }

        .pending-banner p {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .pending-content {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 22px;
            padding: 22px;
        }

        .pending-image {
            width: 100%;
            height: 150px;
            border-radius: 9px;
            object-fit: cover;
        }

        .pending-info h2 {
            color: var(--text);
            font-size: 22px;
        }

        .pending-info p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
        }

        .pending-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 18px;
        }

        .pending-detail {
            color: var(--muted);
            font-size: 11px;
        }

        .pending-detail strong {
            display: block;
            margin-top: 5px;
            color: var(--text);
            font-size: 13px;
        }

        /* ACTIVE ROOM */
        .active-hero {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .active-hero-inner {
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            min-height: 285px;
        }

        .active-hero-image {
            width: 100%;
            height: 100%;
            min-height: 285px;
            object-fit: cover;
        }

        .active-hero-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 30px;
            background: var(--surface);
        }

        .active-hero-info .eyebrow {
            color: var(--primary);
        }

        .active-hero-info h2 {
            margin-bottom: 9px;
            color: var(--text);
            font-size: 30px;
        }

        .active-hero-info p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .hero-price {
            margin-top: 20px;
            color: var(--primary-light);
            font-size: 23px;
            font-weight: 800;
        }

        .hero-price small {
            color: var(--muted);
            font-size: 11px;
            font-weight: 400;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .summary-card {
            padding: 19px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--surface);
            box-shadow: var(--shadow);
            transition: border-color .18s ease, transform .18s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            border-color: rgba(198,164,119,.3);
        }

        .summary-card i {
            color: var(--primary);
            font-size: 20px;
        }

        .summary-card span {
            display: block;
            margin-top: 12px;
            color: var(--muted);
            font-size: 11px;
        }

        .summary-card strong {
            display: block;
            margin-top: 5px;
            color: var(--text);
            font-size: 15px;
        }

        /* ROOM DETAILS */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .detail-item {
            min-width: 0;
            padding: 13px;
            border: 1px solid rgba(187,196,205,.07);
            border-radius: 8px;
            background: var(--surface-2);
        }

        .detail-item span {
            color: var(--muted);
            font-size: 10px;
        }

        .detail-item strong {
            display: block;
            margin-top: 6px;
            color: var(--text);
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .facility-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
            color: var(--muted);
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        .facility-item i {
            flex-shrink: 0;
            color: var(--primary);
            font-size: 15px;
        }

        /* ROOM REPORT */
        .report-box {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .form-group {
            min-width: 0;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: var(--text);
            font-size: 11px;
            font-weight: 700;
        }

        .form-control {
            display: block;
            width: 100%;
            min-height: 43px;
            padding: 11px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            background: var(--surface-2);
            color: var(--text);
            font-size: 12px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .form-control::placeholder {
            color: var(--muted-dark);
            opacity: 1;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: var(--surface-3);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .form-control:disabled {
            cursor: not-allowed;
            opacity: .6;
        }

        select.form-control {
            color-scheme: dark;
        }

        select.form-control option {
            background: var(--surface-2);
            color: var(--text);
        }

        input[type="date"].form-control {
            color-scheme: dark;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .field-error {
            display: block;
            margin-top: 5px;
            color: var(--danger);
            font-size: 10px;
        }

        /* REPORT TABLE */
        .report-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .report-table th,
        .report-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 11px;
            text-align: left;
        }

        .report-table th {
            background: var(--surface-2);
            color: var(--muted);
            font-weight: 700;
        }

        .report-table td {
            color: var(--text);
        }

        .report-table tbody tr {
            transition: background .15s ease;
        }

        .report-table tbody tr:hover {
            background: rgba(255,255,255,.025);
        }

        .report-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .report-empty {
            padding: 25px;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 300;
            display: none;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
            padding: 22px;
            background: rgba(0,0,0,.72);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-box {
            position: relative;
            width: 100%;
            max-width: 650px;
            max-height: calc(100vh - 44px);
            max-height: calc(100dvh - 44px);
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            box-shadow: 0 25px 70px rgba(0,0,0,.4);
            animation: modalIn .18s ease-out;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            position: sticky;
            top: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .modal-header h2 {
            color: var(--text);
            font-size: 20px;
        }

        .modal-close {
            display: grid;
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: var(--surface-2);
            color: var(--muted);
            font-size: 18px;
            transition: background .18s ease, color .18s ease;
        }

        .modal-close:hover {
            background: rgba(213,143,143,.12);
            color: var(--danger);
        }

        .modal-body {
            padding: 22px;
        }

        .modal-room-image {
            width: 100%;
            height: 230px;
            border-radius: 9px;
            object-fit: cover;
        }

        .modal-room-title {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin: 17px 0;
        }

        .modal-room-title h3 {
            color: var(--text);
            font-size: 23px;
        }

        .modal-room-title p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .modal-price {
            color: var(--primary-light);
            font-size: 17px;
            font-weight: 800;
            text-align: right;
        }

        .modal-price small {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 400;
        }

        .modal-description {
            margin: 15px 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .modal-subheading {
            margin: 20px 0 11px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .modal-facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .modal-facility {
            padding: 7px 10px;
            border: 1px solid rgba(198,164,119,.15);
            border-radius: 20px;
            background: var(--primary-soft);
            color: var(--primary-light);
            font-size: 10px;
        }

        .booking-form-area {
            padding-top: 20px;
            margin-top: 22px;
            border-top: 1px solid var(--border);
            scroll-margin-top: 15px;
        }

        .booking-form-area h3 {
            color: var(--text);
            font-size: 19px;
        }

        .booking-form-area > p {
            margin: 6px 0 17px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        /* TOAST AND FOOTER */
        .toast {
            position: fixed;
            right: 25px;
            bottom: 25px;
            z-index: 500;
            display: none;
            max-width: min(370px, calc(100vw - 35px));
            padding: 13px 17px;
            border: 1px solid rgba(198,164,119,.25);
            border-radius: 9px;
            background: var(--surface-2);
            color: var(--text);
            box-shadow: var(--shadow);
            font-size: 12px;
            line-height: 1.6;
        }

        .toast.show {
            display: block;
            animation: modalIn .18s ease-out;
        }

        .footer {
            padding: 25px 0 5px;
            color: var(--muted-dark);
            font-size: 10px;
            text-align: center;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 90;
            display: none;
            background: rgba(0,0,0,.65);
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* TABLET */
        @media (max-width: 1200px) {
            .room-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content {
                padding-right: 27px;
                padding-left: 27px;
            }

            .topbar {
                padding-right: 27px;
                padding-left: 27px;
            }
        }

        /* SIDEBAR MOBILE */
        @media (max-width: 950px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }

            .active-hero-inner {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* MOBILE */
        @media (max-width: 650px) {
            .content {
                padding: 25px 16px 35px;
            }

            .topbar {
                min-height: 65px;
                padding: 12px 16px;
            }

            .topbar-date {
                display: none;
            }

            .page-heading {
                flex-direction: column;
                margin-bottom: 22px;
            }

            .room-grid {
                grid-template-columns: 1fr;
            }

            .room-image-wrap {
                height: 205px;
            }

            .pending-content {
                grid-template-columns: 1fr;
            }

            .pending-image {
                height: 190px;
            }

            .active-hero-inner {
                grid-template-columns: 1fr;
            }

            .active-hero-image {
                height: 210px;
                min-height: 210px;
            }

            .active-hero-info {
                padding: 23px;
            }

            .active-hero-info h2 {
                font-size: 25px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .detail-grid {
                grid-template-columns: 1fr 1fr;
                padding: 13px;
            }

            .facility-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .report-box {
                padding: 16px;
            }

            .modal-overlay {
                align-items: flex-start;
                padding: 10px;
            }

            .modal-box {
                max-height: calc(100vh - 20px);
                max-height: calc(100dvh - 20px);
                margin: auto 0;
            }

            .modal-body {
                padding: 16px;
            }

            .modal-room-image {
                height: 190px;
            }

            .modal-room-title {
                flex-direction: column;
            }

            .modal-price {
                text-align: left;
            }

            .toast {
                right: 16px;
                bottom: 16px;
                left: 16px;
                max-width: none;
            }
        }

        @media (max-width: 380px) {
            .sidebar {
                width: min(255px, 85vw);
            }

            .detail-grid,
            .facility-grid {
                grid-template-columns: 1fr;
            }

            .room-card-actions {
                grid-template-columns: 1fr;
            }

            .room-card-top {
                flex-direction: column;
            }

            .room-price {
                text-align: left;
            }

            .pending-banner {
                align-items: flex-start;
                padding: 16px;
            }

            .pending-content {
                padding: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-house-heart-fill"></i>
            </div>
            <div>
                <div class="brand-name">KosHaven.</div>
            </div>
        </div>

        <div class="nav-label">MENU PENGHUNI</div>

        <nav class="nav-menu">
            <a href="{{ route('penghuni.dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>

            <a href="{{ route('penghuni.kamar.index') }}" class="active" aria-current="page">
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
            <div class="profile-mini">
                <div class="avatar">{{ $inisial ?: 'P' }}</div>
                <div style="min-width:0">
                    <div class="profile-name">{{ $namaPenghuni }}</div>
                    <div class="profile-role">Penghuni KosHaven</div>
                </div>
            </div>

            <div class="logout-component-wrapper">
                @include('components.logout-modal')
            </div>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Buka menu" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <div class="topbar-title">Kamar Saya</div>
                    <div class="topbar-subtitle">Informasi dan pemesanan kamar</div>
                </div>
            </div>

            <div class="topbar-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <div class="content">

            <div class="page-heading">
                <div>
                    <div class="eyebrow">Area Penghuni</div>

                    @if($bookingAktif && $kamar)
                        <h1>Informasi Kamar Saya</h1>
                        <p>Lihat informasi kamar yang sedang kamu tempati di KosHaven.</p>
                    @elseif($bookingMenunggu)
                        <h1>Status Booking Kamar</h1>
                        <p>Pantau pengajuan kamar yang sedang menunggu persetujuan Admin.</p>
                    @else
                        <h1>Temukan Kamar Kos</h1>
                        <p>Pilih kamar yang sesuai dengan kebutuhanmu. Lihat detailnya sebelum mengajukan booking.</p>
                    @endif
                </div>

                @if($bookingAktif && $kamar)
                    <span class="status-badge status-active">
                        <i class="bi bi-check-circle-fill"></i>
                        Sedang Ditempati
                    </span>
                @elseif($bookingMenunggu)
                    <span class="status-badge status-pending">
                        <i class="bi bi-hourglass-split"></i>
                        Menunggu Persetujuan
                    </span>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        <strong>Pengajuan belum dapat diproses.</strong>
                        <ul style="padding-left:18px; margin-top:5px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- KONDISI 1: PENGHUNI SUDAH MEMILIKI KAMAR AKTIF --}}
            @if($bookingAktif && $kamar)

                <section class="active-hero">
                    <div class="active-hero-inner">
                        <img
                            class="active-hero-image"
                            src="{{ $fotoKamar }}"
                            alt="Foto kamar {{ $kamar->nomor_kamar }}"
                            onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85'"
                        >

                        <div class="active-hero-info">
                            <div class="eyebrow">Kamar Tempat Tinggalmu</div>
                            <h2>Kamar {{ $kamar->nomor_kamar }}</h2>

                            <p>
                                {{ $namaTipeKamar($kamar->tipe) }}
                                · {{ $jenisKamarMandi($kamar->jenis_kamar_mandi) }}
                            </p>

                            <div class="hero-price">
                                {{ $formatRupiah($kamar->harga) }}
                                <small>/ bulan</small>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="summary-grid">
                    <div class="summary-card">
                        <i class="bi bi-calendar-check"></i>
                        <span>Tanggal Mulai Menempati</span>
                        <strong>
                            {{ $tanggalMasuk?->locale('id')->translatedFormat('d F Y') ?? '-' }}
                        </strong>
                    </div>

                    <div class="summary-card">
                        <i class="bi bi-wallet2"></i>
                        <span>Harga Sewa Bulanan</span>
                        <strong>{{ $formatRupiah($kamar->harga) }}</strong>
                    </div>

                    <div class="summary-card">
                        <i class="bi bi-people"></i>
                        <span>Kapasitas Kamar</span>
                        <strong>
                            {{ $kamar->jumlah_penghuni }} / {{ $kamar->kapasitas }} orang
                        </strong>
                    </div>
                </div>

                <div class="section-heading">
                    <div>
                        <h2>Detail Kamar</h2>
                        <p>Informasi lengkap mengenai kamar yang kamu tempati.</p>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span>Nama Kos</span>
                        <strong>KosHaven</strong>
                    </div>

                    <div class="detail-item">
                        <span>Nomor Kamar</span>
                        <strong>{{ $kamar->nomor_kamar }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Tipe Kamar</span>
                        <strong>{{ $namaTipeKamar($kamar->tipe) }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Lantai</span>
                        <strong>Lantai {{ $kamar->lantai ?? 1 }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Kamar Mandi</span>
                        <strong>{{ $jenisKamarMandi($kamar->jenis_kamar_mandi) }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Kapasitas</span>
                        <strong>{{ $kamar->kapasitas }} orang</strong>
                    </div>

                    <div class="detail-item">
                        <span>Jumlah Penghuni</span>
                        <strong>{{ $kamar->jumlah_penghuni }} orang</strong>
                    </div>

                    <div class="detail-item">
                        <span>Harga Bulanan</span>
                        <strong>{{ $formatRupiah($kamar->harga) }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Status Kamar</span>
                        <strong>Terisi</strong>
                    </div>

                    <div class="detail-item">
                        <span>Tanggal Masuk</span>
                        <strong>{{ $tanggalMasuk?->locale('id')->translatedFormat('d F Y') ?? '-' }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Tanggal Keluar</span>
                        <strong>
                            {{ $bookingAktif->tanggal_keluar?->locale('id')->translatedFormat('d F Y') ?? 'Belum ditentukan' }}
                        </strong>
                    </div>
                </div>

                <div class="section-heading">
                    <div>
                        <h2>Fasilitas Kamar</h2>
                        <p>Fasilitas yang tersedia di dalam kamarmu.</p>
                    </div>
                </div>

                @if(count($fasilitasKamar))
                    <div class="facility-grid">
                        @foreach($fasilitasKamar as $fasilitas)
                            <div class="facility-item">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $fasilitas }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Belum ada informasi fasilitas kamar.
                    </div>
                @endif

                <div class="section-heading">
                    <div>
                        <h2>Laporan Kondisi Kamar</h2>
                        <p>Sampaikan jika terdapat kerusakan atau kendala pada kamar.</p>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        Gunakan formulir ini untuk mencatat laporan kondisi kamar.
                        Data laporan pada halaman ini tersimpan di browser perangkat yang digunakan.
                    </div>
                </div>

                <div class="report-box">
                    <form id="reportForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="kategoriLaporan">Kategori Laporan *</label>
                                <select id="kategoriLaporan" class="form-control" required>
                                    <option value="">Pilih kategori</option>
                                    <option value="Kerusakan fasilitas">Kerusakan fasilitas</option>
                                    <option value="Kebersihan kamar">Kebersihan kamar</option>
                                    <option value="Kelistrikan">Kelistrikan</option>
                                    <option value="Air dan kamar mandi">Air dan kamar mandi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tanggalLaporan">Tanggal Laporan *</label>
                                <input
                                    type="date"
                                    id="tanggalLaporan"
                                    class="form-control"
                                    max="{{ now()->format('Y-m-d') }}"
                                    value="{{ now()->format('Y-m-d') }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsiLaporan">Deskripsi Laporan *</label>
                            <textarea
                                id="deskripsiLaporan"
                                class="form-control"
                                maxlength="500"
                                placeholder="Jelaskan kondisi atau kendala yang ingin dilaporkan..."
                                required
                            ></textarea>
                            <small style="display:block; margin-top:5px; color:var(--muted); font-size:10px;">
                                Maksimal 500 karakter.
                            </small>
                        </div>

                        <button type="submit" class="button button-primary">
                            <i class="bi bi-send"></i>
                            Simpan Laporan
                        </button>
                    </form>
                </div>

                <div class="section-heading">
                    <div>
                        <h2>Riwayat Laporan</h2>
                        <p>Daftar laporan yang pernah kamu catat melalui browser ini.</p>
                    </div>
                </div>

                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <tr>
                                <td colspan="4" class="report-empty">
                                    Belum ada laporan kamar.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            {{-- KONDISI 2: BOOKING MASIH MENUNGGU --}}
            @elseif($bookingMenunggu)

                @php
                    $kamarMenunggu = $bookingMenunggu->kamar;

                    $fotoMenunggu = $kamarMenunggu?->foto
                        ? asset('storage/' . $kamarMenunggu->foto)
                        : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85';
                @endphp

                <div class="pending-card">
                    <div class="pending-banner">
                        <div class="pending-banner-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <h3>Booking Sedang Ditinjau</h3>
                            <p>Pengajuanmu sudah diterima dan sedang menunggu persetujuan Admin.</p>
                        </div>
                    </div>

                    <div class="pending-content">
                        <img
                            src="{{ $fotoMenunggu }}"
                            class="pending-image"
                            alt="Foto kamar yang diajukan"
                            loading="lazy"
                            onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85'"
                        >

                        <div class="pending-info">
                            <span class="status-badge status-pending">
                                <i class="bi bi-clock"></i>
                                Menunggu Persetujuan
                            </span>

                            <h2 style="margin-top:12px;">
                                Kamar {{ $kamarMenunggu?->nomor_kamar ?? '-' }}
                            </h2>

                            <p>
                                {{ $namaTipeKamar($kamarMenunggu?->tipe ?? '-') }}
                                · Lantai {{ $kamarMenunggu?->lantai ?? 1 }}
                                · {{ $jenisKamarMandi($kamarMenunggu?->jenis_kamar_mandi ?? '-') }}
                            </p>

                            <div class="pending-details">
                                <div class="pending-detail">
                                    Harga per Bulan
                                    <strong>
                                        {{ $formatRupiah($kamarMenunggu?->harga ?? 0) }}
                                    </strong>
                                </div>

                                <div class="pending-detail">
                                    Tanggal Booking
                                    <strong>
                                        {{ $bookingMenunggu->tanggal_booking?->locale('id')->translatedFormat('d F Y') ?? '-' }}
                                    </strong>
                                </div>

                                <div class="pending-detail">
                                    Rencana Masuk
                                    <strong>
                                        {{ $bookingMenunggu->tanggal_masuk?->locale('id')->translatedFormat('d F Y') ?? '-' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info" style="margin-top:20px;">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        Kamu belum bisa mengajukan booking kamar lain selama pengajuan ini
                        masih menunggu keputusan Admin. Silakan tunggu informasi selanjutnya.
                    </div>
                </div>

            {{-- KONDISI 3: BELUM PUNYA KAMAR DAN BELUM BOOKING --}}
            @else

                <div class="alert alert-info">
                    <i class="bi bi-lightbulb-fill"></i>
                    <div>
                        Pilih kamar yang tersedia. Tekan tombol <strong>Lihat Detail</strong>
                        untuk memeriksa informasi kamar sebelum mengajukan booking.
                    </div>
                </div>

                <div class="section-heading">
                    <div>
                        <h2>Daftar Kamar Tersedia</h2>
                        <p>
                            {{ $kamarsTersedia->count() }} kamar tersedia. Setiap kartu menampilkan lokasi lantainya.
                        </p>
                    </div>
                </div>

                @if($kamarsTersedia->isNotEmpty())
                    <div class="room-grid">
                        @foreach($kamarsTersedia->sortBy([
                            ['lantai', 'asc'],
                            ['nomor_kamar', 'asc'],
                        ]) as $item)
                            @php
                                $fotoItem = $item->foto
                                    ? asset('storage/' . $item->foto)
                                    : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85';

                                $fasilitasItem = is_array($item->fasilitas)
                                    ? $item->fasilitas
                                    : [];
                            @endphp

                            <article class="room-card">
                                <div class="room-image-wrap">
                                    <img
                                        src="{{ $fotoItem }}"
                                        alt="Kamar {{ $item->nomor_kamar }}"
                                        class="room-image"
                                        loading="lazy"
                                        onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85'"
                                    >

                                    <span class="room-floor-badge">
                                        <i class="bi bi-layers"></i>
                                        Lantai {{ $item->lantai ?? '-' }}
                                    </span>

                                    <span class="status-badge status-available">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Tersedia
                                    </span>
                                </div>

                                <div class="room-card-body">
                                    <div class="room-card-top">
                                        <div>
                                            <div class="room-number">
                                                Kamar {{ $item->nomor_kamar }}
                                            </div>

                                            <div class="room-type">
                                                {{ $namaTipeKamar($item->tipe) }}
                                            </div>
                                        </div>

                                        <div class="room-price">
                                            {{ $formatRupiah($item->harga) }}
                                            <small>per bulan</small>
                                        </div>
                                    </div>

                                    <div class="room-meta">
                                        <span>
                                            <i class="bi bi-droplet"></i>
                                            {{ $jenisKamarMandi($item->jenis_kamar_mandi) }}
                                        </span>

                                        <span>
                                            <i class="bi bi-people"></i>
                                            {{ $item->jumlah_penghuni }}/{{ $item->kapasitas }} penghuni
                                        </span>
                                    </div>

                                    <p class="room-description">
                                        {{ $item->deskripsi ?: 'Belum ada deskripsi untuk kamar ini.' }}
                                    </p>

                                    <div class="room-card-actions">
                                        <button
                                            type="button"
                                            class="button button-outline button-full"
                                            data-open-room="{{ $item->id }}"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Lihat Detail
                                        </button>

                                        <button
                                            type="button"
                                            class="button button-primary button-full"
                                            data-open-booking="{{ $item->id }}"
                                        >
                                            <i class="bi bi-calendar-plus"></i>
                                            Booking Kamar
                                        </button>
                                    </div>
                                </div>
                            </article>

                            {{-- MODAL DETAIL DAN BOOKING UNTUK SETIAP KAMAR --}}
                            <div
                                class="modal-overlay"
                                id="roomModal{{ $item->id }}"
                                aria-hidden="true"
                            >
                                <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="roomModalTitle{{ $item->id }}">
                                    <div class="modal-header">
                                        <h2 id="roomModalTitle{{ $item->id }}">Detail Kamar</h2>

                                        <button
                                            type="button"
                                            class="modal-close"
                                            data-close-modal
                                            aria-label="Tutup"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <img
                                            src="{{ $fotoItem }}"
                                            alt="Foto kamar {{ $item->nomor_kamar }}"
                                            class="modal-room-image"
                                            loading="lazy"
                                            onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85'"
                                        >

                                        <div class="modal-room-title">
                                            <div>
                                                <h3>Kamar {{ $item->nomor_kamar }}</h3>
                                                <p>
                                                    {{ $namaTipeKamar($item->tipe) }}
                                                    · {{ $jenisKamarMandi($item->jenis_kamar_mandi) }}
                                                </p>
                                            </div>

                                            <div class="modal-price">
                                                {{ $formatRupiah($item->harga) }}
                                                <small>per bulan</small>
                                            </div>
                                        </div>

                                        <div class="detail-grid">
                                            <div class="detail-item">
                                                <span>Nomor Kamar</span>
                                                <strong>{{ $item->nomor_kamar }}</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Tipe Kamar</span>
                                                <strong>{{ $namaTipeKamar($item->tipe) }}</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Lantai</span>
                                                <strong>Lantai {{ $item->lantai ?? 1 }}</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Kamar Mandi</span>
                                                <strong>{{ $jenisKamarMandi($item->jenis_kamar_mandi) }}</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Kapasitas</span>
                                                <strong>{{ $item->kapasitas }} orang</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Penghuni Saat Ini</span>
                                                <strong>{{ $item->jumlah_penghuni }} orang</strong>
                                            </div>

                                            <div class="detail-item">
                                                <span>Status</span>
                                                <strong style="color:var(--green);">Tersedia</strong>
                                            </div>
                                        </div>

                                        <h3 class="modal-subheading">Deskripsi Kamar</h3>

                                        <p class="modal-description">
                                            {{ $item->deskripsi ?: 'Belum ada deskripsi untuk kamar ini.' }}
                                        </p>

                                        <h3 class="modal-subheading">Fasilitas Kamar</h3>

                                        @if(count($fasilitasItem))
                                            <div class="modal-facilities">
                                                @foreach($fasilitasItem as $fasilitas)
                                                    <span class="modal-facility">
                                                        <i class="bi bi-check-circle"></i>
                                                        {{ $fasilitas }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="modal-description">
                                                Belum ada informasi fasilitas kamar.
                                            </p>
                                        @endif

                                        <div class="booking-form-area" id="bookingFormArea{{ $item->id }}">
                                            <h3>Ajukan Booking Kamar</h3>

                                            <p>
                                                Lengkapi tanggal masuk dan catatan jika diperlukan.
                                                Pengajuanmu akan menunggu persetujuan Admin.
                                            </p>

                                            <form
                                                action="{{ route('penghuni.kamar.booking.store') }}"
                                                method="POST"
                                                class="booking-form"
                                            >
                                                @csrf

                                                <input
                                                    type="hidden"
                                                    name="kamar_id"
                                                    value="{{ $item->id }}"
                                                >

                                                <div class="form-group">
                                                    <label for="tanggalMasuk{{ $item->id }}">
                                                        Tanggal Masuk *
                                                    </label>

                                                    <input
                                                        type="date"
                                                        id="tanggalMasuk{{ $item->id }}"
                                                        name="tanggal_masuk"
                                                        class="form-control"
                                                        min="{{ now()->format('Y-m-d') }}"
                                                        value="{{ old('tanggal_masuk') }}"
                                                        required
                                                    >

                                                    @error('tanggal_masuk')
                                                        <span class="field-error">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="catatan{{ $item->id }}">
                                                        Catatan Tambahan
                                                    </label>

                                                    <textarea
                                                        id="catatan{{ $item->id }}"
                                                        name="catatan"
                                                        class="form-control"
                                                        maxlength="500"
                                                        placeholder="Contoh: Saya berencana masuk pada awal bulan..."
                                                    >{{ old('catatan') }}</textarea>

                                                    <small style="display:block; margin-top:5px; color:var(--muted); font-size:10px;">
                                                        Maksimal 500 karakter.
                                                    </small>

                                                    @error('catatan')
                                                        <span class="field-error">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                @error('kamar_id')
                                                    <div class="alert alert-error">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <button type="submit" class="button button-primary button-full">
                                                    <i class="bi bi-send"></i>
                                                    Kirim Pengajuan Booking
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                        @endforeach
                    </div>

                @else

                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-house-x"></i>
                        </div>

                        <h3>Belum Ada Kamar Tersedia</h3>

                        <p>
                            Saat ini belum ada kamar yang dapat dipesan.
                            Silakan periksa kembali nanti atau hubungi petugas KosHaven
                            untuk mendapatkan informasi ketersediaan kamar.
                        </p>
                    </div>

                @endif

            @endif

            <div class="footer">
                © {{ date('Y') }} KosHaven. Sistem Manajemen Kos.
            </div>

        </div>
    </main>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            function syncBodyScrollLock() {
                const hasOpenModal = document.querySelector('.modal-overlay.show');
                const hasOpenSidebar = sidebar?.classList.contains('open');

                document.body.style.overflow = (hasOpenModal || hasOpenSidebar)
                    ? 'hidden'
                    : '';
            }

            function closeSidebar() {
                sidebar?.classList.remove('open');
                sidebarOverlay?.classList.remove('show');
                menuToggle?.setAttribute('aria-expanded', 'false');
                syncBodyScrollLock();
            }

            menuToggle?.addEventListener('click', function () {
                const isOpen = sidebar?.classList.toggle('open');

                sidebarOverlay?.classList.toggle('show', Boolean(isOpen));
                menuToggle.setAttribute('aria-expanded', String(Boolean(isOpen)));
                syncBodyScrollLock();
            });

            sidebarOverlay?.addEventListener('click', closeSidebar);

            sidebar?.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 950) {
                        closeSidebar();
                    }
                });
            });

            // MODAL DETAIL KAMAR
            function openModal(modal) {
                if (!modal) return;

                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
                syncBodyScrollLock();

                const closeButton = modal.querySelector('[data-close-modal]');
                closeButton?.focus();
            }

            function closeModal(modal) {
                if (!modal) return;

                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                syncBodyScrollLock();
            }

            document.querySelectorAll('[data-open-room]').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.openRoom;
                    openModal(document.getElementById('roomModal' + id));
                });
            });

            document.querySelectorAll('[data-open-booking]').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.openBooking;
                    const modal = document.getElementById('roomModal' + id);

                    openModal(modal);

                    requestAnimationFrame(() => {
                        const formArea = document.getElementById('bookingFormArea' + id);
                        const modalBox = modal?.querySelector('.modal-box');

                        if (formArea && modalBox) {
                            modalBox.scrollTo({
                                top: formArea.offsetTop - modalBox.offsetTop,
                                behavior: 'auto'
                            });
                        }
                    });
                });
            });

            document.querySelectorAll('[data-close-modal]').forEach(button => {
                button.addEventListener('click', function () {
                    closeModal(this.closest('.modal-overlay'));
                });
            });

            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const logoutModal = document.getElementById('khLogoutModal');

                // Biarkan komponen logout menangani Escape sendiri.
                if (logoutModal && logoutModal.classList.contains('is-visible')) {
                    return;
                }

                document.querySelectorAll('.modal-overlay.show').forEach(closeModal);
                closeSidebar();
            }
        });

            // Jika validasi booking gagal, buka kembali modal kamar terkait.
            @if($errors->any() && old('kamar_id'))
                const failedModal = document.getElementById(
                    'roomModal{{ old('kamar_id') }}'
                );

                if (failedModal) {
                    openModal(failedModal);
                }
            @endif

            // TOAST
            const toast = document.getElementById('toast');
            let toastTimeout;

            function showToast(message) {
                if (!toast) return;

                toast.textContent = message;
                toast.classList.add('show');

                clearTimeout(toastTimeout);

                toastTimeout = setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }

            // LAPORAN KAMAR - PENYIMPANAN LOCAL STORAGE
            const reportForm = document.getElementById('reportForm');
            const reportTableBody = document.getElementById('reportTableBody');

            const reportStorageKey = @json(
                'koshaven_penghuni_laporan_kamar_' .
                auth()->id() . '_' .
                ($kamar?->id ?? 'tanpa-kamar')
            );

            function escapeHTML(value) {
                return String(value).replace(/[&<>"']/g, function (character) {
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

            function getReports() {
                try {
                    const data = JSON.parse(
                        localStorage.getItem(reportStorageKey) || '[]'
                    );

                    return Array.isArray(data) ? data : [];
                } catch (error) {
                    return [];
                }
            }

            function renderReports() {
                if (!reportTableBody) return;

                const reports = getReports();

                if (reports.length === 0) {
                    reportTableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="report-empty">
                                Belum ada laporan kamar.
                            </td>
                        </tr>
                    `;

                    return;
                }

                reportTableBody.innerHTML = reports
                    .slice()
                    .reverse()
                    .map((report, index) => `
                        <tr>
                            <td>${reports.length - index}</td>
                            <td>${escapeHTML(report.tanggal)}</td>
                            <td>${escapeHTML(report.kategori)}</td>
                            <td>${escapeHTML(report.deskripsi)}</td>
                        </tr>
                    `)
                    .join('');
            }

            reportForm?.addEventListener('submit', function (event) {
                event.preventDefault();

                const kategori = document.getElementById('kategoriLaporan')?.value;
                const tanggal = document.getElementById('tanggalLaporan')?.value;
                const deskripsi = document.getElementById('deskripsiLaporan')?.value.trim();

                if (!kategori || !tanggal || !deskripsi) {
                    showToast('Lengkapi seluruh kolom laporan terlebih dahulu.');
                    return;
                }

                if (deskripsi.length > 500) {
                    showToast('Deskripsi laporan maksimal 500 karakter.');
                    return;
                }

                const tanggalDipilih = new Date(tanggal + 'T00:00:00');
                const hariIni = new Date();
                hariIni.setHours(0, 0, 0, 0);

                if (Number.isNaN(tanggalDipilih.getTime()) || tanggalDipilih > hariIni) {
                    showToast('Tanggal laporan tidak boleh melebihi hari ini.');
                    return;
                }

                const reports = getReports();

                reports.push({
                    kategori: kategori,
                    tanggal: tanggal,
                    deskripsi: deskripsi,
                    dibuatPada: new Date().toISOString()
                });

                try {
                    localStorage.setItem(
                        reportStorageKey,
                        JSON.stringify(reports)
                    );
                } catch (error) {
                    showToast('Browser tidak dapat menyimpan laporan. Periksa ruang penyimpanan.');
                    return;
                }

                reportForm.reset();

                const dateInput = document.getElementById('tanggalLaporan');

                if (dateInput) {
                    const now = new Date();
                    const localDate = [
                        now.getFullYear(),
                        String(now.getMonth() + 1).padStart(2, '0'),
                        String(now.getDate()).padStart(2, '0')
                    ].join('-');

                    dateInput.value = localDate;
                }

                renderReports();
                showToast('Laporan kamar berhasil dicatat.');
            });

            renderReports();

            // Pastikan sidebar tidak tertinggal dalam kondisi terbuka saat berpindah ukuran layar.
            window.addEventListener('resize', function () {
                if (window.innerWidth > 950) {
                    closeSidebar();
                }
            });
        });
    </script>

</body>
</html>