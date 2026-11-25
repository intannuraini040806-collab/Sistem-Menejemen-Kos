
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#191D22">
<title>Data Penghuni Petugas - KosHaven</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
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

    --green:#91AE9B;
    --yellow:#D9B77F;
    --red:#D58F8F;

    --border:rgba(198,164,119,.15);
    --shadow:0 12px 35px rgba(0,0,0,.16);

    --sidebar-width:270px;
}

* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html {
    scroll-behavior:smooth;
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
select:focus-visible {
    outline:2px solid var(--gold-light);
    outline-offset:3px;
}

[hidden] {
    display:none !important;
}

/* SIDEBAR */

.sidebar {
    position:fixed;
    top:0;
    left:0;
    bottom:0;
    width:var(--sidebar-width);
    background:var(--bg-deep);
    color:white;
    padding:27px 18px;
    z-index:1000;
    display:flex;
    flex-direction:column;
    transition:transform .3s ease;
    border-right:1px solid rgba(198,164,119,.12);
    overflow-y:auto;
}

.brand {
    display:flex;
    align-items:center;
    gap:12px;
    padding:0 12px 28px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.brand-icon {
    width:43px;
    height:43px;
    flex-shrink:0;
    border-radius:13px;
    display:grid;
    place-items:center;
    background:linear-gradient(145deg,var(--gold-light),var(--gold));
    color:var(--bg-deep);
    font-size:21px;
}

.brand h2 {
    font-family:'Playfair Display',serif;
    font-size:23px;
    color:var(--ivory);
    letter-spacing:.3px;
}

.brand small {
    color:var(--silver);
    font-size:10px;
}

.nav-label {
    color:#818B96;
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
    color:#B6BEC6;
    font-size:12px;
    font-weight:500;
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
    border:1px solid rgba(198,164,119,.15);
}

.sidebar-bottom {
    margin-top:auto;
    border-top:1px solid rgba(255,255,255,.08);
    padding-top:18px;
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
    background:var(--gold);
    color:var(--bg-deep);
    display:grid;
    place-items:center;
    font-weight:800;
    font-size:13px;
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
    color:#D58F8F;
    font-size:12px;
    border-radius:9px;
    transition:.2s;
}

.logout:hover {
    background:rgba(213,143,143,.09);
}

/* MAIN */

.main {
    margin-left:var(--sidebar-width);
    padding:32px 38px;
    min-height:100vh;
    max-width:1800px;
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

.breadcrumb {
    font-size:11px;
    color:var(--muted);
    margin-bottom:8px;
}

.page-title {
    font-family:'Playfair Display',serif;
    font-size:30px;
    font-weight:600;
    color:var(--ivory);
}

.page-subtitle {
    color:var(--muted);
    font-size:12px;
    margin-top:6px;
}

.date-display {
    background:var(--surface);
    padding:11px 15px;
    border:1px solid var(--border);
    border-radius:10px;
    font-size:11px;
    color:var(--gold-light);
    white-space:nowrap;
}

.date-display i {
    margin-right:7px;
}

.menu-toggle {
    display:none;
    border:1px solid var(--border);
    background:var(--surface);
    border-radius:9px;
    padding:9px 12px;
    font-size:20px;
    color:var(--gold-light);
}

/* STATS */

.stats {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:16px;
    margin-bottom:25px;
}

.stat-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:14px;
    padding:20px;
    box-shadow:var(--shadow);
    min-width:0;
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
    gap:10px;
    margin-bottom:17px;
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
    background:rgba(146,157,168,.14);
    color:var(--silver-light);
}

.icon-green {
    background:rgba(145,174,155,.13);
    color:var(--green);
}

.icon-orange {
    background:rgba(217,183,127,.13);
    color:var(--yellow);
}

.icon-red {
    background:rgba(213,143,143,.13);
    color:var(--red);
}

.stat-number {
    font-size:28px;
    font-weight:700;
    color:var(--ivory);
    line-height:1.2;
}

.stat-label {
    color:var(--muted);
    font-size:11px;
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
    font-size:15px;
    color:var(--ivory);
    font-weight:700;
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

.add-btn {
    border:0;
    background:var(--gold);
    color:var(--bg-deep);
    border-radius:9px;
    padding:11px 15px;
    font-size:11px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:.2s;
    white-space:nowrap;
}

.add-btn:hover {
    background:var(--gold-light);
    transform:translateY(-1px);
}

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
    font-size:11px;
    background:var(--bg);
    color:var(--text);
    transition:.2s;
}

.search-box input::placeholder {
    color:#77818B;
}

.search-box input:focus,
.filter-select:focus,
.form-control:focus {
    border-color:var(--gold);
    box-shadow:0 0 0 3px rgba(198,164,119,.09);
}

.filter-select {
    border:1px solid var(--border);
    border-radius:9px;
    padding:11px 13px;
    background:var(--bg);
    outline:none;
    color:var(--text);
    font-size:11px;
    min-width:155px;
}

.filter-select option,
.form-control option {
    background:var(--surface);
    color:var(--text);
}

.table-wrap {
    width:100%;
    overflow-x:auto;
    scrollbar-width:thin;
    scrollbar-color:var(--surface-soft) transparent;
}

table {
    width:100%;
    border-collapse:collapse;
    min-width:850px;
}

th {
    background:var(--bg-deep);
    color:var(--silver);
    text-align:left;
    padding:15px 18px;
    font-size:9px;
    text-transform:uppercase;
    letter-spacing:.8px;
    font-weight:700;
    white-space:nowrap;
}

td {
    padding:15px 18px;
    border-top:1px solid rgba(255,255,255,.045);
    font-size:11px;
    color:#D4D8DB;
    white-space:nowrap;
}

tbody tr {
    transition:background .2s;
}

tbody tr:hover {
    background:rgba(255,255,255,.025);
}

.person {
    display:flex;
    align-items:center;
    gap:10px;
}

.person-avatar {
    width:36px;
    height:36px;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:rgba(198,164,119,.14);
    color:var(--gold-light);
    font-size:11px;
    font-weight:700;
    flex-shrink:0;
}

.person strong {
    display:block;
    color:var(--ivory);
    font-size:11px;
    font-weight:600;
}

.person small {
    display:block;
    color:var(--muted);
    font-size:9px;
    margin-top:4px;
}

.status {
    display:inline-flex;
    align-items:center;
    gap:6px;
    border-radius:20px;
    padding:6px 10px;
    font-size:9px;
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

.status.active {
    color:var(--green);
    background:rgba(145,174,155,.12);
}

.status.ending {
    color:var(--yellow);
    background:rgba(217,183,127,.12);
}

.status.inactive {
    color:var(--red);
    background:rgba(213,143,143,.12);
}

.action-group {
    display:flex;
    gap:6px;
}

.action-btn {
    border:1px solid var(--border);
    background:var(--bg);
    color:var(--silver-light);
    border-radius:7px;
    padding:7px 9px;
    font-size:11px;
    transition:.2s;
}

.action-btn:hover {
    background:var(--gold);
    color:var(--bg-deep);
    border-color:var(--gold);
}

.empty-state {
    padding:38px 20px;
    text-align:center;
    color:var(--muted);
    font-size:12px;
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
    gap:10px;
    color:var(--muted);
    font-size:10px;
    border-top:1px solid var(--border);
}

/* MODALS */

.modal {
    display:none;
    position:fixed;
    inset:0;
    z-index:1100;
    background:rgba(0,0,0,.72);
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
    width:100%;
    max-width:570px;
    border:1px solid var(--border);
    border-radius:16px;
    padding:25px;
    max-height:90vh;
    overflow-y:auto;
    box-shadow:0 25px 80px rgba(0,0,0,.4);
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
    margin-bottom:23px;
}

.modal-header h3 {
    font-family:'Playfair Display',serif;
    color:var(--ivory);
    font-size:22px;
    font-weight:600;
}

.close-modal {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--silver-light);
    border-radius:8px;
    width:35px;
    height:35px;
    font-size:18px;
    flex-shrink:0;
}

.close-modal:hover {
    background:var(--gold);
    color:var(--bg-deep);
}

.form-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.form-group {
    margin-bottom:16px;
    min-width:0;
}

.form-group label {
    display:block;
    margin-bottom:8px;
    font-size:11px;
    font-weight:600;
    color:var(--ivory);
}

.form-control {
    width:100%;
    padding:11px 12px;
    border:1px solid var(--border);
    border-radius:9px;
    outline:none;
    font-size:11px;
    background:var(--bg);
    color:var(--text);
    transition:.2s;
}

.form-control:disabled {
    background:var(--surface-light);
    color:var(--silver);
    cursor:not-allowed;
}

.form-control::placeholder {
    color:#77818B;
}

.field-hint {
    color:var(--muted);
    font-size:9px;
    margin-top:6px;
    line-height:1.5;
}

.error-message {
    display:none;
    color:var(--red);
    font-size:10px;
    margin-top:6px;
    line-height:1.4;
}

.form-group.invalid .form-control {
    border-color:var(--red);
}

.form-group.invalid .error-message {
    display:block;
}

.modal-actions {
    display:flex;
    justify-content:flex-end;
    flex-wrap:wrap;
    gap:10px;
    margin-top:20px;
    padding-top:17px;
    border-top:1px solid var(--border);
}

.primary-btn {
    border:0;
    background:var(--gold);
    color:var(--bg-deep);
    border-radius:9px;
    padding:12px 17px;
    font-size:11px;
    font-weight:700;
}

.primary-btn:hover {
    background:var(--gold-light);
}

.primary-btn:disabled {
    opacity:.6;
    cursor:not-allowed;
}

.secondary-btn {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--silver-light);
    border-radius:9px;
    padding:11px 16px;
    font-size:11px;
}

.secondary-btn:hover {
    background:var(--surface-soft);
    color:var(--ivory);
}

.detail-row {
    padding:13px 0;
    border-bottom:1px solid rgba(255,255,255,.07);
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    font-size:11px;
}

.detail-row span {
    color:var(--muted);
}

.detail-row strong {
    color:var(--ivory);
    text-align:right;
    max-width:60%;
    overflow-wrap:anywhere;
}

.detail-status {
    display:inline-flex;
    align-items:center;
    gap:6px;
    border-radius:20px;
    padding:6px 10px;
    font-size:9px;
}

/* TOAST */

.toast {
    position:fixed;
    bottom:25px;
    right:25px;
    background:var(--surface-light);
    color:var(--ivory);
    padding:14px 19px;
    border:1px solid var(--border);
    border-radius:10px;
    font-size:11px;
    box-shadow:var(--shadow);
    display:none;
    z-index:1200;
    max-width:calc(100% - 40px);
}

.toast.show {
    display:block;
    animation:modalIn .2s ease;
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
        padding:28px 24px;
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
        padding:21px 16px;
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
        padding:19px;
    }

    .add-btn {
        width:100%;
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
        font-size:9px;
    }

    .stat-icon {
        width:34px;
        height:34px;
        font-size:15px;
    }

    .stat-top {
        margin-bottom:13px;
    }

    .page-title {
        font-size:23px;
    }

    .page-subtitle {
        font-size:10px;
        line-height:1.5;
    }

    .breadcrumb {
        font-size:10px;
    }

    .form-grid {
        grid-template-columns:1fr;
        gap:0;
    }

    .modal {
        padding:10px;
        align-items:flex-end;
    }

    .modal-box {
        padding:19px;
        max-height:92vh;
        border-radius:15px 15px 10px 10px;
    }

    .modal-header h3 {
        font-size:20px;
    }

    .modal-actions {
        flex-direction:column-reverse;
    }

    .modal-actions button {
        width:100%;
    }

    .toast {
        right:12px;
        bottom:15px;
        max-width:calc(100% - 24px);
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
        <div class="brand-icon"><i class="bi bi-house-heart-fill"></i></div>
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

        <a href="{{ route('petugas.kamar.index') }}" class="nav-link">
            <i class="bi bi-door-open"></i> Data Kamar
        </a>

        <a href="{{ route('petugas.penghuni.index') }}" class="nav-link active" aria-current="page">
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

        <button class="logout" type="button" onclick="logout()">
            <i class="bi bi-box-arrow-left"></i> Keluar
        </button>
    </div>
</aside>

<main class="main">

    <header class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <div class="breadcrumb">Petugas / Data Penghuni</div>
                <h1 class="page-title">Data Penghuni</h1>
                <p class="page-subtitle">Pantau dan kelola informasi penghuni kos.</p>
            </div>
        </div>

        <div class="date-display">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </header>

    <!-- STATISTIK -->

    <section class="stats">

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Penghuni</span>
                <div class="stat-icon icon-blue"><i class="bi bi-people"></i></div>
            </div>
            <div class="stat-number" id="totalResidents">0</div>
            <div class="stat-label">Seluruh data penghuni</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Penghuni Aktif</span>
                <div class="stat-icon icon-green"><i class="bi bi-person-check"></i></div>
            </div>
            <div class="stat-number" id="activeResidents">0</div>
            <div class="stat-label">Masih tinggal di kos</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Akan Berakhir</span>
                <div class="stat-icon icon-orange"><i class="bi bi-calendar-event"></i></div>
            </div>
            <div class="stat-number" id="endingResidents">0</div>
            <div class="stat-label">Masa tinggal mendekati akhir</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Tidak Aktif</span>
                <div class="stat-icon icon-red"><i class="bi bi-person-dash"></i></div>
            </div>
            <div class="stat-number" id="inactiveResidents">0</div>
            <div class="stat-label">Sudah tidak tinggal</div>
        </div>

    </section>

    <!-- DAFTAR PENGHUNI -->

    <section class="content-card">

        <div class="card-heading">
            <div>
                <h3><i class="bi bi-people"></i> Daftar Penghuni</h3>
                <p>Informasi penghuni dan kamar yang ditempati.</p>
            </div>

            <button class="add-btn" type="button" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i> Tambah Penghuni
            </button>
        </div>

        <div class="filter-area">

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    id="searchInput"
                    placeholder="Cari nama, kamar, atau telepon..."
                    aria-label="Cari penghuni"
                >
            </div>

            <select class="filter-select" id="statusFilter" aria-label="Filter status penghuni">
                <option value="all">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Akan Berakhir">Akan Berakhir</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>

        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Penghuni</th>
                        <th>Nomor Kamar</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Masuk</th>
                        <th>Masa Tinggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="residentTable"></tbody>
            </table>

            <div class="empty-state" id="emptyState" hidden>
                <i class="bi bi-search"></i>
                <p style="margin-top:8px">Data penghuni tidak ditemukan.</p>
            </div>
        </div>

        <div class="pagination">
            <span id="resultCount">Menampilkan data penghuni</span>
            <span>Data Penghuni KosHaven</span>
        </div>

    </section>

</main>

<!-- MODAL TAMBAH / EDIT -->

<div class="modal" id="residentModal" role="dialog" aria-modal="true" aria-labelledby="formTitle">
    <div class="modal-box">

        <div class="modal-header">
            <h3 id="formTitle">Tambah Penghuni</h3>
            <button class="close-modal" type="button" onclick="closeModal('residentModal')" aria-label="Tutup">&times;</button>
        </div>

        <form id="residentForm" novalidate>

            <input type="hidden" id="residentId">

            <div class="form-grid">

                <div class="form-group" id="nameGroup">
                    <label for="residentName">Nama Lengkap *</label>
                    <input
                        class="form-control"
                        id="residentName"
                        type="text"
                        maxlength="80"
                        placeholder="Masukkan nama lengkap"
                        autocomplete="name"
                        required
                    >
                    <small class="error-message">Nama wajib diisi minimal 3 karakter dan hanya menggunakan karakter yang valid.</small>
                </div>

                <div class="form-group" id="phoneGroup">
                    <label for="residentPhone">Nomor Telepon *</label>
                    <input
                        class="form-control"
                        id="residentPhone"
                        type="tel"
                        maxlength="18"
                        placeholder="08xxxxxxxxxx"
                        autocomplete="tel"
                        required
                    >
                    <small class="error-message">Masukkan nomor telepon Indonesia yang valid dan belum digunakan.</small>
                </div>

                <div class="form-group">
                    <label for="residentRoom">Nomor Kamar Otomatis</label>
                    <input
                        class="form-control"
                        id="residentRoom"
                        type="text"
                        placeholder="Akan terisi otomatis"
                        disabled
                    >
                    <p class="field-hint" id="roomHint">
                        Kamar akan ditentukan dari data kamar yang tersedia.
                    </p>
                </div>

                <div class="form-group" id="dateGroup">
                    <label for="residentDate">Tanggal Masuk *</label>
                    <input class="form-control" id="residentDate" type="date" required>
                    <small class="error-message">Tanggal masuk tidak boleh kosong atau di masa depan.</small>
                </div>

                <div class="form-group" id="durationGroup">
                    <label for="residentDuration">Durasi Tinggal *</label>
                    <select class="form-control" id="residentDuration" required>
                        <option value="">Pilih durasi</option>
                        <option value="1 Bulan">1 Bulan</option>
                        <option value="3 Bulan">3 Bulan</option>
                        <option value="6 Bulan">6 Bulan</option>
                        <option value="12 Bulan">12 Bulan</option>
                    </select>
                    <small class="error-message">Pilih durasi tinggal yang tersedia.</small>
                </div>

                <div class="form-group" id="statusGroup">
                    <label for="residentStatus">Status Penghuni *</label>
                    <select class="form-control" id="residentStatus" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Akan Berakhir">Akan Berakhir</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                    <small class="error-message">Pilih status penghuni yang valid.</small>
                </div>

            </div>

            <div class="modal-actions">
                <button type="button" class="secondary-btn" onclick="closeModal('residentModal')">Batal</button>
                <button type="submit" class="primary-btn" id="saveResidentBtn">Simpan Data</button>
            </div>

        </form>

    </div>
</div>

<!-- MODAL DETAIL -->

<div class="modal" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
    <div class="modal-box">

        <div class="modal-header">
            <h3 id="detailTitle">Detail Penghuni</h3>
            <button class="close-modal" type="button" onclick="closeModal('detailModal')" aria-label="Tutup">&times;</button>
        </div>

        <div id="detailContent"></div>

        <div class="modal-actions">
            <button class="secondary-btn" type="button" onclick="closeModal('detailModal')">Tutup</button>
        </div>

    </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
'use strict';

/* =====================================
   KONFIGURASI
===================================== */

const RESIDENT_KEY = 'koshaven_petugas_residents_v1';
const ROOM_KEY = 'koshaven_petugas_rooms_v1';

const VALID_STATUSES = [
    'Aktif',
    'Akan Berakhir',
    'Tidak Aktif'
];

const VALID_DURATIONS = [
    '1 Bulan',
    '3 Bulan',
    '6 Bulan',
    '12 Bulan'
];

const initialResidents = [
    {id:1,name:'Andi Pratama',phone:'081234567890',room:'A-01',date:'2026-01-01',duration:'12 Bulan',status:'Aktif'},
    {id:2,name:'Siti Rahma',phone:'081234567891',room:'A-02',date:'2026-02-01',duration:'6 Bulan',status:'Aktif'},
    {id:3,name:'Budi Santoso',phone:'081234567892',room:'A-04',date:'2026-03-01',duration:'12 Bulan',status:'Aktif'},
    {id:4,name:'Dewi Lestari',phone:'081234567893',room:'B-01',date:'2026-04-01',duration:'6 Bulan',status:'Akan Berakhir'},
    {id:5,name:'Rina Amelia',phone:'081234567894',room:'B-03',date:'2026-05-01',duration:'12 Bulan',status:'Aktif'},
    {id:6,name:'Fajar Nugraha',phone:'081234567895',room:'C-02',date:'2026-06-01',duration:'3 Bulan',status:'Tidak Aktif'},
    {id:7,name:'Nadia Putri',phone:'081234567896',room:'C-04',date:'2026-06-15',duration:'6 Bulan',status:'Aktif'},
    {id:8,name:'Rizky Maulana',phone:'081234567897',room:'B-04',date:'2025-10-01',duration:'12 Bulan',status:'Tidak Aktif'}
];

const initialRooms = [
    {id:1,number:'A-01',status:'Terisi',tenant:'Andi Pratama'},
    {id:2,number:'A-02',status:'Terisi',tenant:'Siti Rahma'},
    {id:3,number:'A-03',status:'Kosong',tenant:'-'},
    {id:4,number:'A-04',status:'Terisi',tenant:'Budi Santoso'},
    {id:5,number:'B-01',status:'Terisi',tenant:'Dewi Lestari'},
    {id:6,number:'B-02',status:'Maintenance',tenant:'-'},
    {id:7,number:'B-03',status:'Terisi',tenant:'Rina Amelia'},
    {id:8,number:'B-04',status:'Kosong',tenant:'-'},
    {id:9,number:'C-01',status:'Maintenance',tenant:'-'},
    {id:10,number:'C-02',status:'Terisi',tenant:'Fajar Nugraha'},
    {id:11,number:'C-03',status:'Kosong',tenant:'-'},
    {id:12,number:'C-04',status:'Terisi',tenant:'Nadia Putri'}
];

let residents = loadResidents();
let toastTimeout = null;
let isSaving = false;
let lastFocusedElement = null;

/* =====================================
   PENYIMPANAN DATA
===================================== */

function isValidResident(item) {
    return item &&
        typeof item === 'object' &&
        Number.isFinite(Number(item.id)) &&
        String(item.name || '').trim().length >= 3 &&
        typeof item.phone === 'string' &&
        typeof item.room === 'string' &&
        typeof item.date === 'string' &&
        VALID_DURATIONS.includes(item.duration) &&
        VALID_STATUSES.includes(item.status);
}

function loadResidents() {
    try {
        const saved = localStorage.getItem(RESIDENT_KEY);

        if (!saved) {
            return initialResidents.map(item => ({...item}));
        }

        const parsed = JSON.parse(saved);

        if (!Array.isArray(parsed)) {
            throw new Error('Format data penghuni tidak valid.');
        }

        return parsed.filter(isValidResident).map(item => ({
            id:Number(item.id),
            name:String(item.name),
            phone:String(item.phone),
            room:String(item.room),
            date:String(item.date),
            duration:item.duration,
            status:item.status
        }));

    } catch(error) {
        console.error('Gagal membaca data penghuni:',error);
        return initialResidents.map(item => ({...item}));
    }
}

function saveResidents() {
    try {
        localStorage.setItem(RESIDENT_KEY,JSON.stringify(residents));
        return true;
    } catch(error) {
        console.error('Gagal menyimpan data:',error);
        showToast('Gagal menyimpan data. Periksa penyimpanan browser.');
        return false;
    }
}

function getRooms() {
    try {
        const saved = localStorage.getItem(ROOM_KEY);
        const parsed = saved ? JSON.parse(saved) : null;

        if (Array.isArray(parsed)) {
            return parsed.filter(room =>
                room &&
                typeof room.number === 'string' &&
                ['Kosong','Terisi','Maintenance'].includes(room.status)
            );
        }

    } catch(error) {
        console.error('Gagal membaca data kamar:',error);
    }

    return initialRooms.map(room => ({...room}));
}

/* =====================================
   HELPER
===================================== */

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g,char => ({
        '&':'&amp;',
        '<':'&lt;',
        '>':'&gt;',
        '"':'&quot;',
        "'":'&#039;'
    })[char]);
}

function formatDate(date) {
    if (!date || !/^\d{4}-\d{2}-\d{2}$/.test(date)) {
        return '-';
    }

    const parsed = new Date(date + 'T00:00:00');

    if (Number.isNaN(parsed.getTime())) {
        return '-';
    }

    return new Intl.DateTimeFormat('id-ID',{
        day:'numeric',
        month:'short',
        year:'numeric'
    }).format(parsed);
}

function getToday() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth()+1).padStart(2,'0');
    const day = String(now.getDate()).padStart(2,'0');

    return `${year}-${month}-${day}`;
}

function normalizePhone(phone) {
    return phone.replace(/[\s-]/g,'');
}

function getInitials(name) {
    return String(name)
        .trim()
        .split(/\s+/)
        .map(part => part.charAt(0))
        .slice(0,2)
        .join('')
        .toUpperCase();
}

function getStatusClass(status) {
    if (status === 'Aktif') return 'active';
    if (status === 'Akan Berakhir') return 'ending';
    return 'inactive';
}

/* =====================================
   PENENTUAN KAMAR
===================================== */

function getRoomForResident(name,currentId = null) {
    const rooms = getRooms();

    const occupiedByOther = residents
        .filter(item =>
            Number(item.id) !== Number(currentId) &&
            item.status !== 'Tidak Aktif'
        )
        .map(item => item.room);

    const matchingRoom = rooms.find(room =>
        room.tenant &&
        room.tenant !== '-' &&
        room.tenant.toLowerCase() === name.toLowerCase() &&
        room.status !== 'Maintenance' &&
        !occupiedByOther.includes(room.number)
    );

    if (matchingRoom) {
        return matchingRoom.number;
    }

    const freeRoom = rooms.find(room =>
        room.status === 'Kosong' &&
        !occupiedByOther.includes(room.number)
    );

    return freeRoom ? freeRoom.number : '';
}

/* =====================================
   STATISTIK
===================================== */

function updateStats() {
    document.getElementById('totalResidents').textContent =
        residents.length;

    document.getElementById('activeResidents').textContent =
        residents.filter(item => item.status === 'Aktif').length;

    document.getElementById('endingResidents').textContent =
        residents.filter(item => item.status === 'Akan Berakhir').length;

    document.getElementById('inactiveResidents').textContent =
        residents.filter(item => item.status === 'Tidak Aktif').length;
}

/* =====================================
   TAMPILKAN DATA
===================================== */

function renderResidents() {
    const keyword = document.getElementById('searchInput')
        .value.trim().toLowerCase();

    const status = document.getElementById('statusFilter').value;

    const filtered = residents.filter(item => {
        const matchesKeyword =
            item.name.toLowerCase().includes(keyword) ||
            item.room.toLowerCase().includes(keyword) ||
            item.phone.toLowerCase().includes(keyword);

        const matchesStatus =
            status === 'all' || item.status === status;

        return matchesKeyword && matchesStatus;
    });

    const tbody = document.getElementById('residentTable');
    tbody.innerHTML = '';

    filtered.forEach(item => {
        const tr = document.createElement('tr');

        const initials = getInitials(item.name);
        const statusClass = getStatusClass(item.status);

        tr.innerHTML = `
            <td>
                <div class="person">
                    <div class="person-avatar">${escapeHTML(initials)}</div>
                    <div>
                        <strong>${escapeHTML(item.name)}</strong>
                        <small>ID: KH-${String(item.id).padStart(3,'0')}</small>
                    </div>
                </div>
            </td>

            <td><strong>${escapeHTML(item.room || '-')}</strong></td>

            <td>${escapeHTML(item.phone)}</td>

            <td>${formatDate(item.date)}</td>

            <td>${escapeHTML(item.duration)}</td>

            <td>
                <span class="status ${statusClass}">
                    ${escapeHTML(item.status)}
                </span>
            </td>

            <td>
                <div class="action-group">
                    <button
                        class="action-btn"
                        type="button"
                        data-action="detail"
                        data-id="${Number(item.id)}"
                        title="Detail penghuni"
                        aria-label="Lihat detail ${escapeHTML(item.name)}"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                    <button
                        class="action-btn"
                        type="button"
                        data-action="edit"
                        data-id="${Number(item.id)}"
                        title="Edit penghuni"
                        aria-label="Edit ${escapeHTML(item.name)}"
                    >
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
    });

    document.getElementById('emptyState').hidden =
        filtered.length !== 0;

    document.getElementById('resultCount').textContent =
        `Menampilkan ${filtered.length} dari ${residents.length} penghuni`;

    updateStats();
}

/* =====================================
   VALIDASI FORM
===================================== */

function clearErrors() {
    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.remove('invalid');
    });
}

function showError(id) {
    document.getElementById(id).classList.add('invalid');
}

function validateResident(data,id = null) {
    clearErrors();

    let valid = true;

    const namePattern = /^[\p{L}][\p{L}\s.'-]*$/u;
    const phonePattern = /^(\+62|62|0)8[1-9][0-9]{7,11}$/;

    if (
        data.name.length < 3 ||
        data.name.length > 80 ||
        !namePattern.test(data.name)
    ) {
        showError('nameGroup');
        valid = false;
    }

    if (!phonePattern.test(data.phone)) {
        showError('phoneGroup');
        valid = false;
    }

    if (!data.date ||
        !/^\d{4}-\d{2}-\d{2}$/.test(data.date) ||
        data.date > getToday()
    ) {
        showError('dateGroup');
        valid = false;
    }

    if (!VALID_DURATIONS.includes(data.duration)) {
        showError('durationGroup');
        valid = false;
    }

    if (!VALID_STATUSES.includes(data.status)) {
        showError('statusGroup');
        valid = false;
    }

    const duplicatePhone = residents.some(item =>
        normalizePhone(item.phone) === normalizePhone(data.phone) &&
        Number(item.id) !== Number(id)
    );

    if (duplicatePhone) {
        showError('phoneGroup');
        showToast('Nomor telepon sudah digunakan penghuni lain.');
        valid = false;
    }

    return valid;
}

/* =====================================
   TAMBAH PENGHUNI
===================================== */

function openAddModal() {
    lastFocusedElement = document.activeElement;

    document.getElementById('residentForm').reset();
    document.getElementById('residentId').value = '';

    document.getElementById('formTitle').textContent =
        'Tambah Penghuni';

    document.getElementById('residentRoom').value = '';

    document.getElementById('roomHint').textContent =
        'Nomor kamar akan ditentukan otomatis berdasarkan kamar kosong.';

    document.getElementById('residentStatus').value = 'Aktif';

    clearErrors();
    openModal('residentModal');

    document.getElementById('residentName').focus();
}

/* =====================================
   EDIT PENGHUNI
===================================== */

function editResident(id) {
    const item = residents.find(resident =>
        Number(resident.id) === Number(id)
    );

    if (!item) {
        showToast('Data penghuni tidak ditemukan.');
        return;
    }

    lastFocusedElement = document.activeElement;

    document.getElementById('residentForm').reset();

    document.getElementById('residentId').value = item.id;
    document.getElementById('residentName').value = item.name;
    document.getElementById('residentPhone').value = item.phone;
    document.getElementById('residentRoom').value = item.room;
    document.getElementById('residentDate').value = item.date;
    document.getElementById('residentDuration').value = item.duration;
    document.getElementById('residentStatus').value = item.status;

    document.getElementById('formTitle').textContent =
        'Edit Penghuni';

    document.getElementById('roomHint').textContent =
        'Nomor kamar penghuni yang sudah terdaftar.';

    clearErrors();

    openModal('residentModal');
    document.getElementById('residentName').focus();
}

/* =====================================
   SIMPAN FORM
===================================== */

document.getElementById('residentForm').addEventListener('submit',function(event) {
    event.preventDefault();

    if (isSaving) return;

    const idValue = document.getElementById('residentId').value;
    const id = idValue ? Number(idValue) : null;

    const name = document.getElementById('residentName')
        .value.trim().replace(/\s+/g,' ');

    const phone = normalizePhone(
        document.getElementById('residentPhone').value.trim()
    );

    const date = document.getElementById('residentDate').value;
    const duration = document.getElementById('residentDuration').value;
    const status = document.getElementById('residentStatus').value;

    const data = {
        name,
        phone,
        date,
        duration,
        status
    };

    if (!validateResident(data,id)) {
        showToast('Periksa kembali data yang wajib diisi.');
        return;
    }

    const existing = id
        ? residents.find(item => Number(item.id) === id)
        : null;

    if (id && !existing) {
        showToast('Data penghuni tidak ditemukan.');
        return;
    }

    let room = existing ? existing.room : '';

    if (status !== 'Tidak Aktif') {
        if (!existing || existing.status === 'Tidak Aktif') {
            room = getRoomForResident(name,id);

            if (!room) {
                showToast('Tidak ada kamar kosong. Periksa Data Kamar.');
                return;
            }
        }
    } else {
        room = existing?.room || '-';
    }

    const residentData = {
        id:existing ? existing.id : Date.now(),
        name,
        phone,
        room:room || '-',
        date,
        duration,
        status
    };

    const previousResidents = residents.map(item => ({...item}));

    if (existing) {
        Object.assign(existing,residentData);
    } else {
        residents.push(residentData);
    }

    isSaving = true;

    const saveButton = document.getElementById('saveResidentBtn');
    saveButton.disabled = true;
    saveButton.textContent = 'Menyimpan...';

    const saved = saveResidents();

    isSaving = false;
    saveButton.disabled = false;
    saveButton.textContent = 'Simpan Data';

    if (!saved) {
        residents = previousResidents;
        return;
    }

    renderResidents();
    closeModal('residentModal');

    showToast(existing
        ? 'Data penghuni berhasil diperbarui.'
        : 'Data penghuni berhasil ditambahkan.'
    );
});

/* =====================================
   DETAIL PENGHUNI
===================================== */

function showDetail(id) {
    const item = residents.find(resident =>
        Number(resident.id) === Number(id)
    );

    if (!item) {
        showToast('Data penghuni tidak ditemukan.');
        return;
    }

    lastFocusedElement = document.activeElement;

    const content = document.getElementById('detailContent');
    content.innerHTML = '';

    const details = [
        ['ID Penghuni','KH-' + String(item.id).padStart(3,'0')],
        ['Nama Lengkap',item.name],
        ['Nomor Telepon',item.phone],
        ['Nomor Kamar',item.room],
        ['Tanggal Masuk',formatDate(item.date)],
        ['Durasi Tinggal',item.duration],
        ['Status',item.status]
    ];

    details.forEach(([label,value]) => {
        const row = document.createElement('div');
        row.className = 'detail-row';

        const left = document.createElement('span');
        left.textContent = label;

        const right = document.createElement('strong');

        if (label === 'Status') {
            const badge = document.createElement('span');
            badge.className = `status ${getStatusClass(item.status)}`;
            badge.textContent = value;
            right.appendChild(badge);
        } else {
            right.textContent = value;
        }

        row.append(left,right);
        content.appendChild(row);
    });

    openModal('detailModal');
}

/* =====================================
   MODAL
===================================== */

function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('show');

    const anotherOpen = document.querySelector('.modal.show');

    if (!anotherOpen) {
        document.body.style.overflow = '';
    }

    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
        lastFocusedElement.focus();
    }
}

/* =====================================
   NOTIFIKASI
===================================== */

function showToast(message) {
    const toast = document.getElementById('toast');

    toast.textContent = message;
    toast.classList.add('show');

    clearTimeout(toastTimeout);

    toastTimeout = setTimeout(() => {
        toast.classList.remove('show');
    },3000);
}

/* =====================================
   EVENT TABEL
===================================== */

document.getElementById('residentTable').addEventListener('click',function(event) {
    const button = event.target.closest('button[data-action]');

    if (!button) return;

    const id = Number(button.dataset.id);

    if (!Number.isFinite(id)) return;

    if (button.dataset.action === 'detail') {
        showDetail(id);
    }

    if (button.dataset.action === 'edit') {
        editResident(id);
    }
});

/* =====================================
   FILTER DAN PENCARIAN
===================================== */

document.getElementById('searchInput').addEventListener('input',renderResidents);

document.getElementById('statusFilter').addEventListener('change',renderResidents);

/* =====================================
   MODAL EVENT
===================================== */

document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click',event => {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
});

/* =====================================
   LOGOUT
===================================== */

function logout() {
    if (confirm('Apakah kamu yakin ingin keluar dari akun Petugas?')) {
        window.location.href = "{{ url('/login') }}";
    }
}

/* =====================================
   SIDEBAR RESPONSIF
===================================== */

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const menuToggle = document.getElementById('menuToggle');

function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('show');

    menuToggle.setAttribute('aria-expanded','true');
    menuToggle.setAttribute('aria-label','Tutup menu');

    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');

    menuToggle.setAttribute('aria-expanded','false');
    menuToggle.setAttribute('aria-label','Buka menu');

    if (!document.querySelector('.modal.show')) {
        document.body.style.overflow = '';
    }
}

menuToggle.addEventListener('click',() => {
    sidebar.classList.contains('open')
        ? closeSidebar()
        : openSidebar();
});

overlay.addEventListener('click',closeSidebar);

sidebar.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click',() => {
        if (window.innerWidth <= 760) {
            closeSidebar();
        }
    });
});

document.addEventListener('keydown',event => {
    if (event.key === 'Escape') {
        closeSidebar();

        document.querySelectorAll('.modal.show').forEach(modal => {
            closeModal(modal.id);
        });
    }
});

window.addEventListener('resize',() => {
    if (window.innerWidth > 760) {
        closeSidebar();
    }
});

/* =====================================
   TANGGAL DAN INISIALISASI
===================================== */

document.getElementById('currentDate').textContent =
    new Intl.DateTimeFormat('id-ID',{
        day:'numeric',
        month:'long',
        year:'numeric'
    }).format(new Date());

renderResidents();
</script>

</body>
</html>
