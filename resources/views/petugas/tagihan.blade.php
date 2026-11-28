
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Tagihan Bulanan - KosHaven</title>

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
    --yellow:#D9B77F;
    --blue:#91AFC7;
    --shadow:0 12px 35px rgba(0,0,0,.15);
    --sidebar-width:270px;
}

* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html {scroll-behavior:smooth}

body {
    font-family:'DM Sans',sans-serif;
    background:var(--bg);
    color:var(--text);
    min-height:100vh;
}

button,input,select {font:inherit}
button {cursor:pointer}
button:focus-visible,a:focus-visible,input:focus-visible,select:focus-visible {
    outline:2px solid var(--gold);
    outline-offset:3px;
}

.sidebar {
    position:fixed;
    inset:0 auto 0 0;
    width:var(--sidebar-width);
    background:var(--bg-deep);
    color:white;
    padding:28px 18px;
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
    padding:0 12px 28px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.brand-icon {
    width:43px;
    height:43px;
    border-radius:13px;
    display:grid;
    place-items:center;
    background:linear-gradient(135deg,var(--gold-light),var(--gold));
    color:var(--bg-deep);
    font-size:21px;
    flex-shrink:0;
}

.brand h2 {
    font-family:'Playfair Display',serif;
    font-size:23px;
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
    border-radius:9px;
    text-decoration:none;
    color:#B7C0C9;
    font-size:13px;
    transition:.2s;
}

.nav-link i {font-size:17px}

.nav-link:hover,.nav-link.active {
    background:rgba(198,164,119,.12);
    color:var(--gold-light);
}

.nav-link.active {
    border-left:3px solid var(--gold);
    padding-left:11px;
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
    font-weight:700;
}

.user-info strong {
    font-size:12px;
    display:block;
}

.user-info small {
    color:var(--silver);
    font-size:10px;
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

.overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.65);
    z-index:999;
}

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
    gap:13px;
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
    font-size:11px;
    color:var(--silver);
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
    font-size:12px;
    margin-top:6px;
    line-height:1.6;
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

.stats {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:16px;
    margin-bottom:25px;
}

.stat-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:13px;
    padding:19px;
    box-shadow:var(--shadow);
    min-width:0;
}

.stat-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-bottom:17px;
}

.stat-label {
    color:var(--muted);
    font-size:11px;
}

.stat-icon {
    width:40px;
    height:40px;
    display:grid;
    place-items:center;
    border-radius:11px;
    font-size:18px;
    flex-shrink:0;
}

.icon-blue {background:rgba(145,175,199,.13);color:var(--blue)}
.icon-green {background:rgba(145,174,155,.13);color:var(--green)}
.icon-orange {background:rgba(217,183,127,.13);color:var(--yellow)}
.icon-red {background:rgba(213,143,143,.13);color:var(--red)}

.stat-number {
    font-size:27px;
    font-weight:700;
    color:var(--ivory);
    font-variant-numeric:tabular-nums;
}

.stat-description {
    color:var(--silver);
    font-size:10px;
    margin-top:5px;
}

.content-card {
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:14px;
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

.filter-area {
    padding:19px 24px;
    display:flex;
    align-items:center;
    gap:11px;
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
    padding:11px 13px 11px 38px;
    outline:none;
    background:var(--bg);
    color:var(--text);
    font-size:11px;
    transition:.2s;
}

.search-box input::placeholder {color:#818B96}

.search-box input:focus,.filter-select:focus {
    border-color:var(--gold);
}

.filter-select {
    border:1px solid var(--border);
    border-radius:9px;
    padding:11px 13px;
    background:var(--bg);
    outline:none;
    color:var(--text);
    font-size:11px;
    min-width:145px;
}

.filter-select option {
    background:var(--surface);
    color:var(--text);
}

.table-wrap {overflow-x:auto}

table {
    width:100%;
    border-collapse:collapse;
    min-width:850px;
}

th {
    background:#20262D;
    color:var(--silver);
    text-align:left;
    padding:14px 18px;
    font-size:9px;
    text-transform:uppercase;
    letter-spacing:.8px;
    white-space:nowrap;
}

td {
    padding:16px 18px;
    border-top:1px solid rgba(255,255,255,.045);
    font-size:11px;
    color:#D7DCE0;
    white-space:nowrap;
}

tbody tr {transition:.2s}
tbody tr:hover {background:rgba(198,164,119,.035)}

.person {
    display:flex;
    align-items:center;
    gap:10px;
}

.person-avatar {
    width:35px;
    height:35px;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:rgba(198,164,119,.13);
    color:var(--gold-light);
    font-weight:700;
    flex-shrink:0;
    font-size:10px;
}

.person strong {
    display:block;
    color:var(--ivory);
    font-size:11px;
}

.person small {
    display:block;
    color:var(--silver);
    font-size:9px;
    margin-top:4px;
}

.amount {
    font-weight:700;
    color:var(--gold-light);
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

.status.paid {color:var(--green);background:rgba(145,174,155,.12)}
.status.unpaid {color:var(--blue);background:rgba(145,175,199,.12)}
.status.late {color:var(--red);background:rgba(213,143,143,.12)}

.action-btn {
    border:1px solid var(--border);
    background:transparent;
    color:var(--gold-light);
    border-radius:7px;
    padding:7px 10px;
    font-size:10px;
    transition:.2s;
}

.action-btn:hover {
    background:var(--gold);
    color:var(--bg-deep);
}

.empty-state {
    padding:38px 20px;
    text-align:center;
    color:var(--silver);
    font-size:12px;
}

.empty-state i {
    font-size:27px;
    color:var(--gold);
}

.pagination {
    padding:16px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    color:var(--silver);
    font-size:10px;
    border-top:1px solid var(--border);
}

.info-box {
    margin-top:20px;
    background:rgba(198,164,119,.07);
    border:1px solid var(--border);
    padding:15px 17px;
    border-radius:11px;
    display:flex;
    align-items:flex-start;
    gap:12px;
    color:var(--silver-light);
    font-size:10px;
    line-height:1.8;
}

.info-box i {
    font-size:17px;
    color:var(--gold);
    flex-shrink:0;
}

.info-box strong {color:var(--gold-light)}

.modal {
    display:none;
    position:fixed;
    inset:0;
    z-index:1100;
    background:rgba(0,0,0,.72);
    align-items:center;
    justify-content:center;
    padding:18px;
}

.modal.show {display:flex}

.modal-box {
    background:var(--surface);
    border:1px solid var(--border);
    width:100%;
    max-width:470px;
    border-radius:15px;
    padding:24px;
    max-height:90vh;
    overflow-y:auto;
    box-shadow:var(--shadow);
}

.modal-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:19px;
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
    width:34px;
    height:34px;
    font-size:17px;
}

.detail-row {
    padding:13px 0;
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:15px;
    font-size:11px;
}

.detail-row span {color:var(--silver)}
.detail-row strong {
    color:var(--ivory);
    text-align:right;
    overflow-wrap:anywhere;
}

.modal-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

.secondary-btn {
    border:1px solid var(--border);
    background:var(--surface-light);
    color:var(--ivory);
    border-radius:8px;
    padding:10px 16px;
    font-size:11px;
}

.toast {
    position:fixed;
    bottom:24px;
    right:24px;
    background:var(--bg-deep);
    color:var(--ivory);
    border:1px solid var(--border);
    padding:13px 18px;
    border-radius:9px;
    font-size:11px;
    box-shadow:var(--shadow);
    display:none;
    z-index:1200;
    max-width:calc(100% - 40px);
}

@media(max-width:1150px) {
    .stats {grid-template-columns:repeat(2,minmax(0,1fr))}
    .main {padding:27px 24px}
}

@media(max-width:760px) {
    .sidebar {transform:translateX(-100%)}
    .sidebar.open {transform:translateX(0)}
    .overlay.show {display:block}
    .main {margin-left:0;padding:20px 15px}
    .menu-toggle {display:block}
    .topbar {align-items:flex-start}
    .page-title {font-size:25px}
    .date-display {display:none}
    .card-heading {align-items:flex-start;padding:18px}
    .filter-area {padding:16px}
    .search-box {flex-basis:100%}
    .filter-select {flex:1;min-width:0}
    .pagination {padding:15px;flex-wrap:wrap}
}

@media(max-width:450px) {
    .stats {gap:10px}
    .stat-card {padding:14px}
    .stat-number {font-size:23px}
    .stat-label {font-size:10px}
    .stat-description {font-size:9px;line-height:1.5}
    .stat-icon {width:34px;height:34px;font-size:15px}
    .page-title {font-size:22px}
    .page-subtitle {font-size:11px}
    .modal-box {padding:19px}
    .detail-row {font-size:10px}
}

@media(prefers-reduced-motion:reduce) {
    *,*::before,*::after {
        scroll-behavior:auto!important;
        transition:none!important;
        animation:none!important;
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
        <a href="{{ route('petugas.penghuni.index') }}" class="nav-link">
            <i class="bi bi-people"></i> Data Penghuni
        </a>
        <a href="{{ route('petugas.tagihan.index') }}" class="nav-link active" aria-current="page">
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
            <button class="menu-toggle" id="menuToggle" type="button" aria-label="Buka menu" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="breadcrumb">Petugas / Tagihan Bulanan</div>
                <h1 class="page-title">Tagihan Bulanan</h1>
                <p class="page-subtitle">Pantau tagihan dan status pembayaran seluruh penghuni kos.</p>
            </div>
        </div>

        <div class="date-display">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </header>

    <section class="stats">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Tagihan</span>
                <div class="stat-icon icon-blue"><i class="bi bi-receipt"></i></div>
            </div>
            <div class="stat-number" id="totalBills">0</div>
            <div class="stat-description">Seluruh tagihan tercatat</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Sudah Dibayar</span>
                <div class="stat-icon icon-green"><i class="bi bi-check-circle"></i></div>
            </div>
            <div class="stat-number" id="paidBills">0</div>
            <div class="stat-description">Tagihan lunas</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Belum Dibayar</span>
                <div class="stat-icon icon-blue"><i class="bi bi-clock-history"></i></div>
            </div>
            <div class="stat-number" id="unpaidBills">0</div>
            <div class="stat-description">Menunggu pembayaran</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Terlambat</span>
                <div class="stat-icon icon-red"><i class="bi bi-exclamation-circle"></i></div>
            </div>
            <div class="stat-number" id="lateBills">0</div>
            <div class="stat-description">Melewati tanggal jatuh tempo</div>
        </div>
    </section>

    <section class="content-card">
        <div class="card-heading">
            <div>
                <h3><i class="bi bi-receipt"></i> Daftar Tagihan Penghuni</h3>
                <p>Informasi tagihan bulanan seluruh penghuni kos.</p>
            </div>
        </div>

        <div class="filter-area">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search" id="searchInput" placeholder="Cari nama atau nomor kamar..." aria-label="Cari tagihan">
            </div>

            <select class="filter-select" id="statusFilter" aria-label="Filter status">
                <option value="all">Semua Status</option>
                <option value="Lunas">Lunas</option>
                <option value="Belum Dibayar">Belum Dibayar</option>
                <option value="Terlambat">Terlambat</option>
            </select>

            <select class="filter-select" id="monthFilter" aria-label="Filter bulan">
                <option value="all">Semua Bulan</option>
            </select>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Periode</th>
                        <th>Nominal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="billTable"></tbody>
            </table>

            <div class="empty-state" id="emptyState" hidden>
                <i class="bi bi-search"></i>
                <p style="margin-top:8px">Data tagihan tidak ditemukan.</p>
            </div>
        </div>

        <div class="pagination">
            <span id="resultCount">Menampilkan tagihan</span>
            <span>Data Tagihan KosHaven</span>
        </div>
    </section>

    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <div>
            <strong>Informasi Hak Akses Petugas</strong><br>
            Halaman ini digunakan untuk memantau tagihan penghuni. Pembuatan tagihan, pengaturan nominal, dan penghapusan tagihan dilakukan oleh Admin. Konfirmasi pembayaran dilakukan melalui menu Pembayaran.
        </div>
    </div>

</main>

<div class="modal" id="detailModal" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="detailTitle">Detail Tagihan</h3>
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

const bills = @json($bills ?? []);
const allowedStatuses = ['Lunas','Menunggu Verifikasi','Dibayar Sebagian','Belum Dibayar','Terlambat'];

function isValidDate(value) {
    if (typeof value !== 'string' || !/^\d{4}-\d{2}-\d{2}$/.test(value)) return false;

    const date = new Date(value + 'T00:00:00');
    return !Number.isNaN(date.getTime()) && date.toISOString().slice(0,10) === value;
}

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&':'&amp;',
        '<':'&lt;',
        '>':'&gt;',
        '"':'&quot;',
        "'":'&#039;'
    })[char]);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID',{
        style:'currency',
        currency:'IDR',
        maximumFractionDigits:0
    }).format(amount);
}

function formatDate(date) {
    if (!isValidDate(date)) return '-';

    const parsed = new Date(date + 'T00:00:00');

    return new Intl.DateTimeFormat('id-ID',{
        day:'numeric',
        month:'short',
        year:'numeric'
    }).format(parsed);
}

function getStatus(bill) {
    if (bill.status === 'Lunas') return 'Lunas';

    if (!isValidDate(bill.dueDate)) return bill.status;

    const today = new Date();
    today.setHours(0,0,0,0);

    const due = new Date(bill.dueDate + 'T00:00:00');

    if (due < today) return 'Terlambat';

    return 'Belum Dibayar';
}

function updateStats() {
    const statuses = bills.map(getStatus);

    document.getElementById('totalBills').textContent = bills.length;
    document.getElementById('paidBills').textContent =
        statuses.filter(status => status === 'Lunas').length;
    document.getElementById('unpaidBills').textContent =
        statuses.filter(status => status === 'Belum Dibayar').length;
    document.getElementById('lateBills').textContent =
        statuses.filter(status => status === 'Terlambat').length;
}

function statusClass(status) {
    if (status === 'Lunas') return 'paid';
    if (status === 'Terlambat') return 'late';
    return 'unpaid';
}

function renderMonthOptions() {
    const select = document.getElementById('monthFilter');
    const previousValue = select.value;

    const months = [...new Set(bills.map(bill => bill.month))].sort().reverse();

    select.innerHTML = '<option value="all">Semua Bulan</option>';

    months.forEach(month => {
        const option = document.createElement('option');
        option.value = month;

        const date = new Date(month + '-01T00:00:00');

        option.textContent = new Intl.DateTimeFormat('id-ID',{
            month:'long',
            year:'numeric'
        }).format(date);

        select.appendChild(option);
    });

    if (months.includes(previousValue)) {
        select.value = previousValue;
    }
}

function renderBills() {
    const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const monthFilter = document.getElementById('monthFilter').value;

    const filtered = bills.filter(bill => {
        const currentStatus = getStatus(bill);

        const matchesKeyword =
            bill.name.toLowerCase().includes(keyword) ||
            bill.room.toLowerCase().includes(keyword) ||
            String(bill.id).includes(keyword);

        const matchesStatus =
            statusFilter === 'all' || currentStatus === statusFilter;

        const matchesMonth =
            monthFilter === 'all' || bill.month === monthFilter;

        return matchesKeyword && matchesStatus && matchesMonth;
    });

    const tbody = document.getElementById('billTable');
    tbody.innerHTML = '';

    filtered.forEach(bill => {
        const status = getStatus(bill);
        const initials = bill.name.trim().split(/\s+/)
            .map(part => part[0])
            .slice(0,2)
            .join('')
            .toUpperCase();

        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>
                <div class="person">
                    <div class="person-avatar">${escapeHTML(initials)}</div>
                    <div>
                        <strong>${escapeHTML(bill.name)}</strong>
                        <small>ID: TG-${String(bill.id).padStart(3,'0')}</small>
                    </div>
                </div>
            </td>
            <td><strong>${escapeHTML(bill.room)}</strong></td>
            <td>${escapeHTML(bill.period)}</td>
            <td><span class="amount">${formatCurrency(bill.amount)}</span></td>
            <td>${formatDate(bill.dueDate)}</td>
            <td><span class="status ${statusClass(status)}">${escapeHTML(status)}</span></td>
            <td>
                <button class="action-btn" type="button" data-bill-id="${bill.id}">
                    <i class="bi bi-eye"></i> Detail
                </button>
            </td>
        `;

        tbody.appendChild(tr);
    });

    tbody.querySelectorAll('[data-bill-id]').forEach(button => {
        button.addEventListener('click',() => {
            showDetail(Number(button.dataset.billId));
        });
    });

    document.getElementById('emptyState').hidden = filtered.length !== 0;

    document.getElementById('resultCount').textContent =
        `Menampilkan ${filtered.length} dari ${bills.length} tagihan`;

    updateStats();
}

function showDetail(id) {
    const bill = bills.find(item => item.id === id);

    if (!bill) {
        showToast('Data tagihan tidak ditemukan.');
        return;
    }

    const content = document.getElementById('detailContent');
    content.innerHTML = '';

    const details = [
        ['ID Tagihan','TG-' + String(bill.id).padStart(3,'0')],
        ['Nama Penghuni',bill.name],
        ['Nomor Kamar',bill.room],
        ['Periode Tagihan',bill.period],
        ['Nominal Tagihan',formatCurrency(bill.amount)],
        ['Tanggal Jatuh Tempo',formatDate(bill.dueDate)],
        ['Status Pembayaran',getStatus(bill)]
    ];

    details.forEach(([label,value]) => {
        const row = document.createElement('div');
        row.className = 'detail-row';

        const left = document.createElement('span');
        left.textContent = label;

        const right = document.createElement('strong');
        right.textContent = value;

        row.append(left,right);
        content.appendChild(row);
    });

    openModal('detailModal');
    document.querySelector('#detailModal .close-modal').focus();
}

function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');

    if (!document.querySelector('.modal.show') &&
        !document.getElementById('sidebar').classList.contains('open')) {
        document.body.style.overflow = '';
    }
}

document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click',event => {
        if (event.target === modal) closeModal(modal.id);
    });
});

let toastTimeout;

function showToast(message) {
    const toast = document.getElementById('toast');

    toast.textContent = message;
    toast.style.display = 'block';

    clearTimeout(toastTimeout);

    toastTimeout = setTimeout(() => {
        toast.style.display = 'none';
    },2800);
}

document.getElementById('searchInput').addEventListener('input',renderBills);
document.getElementById('statusFilter').addEventListener('change',renderBills);
document.getElementById('monthFilter').addEventListener('change',renderBills);

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const menuToggle = document.getElementById('menuToggle');

function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('show');
    menuToggle.setAttribute('aria-expanded','true');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
    menuToggle.setAttribute('aria-expanded','false');

    if (!document.querySelector('.modal.show')) {
        document.body.style.overflow = '';
    }
}

menuToggle.addEventListener('click',() => {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
});

overlay.addEventListener('click',closeSidebar);

sidebar.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click',() => {
        if (window.innerWidth <= 760) closeSidebar();
    });
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        const logoutModal = document.getElementById('khLogoutModal');

        // Jangan ganggu popup logout ketika sedang terbuka.
        if (logoutModal && logoutModal.classList.contains('is-visible')) {
            return;
        }

        closeSidebar();

        document.querySelectorAll('.modal.show').forEach(modal => {
            closeModal(modal.id);
        });
    }
});

window.addEventListener('resize',() => {
    if (window.innerWidth > 760) closeSidebar();
});

document.getElementById('currentDate').textContent =
    new Intl.DateTimeFormat('id-ID',{
        day:'numeric',
        month:'long',
        year:'numeric'
    }).format(new Date());

renderMonthOptions();
renderBills();
</script>

</body>
</html>
