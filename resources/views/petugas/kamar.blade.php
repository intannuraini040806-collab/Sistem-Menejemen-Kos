
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Data Kamar Petugas - KosHaven</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
:root {
    --bg:#191D22;
    --bg-deep:#12161B;
    --surface:#242A31;
    --surface-light:#2D343D;
    --surface-soft:#363E48;

    --gold:#C6A477;
    --gold-light:#E0C49B;
    --silver:#929DA8;
    --silver-light:#BBC4CD;
    --ivory:#F4F0E8;

    --text:#F1F0EC;
    --muted:#A9B0B8;
    --border:rgba(198,164,119,.15);

    --green:#91AE9B;
    --red:#D58F8F;
    --orange:#D9B77F;
    --blue:#9BB4C9;

    --shadow:0 12px 30px rgba(0,0,0,.16);
    --sidebar-width:270px;
}

* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {
    font-family:'DM Sans',sans-serif;
    background:var(--bg);
    color:var(--text);
    min-height:100vh;
}

body,button,input,select,textarea {
    font-family:'DM Sans',sans-serif;
}

button {
    cursor:pointer;
}

button:focus-visible,
a:focus-visible,
input:focus-visible,
select:focus-visible,
textarea:focus-visible {
    outline:2px solid var(--gold-light);
    outline-offset:3px;
}

/* SIDEBAR */

.sidebar {
    position:fixed;
    top:0;
    left:0;
    bottom:0;
    width:var(--sidebar-width);
    background:var(--bg-deep);
    color:var(--text);
    padding:27px 18px;
    z-index:1000;
    display:flex;
    flex-direction:column;
    border-right:1px solid var(--border);
    transition:transform .3s ease;
}

.brand {
    display:flex;
    align-items:center;
    gap:12px;
    padding:0 12px 27px;
    border-bottom:1px solid var(--border);
}

.brand-icon {
    width:43px;
    height:43px;
    border-radius:13px;
    display:grid;
    place-items:center;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    color:var(--bg-deep);
    font-size:22px;
    flex-shrink:0;
}

.brand h2 {
    font-family:'Playfair Display',serif;
    font-size:23px;
    color:var(--ivory);
    letter-spacing:.2px;
}

.brand small {
    color:var(--silver);
    font-size:10px;
}

.nav-label {
    color:#78838E;
    font-size:10px;
    letter-spacing:1.5px;
    font-weight:700;
    margin:27px 12px 12px;
}

.nav-menu {
    display:flex;
    flex-direction:column;
    gap:6px;
}

.nav-link {
    display:flex;
    align-items:center;
    gap:13px;
    padding:12px 14px;
    border-radius:10px;
    text-decoration:none;
    color:#B9C0C8;
    font-size:13px;
    transition:.2s;
}

.nav-link i {
    font-size:17px;
    width:20px;
    text-align:center;
}

.nav-link:hover,
.nav-link.active {
    background:rgba(198,164,119,.13);
    color:var(--gold-light);
}

.nav-link.active {
    border-left:3px solid var(--gold);
    padding-left:11px;
}

.sidebar-bottom {
    margin-top:auto;
    border-top:1px solid var(--border);
    padding-top:17px;
}

.user-info {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
}

.avatar {
    width:38px;
    height:38px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    color:var(--bg-deep);
    display:grid;
    place-items:center;
    font-weight:700;
    flex-shrink:0;
}

.user-info strong {
    font-size:12px;
    display:block;
    color:var(--ivory);
}

.user-info small {
    color:var(--silver);
    font-size:10px;
}

.logout {
    display:flex;
    gap:10px;
    align-items:center;
    width:100%;
    padding:12px;
    border:0;
    background:transparent;
    color:var(--red);
    font-size:13px;
    border-radius:9px;
    transition:.2s;
}

.logout:hover {
    background:rgba(213,143,143,.09);
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
    transition: .2s;
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
/* MAIN */

.main {
    margin-left:var(--sidebar-width);
    padding:32px 38px;
    min-height:100vh;
}

.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin-bottom:30px;
}

.topbar-left {
    display:flex;
    align-items:flex-start;
    gap:14px;
}

.menu-toggle {
    display:none;
    border:1px solid var(--border);
    background:var(--surface);
    border-radius:10px;
    padding:9px 12px;
    font-size:20px;
    color:var(--gold-light);
}

.breadcrumb {
    font-size:12px;
    color:var(--muted);
    margin-bottom:7px;
}

.page-title {
    font-family:'Playfair Display',serif;
    font-size:30px;
    color:var(--ivory);
    font-weight:600;
}

.page-subtitle {
    color:var(--muted);
    font-size:13px;
    margin-top:6px;
}

.date-display {
    background:var(--surface);
    padding:11px 15px;
    border:1px solid var(--border);
    border-radius:10px;
    font-size:12px;
    color:var(--gold-light);
    white-space:nowrap;
}

/* STATISTICS */

.stats {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:17px;
    margin-bottom:25px;
}

.stat-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:14px;
    padding:20px;
    box-shadow:var(--shadow);
    transition:transform .2s,border-color .2s;
}

.stat-card:hover {
    transform:translateY(-3px);
    border-color:rgba(198,164,119,.35);
}

.stat-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:17px;
    gap:10px;
}

.stat-icon {
    width:42px;
    height:42px;
    display:grid;
    place-items:center;
    border-radius:12px;
    font-size:19px;
    flex-shrink:0;
}

.icon-blue {
    background:rgba(155,180,201,.13);
    color:var(--blue);
}

.icon-green {
    background:rgba(145,174,155,.13);
    color:var(--green);
}

.icon-orange {
    background:rgba(217,183,127,.13);
    color:var(--orange);
}

.icon-red {
    background:rgba(213,143,143,.13);
    color:var(--red);
}

.stat-number {
    font-size:28px;
    font-weight:700;
    color:var(--ivory);
    font-variant-numeric:tabular-nums;
}

.stat-label {
    color:var(--muted);
    font-size:12px;
    margin-top:4px;
}

/* CONTENT */

.content-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:15px;
    box-shadow:var(--shadow);
    overflow:hidden;
}

.card-heading {
    padding:22px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    border-bottom:1px solid var(--border);
}

.card-heading h3 {
    font-size:16px;
    color:var(--ivory);
    font-weight:600;
}

.card-heading h3 i {
    color:var(--gold);
    margin-right:7px;
}

.card-heading p {
    color:var(--muted);
    font-size:11px;
    margin-top:6px;
}

/* FILTER */

.filter-area {
    padding:20px 24px;
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.search-box {
    position:relative;
    flex:1;
    min-width:190px;
}

.search-box i {
    position:absolute;
    left:13px;
    top:50%;
    transform:translateY(-50%);
    color:var(--silver);
}

.search-box input {
    width:100%;
    border:1px solid var(--border);
    border-radius:9px;
    padding:11px 12px 11px 38px;
    outline:none;
    font-size:12px;
    background:var(--bg);
    color:var(--text);
}

.search-box input::placeholder {
    color:#7F8994;
}

.search-box input:focus,
.filter-select:focus {
    border-color:var(--gold);
}

.filter-select {
    border:1px solid var(--border);
    border-radius:9px;
    padding:11px 13px;
    background:var(--bg);
    outline:none;
    color:var(--text);
    font-size:12px;
    min-width:145px;
}

.filter-select option,
.form-group select option {
    background:var(--surface);
    color:var(--text);
}

/* TABLE */

.table-wrap {
    overflow-x:auto;
    width:100%;
}

table {
    width:100%;
    border-collapse:collapse;
    min-width:720px;
}

th {
    background:var(--surface-light);
    color:var(--silver);
    text-align:left;
    padding:15px 20px;
    font-size:10px;
    text-transform:uppercase;
    letter-spacing:.7px;
    white-space:nowrap;
}

td {
    padding:16px 20px;
    border-top:1px solid var(--border);
    font-size:12px;
    color:#D6D9DC;
    vertical-align:middle;
}

tbody tr {
    transition:background .2s;
}

tbody tr:hover {
    background:rgba(255,255,255,.025);
}

.room-number {
    font-weight:700;
    color:var(--gold-light);
}

.room-type {
    color:var(--muted);
    font-size:10px;
    margin-top:4px;
}

.status {
    display:inline-flex;
    align-items:center;
    gap:7px;
    border-radius:20px;
    padding:6px 10px;
    font-size:10px;
    font-weight:700;
    white-space:nowrap;
}

.status::before {
    content:'';
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
}

.status.occupied {
    color:var(--green);
    background:rgba(145,174,155,.12);
}

.status.empty {
    color:var(--blue);
    background:rgba(155,180,201,.12);
}

.status.maintenance {
    color:var(--orange);
    background:rgba(217,183,127,.12);
}

.action-btn {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--gold-light);
    border-radius:7px;
    padding:8px 12px;
    font-size:11px;
    transition:.2s;
    white-space:nowrap;
}

.action-btn:hover {
    background:var(--gold);
    border-color:var(--gold);
    color:var(--bg-deep);
}

.empty-state {
    padding:40px 20px;
    text-align:center;
    color:var(--muted);
    font-size:13px;
}

.empty-state i {
    font-size:27px;
    color:var(--silver);
}

.pagination {
    padding:17px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:var(--muted);
    font-size:11px;
    border-top:1px solid var(--border);
    gap:12px;
}

/* MODAL */

.modal {
    display:none;
    position:fixed;
    inset:0;
    z-index:1100;
    background:rgba(0,0,0,.7);
    align-items:center;
    justify-content:center;
    padding:18px;
    backdrop-filter:blur(4px);
}

.modal.show {
    display:flex;
}

.modal-box {
    background:var(--surface);
    border:1px solid var(--border);
    width:100%;
    max-width:470px;
    border-radius:16px;
    padding:25px;
    max-height:90vh;
    overflow-y:auto;
    box-shadow:0 20px 60px rgba(0,0,0,.3);
    animation:modalIn .2s ease;
}

@keyframes modalIn {
    from {
        opacity:0;
        transform:translateY(10px);
    }
    to {
        opacity:1;
        transform:translateY(0);
    }
}

.modal-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    margin-bottom:22px;
}

.modal-header h3 {
    font-family:'Playfair Display',serif;
    color:var(--ivory);
    font-size:22px;
}

.close-modal {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--silver-light);
    border-radius:8px;
    width:35px;
    height:35px;
    font-size:20px;
    flex-shrink:0;
}

.close-modal:hover {
    color:var(--gold-light);
    border-color:var(--gold);
}

.detail-row {
    padding:13px 0;
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    font-size:12px;
}

.detail-row span:first-child {
    color:var(--muted);
    flex-shrink:0;
}

.detail-row strong {
    text-align:right;
    color:var(--ivory);
    font-weight:600;
    overflow-wrap:anywhere;
}

.form-group {
    margin-bottom:17px;
}

.form-group label {
    display:block;
    margin-bottom:8px;
    font-size:12px;
    font-weight:600;
    color:var(--silver-light);
}

.form-group select,
.form-group textarea {
    width:100%;
    padding:12px;
    border:1px solid var(--border);
    border-radius:9px;
    outline:none;
    font-size:12px;
    background:var(--bg);
    color:var(--text);
}

.form-group select:focus,
.form-group textarea:focus {
    border-color:var(--gold);
}

.form-group textarea {
    min-height:95px;
    resize:vertical;
}

.form-group textarea::placeholder {
    color:#7F8994;
}

.form-help {
    color:var(--muted);
    font-size:10px;
    display:block;
    margin-top:7px;
}

.primary-btn {
    border:0;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    color:var(--bg-deep);
    border-radius:9px;
    padding:12px 17px;
    font-size:12px;
    font-weight:700;
    transition:.2s;
}

.primary-btn:hover {
    filter:brightness(1.08);
    transform:translateY(-1px);
}

.modal-actions {
    display:flex;
    justify-content:flex-end;
    flex-wrap:wrap;
    gap:10px;
    margin-top:22px;
}

.secondary-btn {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--silver-light);
    border-radius:9px;
    padding:11px 16px;
    font-size:12px;
}

.secondary-btn:hover {
    border-color:var(--gold);
    color:var(--gold-light);
}

/* TOAST */

.toast {
    position:fixed;
    bottom:25px;
    right:25px;
    max-width:calc(100% - 40px);
    background:var(--bg-deep);
    border:1px solid var(--border);
    color:var(--ivory);
    padding:14px 19px;
    border-radius:10px;
    font-size:12px;
    box-shadow:var(--shadow);
    display:none;
    z-index:1200;
}

/* OVERLAY */

.overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.65);
    z-index:999;
}

/* RESPONSIVE */

@media(max-width:1150px) {
    .stats {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .main {
        padding:27px 24px;
    }
}

@media(max-width:760px) {
    .sidebar {
        transform:translateX(-100%);
    }

    .sidebar.open {
        transform:translateX(0);
    }

    .overlay.show {
        display:block;
    }

    .main {
        margin-left:0;
        padding:20px 15px;
    }

    .menu-toggle {
        display:block;
    }

    .topbar {
        align-items:flex-start;
    }

    .topbar-left {
        gap:11px;
    }

    .page-title {
        font-size:25px;
    }

    .date-display {
        display:none;
    }

    .card-heading {
        align-items:flex-start;
        flex-direction:column;
        padding:18px;
    }

    .filter-area {
        padding:16px;
    }

    .search-box {
        flex-basis:100%;
    }

    .filter-select {
        flex:1;
        min-width:0;
    }

    .pagination {
        padding:15px;
        flex-wrap:wrap;
    }
}

@media(max-width:480px) {
    .main {
        padding:17px 12px;
    }

    .stats {
        gap:10px;
    }

    .stat-card {
        padding:14px;
    }

    .stat-number {
        font-size:23px;
    }

    .stat-label {
        font-size:10px;
    }

    .stat-icon {
        width:35px;
        height:35px;
        font-size:16px;
    }

    .page-title {
        font-size:22px;
    }

    .page-subtitle {
        font-size:11px;
        line-height:1.6;
    }

    .breadcrumb {
        font-size:10px;
    }

    .filter-select {
        font-size:11px;
        padding:10px 8px;
    }

    .modal-box {
        padding:19px;
    }

    .modal-header h3 {
        font-size:20px;
    }

    .detail-row {
        font-size:11px;
    }

    .modal-actions button {
        flex:1;
    }

    .toast {
        left:12px;
        right:12px;
        bottom:15px;
        max-width:none;
    }
}

@media(prefers-reduced-motion:reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior:auto !important;
        animation-duration:.01ms !important;
        transition-duration:.01ms !important;
    }
}
</style>
</head>

<body>

<div class="overlay" id="overlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-house-heart-fill"></i>
        </div>
        <div>
            <h2>KosHaven</h2>
            <small>Boarding House Management</small>
        </div>
    </div>

    <div class="nav-label">MENU UTAMA</div>

    <nav class="nav-menu">
        <a href="{{ route('petugas.dashboard') }}" class="nav-link">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <a href="{{ route('petugas.kamar.index') }}" class="nav-link active" aria-current="page">
            <i class="bi bi-door-open"></i> Data Kamar
        </a>

        <a href="{{ route('petugas.penghuni.index') }}" class="nav-link">
            <i class="bi bi-people"></i> Data Penghuni
        </a>

        <a href="{{ route('petugas.tagihan.index') }}" class="nav-link">
            <i class="bi bi-receipt"></i> Tagihan Bulanan
        </a>

        <a href="{{ route('petugas.pembayaran.index') }}" class="nav-link">
            <i class="bi bi-wallet2"></i> Pembayaran
        </a>

        <a href="{{ route('petugas.aktivitas.index') }}" class="nav-link">
            <i class="bi bi-clock-history"></i> Aktivitas
        </a>
    </nav>

    <div class="nav-label">AKUN</div>

    <nav class="nav-menu">
        <a href="{{ route('petugas.profil.index') }}" class="nav-link">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="user-info">
            <div class="avatar">P</div>
            <div>
                <strong>Petugas Kos</strong>
                <small>Staff Operasional</small>
            </div>
        </div>

        <div class="kh-logout-component-wrapper">
            @include('components.logout-modal')
        </div>
    </div>
</aside>

<main class="main">

    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" type="button"
                aria-label="Buka menu" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <div class="breadcrumb">Petugas / Data Kamar</div>
                <h1 class="page-title">Data Kamar</h1>
                <p class="page-subtitle">
                    Pantau kondisi dan ketersediaan kamar kos.
                </p>
            </div>
        </div>

        <div class="date-display">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </header>

    <!-- STATISTIK KAMAR -->

    <section class="stats">

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Kamar</span>
                <div class="stat-icon icon-blue">
                    <i class="bi bi-door-closed"></i>
                </div>
            </div>
            <div class="stat-number" id="totalRooms">0</div>
            <div class="stat-label">Seluruh kamar kos</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Kamar Terisi</span>
                <div class="stat-icon icon-green">
                    <i class="bi bi-house-check"></i>
                </div>
            </div>
            <div class="stat-number" id="occupiedRooms">0</div>
            <div class="stat-label">Sedang ditempati</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Kamar Kosong</span>
                <div class="stat-icon icon-blue">
                    <i class="bi bi-house"></i>
                </div>
            </div>
            <div class="stat-number" id="emptyRooms">0</div>
            <div class="stat-label">Siap untuk ditempati</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Maintenance</span>
                <div class="stat-icon icon-orange">
                    <i class="bi bi-tools"></i>
                </div>
            </div>
            <div class="stat-number" id="maintenanceRooms">0</div>
            <div class="stat-label">Dalam perawatan</div>
        </div>

    </section>

    <!-- DAFTAR KAMAR -->

    <section class="content-card">

        <div class="card-heading">
            <div>
                <h3>
                    <i class="bi bi-buildings"></i>
                    Daftar Kamar Kos
                </h3>
                <p>Informasi kamar dan kondisi terkini seluruh unit.</p>
            </div>
        </div>

        <div class="filter-area">

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    id="searchInput"
                    placeholder="Cari nomor kamar atau penghuni..."
                    aria-label="Cari kamar"
                    maxlength="100"
                >
            </div>

            <select class="filter-select" id="statusFilter" aria-label="Filter status">
                <option value="all">Semua Status</option>
                <option value="Terisi">Terisi</option>
                <option value="Kosong">Kosong</option>
                <option value="Maintenance">Maintenance</option>
            </select>

            <select class="filter-select" id="floorFilter" aria-label="Filter lantai">
                <option value="all">Semua Lantai</option>
                <option value="1">Lantai 1</option>
                <option value="2">Lantai 2</option>
                <option value="3">Lantai 3</option>
            </select>

        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nomor Kamar</th>
                        <th>Lantai</th>
                        <th>Tipe Kamar</th>
                        <th>Penghuni</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="roomTable"></tbody>
            </table>

            <div class="empty-state" id="emptyState" hidden>
                <i class="bi bi-search"></i>
                <p style="margin-top:8px">Data kamar tidak ditemukan.</p>
            </div>
        </div>

        <div class="pagination">
            <span id="resultCount">Menampilkan 0 kamar</span>
            <span>Data kamar KosHaven</span>
        </div>

    </section>

</main>

<!-- MODAL DETAIL KAMAR -->

<div class="modal" id="detailModal" role="dialog"
    aria-modal="true" aria-labelledby="detailModalTitle">

    <div class="modal-box">

        <div class="modal-header">
            <h3 id="detailModalTitle">Detail Kamar</h3>

            <button class="close-modal" type="button"
                onclick="closeModal('detailModal')" aria-label="Tutup">
                &times;
            </button>
        </div>

        <div id="detailContent"></div>

        <div class="modal-actions">
            <button class="secondary-btn" type="button"
                onclick="closeModal('detailModal')">
                Tutup
            </button>

            <button class="primary-btn" type="button" id="detailUpdateBtn">
                Perbarui Kondisi
            </button>
        </div>

    </div>
</div>

<!-- MODAL UPDATE KAMAR -->

<div class="modal" id="updateModal" role="dialog"
    aria-modal="true" aria-labelledby="updateModalTitle">

    <div class="modal-box">

        <div class="modal-header">
            <h3 id="updateModalTitle">Perbarui Kondisi</h3>

            <button class="close-modal" type="button"
                onclick="closeModal('updateModal')" aria-label="Tutup">
                &times;
            </button>
        </div>

        <form id="updateForm">

            <input type="hidden" id="updateRoomId">

            <div class="form-group">
                <label for="updateStatus">Status Kondisi Kamar</label>

                <select id="updateStatus" required>
                    <option value="">Pilih status</option>
                    <option value="Kosong">Kosong</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Terisi">Terisi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="updateNote">Catatan Kondisi</label>

                <textarea
                    id="updateNote"
                    maxlength="250"
                    placeholder="Contoh: Lampu kamar perlu diganti..."
                ></textarea>

                <small class="form-help">
                    Maksimal 250 karakter.
                </small>
            </div>

            <div class="modal-actions">
                <button type="button" class="secondary-btn"
                    onclick="closeModal('updateModal')">
                    Batal
                </button>

                <button type="submit" class="primary-btn">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
'use strict';

const STORAGE_KEY = 'koshaven_petugas_rooms_v1';

const VALID_STATUSES = ['Terisi', 'Kosong', 'Maintenance'];

const initialRooms = [
    {id:1,number:'A-01',floor:1,type:'Standard',tenant:'Andi Pratama',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:2,number:'A-02',floor:1,type:'Standard',tenant:'Siti Rahma',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:3,number:'A-03',floor:1,type:'Standard',tenant:'-',status:'Kosong',note:'Siap ditempati',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:4,number:'A-04',floor:1,type:'Deluxe',tenant:'Budi Santoso',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, AC, Lemari, WiFi'},
    {id:5,number:'B-01',floor:2,type:'Standard',tenant:'Dewi Lestari',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:6,number:'B-02',floor:2,type:'Deluxe',tenant:'-',status:'Maintenance',note:'Perbaikan AC',facilities:'Kasur, AC, Lemari, WiFi'},
    {id:7,number:'B-03',floor:2,type:'Standard',tenant:'Rina Amelia',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:8,number:'B-04',floor:2,type:'Standard',tenant:'-',status:'Kosong',note:'Siap ditempati',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:9,number:'C-01',floor:3,type:'Deluxe',tenant:'-',status:'Maintenance',note:'Perbaikan saluran air',facilities:'Kasur, AC, Lemari, WiFi'},
    {id:10,number:'C-02',floor:3,type:'Standard',tenant:'Fajar Nugraha',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:11,number:'C-03',floor:3,type:'Standard',tenant:'-',status:'Kosong',note:'Siap ditempati',facilities:'Kasur, Lemari, Kamar Mandi Dalam'},
    {id:12,number:'C-04',floor:3,type:'Deluxe',tenant:'Nadia Putri',status:'Terisi',note:'Kondisi kamar baik',facilities:'Kasur, AC, Lemari, WiFi'}
];

let rooms = loadRooms();
let selectedRoomId = null;
let toastTimeout = null;

function validateRoom(room) {
    return room &&
        Number.isInteger(Number(room.id)) &&
        typeof room.number === 'string' &&
        Number.isInteger(Number(room.floor)) &&
        typeof room.type === 'string' &&
        typeof room.tenant === 'string' &&
        VALID_STATUSES.includes(room.status) &&
        typeof room.note === 'string' &&
        typeof room.facilities === 'string';
}

function loadRooms() {
    try {
        const saved = localStorage.getItem(STORAGE_KEY);

        if (!saved) {
            return initialRooms.map(room => ({...room}));
        }

        const parsed = JSON.parse(saved);

        if (!Array.isArray(parsed)) {
            throw new Error('Format data tidak valid.');
        }

        const validRooms = parsed.filter(validateRoom);

        if (validRooms.length !== parsed.length) {
            console.warn('Beberapa data kamar tidak valid dan tidak ditampilkan.');
        }

        return validRooms;
    } catch (error) {
        console.error('Gagal membaca data kamar:', error);
        return initialRooms.map(room => ({...room}));
    }
}

function saveRooms() {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(rooms));
        return true;
    } catch (error) {
        console.error('Gagal menyimpan data kamar:', error);
        showToast('Gagal menyimpan data pada browser.');
        return false;
    }
}

/* STATISTIK */

function updateStats() {
    document.getElementById('totalRooms').textContent = rooms.length;

    document.getElementById('occupiedRooms').textContent =
        rooms.filter(room => room.status === 'Terisi').length;

    document.getElementById('emptyRooms').textContent =
        rooms.filter(room => room.status === 'Kosong').length;

    document.getElementById('maintenanceRooms').textContent =
        rooms.filter(room => room.status === 'Maintenance').length;
}

/* STATUS */

function statusClass(status) {
    if (status === 'Terisi') return 'occupied';
    if (status === 'Kosong') return 'empty';
    return 'maintenance';
}

/* RENDER TABEL */

function renderRooms() {
    const keyword = document.getElementById('searchInput')
        .value.trim().toLowerCase();

    const status = document.getElementById('statusFilter').value;
    const floor = document.getElementById('floorFilter').value;

    const filtered = rooms.filter(room => {
        const matchesKeyword =
            room.number.toLowerCase().includes(keyword) ||
            room.tenant.toLowerCase().includes(keyword);

        const matchesStatus =
            status === 'all' || room.status === status;

        const matchesFloor =
            floor === 'all' || String(room.floor) === floor;

        return matchesKeyword && matchesStatus && matchesFloor;
    });

    const tbody = document.getElementById('roomTable');
    const emptyState = document.getElementById('emptyState');

    tbody.replaceChildren();

    filtered.forEach(room => {
        const tr = document.createElement('tr');

        const numberCell = document.createElement('td');
        numberCell.className = 'room-number';
        numberCell.textContent = room.number;

        const floorCell = document.createElement('td');
        floorCell.textContent = 'Lantai ' + room.floor;

        const typeCell = document.createElement('td');
        typeCell.textContent = room.type;

        const tenantCell = document.createElement('td');
        tenantCell.textContent = room.tenant;

        const statusCell = document.createElement('td');
        const statusBadge = document.createElement('span');
        statusBadge.className = 'status ' + statusClass(room.status);
        statusBadge.textContent = room.status;
        statusCell.appendChild(statusBadge);

        const actionCell = document.createElement('td');
        const detailButton = document.createElement('button');

        detailButton.type = 'button';
        detailButton.className = 'action-btn';
        detailButton.textContent = 'Detail';

        detailButton.addEventListener('click', () => {
            showDetail(room.id);
        });

        actionCell.appendChild(detailButton);

        tr.append(
            numberCell,
            floorCell,
            typeCell,
            tenantCell,
            statusCell,
            actionCell
        );

        tbody.appendChild(tr);
    });

    emptyState.hidden = filtered.length !== 0;

    document.getElementById('resultCount').textContent =
        `Menampilkan ${filtered.length} dari ${rooms.length} kamar`;

    updateStats();
}

/* DETAIL KAMAR */

function showDetail(id) {
    const room = rooms.find(item => item.id === id);

    if (!room) {
        showToast('Data kamar tidak ditemukan.');
        return;
    }

    selectedRoomId = id;

    const content = document.getElementById('detailContent');
    content.replaceChildren();

    const details = [
        ['Nomor Kamar', room.number],
        ['Lantai', 'Lantai ' + room.floor],
        ['Tipe Kamar', room.type],
        ['Nama Penghuni', room.tenant],
        ['Status', room.status],
        ['Fasilitas', room.facilities],
        ['Catatan Kondisi', room.note || '-']
    ];

    details.forEach(([label, value]) => {
        const row = document.createElement('div');
        row.className = 'detail-row';

        const left = document.createElement('span');
        left.textContent = label;

        const right = document.createElement('strong');
        right.textContent = value;

        row.append(left, right);
        content.appendChild(row);
    });

    document.getElementById('detailUpdateBtn').onclick = () => {
        closeModal('detailModal');
        openUpdate(id);
    };

    openModal('detailModal');
}

/* FORM UPDATE */

function openUpdate(id) {
    const room = rooms.find(item => item.id === id);

    if (!room) {
        showToast('Data kamar tidak ditemukan.');
        return;
    }

    document.getElementById('updateRoomId').value = id;
    document.getElementById('updateStatus').value = room.status;
    document.getElementById('updateNote').value = room.note || '';

    openModal('updateModal');
}

document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const id = Number(document.getElementById('updateRoomId').value);
    const status = document.getElementById('updateStatus').value;
    const note = document.getElementById('updateNote').value.trim();

    const room = rooms.find(item => item.id === id);

    if (!room) {
        showToast('Data kamar tidak ditemukan.');
        return;
    }

    if (!VALID_STATUSES.includes(status)) {
        showToast('Status kamar tidak valid.');
        return;
    }

    if (note.length > 250) {
        showToast('Catatan maksimal 250 karakter.');
        return;
    }

    /*
     * Petugas hanya dapat mengubah kondisi kamar menjadi Maintenance
     * atau mengembalikan kamar Maintenance menjadi Kosong.
     *
     * Perubahan status hunian tetap melalui pengelolaan penghuni.
     */

    if (
        status !== room.status &&
        status !== 'Maintenance' &&
        room.status !== 'Maintenance'
    ) {
        showToast('Perubahan status hunian perlu melalui pengelolaan penghuni.');
        return;
    }

    if (status === 'Terisi' && room.tenant === '-') {
        showToast('Kamar tanpa penghuni tidak dapat diubah menjadi Terisi.');
        return;
    }

    const previousStatus = room.status;
    const previousNote = room.note;

    room.status = status;
    room.note = note || 'Belum ada catatan';

    if (!saveRooms()) {
        room.status = previousStatus;
        room.note = previousNote;
        return;
    }

    renderRooms();
    closeModal('updateModal');

    showToast('Kondisi kamar berhasil diperbarui.');
});

/* MODAL */

function openModal(id) {
    const modal = document.getElementById(id);

    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);

    if (modal) {
        modal.classList.remove('show');
    }

    if (!document.querySelector('.modal.show')) {
        document.body.style.overflow = '';
    }
}

document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', event => {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
});

/* TOAST */

function showToast(message) {
    const toast = document.getElementById('toast');

    toast.textContent = message;
    toast.style.display = 'block';

    clearTimeout(toastTimeout);

    toastTimeout = setTimeout(() => {
        toast.style.display = 'none';
    }, 2800);
}

/* FILTER */

document.getElementById('searchInput')
    .addEventListener('input', renderRooms);

document.getElementById('statusFilter')
    .addEventListener('change', renderRooms);

document.getElementById('floorFilter')
    .addEventListener('change', renderRooms);

/* SIDEBAR RESPONSIF */

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const menuToggle = document.getElementById('menuToggle');

function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('show');

    menuToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');

    menuToggle.setAttribute('aria-expanded', 'false');

    if (!document.querySelector('.modal.show')) {
        document.body.style.overflow = '';
    }
}

menuToggle.addEventListener('click', () => {
    sidebar.classList.contains('open')
        ? closeSidebar()
        : openSidebar();
});

overlay.addEventListener('click', closeSidebar);

sidebar.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 760) {
            closeSidebar();
        }
    });
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        const logoutModal = document.getElementById('khLogoutModal');

        // Biarkan komponen logout menangani Escape sendiri.
        if (logoutModal && logoutModal.classList.contains('is-visible')) {
            return;
        }

        closeSidebar();

        document.querySelectorAll('.modal.show').forEach(modal => {
            closeModal(modal.id);
        });
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth > 760) {
        closeSidebar();
    }
});

/* TANGGAL */

document.getElementById('currentDate').textContent =
    new Intl.DateTimeFormat('id-ID', {
        day:'numeric',
        month:'long',
        year:'numeric'
    }).format(new Date());

/* INISIALISASI */

renderRooms();
</script>

</body>
</html>
