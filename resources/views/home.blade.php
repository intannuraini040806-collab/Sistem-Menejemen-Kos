<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#191D22">

    <title>KosHaven - Hunian Nyaman</title>

    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            --silver: #BBC4CD;
            --ivory: #F4F0E8;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --green: #91AE9B;
            --red: #D58F8F;
            --border: rgba(198,164,119,.17);
            --shadow: 0 18px 50px rgba(0,0,0,.22);
            --radius: 17px;
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
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        body.modal-open,
        body.mobile-menu-open {
            overflow: hidden;
        }

        button, input, select {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        a {
            color: inherit;
        }

        img {
            max-width: 100%;
        }

        .container {
            width: min(1180px, calc(100% - 48px));
            margin: auto;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--gold-light);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .section-heading h2,
        .about-content h2 {
            margin-top: 13px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 4vw, 43px);
            line-height: 1.25;
            font-weight: 600;
        }

        .section-heading h2 span,
        .about-content h2 span {
            color: var(--gold-light);
        }

        .section-heading p,
        .about-content > p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        /* NAVBAR */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1200;
            padding: 0;
            background: rgba(18,22,27,.96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(18px);
            transition: background .3s ease, box-shadow .3s ease;
        }

        .navbar.is-scrolled {
            background: rgba(14,18,23,.98);
            box-shadow: 0 10px 30px rgba(0,0,0,.32);
        }

        .nav-container {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: var(--ivory);
            text-decoration: none;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.8px;
            white-space: nowrap;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            color: var(--bg-deep);
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            border-radius: 12px;
            font-size: 21px;
        }

        .logo-gold {
            color: var(--gold-light);
        }

        .mobile-nav-panel {
            display: flex;
            align-items: center;
            flex: 1;
            justify-content: space-between;
            gap: 25px;
        }

        .nav-menu {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 26px;
            margin: auto;
        }

        .nav-menu a {
            position: relative;
            padding: 10px 2px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color .28s cubic-bezier(.22, 1, .36, 1), transform .24s cubic-bezier(.22, 1, .36, 1);
        }

        .nav-menu a::before {
            content: "";
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 100%;
            height: 2px;
            border-radius: 5px;
            background: rgba(224,196,155,.35);
            transform: scaleX(0);
            transform-origin: left center;
            transition: transform .28s cubic-bezier(.22, 1, .36, 1), opacity .28s ease;
            opacity: 0;
        }

        .nav-menu a:hover {
            color: var(--gold-light);
            transform: translateY(-1px);
        }

        .nav-menu a:not(.active):hover::before {
            transform: scaleX(.65);
            opacity: 1;
        }

        .nav-menu a.active {
            color: var(--gold-light);
        }

        .nav-menu a:active {
            transform: translateY(0) scale(.97);
        }

        .nav-indicator {
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 22px;
            height: 2.5px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--gold-light), var(--gold));
            box-shadow: 0 0 10px rgba(198,164,119,.45);
            pointer-events: none;
            transition: transform .36s cubic-bezier(.22, 1, .36, 1), width .36s cubic-bezier(.22, 1, .36, 1), opacity .25s ease;
            will-change: transform, width;
        }

        .nav-menu:not(.has-indicator) a.active::after {
            content: "";
            position: absolute;
            bottom: 2px;
            left: 0;
            width: 22px;
            height: 2.5px;
            border-radius: 999px;
            background: var(--gold);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login,
        .btn-register {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 42px;
            padding: 0 17px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: background .25s ease, color .25s ease, border-color .25s ease, transform .25s ease;
        }

        .btn-login {
            background: rgba(255,255,255,.03);
            color: var(--ivory);
            border: 1px solid var(--border);
        }

        .btn-login:hover {
            background: var(--surface);
            color: var(--gold-light);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .btn-register {
            color: var(--bg-deep);
            background: var(--gold-light);
        }

        .btn-register:hover,
        .btn-primary:hover,
        .btn-cta:hover {
            background: var(--gold);
            transform: translateY(-2px);
        }

        .menu-toggle {
            display: none;
            width: 43px;
            height: 43px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--gold-light);
            background: var(--surface);
            font-size: 23px;
            cursor: pointer;
        }

        .mobile-nav-overlay {
            display: none;
        }

        /* HERO */

        .hero {
            position: relative;
            min-height: 650px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: var(--bg-deep);
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: .55;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(18,22,27,.97) 0%, rgba(18,22,27,.83) 48%, rgba(18,22,27,.3) 100%),
                linear-gradient(0deg, rgba(18,22,27,.8), transparent 40%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding-top: 75px;
            padding-bottom: 120px;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            color: var(--gold-light);
            background: rgba(198,164,119,.12);
            border: 1px solid rgba(198,164,119,.3);
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.7px;
        }

        .hero-content h1 {
            max-width: 730px;
            margin: 25px 0 18px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(43px, 6.5vw, 76px);
            line-height: 1.13;
            font-weight: 600;
        }

        .hero-content h1 span {
            color: var(--gold-light);
        }

        .hero-content > p {
            max-width: 540px;
            color: #C1C5C8;
            font-size: 15px;
            line-height: 1.9;
        }

        .hero-buttons {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 13px;
            margin-top: 30px;
        }

        .btn-primary,
        .btn-outline {
            min-height: 49px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0 22px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-primary {
            color: var(--bg-deep);
            background: var(--gold-light);
        }

        .btn-outline {
            color: var(--ivory);
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.04);
        }

        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold-light);
            background: rgba(198,164,119,.1);
        }

        .hero-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 2;
            width: 100%;
            background: rgba(18,22,27,.78);
            border-top: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(12px);
        }

        .hero-bottom-content {
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .hero-bottom-content span {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--silver);
            font-size: 12px;
            font-weight: 600;
        }

        .hero-bottom-content i {
            color: var(--gold-light);
            font-size: 17px;
        }

        /* SEARCH */

        .search-section {
            position: relative;
            z-index: 5;
            margin-top: -1px;
            padding: 30px 0;
            background: var(--bg);
        }

        .search-box {
            display: grid;
            grid-template-columns: 1fr 1px 1fr 1px 1fr auto;
            align-items: center;
            gap: 20px;
            padding: 21px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .search-item {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .search-item > i {
            color: var(--gold);
            font-size: 23px;
        }

        .search-item > div {
            flex: 1;
            min-width: 0;
        }

        .search-item label {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
        }

        .search-item select {
            width: 100%;
            min-width: 0;
            color: var(--ivory);
            background: transparent;
            border: 0;
            outline: 0;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .search-item select:disabled {
            color: var(--muted);
            cursor: not-allowed;
        }

        .search-item select option {
            color: var(--text);
            background: var(--surface);
        }

        .search-divider {
            width: 1px;
            height: 38px;
            background: var(--border);
        }

        .btn-search {
            min-height: 48px;
            padding: 0 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 9px;
            color: var(--bg-deep);
            background: var(--gold-light);
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s;
        }

        .btn-search:hover {
            background: var(--gold);
        }

        /* BENEFIT */

        .benefit-section {
            padding: 30px 0 65px;
        }

        .benefit-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 17px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 22px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .benefit-icon {
            flex: 0 0 49px;
            width: 49px;
            height: 49px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--gold-light);
            background: rgba(198,164,119,.12);
            font-size: 22px;
        }

        .benefit-item h3 {
            margin-bottom: 5px;
            color: var(--ivory);
            font-size: 14px;
        }

        .benefit-item p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        /* ROOM SECTION */

        .room-section {
            padding: 85px 0;
            background: var(--bg-deep);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 25px;
            margin-bottom: 32px;
        }

        .section-heading > div {
            max-width: 650px;
        }

        .section-heading p {
            margin-top: 13px;
        }

        .see-all {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            flex-shrink: 0;
            padding-bottom: 7px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
        }

        .see-all:hover {
            color: var(--ivory);
        }

        .room-availability-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 17px;
            margin-bottom: 30px;
        }

        .availability-summary-card {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
            padding: 19px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .availability-summary-icon {
            flex: 0 0 47px;
            width: 47px;
            height: 47px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: var(--gold-light);
            background: rgba(198,164,119,.12);
            font-size: 21px;
        }

        .availability-summary-card span {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .availability-summary-card strong {
            display: block;
            color: var(--ivory);
            font-size: 20px;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 22px;
        }

        .room-card {
            min-width: 0;
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: .25s;
        }

        .room-card:hover {
            transform: translateY(-5px);
            border-color: rgba(198,164,119,.48);
            box-shadow: var(--shadow);
        }

        .room-image {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: var(--surface-light);
        }

        .room-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .4s;
        }

        .room-card:hover .room-image img {
            transform: scale(1.045);
        }

        .room-status {
            position: absolute;
            top: 14px;
            right: 14px;
            padding: 7px 11px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
        }

        .room-status.available {
            color: #B8D8C2;
            background: rgba(32,75,52,.9);
        }

        .room-status.unavailable {
            color: #F0B7B7;
            background: rgba(105,42,42,.9);
        }

        .room-info {
            padding: 21px;
        }

        .room-type {
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .room-info h3 {
            margin: 9px 0;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 20px;
        }

        .room-location {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--muted);
            font-size: 11px;
        }

        .room-location i {
            color: var(--gold);
        }

        .room-facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 17px;
        }

        .room-facilities span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 9px;
            color: var(--silver);
            background: var(--surface-light);
            border-radius: 6px;
            font-size: 10px;
        }

        .room-facilities i {
            color: var(--gold);
        }

        .room-occupancy-info {
            margin-top: 14px;
            color: var(--muted);
            font-size: 11px;
        }

        .room-occupancy-info i {
            color: var(--gold);
        }

        .room-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 19px;
            padding-top: 17px;
            border-top: 1px solid var(--border);
        }

        .price-label {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        .room-footer strong {
            color: var(--gold-light);
            font-size: 17px;
        }

        .room-button {
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--gold-light);
            background: var(--surface-light);
            font-size: 17px;
            cursor: pointer;
            transition: .2s;
        }

        .room-button:hover {
            color: var(--bg-deep);
            background: var(--gold-light);
        }

        .room-empty-state {
            grid-column: 1/-1;
            padding: 55px 20px;
            text-align: center;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 15px;
        }

        .room-empty-state > i {
            display: block;
            margin-bottom: 14px;
            color: var(--gold);
            font-size: 42px;
        }

        .room-empty-state h3 {
            margin-bottom: 8px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 24px;
        }

        .room-empty-state p,
        .room-search-empty {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .room-search-empty {
            display: none;
            margin-top: 25px;
            text-align: center;
        }

        /* ABOUT */

        .about-section {
            padding: 95px 0;
            background: var(--bg);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 65px;
        }

        .about-image {
            position: relative;
            min-width: 0;
        }

        .about-image > img {
            width: 100%;
            height: 440px;
            display: block;
            object-fit: cover;
            border-radius: 18px;
            border: 1px solid var(--border);
        }

        .about-badge {
            position: absolute;
            right: -20px;
            bottom: 25px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 17px 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .about-badge > i {
            color: var(--gold-light);
            font-size: 27px;
        }

        .about-badge strong,
        .about-badge span {
            display: block;
        }

        .about-badge strong {
            color: var(--ivory);
            font-size: 12px;
        }

        .about-badge span {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
        }

        .about-content > p {
            margin-top: 17px;
        }

        .about-points {
            display: grid;
            gap: 13px;
            margin: 23px 0 27px;
        }

        .about-points div {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--silver);
            font-size: 13px;
        }

        .about-points i {
            color: var(--gold-light);
            font-size: 16px;
        }

        /* FASILITAS KOSHAVEN */

        .facility-section {
            padding: 85px 0;
            background: var(--bg-deep);
            border-top: 1px solid var(--border);
        }

        .facility-header {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 46px;
        }

        .facility-header h2 {
            margin-top: 13px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(28px, 3.8vw, 40px);
            line-height: 1.25;
            font-weight: 600;
        }

        .facility-header h2 span {
            color: var(--gold-light);
        }

        .facility-header p {
            margin-top: 12px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .facility-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .facility-card {
            padding: 26px 24px;
            border-radius: var(--radius);
            background: var(--surface);
            border: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }

        .facility-card:hover {
            transform: translateY(-4px);
            border-color: rgba(198,164,119,.42);
            box-shadow: var(--shadow);
        }

        .facility-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: rgba(198,164,119,.13);
            border: 1px solid rgba(198,164,119,.24);
            color: var(--gold-light);
            display: grid;
            place-items: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .facility-card h3 {
            color: var(--ivory);
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .facility-card p {
            color: var(--muted);
            font-size: 12.5px;
            line-height: 1.7;
        }

        @media (max-width: 960px) {
            .facility-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .facility-grid {
                grid-template-columns: 1fr;
            }
        }

        /* STATISTIC */

        .statistic-section {
            padding: 50px 0;
            background: var(--surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .statistic-grid {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 20px;
        }

        .statistic-item {
            text-align: center;
            padding: 15px;
        }

        .statistic-item > i {
            color: var(--gold-light);
            font-size: 27px;
        }

        .statistic-item h3 {
            margin: 12px 0 6px;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: 22px;
        }

        .statistic-item p {
            color: var(--muted);
            font-size: 11px;
        }

        /* CTA */

        .cta-section {
            padding: 75px 0;
            background:
                radial-gradient(circle at 90% 10%, rgba(198,164,119,.14), transparent 35%),
                var(--bg-deep);
        }

        .cta-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 38px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
        }

        .cta-content > div > span {
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
        }

        .cta-content h2 {
            max-width: 620px;
            margin: 12px 0;
            color: var(--ivory);
            font-family: 'Playfair Display', serif;
            font-size: clamp(25px, 3.5vw, 36px);
            line-height: 1.3;
        }

        .cta-content p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .btn-cta {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 0 22px;
            border-radius: 9px;
            color: var(--bg-deep);
            background: var(--gold-light);
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            transition: .2s;
        }

        /* FOOTER */

        .footer {
            padding-top: 65px;
            background: #101419;
            border-top: 1px solid var(--border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 40px;
            padding-bottom: 45px;
        }

        .footer-logo {
            margin-bottom: 18px;
        }

        .footer-about > p {
            max-width: 280px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .social-links {
            display: flex;
            gap: 9px;
            margin-top: 20px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            color: var(--gold-light);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 9px;
            text-decoration: none;
            transition: .2s;
        }

        .social-links a:hover {
            color: var(--bg-deep);
            background: var(--gold-light);
        }

        .social-links a.is-unavailable {
            opacity: .4;
            cursor: not-allowed;
        }

        .footer-links h4 {
            margin-bottom: 19px;
            color: var(--ivory);
            font-size: 13px;
        }

        .footer-links > a {
            display: block;
            width: fit-content;
            margin-bottom: 13px;
            color: var(--muted);
            text-decoration: none;
            font-size: 12px;
            transition: .2s;
        }

        .footer-links > a:hover {
            color: var(--gold-light);
        }

        .footer-links p {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 13px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .footer-links p i {
            color: var(--gold);
            font-size: 14px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .footer-bottom .container {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .footer-bottom p {
            color: #858D96;
            font-size: 10px;
        }

        /* MODAL UMUM */

        .rules-modal,
        .room-detail-modal {
            position: fixed;
            inset: 0;
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-y: auto;
            background: rgba(5,8,12,.82);
            backdrop-filter: blur(5px);
        }

        .rules-modal.show,
        .room-detail-modal.show {
            display: flex;
        }

        .rules-dialog,
        .room-detail-dialog {
            position: relative;
            width: min(850px,100%);
            max-height: min(90dvh,900px);
            overflow-y: auto;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 25px 80px rgba(0,0,0,.4);
            animation: modalIn .22s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(12px) scale(.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .rules-close,
        .room-detail-close {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 3;
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50%;
            color: var(--ivory);
            background: rgba(18,22,27,.75);
            cursor: pointer;
        }

        .rules-header {
            position: relative;
            padding: 32px;
            background: linear-gradient(125deg,#171C22,#34312B);
            border-bottom: 1px solid var(--border);
        }

        .rules-header-label {
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .rules-header h2 {
            max-width: 650px;
            margin: 15px 40px 10px 0;
            color: var(--ivory);
            font-family: 'Playfair Display',serif;
            font-size: clamp(25px,4vw,34px);
            line-height: 1.3;
        }

        .rules-header p {
            max-width: 620px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .rules-body {
            padding: 25px 30px;
        }

        .rules-intro,
        .rules-note {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
            margin-bottom: 20px;
            color: var(--muted);
            background: rgba(198,164,119,.08);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.8;
        }

        .rules-intro i,
        .rules-note i {
            flex-shrink: 0;
            color: var(--gold);
            font-size: 18px;
        }

        .rules-list {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 12px;
        }

        .rule-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--bg);
        }

        .rule-icon {
            flex: 0 0 36px;
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            color: var(--gold-light);
            background: rgba(198,164,119,.12);
            font-size: 17px;
        }

        .rule-content h3 {
            margin-bottom: 8px;
            color: var(--ivory);
            font-size: 12px;
        }

        .rule-content ul {
            padding-left: 15px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.8;
        }

        .rule-content li {
            margin-bottom: 4px;
        }

        .rules-note {
            margin: 20px 0 0;
        }

        .rules-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 30px;
            border-top: 1px solid var(--border);
        }

        .rules-footer p {
            color: var(--muted);
            font-size: 11px;
        }

        .rules-understand-button {
            min-height: 42px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            color: var(--bg-deep);
            background: var(--gold-light);
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
        }

        /* DETAIL KAMAR */

        .room-detail-dialog {
            width: min(900px,100%);
        }

        .room-detail-image {
            width: 100%;
            height: 310px;
            display: block;
            object-fit: cover;
            background: var(--surface-light);
        }

        .room-detail-content {
            padding: 28px;
        }

        .room-detail-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .room-detail-type {
            color: var(--gold-light);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .room-detail-status {
            padding: 7px 11px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
        }

        .room-detail-status.available {
            color: #B8D8C2;
            background: rgba(32,75,52,.45);
        }

        .room-detail-status.unavailable {
            color: #F0B7B7;
            background: rgba(105,42,42,.45);
        }

        .room-detail-content h2 {
            margin-bottom: 10px;
            color: var(--ivory);
            font-family: 'Playfair Display',serif;
            font-size: 30px;
        }

        .room-detail-description {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .room-detail-section-title {
            margin: 23px 0 13px;
            color: var(--ivory);
            font-size: 14px;
        }

        .room-detail-facilities {
            display: grid;
            grid-template-columns: repeat(2,minmax(0,1fr));
            gap: 10px;
        }

        .room-detail-facility {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
            padding: 12px;
            color: var(--silver);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            font-size: 11px;
        }

        .room-detail-facility i {
            flex-shrink: 0;
            color: var(--gold);
            font-size: 15px;
        }

        .room-detail-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .room-detail-price-label {
            display: block;
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .room-detail-price {
            color: var(--gold-light);
            font-size: 19px;
            font-weight: 800;
        }

        .room-detail-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .room-detail-whatsapp,
        .room-detail-booking {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
        }

        .room-detail-whatsapp {
            color: var(--ivory);
            background: var(--surface-light);
        }

        .room-detail-booking {
            color: var(--bg-deep);
            background: var(--gold-light);
        }

        .room-detail-booking:disabled {
            color: var(--muted);
            background: var(--surface-light);
            cursor: not-allowed;
        }

        button:focus-visible,
        a:focus-visible,
        select:focus-visible {
            outline: 3px solid rgba(224,196,155,.65);
            outline-offset: 3px;
        }

        /* RESPONSIVE TABLET */

        @media (max-width: 1050px) {
            .nav-menu {
                gap: 15px;
            }

            .nav-menu a {
                font-size: 11px;
            }

            .search-box {
                gap: 13px;
                padding: 16px;
            }

            .room-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
            }

            .about-grid {
                gap: 35px;
            }

            .footer-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
            }
        }

        @media (max-width: 1024px) {
            .nav-container {
                min-height: 72px;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
                margin-left: auto;
            }

            .mobile-nav-panel {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                width: 100%;
                max-height: calc(100dvh - 75px);
                overflow-y: auto;
                padding: 20px;
                background: var(--bg-deep);
                border: 1px solid var(--border);
                border-top: 0;
                box-shadow: var(--shadow);
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
            }

            .mobile-nav-panel.show {
                display: flex;
            }

            .nav-menu {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
            }

            .nav-menu a {
                padding: 13px;
                border-radius: 8px;
                font-size: 13px;
            }

            .nav-menu a::before,
            .nav-menu a.active::after,
            .nav-indicator {
                display: none;
            }

            .nav-menu a:hover,
            .nav-menu a.active {
                background: var(--surface);
                transform: translateX(4px);
            }

            .nav-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
                padding-top: 16px;
                border-top: 1px solid var(--border);
            }

            .mobile-nav-overlay.show {
                display: block;
                position: fixed;
                inset: 72px 0 0;
                z-index: 1100;
                background: rgba(0,0,0,.55);
            }

            .navbar {
                z-index: 1200;
            }

            .search-box {
                grid-template-columns: 1fr 1fr;
            }

            .search-divider {
                display: none;
            }

            .btn-search {
                grid-column: 1/-1;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .about-image {
                max-width: 650px;
            }

            .about-image > img {
                height: 380px;
            }
        }

        /* RESPONSIVE MOBILE */

        @media (max-width: 650px) {
            .container {
                width: min(100% - 32px, 1180px);
            }

            .hero {
                min-height: 600px;
            }

            .hero-content {
                padding-top: 65px;
                padding-bottom: 130px;
            }

            .hero-content h1 {
                font-size: clamp(39px,10vw,58px);
            }

            .hero-content > p {
                font-size: 13px;
            }

            .hero-bottom-content {
                min-height: auto;
                padding-top: 14px;
                padding-bottom: 14px;
                display: grid;
                grid-template-columns: 1fr;
                gap: 11px;
            }

            .hero-bottom-content span {
                font-size: 10px;
            }

            .search-section {
                padding: 22px 0;
            }

            .search-box {
                grid-template-columns: 1fr;
                gap: 19px;
                padding: 18px;
            }

            .btn-search {
                grid-column: auto;
                width: 100%;
            }

            .benefit-section {
                padding: 20px 0 50px;
            }

            .benefit-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .benefit-item {
                padding: 16px;
            }

            .room-section,
            .about-section {
                padding: 65px 0;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .section-heading h2,
            .about-content h2 {
                font-size: 32px;
            }

            .room-availability-summary {
                grid-template-columns: repeat(2,minmax(0,1fr));
                gap: 10px;
            }

            .availability-summary-card {
                padding: 13px;
                gap: 10px;
            }

            .availability-summary-icon {
                flex-basis: 37px;
                width: 37px;
                height: 37px;
                font-size: 17px;
            }

            .availability-summary-card span {
                font-size: 9px;
                line-height: 1.5;
            }

            .availability-summary-card strong {
                font-size: 16px;
            }

            .room-grid {
                grid-template-columns: 1fr;
                gap: 17px;
            }

            .room-image {
                height: 220px;
            }

            .about-image > img {
                height: 300px;
            }

            .about-badge {
                right: 10px;
                bottom: 12px;
                padding: 12px;
            }

            .statistic-grid {
                grid-template-columns: repeat(2,1fr);
                gap: 12px;
            }

            .statistic-item {
                padding: 12px 5px;
            }

            .cta-content {
                align-items: flex-start;
                flex-direction: column;
                padding: 25px 20px;
            }

            .btn-cta {
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px 20px;
            }

            .footer-about {
                grid-column: 1/-1;
            }

            .footer-bottom .container {
                padding-top: 15px;
                padding-bottom: 15px;
                align-items: flex-start;
                flex-direction: column;
            }

            .rules-modal,
            .room-detail-modal {
                padding: 10px;
                align-items: flex-start;
            }

            .rules-dialog,
            .room-detail-dialog {
                max-height: calc(100dvh - 20px);
                margin: auto 0;
                border-radius: 13px;
            }

            .rules-header {
                padding: 26px 20px;
            }

            .rules-header h2 {
                font-size: 26px;
            }

            .rules-body,
            .room-detail-content {
                padding: 20px 17px;
            }

            .rules-list {
                grid-template-columns: 1fr;
            }

            .rules-footer {
                padding: 16px;
                align-items: stretch;
                flex-direction: column;
            }

            .rules-footer p {
                text-align: center;
            }

            .rules-understand-button {
                width: 100%;
            }

            .room-detail-image {
                height: 220px;
            }

            .room-detail-content h2 {
                font-size: 25px;
            }

            .room-detail-bottom {
                align-items: stretch;
                flex-direction: column;
            }

            .room-detail-actions {
                display: grid;
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 390px) {
            .container {
                width: calc(100% - 26px);
            }

            .logo {
                font-size: 20px;
            }

            .logo-icon {
                width: 38px;
                height: 38px;
            }

            .room-availability-summary {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-about {
                grid-column: auto;
            }

            .room-detail-facilities {
                grid-template-columns: 1fr;
            }
        }


        /* RESPONSIVE REFINEMENT */
        .room-card[hidden] {
            display: none !important;
        }

        .footer-links,
        .footer-about {
            min-width: 0;
        }

        .footer-links a,
        .footer-links p,
        .footer-about p {
            overflow-wrap: anywhere;
            word-break: normal;
        }

        @media (max-width: 1024px) {
            .navbar {
                position: sticky;
                isolation: isolate;
            }

            .nav-container {
                min-height: 72px;
            }

            .menu-toggle {
                position: relative;
                z-index: 1204;
                display: grid;
                place-items: center;
                flex: 0 0 44px;
                margin-left: auto;
            }

            .mobile-nav-panel {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1203;
                display: none;
                width: 100%;
                max-height: calc(100dvh - 72px);
                overflow-x: hidden;
                overflow-y: auto;
                overscroll-behavior: contain;
                padding: 20px max(20px, calc((100% - 1180px) / 2));
                background: var(--bg-deep);
                border: 1px solid var(--border);
                border-top: 0;
                box-shadow: var(--shadow);
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
            }

            .mobile-nav-panel.show {
                display: flex;
            }

            .nav-menu {
                width: 100%;
                margin: 0;
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
            }

            .nav-menu a {
                display: block;
                padding: 13px 14px;
                border-radius: 8px;
                font-size: 13px;
            }

            .nav-menu a::before,
            .nav-menu a.active::after,
            .nav-indicator {
                display: none;
            }

            .nav-menu a:hover,
            .nav-menu a.active {
                background: var(--surface);
                transform: translateX(4px);
            }

            .nav-actions {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                padding-top: 16px;
                border-top: 1px solid var(--border);
            }

            .mobile-nav-overlay.show {
                display: block;
                position: fixed;
                inset: 72px 0 0;
                z-index: 1100;
                background: rgba(0,0,0,.58);
            }

            .search-box {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .search-divider {
                display: none;
            }

            .btn-search {
                grid-column: 1 / -1;
            }

            .room-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .about-grid {
                gap: 35px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 650px) {
            .mobile-nav-panel {
                padding: 16px;
            }

            .search-box {
                grid-template-columns: minmax(0, 1fr);
            }

            .btn-search {
                grid-column: auto;
                width: 100%;
            }

            .room-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 28px 18px;
            }

            .footer-about {
                grid-column: 1 / -1;
            }

            .footer-links {
                min-width: 0;
            }

            .rules-modal,
            .room-detail-modal {
                overscroll-behavior: contain;
            }
        }

        @media (max-width: 390px) {
            .footer-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .footer-about {
                grid-column: auto;
            }

            .nav-actions {
                grid-template-columns: minmax(0, 1fr);
            }

            .hero-buttons {
                align-items: stretch;
                flex-direction: column;
            }

            .hero-buttons a {
                width: 100%;
            }

            .room-footer {
                align-items: flex-start;
            }

            .room-detail-actions {
                width: 100%;
            }

            .room-detail-actions > * {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *:not(.nav-indicator):not(.nav-menu a) {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar" id="mainNavbar">
        <div class="container nav-container">

            <a href="{{ url('/') }}" class="logo">
                <span class="logo-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </span>
                <span>Kos<span class="logo-gold">Haven</span></span>
            </a>

            <div class="mobile-nav-panel" id="mobileNavPanel">
                <nav class="nav-menu" id="primaryNavigation" aria-label="Navigasi utama">
                    <a href="#home" class="active" data-nav-target="home">Beranda</a>
                    <a href="#kamar" data-nav-target="kamar">Pilihan Kamar</a>
                    <a href="#fasilitas" data-nav-target="fasilitas">Fasilitas</a>
                    <a href="#tentang" data-nav-target="tentang">Tentang Kami</a>
                    <a href="#peraturan-kos" id="openRulesButton" data-nav-target="peraturan-kos">Peraturan Kos</a>
                    <span class="nav-indicator" id="navIndicator" aria-hidden="true"></span>
                </nav>

                <div class="nav-actions">
                    <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar Sekarang</a>
                </div>
            </div>

            <button type="button" class="menu-toggle" id="menuToggle"
                    aria-label="Buka menu" aria-expanded="false"
                    aria-controls="mobileNavPanel">
                <i class="bi bi-list"></i>
            </button>

        </div>
    </header>

    <div class="mobile-nav-overlay" id="mobileNavOverlay" aria-hidden="true"></div>

    <!-- HERO -->
    <section class="hero" id="home">

        <img
            src="{{ asset('image/gambar utama navbar.jpeg') }}"
            alt="Hunian modern dan nyaman KosHaven"
            class="hero-bg"
            fetchpriority="high"
        >

        <div class="hero-overlay"></div>

        <div class="container hero-content">

            <span class="hero-label">
                <i class="bi bi-stars"></i>
                TEMUKAN TEMPAT TINGGAL IDEALMU
            </span>

            <h1>
                Hunian Nyaman,<br>
                <span>Hidup Lebih Tenang.</span>
            </h1>

            <p>
                Temukan tempat tinggal yang nyaman, aman, dan sesuai
                kebutuhanmu. Kami hadir untuk memberikan pengalaman
                tinggal yang lebih baik.
            </p>

            <div class="hero-buttons">
                <a href="#kamar" class="btn-primary">
                    Jelajahi Kamar
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="#tentang" class="btn-outline">
                    Tentang Kami
                </a>
            </div>

        </div>

        <div class="hero-bottom">
            <div class="container hero-bottom-content">
                <span><i class="bi bi-shield-check"></i> Hunian Aman dan Terpercaya</span>
                <span><i class="bi bi-house-check"></i> Kamar Nyaman dan Terawat</span>
                <span><i class="bi bi-headset"></i> Layanan Penghuni Responsif</span>
            </div>
        </div>

    </section>

    <!-- SEARCH -->
    <section class="search-section">
        <div class="container">

            <div class="search-box">

                <div class="search-item">
                    <i class="bi bi-geo-alt"></i>
                    <div>
                        <label for="searchLocation">Lokasi</label>
                        <select id="searchLocation" disabled>
                            <option value="">Informasi lokasi belum tersedia</option>
                        </select>
                    </div>
                </div>

                <div class="search-divider"></div>

                <div class="search-item">
                    <i class="bi bi-house-door"></i>
                    <div>
                        <label for="searchType">Tipe Kamar</label>
                        <select id="searchType">
                            <option value="">Semua tipe</option>
                            <option value="single">Kamar Single</option>
                            <option value="double">Kamar Double</option>
                        </select>
                    </div>
                </div>

                <div class="search-divider"></div>

                <div class="search-item">
                    <i class="bi bi-wallet2"></i>
                    <div>
                        <label for="searchBudget">Anggaran</label>
                        <select id="searchBudget">
                            <option value="">Semua harga</option>
                            <option value="under1">Di bawah Rp1 juta</option>
                            <option value="1to2">Rp1 juta - Rp2 juta</option>
                            <option value="above2">Di atas Rp2 juta</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn-search" id="searchButton">
                    <i class="bi bi-search"></i>
                    Cari Kamar
                </button>

            </div>
        </div>
    </section>

    <!-- BENEFIT -->
    <section class="benefit-section">
        <div class="container benefit-grid">

            <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-shield-lock"></i></div>
                <div>
                    <h3>Keamanan Terjamin</h3>
                    <p>Lingkungan yang aman dan nyaman untuk penghuni.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-wifi"></i></div>
                <div>
                    <h3>Fasilitas Lengkap</h3>
                    <p>Fasilitas yang mendukung aktivitas sehari-hari.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-credit-card"></i></div>
                <div>
                    <h3>Pembayaran Mudah</h3>
                    <p>Kelola pembayaran kos dengan lebih praktis.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- PILIHAN KAMAR -->
    <section class="room-section" id="kamar">
        <div class="container">

            <div class="section-heading">
                <div>
                    <span class="section-label">PILIHAN HUNIAN</span>
                    <h2>Temukan Kamar <span>Favoritmu</span></h2>
                    <p>
                        Pilih kamar Single atau Double sesuai kebutuhanmu.
                        Informasi kamar ditampilkan langsung dari database.
                    </p>
                </div>

                <a href="#kamar" class="see-all">
                    Lihat Semua Kamar
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- RINGKASAN KAMAR -->
            <div class="room-availability-summary">

                <div class="availability-summary-card">
                    <div class="availability-summary-icon"><i class="bi bi-door-open"></i></div>
                    <div>
                        <span>Kamar Single Tersedia</span>
                        <strong>{{ $totalSingle }} Kamar</strong>
                    </div>
                </div>

                <div class="availability-summary-card">
                    <div class="availability-summary-icon"><i class="bi bi-buildings"></i></div>
                    <div>
                        <span>Kamar Double Tersedia</span>
                        <strong>{{ $totalDouble }} Kamar</strong>
                    </div>
                </div>

                <div class="availability-summary-card">
                    <div class="availability-summary-icon"><i class="bi bi-house-check"></i></div>
                    <div>
                        <span>Total Kamar Tersedia</span>
                        <strong>{{ $totalTersedia }} Kamar</strong>
                    </div>
                </div>

            </div>

            <!-- DATA KAMAR DARI DATABASE -->
            <div class="room-grid" id="roomGrid">

                @forelse ($kamars as $kamar)

                    @php
                        $tersedia = $kamar->status === 'tersedia'
                            && (int) $kamar->jumlah_penghuni < (int) $kamar->kapasitas;

                        $statusLabel = $kamar->status === 'maintenance'
                            ? 'Maintenance'
                            : ($tersedia ? 'Tersedia' : 'Terisi');

                        $fotoKamar = $kamar->foto
                            ? asset('storage/' . $kamar->foto)
                            : asset('image/gambar utama navbar.jpeg');

                        $fasilitasKamar = is_array($kamar->fasilitas)
                            ? $kamar->fasilitas
                            : [];

                        $tipeLabel = $kamar->tipe === 'single'
                            ? 'KAMAR SINGLE'
                            : 'KAMAR DOUBLE';

                        $deskripsiKamar = $kamar->deskripsi
                            ?: 'Kamar kos yang nyaman dan terawat untuk mendukung aktivitas sehari-hari.';

                        $roomData = [
                            'id' => $kamar->id,
                            'nomor' => $kamar->nomor_kamar,
                            'lantai' => $kamar->lantai,
                            'tipe' => $kamar->tipe,
                            'tipe_label' => $tipeLabel,
                            'harga' => $kamar->harga,
                            'kapasitas' => $kamar->kapasitas,
                            'jumlah_penghuni' => $kamar->jumlah_penghuni,
                            'status' => $statusLabel,
                            'tersedia' => $tersedia,
                            'foto' => $fotoKamar,
                            'deskripsi' => $deskripsiKamar,
                            'fasilitas' => $fasilitasKamar,
                            'jenis_kamar_mandi' => $kamar->jenis_kamar_mandi,
                        ];
                    @endphp

                    <article
                        class="room-card"
                        data-type="{{ $kamar->tipe }}"
                        data-price="{{ $kamar->harga }}"
                    >

                        <div class="room-image">
                            <img
                                src="{{ $fotoKamar }}"
                                alt="Kamar {{ ucfirst($kamar->tipe) }} nomor {{ $kamar->nomor_kamar }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('image/gambar utama navbar.jpeg') }}';"
                            >

                            <span class="room-status {{ $tersedia ? 'available' : 'unavailable' }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="room-info">

                            <span class="room-type">{{ $tipeLabel }}</span>

                            <h3>Kamar {{ ucfirst($kamar->tipe) }} - {{ $kamar->nomor_kamar }}</h3>

                            <p class="room-location">
                                <i class="bi bi-door-closed"></i>
                                Nomor kamar: {{ $kamar->nomor_kamar }}
                                <span aria-hidden="true">&bull;</span>
                                Lantai: {{ $kamar->lantai ?? '-' }}
                            </p>

                            <div class="room-facilities">
                                @forelse (array_slice($fasilitasKamar, 0, 3) as $fasilitas)
                                    <span>
                                        <i class="bi bi-check-circle"></i>
                                        {{ is_array($fasilitas) ? ($fasilitas['nama'] ?? 'Fasilitas') : $fasilitas }}
                                    </span>
                                @empty
                                    <span><i class="bi bi-info-circle"></i> Fasilitas belum diatur</span>
                                @endforelse
                            </div>

                            <p class="room-occupancy-info">
                                <i class="bi bi-people"></i>
                                {{ $kamar->jumlah_penghuni }} dari {{ $kamar->kapasitas }} penghuni
                            </p>

                            <div class="room-footer">
                                <div>
                                    <span class="price-label">Harga sewa / bulan</span>
                                    <strong>Rp{{ number_format($kamar->harga, 0, ',', '.') }}</strong>
                                </div>

                                <button
                                    type="button"
                                    class="room-button room-detail-trigger"
                                    aria-label="Lihat detail kamar {{ $kamar->nomor_kamar }}"
                                    data-room="{{ json_encode($roomData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
                                >
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>

                        </div>
                    </article>

                @empty

                    <div class="room-empty-state">
                        <i class="bi bi-house-exclamation"></i>
                        <h3>Belum Ada Kamar</h3>
                        <p>
                            Data kamar belum tersedia. Silakan cek kembali
                            setelah Admin menambahkan data kamar.
                        </p>
                    </div>

                @endforelse

            </div>

            <p id="searchMessage" class="room-search-empty">
                Kamar yang kamu cari belum tersedia.
            </p>

        </div>
    </section>

    <!-- FASILITAS KOSHAVEN -->
    <section class="facility-section" id="fasilitas">
        <div class="container">

            <div class="facility-header">
                <span class="section-label">
                    <i class="bi bi-stars"></i>
                    FASILITAS HUNIAN
                </span>
                <h2>Fasilitas Lengkap <span>KosHaven</span></h2>
                <p>
                    Seluruh fasilitas dirancang untuk menunjang kenyamanan istirahat,
                    produktivitas, dan keamanan penghuni setiap hari.
                </p>
            </div>

            <div class="facility-grid">
                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-wifi"></i></div>
                    <div>
                        <h3>Wi-Fi Berkecepatan Tinggi</h3>
                        <p>Koneksi internet stabil 24 jam untuk mendukung kuliah, kerja jarak jauh, dan hiburan.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-snow"></i></div>
                    <div>
                        <h3>AC &amp; Sirkulasi Nyaman</h3>
                        <p>Kamar sejuk dengan pencahayaan alami dan ventilasi udara yang terawat.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-droplet-half"></i></div>
                    <div>
                        <h3>Kamar Mandi Bersih</h3>
                        <p>Tersedia pilihan kamar mandi dalam maupun bersama dengan air bersih lancar.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-cup-hot"></i></div>
                    <div>
                        <h3>Dapur Bersama Lengkap</h3>
                        <p>Area memasak dan penyimpanan rapi untuk menyiapkan makanan kapan saja.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-camera-video"></i></div>
                    <div>
                        <h3>Parkir Luas &amp; CCTV 24 Jam</h3>
                        <p>Lingkungan kos terpantau kamera keamanan dengan area parkir kendaraan yang aman.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-card-icon"><i class="bi bi-basket"></i></div>
                    <div>
                        <h3>Area Cuci &amp; Laundry</h3>
                        <p>Kemudahan fasilitas pencucian dan jemuran pakaian yang bersih serta praktis.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section class="about-section" id="tentang">
        <div class="container about-grid">

            <div class="about-image">
                <img
                    src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1000&q=85"
                    alt="Interior hunian nyaman"
                    loading="lazy"
                >

                <div class="about-badge">
                    <i class="bi bi-house-heart-fill"></i>
                    <div>
                        <strong>Hunian Nyaman</strong>
                        <span>Tempat terbaik untuk beristirahat</span>
                    </div>
                </div>
            </div>

            <div class="about-content">
                <span class="section-label">TENTANG KAMI</span>

                <h2>
                    Lebih dari Sekadar Kos,
                    <span>Tempat untuk Merasa Nyaman.</span>
                </h2>

                <p>
                    Kami percaya bahwa tempat tinggal yang baik dapat
                    memberikan kenyamanan dan ketenangan dalam menjalani
                    aktivitas sehari-hari.
                </p>

                <p>
                    Melalui Sistem Manajemen KosHaven, kami membantu calon
                    penghuni menemukan kamar yang sesuai serta memudahkan
                    pengelolaan informasi dan pembayaran kos.
                </p>

                <div class="about-points">
                    <div><i class="bi bi-check-circle-fill"></i> Informasi kamar yang jelas</div>
                    <div><i class="bi bi-check-circle-fill"></i> Pengelolaan pembayaran lebih praktis</div>
                    <div><i class="bi bi-check-circle-fill"></i> Pelayanan penghuni yang terorganisir</div>
                </div>

                <a href="{{ route('register') }}" class="btn-primary">
                    Mulai Sekarang
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- STATISTIK -->
    <section class="statistic-section">
        <div class="container statistic-grid">

            <div class="statistic-item">
                <i class="bi bi-buildings"></i>
                <h3>Nyaman</h3>
                <p>Hunian untuk kebutuhanmu</p>
            </div>

            <div class="statistic-item">
                <i class="bi bi-shield-check"></i>
                <h3>Aman</h3>
                <p>Lingkungan yang terjaga</p>
            </div>

            <div class="statistic-item">
                <i class="bi bi-wallet2"></i>
                <h3>Praktis</h3>
                <p>Pembayaran lebih mudah</p>
            </div>

            <div class="statistic-item">
                <i class="bi bi-headset"></i>
                <h3>Responsif</h3>
                <p>Layanan untuk penghuni</p>
            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container cta-content">

            <div>
                <span>WAKTUNYA MENEMUKAN HUNIAN BARUMU</span>
                <h2>Siap Menemukan Tempat Tinggal yang Tepat?</h2>
                <p>Daftar sekarang dan temukan kamar yang sesuai dengan kebutuhanmu.</p>
            </div>

            <a href="{{ route('register') }}" class="btn-cta">
                Daftar Sekarang
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-grid">

            <div class="footer-about">
                <a href="{{ url('/') }}" class="logo footer-logo">
                    <span class="logo-icon"><i class="bi bi-house-heart-fill"></i></span>
                    <span>Kos<span class="logo-gold">Haven</span></span>
                </a>

                <p>
                    Membantu kamu menemukan hunian yang nyaman,
                    aman, dan sesuai kebutuhan.
                </p>

                <div class="social-links">
                    <a href="#" class="is-unavailable" aria-label="Instagram belum diatur" aria-disabled="true" title="Instagram belum diatur">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="#" class="is-unavailable" aria-label="Facebook belum diatur" aria-disabled="true" title="Facebook belum diatur">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="https://wa.me/628815693992?text=Halo%2C%20saya%20ingin%20bertanya%20mengenai%20informasi%20kamar%20kos%20di%20KosHaven."
                       target="_blank" rel="noopener noreferrer" aria-label="Hubungi KosHaven melalui WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="#home">Beranda</a>
                <a href="#kamar">Pilihan Kamar</a>
                <a href="#fasilitas">Fasilitas</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#peraturan-kos" class="open-rules-link">Peraturan Kos</a>
            </div>

            <div class="footer-links">
                <h4>Akun</h4>
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>

            <div class="footer-links">
                <h4>Hubungi Kami</h4>

                <p><i class="bi bi-geo-alt"></i> Indonesia</p>
                <p><i class="bi bi-envelope"></i> info@koshaven.com</p>

                <p>
                    <i class="bi bi-whatsapp"></i>
                    <a href="https://wa.me/628815693992?text=Halo%2C%20saya%20ingin%20bertanya%20mengenai%20informasi%20kamar%20kos%20di%20KosHaven."
                       target="_blank" rel="noopener noreferrer">
                        Hubungi Admin &amp; Petugas
                    </a>
                </p>
            </div>

        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>© {{ date('Y') }} KosHaven. All Rights Reserved.</p>
                <p>Dibuat untuk hunian yang lebih nyaman.</p>
            </div>
        </div>
    </footer>

    <!-- MODAL PERATURAN KOS -->
    <div class="rules-modal" id="rulesModal" aria-hidden="true">
        <div class="rules-dialog" role="dialog" aria-modal="true"
             aria-labelledby="rulesTitle" tabindex="-1">

            <div class="rules-header">
                <button type="button" class="rules-close" id="closeRulesModal"
                        aria-label="Tutup peraturan kos">
                    <i class="bi bi-x-lg"></i>
                </button>

                <span class="rules-header-label">
                    <i class="bi bi-shield-check"></i>
                    KENYAMANAN BERSAMA
                </span>

                <h2 id="rulesTitle">Peraturan dan Tata Tertib KosHaven</h2>

                <p>
                    Pedoman bersama untuk menciptakan lingkungan kos yang aman,
                    bersih, tertib, dan nyaman bagi seluruh penghuni.
                </p>
            </div>

            <div class="rules-body">

                <div class="rules-intro">
                    <i class="bi bi-info-circle-fill"></i>
                    <p>
                        Setiap penghuni diharapkan membaca dan mematuhi
                        peraturan berikut. Peraturan ini dibuat untuk menjaga
                        kenyamanan serta menghormati hak seluruh penghuni KosHaven.
                    </p>
                </div>

                <div class="rules-list">

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-stars"></i></div>
                        <div class="rule-content">
                            <h3>1. Kebersihan dan Kerapian</h3>
                            <ul>
                                <li>Penghuni wajib menjaga kebersihan dan kerapian kamar masing-masing.</li>
                                <li>Sampah harus dibuang pada tempat yang telah disediakan.</li>
                                <li>Area bersama wajib dijaga kebersihannya setelah digunakan.</li>
                                <li>Hindari menyimpan sampah yang dapat menimbulkan bau tidak sedap.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-moon-stars"></i></div>
                        <div class="rule-content">
                            <h3>2. Ketertiban dan Jam Istirahat</h3>
                            <ul>
                                <li>Jam tenang berlaku pukul 22.00 sampai 06.00 WIB.</li>
                                <li>Penghuni wajib menjaga volume suara, musik, dan aktivitas lainnya.</li>
                                <li>Dilarang melakukan kegiatan yang mengganggu ketenangan penghuni lain.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-people"></i></div>
                        <div class="rule-content">
                            <h3>3. Ketentuan Tamu</h3>
                            <ul>
                                <li>Tamu wajib melapor kepada petugas atau pengelola kos.</li>
                                <li>Jam kunjungan tamu berlaku pukul 08.00 sampai 21.00 WIB.</li>
                                <li>Tamu tidak diperbolehkan menginap tanpa persetujuan pengelola.</li>
                                <li>Penghuni bertanggung jawab atas perilaku dan keamanan tamunya.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-house-check"></i></div>
                        <div class="rule-content">
                            <h3>4. Penggunaan Fasilitas</h3>
                            <ul>
                                <li>Fasilitas bersama digunakan secara bergantian dan sesuai fungsinya.</li>
                                <li>Penghuni wajib menjaga fasilitas yang telah disediakan.</li>
                                <li>Dilarang memindahkan atau mengubah fasilitas kamar tanpa izin.</li>
                                <li>Kerusakan akibat kelalaian penghuni menjadi tanggung jawab penghuni yang bersangkutan.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-shield-lock"></i></div>
                        <div class="rule-content">
                            <h3>5. Keamanan Kos</h3>
                            <ul>
                                <li>Pastikan pintu kamar terkunci ketika meninggalkan kamar.</li>
                                <li>Jangan memberikan kunci kamar kepada pihak yang tidak berkepentingan.</li>
                                <li>Dilarang membawa atau menyimpan barang berbahaya maupun barang terlarang.</li>
                                <li>Kejadian mencurigakan wajib segera dilaporkan kepada petugas.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-wallet2"></i></div>
                        <div class="rule-content">
                            <h3>6. Pembayaran Kos</h3>
                            <ul>
                                <li>Pembayaran dilakukan sesuai tanggal jatuh tempo yang telah disepakati.</li>
                                <li>Gunakan metode pembayaran resmi yang disediakan pengelola.</li>
                                <li>Bukti pembayaran wajib disimpan dan diserahkan melalui sistem.</li>
                                <li>Keterlambatan pembayaran harus dikomunikasikan kepada pengelola.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="rule-item">
                        <div class="rule-icon"><i class="bi bi-clipboard-check"></i></div>
                        <div class="rule-content">
                            <h3>7. Ketentuan Umum</h3>
                            <ul>
                                <li>Penghuni wajib menghormati privasi dan hak penghuni lainnya.</li>
                                <li>Dilarang melakukan tindakan yang mengganggu kenyamanan lingkungan kos.</li>
                                <li>Setiap keluhan atau masalah dapat disampaikan kepada petugas.</li>
                                <li>Penghuni diharapkan mengikuti arahan pengelola sesuai ketentuan kos.</li>
                            </ul>
                        </div>
                    </article>

                </div>

                <div class="rules-note">
                    <i class="bi bi-lightbulb-fill"></i>
                    <p>
                        <strong>Catatan:</strong>
                        Peraturan ini merupakan tata tertib umum KosHaven.
                        Ketentuan dapat disesuaikan oleh pengelola dengan tetap
                        memperhatikan kenyamanan, keamanan, dan kesepakatan bersama.
                    </p>
                </div>

            </div>

            <div class="rules-footer">
                <p>Terima kasih telah ikut menjaga kenyamanan lingkungan KosHaven.</p>
                <button type="button" class="rules-understand-button" id="understandRulesButton">
                    Saya Mengerti <i class="bi bi-check-circle"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- MODAL DETAIL KAMAR -->
    <div class="room-detail-modal" id="roomDetailModal" aria-hidden="true">
        <div class="room-detail-dialog" role="dialog" aria-modal="true"
             aria-labelledby="roomDetailTitle" tabindex="-1">

            <button type="button" class="room-detail-close" id="closeRoomDetail"
                    aria-label="Tutup detail kamar">
                <i class="bi bi-x-lg"></i>
            </button>

            <img src="" alt="" class="room-detail-image" id="roomDetailImage">

            <div class="room-detail-content">

                <div class="room-detail-topline">
                    <span class="room-detail-type" id="roomDetailType"></span>
                    <span class="room-detail-status" id="roomDetailStatus"></span>
                </div>

                <h2 id="roomDetailTitle"></h2>
                <p class="room-detail-description" id="roomDetailDescription"></p>

                <h3 class="room-detail-section-title">Informasi Kamar</h3>
                <div id="roomDetailInformation" class="room-detail-facilities"></div>

                <h3 class="room-detail-section-title">Fasilitas Kamar</h3>
                <div id="roomDetailFacilities" class="room-detail-facilities"></div>

                <div class="room-detail-bottom">
                    <div>
                        <span class="room-detail-price-label">Harga sewa / bulan</span>
                        <span class="room-detail-price" id="roomDetailPrice"></span>
                    </div>

                    <div class="room-detail-actions">
                        <a class="room-detail-whatsapp" id="roomDetailWhatsapp"
                           href="https://wa.me/628815693992"
                           target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-whatsapp"></i>
                            Tanya Admin
                        </a>

                        <button type="button" class="room-detail-booking" id="roomDetailBooking">
                            Booking Kamar <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* =====================================
               UTILITAS
            ===================================== */

            const fallbackImage = @json(asset('image/gambar utama navbar.jpeg'));
            const loginUrl = @json(route('login'));
            const whatsappNumber = '628815693992';

            function formatRupiah(value) {
                const number = Number(value);

                if (!Number.isFinite(number) || number < 0) {
                    return 'Harga belum tersedia';
                }

                return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
            }

            function createElement(tag, className, text) {
                const element = document.createElement(tag);

                if (className) element.className = className;
                if (text !== undefined) element.textContent = String(text);

                return element;
            }

            function createRoomInformation(label, value) {
                const item = createElement('div', 'room-detail-facility');
                const icon = createElement('i', 'bi bi-info-circle');
                const text = createElement('span', '', label + ': ' + value);

                icon.setAttribute('aria-hidden', 'true');
                item.append(icon, text);

                return item;
            }

            /* =====================================
               MOBILE MENU
            ===================================== */

            const menuToggle = document.getElementById('menuToggle');
            const mobileNavPanel = document.getElementById('mobileNavPanel');
            const navOverlay = document.getElementById('mobileNavOverlay');
            const mobileBreakpoint = window.matchMedia('(max-width: 1024px)');

            const navLinks = mobileNavPanel.querySelectorAll('.nav-menu a');
            const navActionLinks = mobileNavPanel.querySelectorAll('.nav-actions a');

            mobileNavPanel.setAttribute('aria-hidden', mobileBreakpoint.matches ? 'true' : 'false');

            function openMenu() {
                if (!mobileBreakpoint.matches) return;

                mobileNavPanel.classList.add('show');
                navOverlay.classList.add('show');

                document.body.classList.add('mobile-menu-open');

                menuToggle.setAttribute('aria-expanded', 'true');
                menuToggle.setAttribute('aria-label', 'Tutup menu');

                menuToggle.innerHTML = '<i class="bi bi-x-lg"></i>';

                navOverlay.setAttribute('aria-hidden', 'false');
                mobileNavPanel.setAttribute('aria-hidden', 'false');
            }

            function closeMenu(returnFocus = false) {
                mobileNavPanel.classList.remove('show');
                navOverlay.classList.remove('show');

                document.body.classList.remove('mobile-menu-open');

                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.setAttribute('aria-label', 'Buka menu');

                menuToggle.innerHTML = '<i class="bi bi-list"></i>';

                navOverlay.setAttribute('aria-hidden', 'true');
                mobileNavPanel.setAttribute('aria-hidden', 'true');

                if (returnFocus && mobileBreakpoint.matches) {
                    menuToggle.focus();
                }
            }

            /* Tombol hamburger */
            menuToggle.addEventListener('click', function (event) {
                event.stopPropagation();

                if (mobileNavPanel.classList.contains('show')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            /* Klik area gelap di luar menu */
            navOverlay.addEventListener('click', function () {
                closeMenu();
            });

            /* Klik navigasi + animasi pindah indikator & smooth scroll */
            const primaryNav = document.getElementById('primaryNavigation');
            const navIndicator = document.getElementById('navIndicator');
            const mainNavbar = document.getElementById('mainNavbar');
            let isProgrammaticScroll = false;
            let scrollAnimationId = null;

            function moveNavIndicator(activeLink) {
                if (!primaryNav || !navIndicator || !activeLink || mobileBreakpoint.matches) {
                    return;
                }

                primaryNav.classList.add('has-indicator');
                const navRect = primaryNav.getBoundingClientRect();
                const linkRect = activeLink.getBoundingClientRect();
                const offsetX = linkRect.left - navRect.left;
                const barWidth = Math.max(20, Math.round(linkRect.width * 0.55));

                navIndicator.style.width = barWidth + 'px';
                navIndicator.style.transform = 'translate3d(' + offsetX + 'px, 0, 0)';
            }

            function setActiveNavLink(targetLink) {
                if (!targetLink) return;

                navLinks.forEach(function (item) {
                    const isMatch = item === targetLink;
                    item.classList.toggle('active', isMatch);
                    if (isMatch) {
                        item.setAttribute('aria-current', 'page');
                    } else {
                        item.removeAttribute('aria-current');
                    }
                });

                moveNavIndicator(targetLink);
            }

            function smoothScrollToElement(section) {
                if (!section) return;

                if (scrollAnimationId) {
                    cancelAnimationFrame(scrollAnimationId);
                }

                const navHeight = (mainNavbar ? mainNavbar.offsetHeight : 82) + 8;
                const startY = window.scrollY || window.pageYOffset;
                const targetY = Math.max(
                    0,
                    section.getBoundingClientRect().top + startY - navHeight
                );
                const distance = targetY - startY;

                if (Math.abs(distance) < 4) {
                    isProgrammaticScroll = false;
                    return;
                }

                const duration = Math.min(720, Math.max(420, Math.abs(distance) * 0.35));
                const startTime = performance.now();
                isProgrammaticScroll = true;

                function easeInOutCubic(t) {
                    return t < 0.5
                        ? 4 * t * t * t
                        : 1 - Math.pow(-2 * t + 2, 3) / 2;
                }

                function step(now) {
                    const elapsed = now - startTime;
                    const progress = Math.min(1, elapsed / duration);
                    const eased = easeInOutCubic(progress);

                    window.scrollTo(0, startY + distance * eased);

                    if (progress < 1) {
                        scrollAnimationId = requestAnimationFrame(step);
                    } else {
                        scrollAnimationId = null;
                        setTimeout(function () {
                            isProgrammaticScroll = false;
                        }, 60);
                    }
                }

                scrollAnimationId = requestAnimationFrame(step);
            }

            function getActiveSectionLink() {
                const triggerLine = Math.max(
                    (mainNavbar ? mainNavbar.offsetHeight : 82) + 48,
                    window.innerHeight * 0.35
                );

                const sections = ['home', 'kamar', 'fasilitas', 'tentang']
                    .map(function (id) {
                        const el = document.getElementById(id);
                        return el ? { id: id, top: el.getBoundingClientRect().top } : null;
                    })
                    .filter(Boolean)
                    .sort(function (a, b) {
                        return a.top - b.top;
                    });

                let currentId = sections.length ? sections[0].id : 'home';

                sections.forEach(function (sec) {
                    if (sec.top <= triggerLine) {
                        currentId = sec.id;
                    }
                });

                // Jika sudah mendekati bagian paling bawah halaman, aktifkan seksi terakhir
                const scrolledBottom = window.innerHeight + (window.scrollY || window.pageYOffset);
                const docHeight = document.documentElement.scrollHeight;
                if (sections.length && docHeight - scrolledBottom <= 40) {
                    currentId = sections[sections.length - 1].id;
                }

                return primaryNav.querySelector('a[href="#' + currentId + '"]') || navLinks[0];
            }

            navLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    const href = this.getAttribute('href') || '';

                    setActiveNavLink(this);
                    closeMenu();

                    if (href === '#peraturan-kos') {
                        return;
                    }

                    if (href.startsWith('#') && href.length > 1) {
                        const targetSection = document.querySelector(href);
                        if (targetSection) {
                            event.preventDefault();
                            smoothScrollToElement(targetSection);
                            if (history.replaceState) {
                                history.replaceState(null, '', href);
                            }
                        }
                    }
                });
            });

            window.addEventListener('scroll', function () {
                const y = window.scrollY || window.pageYOffset;
                if (mainNavbar) {
                    mainNavbar.classList.toggle('is-scrolled', y > 20);
                }

                if (isProgrammaticScroll || rulesModal.classList.contains('show')) {
                    return;
                }

                setActiveNavLink(getActiveSectionLink());
            }, { passive: true });

            window.addEventListener('resize', function () {
                const currentActive = primaryNav.querySelector('a.active') || navLinks[0];
                moveNavIndicator(currentActive);
            });

            requestAnimationFrame(function () {
                setActiveNavLink(getActiveSectionLink());
            });

            /* Klik Masuk atau Daftar */
            navActionLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    closeMenu();
                });
            });

            /* Tombol Escape */
            document.addEventListener('keydown', function (event) {
                if (
                    event.key === 'Escape' &&
                    mobileNavPanel.classList.contains('show')
                ) {
                    closeMenu(true);
                }
            });

            /* Tutup menu ketika klik di luar panel */
            document.addEventListener('click', function (event) {
                if (
                    mobileBreakpoint.matches &&
                    mobileNavPanel.classList.contains('show') &&
                    !mobileNavPanel.contains(event.target) &&
                    !menuToggle.contains(event.target)
                ) {
                    closeMenu();
                }
            });

            /* Tutup menu jika ukuran layar berubah menjadi desktop */
            function handleBreakpointChange(event) {
                if (!event.matches) {
                    closeMenu();
                }
            }

            if (typeof mobileBreakpoint.addEventListener === 'function') {
                mobileBreakpoint.addEventListener('change', handleBreakpointChange);
            } else {
                mobileBreakpoint.addListener(handleBreakpointChange);
            }

            /* =====================================
               MODAL PERATURAN
            ===================================== */

            const rulesModal = document.getElementById('rulesModal');
            const rulesDialog = rulesModal.querySelector('.rules-dialog');

            const openRulesButton = document.getElementById('openRulesButton');
            const closeRulesButton = document.getElementById('closeRulesModal');
            const understandRulesButton = document.getElementById('understandRulesButton');

            const footerRulesLinks = document.querySelectorAll('.open-rules-link');

            let lastRulesTrigger = null;

            function openRules(trigger) {
                lastRulesTrigger = trigger || document.activeElement;

                closeMenu();

                rulesModal.classList.add('show');
                rulesModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');

                closeRulesButton.focus();
            }

            function closeRules() {
                rulesModal.classList.remove('show');
                rulesModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');

                setActiveNavLink(getActiveSectionLink());

                if (lastRulesTrigger && typeof lastRulesTrigger.focus === 'function') {
                    lastRulesTrigger.focus();
                }

                lastRulesTrigger = null;
            }

            openRulesButton.addEventListener('click', function (event) {
                event.preventDefault();
                openRules(this);
            });

            footerRulesLinks.forEach(function (link) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    openRules(this);
                });
            });

            closeRulesButton.addEventListener('click', closeRules);
            understandRulesButton.addEventListener('click', closeRules);

            rulesModal.addEventListener('click', function (event) {
                if (event.target === rulesModal) closeRules();
            });

            function trapFocus(event, dialog) {
                if (event.key !== 'Tab') return;

                const focusable = dialog.querySelectorAll(
                    'button:not(:disabled), a[href], select:not(:disabled), [tabindex="0"]'
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

            rulesDialog.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    event.preventDefault();
                    closeRules();
                    return;
                }

                trapFocus(event, rulesDialog);
            });

            /* =====================================
               DETAIL KAMAR
            ===================================== */

            const roomDetailModal = document.getElementById('roomDetailModal');
            const roomDetailDialog = roomDetailModal.querySelector('.room-detail-dialog');

            const closeRoomDetailButton = document.getElementById('closeRoomDetail');
            const roomDetailBooking = document.getElementById('roomDetailBooking');
            const roomDetailWhatsapp = document.getElementById('roomDetailWhatsapp');

            let lastRoomDetailTrigger = null;
            let activeRoomDetail = null;

            const facilityIconMap = {
                'wifi': 'bi-wifi',
                'wi-fi': 'bi-wifi',
                'ac': 'bi-snow',
                'tv': 'bi-tv',
                'lemari': 'bi-door-closed',
                'meja': 'bi-lamp',
                'meja belajar': 'bi-lamp',
                'laundry': 'bi-basket',
                'cctv': 'bi-camera-video',
                'kamar mandi': 'bi-droplet',
                'kamar mandi dalam': 'bi-droplet',
                'parkir': 'bi-p-square',
                'kasur': 'bi-moon',
                'tempat tidur': 'bi-moon'
            };

            function openRoomDetail(button) {
                let room;

                try {
                    room = JSON.parse(button.dataset.room);
                } catch (error) {
                    console.error('Data detail kamar tidak valid:', error);
                    alert('Detail kamar tidak dapat ditampilkan. Silakan muat ulang halaman.');
                    return;
                }

                if (
                    !room ||
                    !room.id ||
                    !['single', 'double'].includes(room.tipe) ||
                    !Number.isFinite(Number(room.harga)) ||
                    !Number.isFinite(Number(room.kapasitas)) ||
                    !Number.isFinite(Number(room.jumlah_penghuni))
                ) {
                    alert('Data kamar tidak lengkap atau tidak valid.');
                    return;
                }

                activeRoomDetail = room;
                lastRoomDetailTrigger = button;

                const imageElement = document.getElementById('roomDetailImage');

                imageElement.onerror = function () {
                    this.onerror = null;
                    this.src = fallbackImage;
                };

                imageElement.src = room.foto || fallbackImage;
                imageElement.alt = 'Kamar ' + String(room.nomor || '');

                document.getElementById('roomDetailType').textContent =
                    room.tipe_label || 'INFORMASI KAMAR';

                document.getElementById('roomDetailTitle').textContent =
                    'Kamar ' + room.tipe.charAt(0).toUpperCase() +
                    room.tipe.slice(1) + ' - ' + String(room.nomor || '-');

                document.getElementById('roomDetailDescription').textContent =
                    room.deskripsi || 'Informasi deskripsi kamar belum tersedia.';

                const statusElement = document.getElementById('roomDetailStatus');

                statusElement.textContent = room.status || 'Tidak diketahui';
                statusElement.className =
                    'room-detail-status ' + (room.tersedia ? 'available' : 'unavailable');

                document.getElementById('roomDetailPrice').textContent =
                    formatRupiah(room.harga);

                const informationContainer =
                    document.getElementById('roomDetailInformation');

                informationContainer.replaceChildren();

                informationContainer.append(
                    createRoomInformation('Nomor kamar', room.nomor || '-'),
                    createRoomInformation('Lantai', room.lantai ?? '-'),
                    createRoomInformation('Kapasitas', room.kapasitas + ' orang'),
                    createRoomInformation('Penghuni saat ini', room.jumlah_penghuni + ' orang'),
                    createRoomInformation(
                        'Kamar mandi',
                        room.jenis_kamar_mandi === 'dalam_kamar'
                            ? 'Dalam kamar'
                            : 'Bersama'
                    )
                );

                const facilitiesContainer =
                    document.getElementById('roomDetailFacilities');

                facilitiesContainer.replaceChildren();

                if (Array.isArray(room.fasilitas) && room.fasilitas.length > 0) {
                    room.fasilitas.forEach(function (facility) {
                        const facilityName =
                            typeof facility === 'object' && facility !== null
                                ? String(facility.nama || facility.name || 'Fasilitas')
                                : String(facility);

                        const normalized = facilityName.toLowerCase().trim();
                        const iconName = facilityIconMap[normalized] || 'bi-check-circle';

                        const item = createElement('div', 'room-detail-facility');
                        const icon = createElement('i', 'bi ' + iconName);
                        const label = createElement('span', '', facilityName);

                        icon.setAttribute('aria-hidden', 'true');
                        item.append(icon, label);
                        facilitiesContainer.appendChild(item);
                    });
                } else {
                    facilitiesContainer.append(
                        createRoomInformation('Fasilitas', 'Belum diatur')
                    );
                }

                const message =
                    'Halo, saya ingin bertanya tentang kamar ' +
                    room.nomor + ' tipe ' + room.tipe +
                    ' di KosHaven. Mohon informasi lebih lanjut.';

                roomDetailWhatsapp.href =
                    'https://wa.me/' + whatsappNumber + '?text=' +
                    encodeURIComponent(message);

                roomDetailBooking.disabled = !room.tersedia;
                roomDetailBooking.innerHTML = room.tersedia
                    ? 'Booking Kamar <i class="bi bi-arrow-right"></i>'
                    : 'Kamar Belum Tersedia';

                roomDetailModal.classList.add('show');
                roomDetailModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');

                closeRoomDetailButton.focus();
            }

            function closeRoomDetail() {
                roomDetailModal.classList.remove('show');
                roomDetailModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');

                activeRoomDetail = null;

                if (lastRoomDetailTrigger) {
                    lastRoomDetailTrigger.focus();
                }

                lastRoomDetailTrigger = null;
            }

            document.querySelectorAll('.room-detail-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    openRoomDetail(this);
                });
            });

            closeRoomDetailButton.addEventListener('click', closeRoomDetail);

            roomDetailModal.addEventListener('click', function (event) {
                if (event.target === roomDetailModal) {
                    closeRoomDetail();
                }
            });

            roomDetailDialog.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    event.preventDefault();
                    closeRoomDetail();
                    return;
                }

                trapFocus(event, roomDetailDialog);
            });

            roomDetailBooking.addEventListener('click', function () {
                if (!activeRoomDetail || !activeRoomDetail.tersedia) return;

                // Pengunjung perlu login sebelum melanjutkan proses booking.
                window.location.href = loginUrl;
            });

            /* =====================================
               FILTER KAMAR
            ===================================== */

            const searchButton = document.getElementById('searchButton');
            const searchType = document.getElementById('searchType');
            const searchBudget = document.getElementById('searchBudget');

            const roomCards = document.querySelectorAll('.room-card');
            const searchMessage = document.getElementById('searchMessage');

            function matchesBudget(price, budget) {
                const roomPrice = Number(price);

                if (!Number.isFinite(roomPrice) || roomPrice < 0) {
                    return false;
                }

                switch (budget) {
                    case 'under1':
                        return roomPrice < 1000000;

                    case '1to2':
                        return roomPrice >= 1000000 && roomPrice <= 2000000;

                    case 'above2':
                        return roomPrice > 2000000;

                    default:
                        return true;
                }
            }

            function filterRooms(scrollToResults = true) {
                const selectedType = searchType.value;
                const selectedBudget = searchBudget.value;

                let visibleRooms = 0;

                roomCards.forEach(function (card) {
                    const roomType = card.dataset.type;
                    const roomPrice = card.dataset.price;

                    const matchesType =
                        selectedType === '' || roomType === selectedType;

                    const matchesPrice =
                        matchesBudget(roomPrice, selectedBudget);

                    const shouldShow = matchesType && matchesPrice;

                    card.hidden = !shouldShow;

                    if (shouldShow) visibleRooms++;
                });

                searchMessage.style.display =
                    roomCards.length > 0 && visibleRooms === 0 ? 'block' : 'none';

                if (scrollToResults) {
                    document.getElementById('kamar').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            searchButton.addEventListener('click', function () {
                filterRooms(true);
            });

            searchType.addEventListener('change', function () {
                filterRooms(false);
            });

            searchBudget.addEventListener('change', function () {
                filterRooms(false);
            });

        });
    </script>

</body>
</html>
