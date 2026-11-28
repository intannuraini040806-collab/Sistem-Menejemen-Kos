<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kamar - KosHaven</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --teal: #929DA8;
            --teal-dark: #191D22;
            --teal-light: #363E48;
            --gold: #C6A477;
            --gold-light: rgba(198,164,119,.14);
            --cream: #191D22;
            --white: #242A31;
            --text: #F1F0EC;
            --muted: #A9B0B8;
            --border: rgba(187,196,205,.13);
            --green: #91AE9B;
            --green-bg: rgba(145,174,155,.14);
            --red: #D58F8F;
            --red-bg: rgba(213,143,143,.14);
            --orange: #D9B77F;
            --orange-bg: rgba(217,183,127,.14);
            --shadow: 0 12px 35px rgba(0,0,0,.16);
            --radius: 16px;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: auto !important; }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        button, input, select, textarea { font: inherit; }
        button { cursor: pointer; }

        .app { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #12161B;
            color: white;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
            overflow-y: auto;
            border-right: 1px solid var(--border);
        }

        .brand {
            padding: 27px 24px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .brand-name span { color: var(--gold); }

        .brand-caption {
            color: #929DA8;
            font-size: 11px;
            margin-top: 5px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .side-label {
            padding: 24px 24px 10px;
            color: #929DA8;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .nav-list {
            padding: 0 12px;
            display: grid;
            gap: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #A9B0B8;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            transition: .2s;
        }

        .nav-link i { font-size: 17px; }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(198,164,119,.12);
            color: #F1F0EC;
        }

        .nav-link.active {
            border-left: 3px solid var(--gold);
            padding-left: 11px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 18px 16px;
            border-top: 1px solid rgba(255,255,255,.1);
        }

        .admin-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            min-width: 0;
        }

        .avatar {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--gold);
            color: var(--teal-dark);
            font-weight: 700;
            flex-shrink: 0;
        }

        .admin-mini strong {
            display: block;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .admin-mini small {
            color: #929DA8;
            font-size: 10px;
        }

        /* MAIN */
        .main {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-width: 0;
        }

        .topbar {
            min-height: 75px;
            padding: 0 34px;
            background: #242A31;
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

        .menu-btn {
            display: none;
            border: 0;
            background: transparent;
            color: #E0C49B;
            font-size: 23px;
        }

        .topbar h2 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 600;
            color: #F1F0EC;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-right i { color: var(--gold); font-size: 17px; }

        .content {
            max-width: 1500px;
            margin: 0 auto;
            padding: 32px 34px 50px;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .eyebrow {
            color: var(--gold);
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            margin-bottom: 8px;
        }

        .page-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            margin: 0 0 7px;
            color: #F1F0EC;
        }

        .page-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        /* BUTTON */
        .btn {
            border: 0;
            border-radius: 9px;
            padding: 11px 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-primary {
            color: #191D22;
            background: var(--gold);
        }

        .btn-primary:hover {
            background: #E0C49B;
            transform: translateY(-1px);
        }

        .btn-light {
            background: #363E48;
            color: #BBC4CD;
            border: 1px solid var(--border);
        }

        .btn-light:hover {
            background: #414B56;
            color: #F1F0EC;
        }

        .btn-danger { background: var(--red-bg); color: var(--red); }
        .btn:disabled { opacity: .55; cursor: not-allowed; transform: none; }

        /* STATISTICS */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #242A31;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 19px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            transition: transform .25s, border-color .25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(198,164,119,.35);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            font-size: 20px;
        }

        .stat-icon.total { background: rgba(146,157,168,.15); color: #BBC4CD; }
        .stat-icon.available { background: var(--green-bg); color: var(--green); }
        .stat-icon.occupied { background: var(--orange-bg); color: var(--orange); }
        .stat-icon.repair { background: var(--red-bg); color: var(--red); }

        .stat-info { min-width: 0; }

        .stat-info small {
            color: var(--muted);
            display: block;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .stat-info strong {
            color: #F1F0EC;
            font-size: 23px;
            font-weight: 700;
        }

        /* PANEL */
        .panel {
            background: #242A31;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-header {
            padding: 21px 23px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: #F1F0EC;
        }

        .panel-header p {
            color: var(--muted);
            margin: 5px 0 0;
            font-size: 11px;
        }

        /* FILTER */
        .filters {
            padding: 17px 23px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }

        .field-control {
            border: 1px solid rgba(187,196,205,.17);
            border-radius: 9px;
            padding: 10px 12px;
            background: #191D22;
            color: #F1F0EC;
            outline: none;
            font-size: 12px;
            min-height: 39px;
        }

        .field-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .field-control::placeholder { color: #7E8994; }

        .field-control option {
            background: #242A31;
            color: #F1F0EC;
        }

        .search-wrap {
            flex: 1 1 230px;
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }

        .search-wrap input { width: 100%; padding-left: 36px; }
        .filters select { min-width: 145px; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        thead { background: #2D343D; }

        th {
            padding: 14px 15px;
            text-align: left;
            color: #A9B0B8;
            font-size: 10px;
            letter-spacing: .7px;
            text-transform: uppercase;
            font-weight: 700;
            white-space: nowrap;
        }

        td {
            padding: 15px;
            border-top: 1px solid rgba(187,196,205,.1);
            color: #BBC4CD;
            font-size: 12px;
            vertical-align: middle;
        }

        tbody tr { transition: background .2s; }
        tbody tr:hover { background: rgba(187,196,205,.045); }

        .room-number {
            color: #E0C49B;
            font-weight: 700;
            font-size: 13px;
        }

        .room-type {
            display: inline-block;
            background: rgba(198,164,119,.13);
            color: #E0C49B;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
        }

        .price {
            color: #E0C49B;
            font-weight: 700;
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
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status.kosong { background: var(--green-bg); color: var(--green); }
        .status.terisi { background: var(--orange-bg); color: var(--orange); }
        .status.perbaikan { background: var(--red-bg); color: var(--red); }

        .action-group { display: flex; gap: 5px; }

        .icon-btn {
            width: 30px;
            height: 30px;
            border: 1px solid var(--border);
            border-radius: 7px;
            display: grid;
            place-items: center;
            background: #2D343D;
            color: #BBC4CD;
            transition: .2s;
        }

        .icon-btn:hover {
            background: rgba(198,164,119,.14);
            color: #E0C49B;
        }

        .icon-btn.delete { color: var(--red); }
        .icon-btn.delete:hover { background: var(--red-bg); }

        .empty-state {
            padding: 48px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state i {
            display: block;
            font-size: 35px;
            color: #7E8994;
            margin-bottom: 10px;
        }

        .empty-state strong {
            display: block;
            color: #E0C49B;
            margin-bottom: 5px;
        }

        .loading-row {
            text-align: center;
            padding: 35px;
            color: var(--muted);
        }

        /* PAGINATION */
        .pagination {
            padding: 15px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 11px;
        }

        .pagination-actions { display: flex; gap: 6px; flex-wrap: wrap; }

        .page-btn {
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 10px;
            background: #2D343D;
            color: #BBC4CD;
            font-size: 11px;
            transition: .2s;
        }

        .page-btn:hover:not(:disabled) {
            border-color: var(--gold);
            color: #E0C49B;
        }

        .page-btn.active {
            background: var(--gold);
            color: #191D22;
            border-color: var(--gold);
        }

        .page-btn:disabled { opacity: .4; cursor: not-allowed; }

        /* MODAL */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(8,12,16,.76);
            backdrop-filter: blur(5px);
            z-index: 200;
            padding: 20px;
            overflow-y: auto;
            align-items: center;
            justify-content: center;
        }

        .overlay.show {
            display: flex;
            animation: overlayIn .2s ease;
        }

        @keyframes overlayIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            width: min(620px, 100%);
            background: #242A31;
            border: 1px solid rgba(187,196,205,.13);
            border-radius: 17px;
            box-shadow: 0 20px 70px rgba(0,0,0,.4);
            overflow: hidden;
            margin: auto;
            animation: modalIn .25s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(12px) scale(.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            padding: 20px 23px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 {
            margin: 0;
            color: #F1F0EC;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
        }

        .close-btn {
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 8px;
            background: #363E48;
            color: #BBC4CD;
            font-size: 18px;
            transition: .2s;
        }

        .close-btn:hover {
            background: var(--gold-light);
            color: #E0C49B;
        }

        .modal-body { padding: 22px 23px; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 15px;
        }

        .form-group { min-width: 0; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #BBC4CD;
            font-size: 11px;
            font-weight: 700;
        }

        .form-group label span { color: var(--red); }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid rgba(187,196,205,.17);
            border-radius: 9px;
            padding: 11px 12px;
            outline: none;
            color: #F1F0EC;
            background: #191D22;
            font-size: 12px;
        }

        .form-group select option {
            background: #242A31;
            color: #F1F0EC;
        }

        .form-group textarea { resize: vertical; min-height: 85px; }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,164,119,.12);
        }

        .form-group input[readonly] {
            background: #2D343D;
            color: #929DA8;
        }

        .hint {
            color: #929DA8;
            font-size: 10px;
            margin-top: 5px;
            line-height: 1.5;
        }

        /* FOTO KAMAR */
        .photo-upload-box {
            border: 1px dashed rgba(198,164,119,.45);
            border-radius: 12px;
            padding: 14px;
            background: #191D22;
        }

        .photo-preview {
            width: 100%;
            height: 210px;
            border-radius: 9px;
            overflow: hidden;
            background: #2D343D;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .photo-placeholder {
            color: #929DA8;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .photo-placeholder i {
            display: block;
            font-size: 35px;
            color: var(--gold);
            margin-bottom: 8px;
        }

        .photo-upload-box input[type="file"] {
            width: 100%;
            padding: 9px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #242A31;
            color: #BBC4CD;
            font-size: 11px;
        }

        .photo-upload-box input[type="file"]::file-selector-button {
            border: 0;
            border-radius: 6px;
            padding: 8px 10px;
            margin-right: 10px;
            background: var(--gold);
            color: #191D22;
            font-weight: 700;
            cursor: pointer;
        }

        .photo-upload-box .hint { margin-top: 9px; }

        @media (max-width: 480px) {
            .photo-preview { height: 180px; }
        }

        /* FACILITIES */
        .facility-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 11px 13px;
            margin-bottom: 12px;
            background: #2D343D;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .facility-select-all {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #E0C49B;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            margin: 0;
        }

        .facility-select-all input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .facility-counter { color: #929DA8; font-size: 10px; }

        .facility-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 9px;
        }

        .facility-option {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            color: #BBC4CD;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: .2s;
            margin: 0;
        }

        .facility-option:hover {
            background: rgba(198,164,119,.09);
            border-color: rgba(198,164,119,.35);
        }

        .facility-option input {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            margin: 0;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .modal-footer {
            padding: 16px 23px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 9px;
        }

        /* DETAIL */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 12px;
        }

        .detail-item {
            background: #2D343D;
            border: 1px solid rgba(187,196,205,.08);
            border-radius: 10px;
            padding: 13px;
        }

        .detail-item small {
            color: var(--muted);
            display: block;
            margin-bottom: 6px;
            font-size: 10px;
        }

        .detail-item strong {
            color: #F1F0EC;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .detail-section { margin-top: 17px; }

        .detail-section h4 {
            margin: 0 0 9px;
            color: #E0C49B;
            font-size: 12px;
        }

        .facility-tags { display: flex; flex-wrap: wrap; gap: 7px; }

        .facility-tag {
            background: var(--gold-light);
            color: #E0C49B;
            border: 1px solid rgba(198,164,119,.15);
            border-radius: 20px;
            padding: 6px 10px;
            font-size: 10px;
        }

        /* TOAST */
        .toast {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 500;
            background: #363E48;
            color: white;
            border: 1px solid rgba(198,164,119,.3);
            border-radius: 10px;
            padding: 13px 17px;
            box-shadow: var(--shadow);
            font-size: 12px;
            max-width: min(380px,calc(100% - 44px));
            display: none;
            line-height: 1.5;
        }

        .toast.show {
            display: block;
            animation: toastIn .25s ease;
        }

        .toast.error {
            background: #593333;
            border-color: rgba(213,143,143,.3);
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* MOBILE */
        .mobile-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 90;
            background: rgba(0,0,0,.6);
        }

        .mobile-backdrop.show { display: block; }

        /* RESPONSIVE */
        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2,minmax(0,1fr)); }
            .content { padding: 27px 24px 40px; }
            .topbar { padding: 0 24px; }
        }

        @media (max-width: 760px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { width: 100%; margin-left: 0; }
            .menu-btn { display: inline-grid; place-items: center; }
            .topbar { min-height: 65px; padding: 0 17px; }
            .topbar h2 { font-size: 18px; }
            .topbar-right span { display: none; }
            .content { padding: 23px 16px 35px; }
            .page-heading { align-items: flex-start; flex-direction: column; }
            .page-heading h1 { font-size: 26px; }
            .page-heading .btn { width: 100%; }
            .panel-header { padding: 17px; }
            .filters { padding: 14px 17px; }
            .filters select { flex: 1 1 130px; }
            .pagination { padding: 14px 17px; }
        }

        @media (max-width: 480px) {
            .stats { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 9px; }
            .stat-card { padding: 12px; gap: 9px; }
            .stat-icon {
                width: 36px;
                height: 36px;
                flex-basis: 36px;
                font-size: 16px;
            }
            .stat-info small { font-size: 9px; }
            .stat-info strong { font-size: 19px; }
            .form-grid, .detail-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: auto; }
            .facility-list { grid-template-columns: repeat(2,minmax(0,1fr)); }
            .modal-body { padding: 17px; }
            .modal-header, .modal-footer { padding: 15px 17px; }
            .pagination { align-items: flex-start; flex-direction: column; }
            .pagination-actions { flex-wrap: wrap; }
            .overlay { padding: 10px; align-items: flex-start; }
            .modal { margin: auto 0; }
            .toast { right: 12px; bottom: 12px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        /* LOGOUT MODAL */
        .sidebar-bottom .kh-logout-component-wrapper {
            width: 100%;
            margin-top: 0;
        }

        .sidebar-bottom .kh-logout-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            padding: 10px;
            border: 1px solid rgba(187,196,205,.17);
            border-radius: 9px;
            background: transparent;
            color: #BBC4CD;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: .2s;
        }

        .sidebar-bottom .kh-logout-trigger:hover {
            background: rgba(187,196,205,.08);
            color: #D58F8F;
        }

        .sidebar-bottom .kh-logout-trigger i {
            font-size: 16px;
            flex-shrink: 0;
        }


        /* ==========================================
           PERBAIKAN SCROLL MODAL DETAIL & EDIT
           Header/footer tetap terlihat, isi modal dapat discroll.
        ========================================== */
        .overlay {
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
        }

        .modal {
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 40px);
            max-height: calc(100dvh - 40px);
            min-height: 0;
            overflow: hidden;
        }

        /* Form adalah pembungkus body dan footer pada modal edit. */
        .modal > form {
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            min-height: 0;
            overflow: hidden;
        }

        .modal-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #59636E #191D22;
        }

        .modal-body::-webkit-scrollbar { width: 7px; }
        .modal-body::-webkit-scrollbar-track {
            background: #191D22;
            border-radius: 10px;
        }
        .modal-body::-webkit-scrollbar-thumb {
            background: #59636E;
            border-radius: 10px;
        }
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #929DA8;
        }

        .modal-header,
        .modal-footer {
            flex: 0 0 auto;
        }

        @media (max-width: 480px) {
            .overlay {
                padding: 10px;
                align-items: flex-start;
            }

            .modal {
                width: 100%;
                max-height: calc(100vh - 20px);
                max-height: calc(100dvh - 20px);
                margin: 0 auto;
            }

            .modal-body { padding: 17px; }
        }

    </style>
</head>

<body>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-name">Kos<span>Haven</span></div>
            <div class="brand-caption">Boarding House Management</div>
        </div>

        <div class="side-label">Menu Utama</div>

        <nav class="nav-list">
            <a href="{{ route('admin.dashboard') }}" class="nav-link" data-page-transition>
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <a href="{{ route('admin.pengguna.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-person-gear"></i> Manajemen Pengguna
            </a>

            <a href="{{ route('admin.kamar.index') }}" class="nav-link active" aria-current="page">
                <i class="bi bi-door-open"></i> Data Kamar
            </a>

            <a href="{{ route('admin.booking.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-calendar-check"></i> Booking
            </a>

            <a href="{{ route('admin.penghuni.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-people"></i> Data Penghuni
            </a>

            <a href="{{ route('admin.petugas.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-person-badge"></i> Data Petugas
            </a>

            <a href="{{ route('admin.pengguna.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-person-gear"></i> Data Pengguna
            </a>
        </nav>

        <div class="side-label">Keuangan & Lainnya</div>

        <nav class="nav-list">
            <a href="{{ route('admin.tagihan.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-receipt"></i> Tagihan
            </a>

            <a href="{{ route('admin.pembayaran.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-wallet2"></i> Pembayaran
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>

            <a href="{{ route('admin.profil.index') }}" class="nav-link" data-page-transition>
                <i class="bi bi-person-circle"></i> Profil Admin
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="admin-mini">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div>
                    <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                    <small>Admin KosHaven</small>
                </div>
            </div>

            <div class="kh-logout-component-wrapper">
                @include('components.logout-modal')
            </div>
        </div>
    </aside>

    <div class="mobile-backdrop" id="mobileBackdrop"></div>

    <main class="main" data-page-enter>
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" id="menuBtn" type="button"
                        aria-label="Buka menu" aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <h2>Data Kamar</h2>
            </div>

            <div class="topbar-right">
                <i class="bi bi-calendar3"></i>
                <span id="currentDate"></span>
                <i class="bi bi-person-circle"></i>
            </div>
        </header>

        <section class="content">
            <div class="page-heading" data-scroll-reveal>
                <div>
                    <div class="eyebrow">Manajemen Properti</div>
                    <h1 data-reveal-words>Data Kamar</h1>
                    <p>Kelola informasi kamar, kapasitas, penghuni, dan ketersediaan kos.</p>
                </div>

                <button class="btn btn-primary" type="button" id="addRoomBtn">
                    <i class="bi bi-plus-lg"></i> Tambah Kamar
                </button>
            </div>

            <div class="stats" data-scroll-reveal>
                <div class="stat-card" data-motion-card>
                    <div class="stat-icon total"><i class="bi bi-door-closed"></i></div>
                    <div class="stat-info">
                        <small>Total Kamar</small>
                        <strong id="statTotal">0</strong>
                    </div>
                </div>

                <div class="stat-card" data-motion-card>
                    <div class="stat-icon available"><i class="bi bi-check-circle"></i></div>
                    <div class="stat-info">
                        <small>Kamar Tersedia</small>
                        <strong id="statAvailable">0</strong>
                    </div>
                </div>

                <div class="stat-card" data-motion-card>
                    <div class="stat-icon occupied"><i class="bi bi-people"></i></div>
                    <div class="stat-info">
                        <small>Kamar Terisi Penuh</small>
                        <strong id="statOccupied">0</strong>
                    </div>
                </div>

                <div class="stat-card" data-motion-card>
                    <div class="stat-icon repair"><i class="bi bi-tools"></i></div>
                    <div class="stat-info">
                        <small>Dalam Perbaikan</small>
                        <strong id="statRepair">0</strong>
                    </div>
                </div>
            </div>

            <section class="panel" data-scroll-reveal>
                <div class="panel-header">
                    <div>
                        <h3>Daftar Seluruh Kamar</h3>
                        <p>Informasi kamar yang terdaftar di KosHaven.</p>
                    </div>

                    <button class="btn btn-light" type="button" id="refreshBtn">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>

                <div class="filters">
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input class="field-control" type="search" id="searchInput"
                               maxlength="100"
                               placeholder="Cari nomor kamar atau fasilitas..."
                               aria-label="Cari kamar">
                    </div>

                    <select class="field-control" id="statusFilter" aria-label="Filter status">
                        <option value="">Semua Status</option>
                        <option value="Kosong">Tersedia</option>
                        <option value="Terisi">Terisi Penuh</option>
                        <option value="Perbaikan">Perbaikan</option>
                    </select>

                    <select class="field-control" id="typeFilter" aria-label="Filter tipe kamar">
                        <option value="">Semua Tipe</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                    </select>

                    <select class="field-control" id="sortFilter" aria-label="Urutkan kamar">
                        <option value="number-asc">Nomor: A-Z</option>
                        <option value="number-desc">Nomor: Z-A</option>
                        <option value="price-asc">Harga Terendah</option>
                        <option value="price-desc">Harga Tertinggi</option>
                    </select>

                    <button class="btn btn-light" type="button" id="resetFilterBtn">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Kamar</th>
                            <th>Tipe</th>
                            <th>Penghuni</th>
                            <th>Kapasitas</th>
                            <th>Harga/Bulan</th>
                            <th>Kamar Mandi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>

                        <tbody id="roomTableBody">
                        <tr>
                            <td colspan="9" class="loading-row">
                                <i class="bi bi-arrow-repeat"></i> Memuat data kamar...
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <span id="paginationInfo">Menampilkan 0 kamar</span>
                    <div class="pagination-actions" id="paginationActions"></div>
                </div>
            </section>
        </section>
    </main>
</div>

<!-- MODAL TAMBAH / EDIT -->
<div class="overlay" id="roomModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="roomModalTitle">
        <div class="modal-header">
            <h3 id="roomModalTitle">Tambah Kamar</h3>
            <button class="close-btn" type="button" data-close="roomModal" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="roomForm" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" id="roomId">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="roomType">Tipe Kamar <span>*</span></label>
                        <select id="roomType" required>
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="roomNumber">Nomor Kamar <span>*</span></label>
                        <input type="text" id="roomNumber" maxlength="20" required>
                        <div class="hint">Single menggunakan awalan A, Double menggunakan awalan B.</div>
                    </div>

                    <div class="form-group">
                        <label for="roomCapacity">Kapasitas</label>
                        <input type="number" id="roomCapacity" readonly>
                    </div>

                    <div class="form-group">
                        <label for="roomOccupants">Jumlah Penghuni Saat Ini <span>*</span></label>
                        <input type="number" id="roomOccupants" min="0" max="1" value="0" required>
                        <div class="hint" id="occupantHint">Kapasitas maksimal 1 orang.</div>
                    </div>

                    <div class="form-group">
                        <label for="roomPrice">Harga per Bulan <span>*</span></label>
                        <input type="number" id="roomPrice" min="1" step="1" required>
                    </div>

                    <div class="form-group">
                        <label for="roomBathroom">Jenis Kamar Mandi <span>*</span></label>
                        <select id="roomBathroom" required>
                            <option value="Dalam Kamar">Dalam Kamar</option>
                            <option value="Bersama">Bersama</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="roomStatus">Status Kamar</label>
                        <select id="roomStatus">
                            <option value="Kosong">Tersedia</option>
                            <option value="Terisi">Terisi Penuh</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                        <div class="hint">
                            Status tersedia dan terisi mengikuti jumlah penghuni.
                            Perbaikan dapat dipilih manual.
                        </div>
                    </div>

                    <div class="form-group full">
                        <label>Fasilitas Kamar</label>

                        <div class="facility-toolbar">
                            <label class="facility-select-all" for="selectAllFacilities">
                                <input type="checkbox" id="selectAllFacilities">
                                <span><i class="bi bi-check2-all"></i> Pilih Semua Fasilitas</span>
                            </label>

                            <span class="facility-counter" id="facilityCounter">
                                0 dari 6 fasilitas dipilih
                            </span>
                        </div>

                        <div class="facility-list" id="facilityList">
                            <label class="facility-option"><input type="checkbox" value="AC"><span>AC</span></label>
                            <label class="facility-option"><input type="checkbox" value="Wi-Fi"><span>Wi-Fi</span></label>
                            <label class="facility-option"><input type="checkbox" value="CCTV"><span>CCTV</span></label>
                            <label class="facility-option"><input type="checkbox" value="Laundry"><span>Laundry</span></label>
                            <label class="facility-option"><input type="checkbox" value="Lemari"><span>Lemari</span></label>
                            <label class="facility-option"><input type="checkbox" value="Meja"><span>Meja</span></label>
                        </div>

                        <div class="hint">Centang fasilitas yang tersedia di kamar.</div>
                    </div>

                    <!-- UPLOAD FOTO KAMAR -->
                    <div class="form-group full">
                        <label for="roomPhoto">Foto Kamar</label>

                        <div class="photo-upload-box">
                            <div class="photo-preview">
                                <img id="photoPreview" alt="Preview foto kamar">

                                <div class="photo-placeholder" id="photoPlaceholder">
                                    <i class="bi bi-image"></i>
                                    <span>Belum ada foto kamar</span>
                                </div>
                            </div>

                            <input
                                type="file"
                                id="roomPhoto"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            >

                            <div class="hint" id="photoHint">
                                Pilih foto kamar. Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label for="roomDescription">Deskripsi</label>
                        <textarea id="roomDescription" maxlength="500"
                                  placeholder="Masukkan keterangan kamar (maksimal 500 karakter)..."></textarea>
                        <div class="hint"><span id="descriptionCount">0</span>/500 karakter</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-close="roomModal">Batal</button>
                <button class="btn btn-primary" type="submit" id="saveRoomBtn">
                    <i class="bi bi-check-lg"></i> Simpan Kamar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="overlay" id="detailModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
        <div class="modal-header">
            <h3 id="detailTitle">Detail Kamar</h3>
            <button class="close-btn" type="button" data-close="detailModal" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="modal-body">
            <div class="detail-grid" id="detailGrid"></div>

            <div class="detail-section">
                <h4>Fasilitas Kamar</h4>
                <div class="facility-tags" id="detailFacilities"></div>
            </div>

            <div class="detail-section">
                <h4>Deskripsi</h4>
                <p id="detailDescription"
                   style="color:#A9B0B8;line-height:1.7;font-size:12px;margin:0;"></p>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-light" type="button" data-close="detailModal">Tutup</button>
        </div>
    </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
'use strict';

/* ==========================================
   KONFIGURASI API
========================================== */

const API = {
    data: @json(route('admin.kamar.data')),
    store: @json(route('admin.kamar.store')),
    update: @json(route('admin.kamar.update', ['kamar' => '__ID__'])),
    destroy: @json(route('admin.kamar.destroy', ['kamar' => '__ID__']))
};

const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const ITEMS_PER_PAGE = 5;

const roomConfig = {
    Single: { prefix: 'A', capacity: 1, price: 1500000 },
    Double: { prefix: 'B', capacity: 2, price: 2000000 }
};

const allowedFacilities = ['AC', 'Wi-Fi', 'CCTV', 'Laundry', 'Lemari', 'Meja'];
const allowedPhotoTypes = ['image/jpeg', 'image/png', 'image/webp'];
const MAX_PHOTO_SIZE = 2 * 1024 * 1024;

let rooms = [];
let currentPage = 1;
let isLoading = false;
let photoPreviewObjectUrl = null;

const $ = id => document.getElementById(id);

/* ==========================================
   NORMALISASI DATA
========================================== */

function normalizeType(value) {
    const type = String(value ?? '').toLowerCase();

    if (type === 'single') return 'Single';
    if (type === 'double') return 'Double';

    return value ?? '-';
}

function normalizeStatus(value) {
    const status = String(value ?? '').toLowerCase();

    if (['tersedia', 'kosong', 'available'].includes(status)) return 'Kosong';
    if (['terisi', 'occupied', 'penuh'].includes(status)) return 'Terisi';
    if (['maintenance', 'perbaikan', 'repair'].includes(status)) return 'Perbaikan';

    return 'Kosong';
}

function normalizeBathroom(value) {
    const bathroom = String(value ?? '').toLowerCase();

    if (['dalam_kamar', 'dalam kamar'].includes(bathroom)) return 'Dalam Kamar';
    if (['bersama', 'luar_kamar', 'luar kamar'].includes(bathroom)) return 'Bersama';

    return value ?? '-';
}

function normalizeFacilities(value) {
    let facilities = value;

    if (typeof facilities === 'string') {
        try {
            facilities = JSON.parse(facilities);
        } catch {
            facilities = [];
        }
    }

    if (!Array.isArray(facilities)) return [];

    return facilities
        .map(item => String(item))
        .filter(item => allowedFacilities.includes(item));
}

function normalizeRoom(room) {
    const type = normalizeType(room.tipe ?? room.type);
    const capacity = Number(
        room.kapasitas ?? room.capacity ?? roomConfig[type]?.capacity ?? 1
    );

    return {
        id: room.id,
        number: String(room.nomor_kamar ?? room.number ?? ''),
        type,
        price: Number(room.harga ?? room.price ?? 0),
        occupants: Number(room.jumlah_penghuni ?? room.occupants ?? 0),
        capacity,
        bathroom: normalizeBathroom(room.jenis_kamar_mandi ?? room.bathroom),
        status: normalizeStatus(room.status),
        facilities: normalizeFacilities(room.fasilitas ?? room.facilities),
        description: String(room.deskripsi ?? room.description ?? ''),
        photoUrl: room.photo_url ?? room.photoUrl ?? null
    };
}

/* ==========================================
   FUNGSI BANTUAN
========================================== */

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}

function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    }).format(Number(value) || 0);
}

function statusClass(status) {
    if (status === 'Perbaikan') return 'perbaikan';
    if (status === 'Terisi') return 'terisi';
    return 'kosong';
}

function showToast(message, isError = false) {
    const toast = $('toast');

    toast.textContent = message;
    toast.className = 'toast show' + (isError ? ' error' : '');

    clearTimeout(showToast.timer);

    showToast.timer = setTimeout(() => {
        toast.className = 'toast';
    }, 3500);
}

/* ==========================================
   REQUEST SERVER
========================================== */

async function apiRequest(url, method = 'GET', body = null) {
    const options = {
        method,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    if (body !== null) {
        if (body instanceof FormData) {
            options.body = body;
        } else {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(body);
        }
    }

    const response = await fetch(url, options);

    let result;

    try {
        result = await response.json();
    } catch {
        throw new Error(
            'Respons server tidak dapat dibaca. Periksa route dan log Laravel.'
        );
    }

    if (!response.ok) {
        if (response.status === 422 && result.errors) {
            const firstError = Object.values(result.errors).flat()[0];

            throw new Error(
                firstError || result.message ||
                'Periksa kembali data yang dimasukkan.'
            );
        }

        if (response.status === 419) {
            throw new Error(
                'Sesi halaman sudah kedaluwarsa. Muat ulang halaman lalu coba lagi.'
            );
        }

        if (response.status === 401 || response.status === 403) {
            throw new Error(
                'Kamu tidak memiliki akses untuk melakukan tindakan ini.'
            );
        }

        throw new Error(result.message || 'Terjadi kesalahan pada server.');
    }

    return result;
}

/* ==========================================
   FOTO KAMAR DAN PREVIEW
========================================== */
function showPhotoPreview(url) {
    const image = $('photoPreview');
    const placeholder = $('photoPlaceholder');

    // Bersihkan handler sebelumnya.
    image.onload = null;
    image.onerror = null;

    if (url) {
        placeholder.style.display = 'none';
        image.style.display = 'block';

        // Pasang handler sebelum memuat gambar.
        image.onload = () => {
            image.style.display = 'block';
            placeholder.style.display = 'none';
        };

        image.onerror = () => {
            image.removeAttribute('src');
            image.style.display = 'none';
            placeholder.style.display = 'block';

            placeholder.querySelector('span').textContent =
                'Foto tidak dapat ditampilkan';
        };

        // Muat gambar setelah handler siap.
        image.src = url;
    } else {
        image.removeAttribute('src');
        image.style.display = 'none';
        placeholder.style.display = 'block';

        placeholder.querySelector('span').textContent =
            'Belum ada foto kamar';
    }
}


/* ==========================================
   RESET DAN GANTI PREVIEW FOTO KAMAR
========================================== */

function resetPhotoPreview(existingUrl = null) {
    if (photoPreviewObjectUrl) {
        URL.revokeObjectURL(photoPreviewObjectUrl);
        photoPreviewObjectUrl = null;
    }

    $('roomPhoto').value = '';

    showPhotoPreview(existingUrl);

    $('photoHint').textContent = existingUrl
        ? 'Foto kamar saat ini. Pilih foto baru jika ingin menggantinya. Maksimal 2 MB.'
        : 'Pilih foto kamar. Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.';
}

function handlePhotoChange(event) {
    const file = event.target.files?.[0];

    if (!file) return;

    if (!allowedPhotoTypes.includes(file.type)) {
        event.target.value = '';
        showToast('Format foto harus JPG, JPEG, PNG, atau WebP.', true);
        return;
    }

    if (file.size > MAX_PHOTO_SIZE) {
        event.target.value = '';
        showToast('Ukuran foto maksimal 2 MB.', true);
        return;
    }

    if (photoPreviewObjectUrl) {
        URL.revokeObjectURL(photoPreviewObjectUrl);
    }

    photoPreviewObjectUrl = URL.createObjectURL(file);

    showPhotoPreview(photoPreviewObjectUrl);

    $('photoHint').textContent =
        `${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
}

/* ==========================================
   MEMUAT DATA KAMAR
========================================== */

async function loadRooms() {
    if (isLoading) return;

    isLoading = true;
    $('refreshBtn').disabled = true;

    $('roomTableBody').innerHTML = `
        <tr>
            <td colspan="9" class="loading-row">
                <i class="bi bi-arrow-repeat"></i> Memuat data kamar...
            </td>
        </tr>
    `;

    try {
        const result = await apiRequest(API.data);

        const rawRooms = Array.isArray(result)
            ? result
            : (Array.isArray(result.data) ? result.data : []);

        rooms = rawRooms.map(normalizeRoom);

        currentPage = 1;
        renderAll();

    } catch (error) {
        $('roomTableBody').innerHTML = `
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Data kamar gagal dimuat</strong>
                        ${escapeHTML(error.message)}
                    </div>
                </td>
            </tr>
        `;

        showToast(error.message, true);

    } finally {
        isLoading = false;
        $('refreshBtn').disabled = false;
    }
}

/* ==========================================
   STATISTIK
========================================== */

function renderStats() {
    $('statTotal').textContent = rooms.length;

    $('statAvailable').textContent = rooms.filter(
        room => room.status === 'Kosong'
    ).length;

    $('statOccupied').textContent = rooms.filter(
        room => room.status === 'Terisi'
    ).length;

    $('statRepair').textContent = rooms.filter(
        room => room.status === 'Perbaikan'
    ).length;
}

/* ==========================================
   FILTER DAN PENCARIAN
========================================== */

function getFilteredRooms() {
    const keyword = $('searchInput').value.trim().toLowerCase();
    const status = $('statusFilter').value;
    const type = $('typeFilter').value;
    const sort = $('sortFilter').value;

    const filtered = rooms.filter(room => {
        const searchText = [
            room.number,
            room.type,
            room.bathroom,
            room.description,
            ...room.facilities
        ].join(' ').toLowerCase();

        return (!keyword || searchText.includes(keyword))
            && (!status || room.status === status)
            && (!type || room.type === type);
    });

    filtered.sort((a, b) => {
        switch (sort) {
            case 'number-desc':
                return b.number.localeCompare(a.number, 'id', { numeric: true });
                
            case 'price-asc':
                return a.price - b.price;

            case 'price-desc':
                return b.price - a.price;

            default:
                return a.number.localeCompare(b.number, 'id', { numeric: true });
        }
    });

    return filtered;
}

/* ==========================================
   TABEL KAMAR
========================================== */

function renderRooms() {
    const filtered = getFilteredRooms();
    const totalPages = Math.max(1, Math.ceil(filtered.length / ITEMS_PER_PAGE));

    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const pageItems = filtered.slice(start, start + ITEMS_PER_PAGE);

    if (!pageItems.length) {
        $('roomTableBody').innerHTML = `
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="bi bi-door-closed"></i>
                        <strong>${rooms.length ? 'Kamar tidak ditemukan' : 'Belum ada data kamar'}</strong>
                        ${rooms.length
                            ? 'Coba ubah kata kunci atau filter pencarian.'
                            : 'Klik tombol Tambah Kamar untuk memasukkan data kamar pertama.'}
                    </div>
                </td>
            </tr>
        `;
    } else {
        $('roomTableBody').innerHTML = pageItems.map((room, index) => `
            <tr>
                <td>${start + index + 1}</td>

                <td><span class="room-number">${escapeHTML(room.number)}</span></td>

                <td><span class="room-type">${escapeHTML(room.type)}</span></td>

                <td>${room.occupants} orang</td>

                <td>${room.capacity} orang</td>

                <td><span class="price">${formatRupiah(room.price)}</span></td>

                <td>${escapeHTML(room.bathroom)}</td>

                <td>
                    <span class="status ${statusClass(room.status)}">
                        ${escapeHTML(room.status === 'Kosong' ? 'Tersedia' : room.status)}
                    </span>
                </td>

                <td>
                    <div class="action-group">
                        <button class="icon-btn" type="button" title="Detail"
                                aria-label="Lihat detail kamar"
                                data-action="detail" data-id="${escapeHTML(room.id)}">
                            <i class="bi bi-eye"></i>
                        </button>

                        <button class="icon-btn" type="button" title="Edit"
                                aria-label="Edit kamar"
                                data-action="edit" data-id="${escapeHTML(room.id)}">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="icon-btn delete" type="button" title="Hapus"
                                aria-label="Hapus kamar"
                                data-action="delete" data-id="${escapeHTML(room.id)}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    $('paginationInfo').textContent = filtered.length
        ? `Menampilkan ${start + 1}–${Math.min(start + ITEMS_PER_PAGE, filtered.length)} dari ${filtered.length} kamar`
        : 'Menampilkan 0 kamar';

    renderPagination(totalPages);
}

/* ==========================================
   PAGINATION
========================================== */

function renderPagination(totalPages) {
    let html = `
        <button class="page-btn" type="button" data-page="${currentPage - 1}"
                aria-label="Halaman sebelumnya"
                ${currentPage <= 1 ? 'disabled' : ''}>
            <i class="bi bi-chevron-left"></i>
        </button>
    `;

    for (let page = 1; page <= totalPages; page++) {
        html += `
            <button class="page-btn ${page === currentPage ? 'active' : ''}"
                    type="button" data-page="${page}"
                    aria-label="Halaman ${page}"
                    ${page === currentPage ? 'aria-current="page"' : ''}>
                ${page}
            </button>
        `;
    }

    html += `
        <button class="page-btn" type="button" data-page="${currentPage + 1}"
                aria-label="Halaman berikutnya"
                ${currentPage >= totalPages ? 'disabled' : ''}>
            <i class="bi bi-chevron-right"></i>
        </button>
    `;

    $('paginationActions').innerHTML = html;
}

function renderAll() {
    renderStats();
    renderRooms();
}

/* ==========================================
   MODAL
========================================== */

let lastFocusedElement = null;

function openModal(id) {
    lastFocusedElement = document.activeElement;

    $(id).classList.add('show');
    document.body.style.overflow = 'hidden';

    const focusTarget = $(id).querySelector(
        'input:not([type="hidden"]), select, textarea, button'
    );

    if (focusTarget) {
        setTimeout(() => focusTarget.focus(), 50);
    }
}

function closeModal(id) {
    $(id).classList.remove('show');

    if (!document.querySelector('.overlay.show')) {
        const sidebarOpen = $('sidebar').classList.contains('open');
        document.body.style.overflow = sidebarOpen ? 'hidden' : '';
    }

    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
        lastFocusedElement.focus();
    }
}

function closeAllModals() {
    document.querySelectorAll('.overlay.show').forEach(modal => {
        modal.classList.remove('show');
    });

    const sidebarOpen = $('sidebar').classList.contains('open');
    document.body.style.overflow = sidebarOpen ? 'hidden' : '';
}

/* ==========================================
   NOMOR KAMAR OTOMATIS
========================================== */

function nextRoomNumber(type) {
    const prefix = roomConfig[type].prefix;

    const usedNumbers = rooms
        .map(room => room.number)
        .filter(number => number.startsWith(prefix))
        .map(number => parseInt(number.slice(1), 10))
        .filter(Number.isFinite);

    let next = 1;

    while (usedNumbers.includes(next)) next++;

    return prefix + String(next).padStart(2, '0');
}

/* ==========================================
   PENGATURAN TIPE KAMAR
========================================== */

function updateTypeFields(resetNumber = false) {
    const type = $('roomType').value;
    const config = roomConfig[type];

    if (!config) return;

    $('roomCapacity').value = config.capacity;
    $('roomOccupants').max = config.capacity;
    $('roomPrice').value = config.price;

    $('occupantHint').textContent = `Kapasitas maksimal ${config.capacity} orang.`;

    if (resetNumber) {
        $('roomNumber').value = nextRoomNumber(type);
        $('roomOccupants').value = 0;
        $('roomStatus').value = 'Kosong';
    } else {
        const occupants = Number($('roomOccupants').value || 0);

        if (occupants > config.capacity) {
            $('roomOccupants').value = config.capacity;
        }

        syncStatusFromOccupants();
    }
}

function syncStatusFromOccupants() {
    if ($('roomStatus').value === 'Perbaikan') return;

    const occupants = Number($('roomOccupants').value || 0);
    const capacity = Number($('roomCapacity').value || 1);

    $('roomStatus').value = occupants >= capacity ? 'Terisi' : 'Kosong';
}

/* ==========================================
   FASILITAS
========================================== */

function getFacilityInputs() {
    return [...document.querySelectorAll('#facilityList input[type="checkbox"]')];
}

function getSelectedFacilities() {
    return getFacilityInputs()
        .filter(input => input.checked)
        .map(input => input.value);
}

function updateFacilitySelectAll() {
    const inputs = getFacilityInputs();
    const total = inputs.length;
    const selected = inputs.filter(input => input.checked).length;

    $('selectAllFacilities').checked = total > 0 && selected === total;
    $('selectAllFacilities').indeterminate = selected > 0 && selected < total;

    $('facilityCounter').textContent = `${selected} dari ${total} fasilitas dipilih`;
}

function toggleAllFacilities(checked) {
    getFacilityInputs().forEach(input => input.checked = checked);
    updateFacilitySelectAll();
}

function setSelectedFacilities(facilities = []) {
    const selected = Array.isArray(facilities) ? facilities : [];

    getFacilityInputs().forEach(input => {
        input.checked = selected.includes(input.value);
    });

    updateFacilitySelectAll();
}

/* ==========================================
   TAMBAH KAMAR
========================================== */

function openAddModal() {
    $('roomForm').reset();
    $('roomId').value = '';

    $('roomModalTitle').textContent = 'Tambah Kamar';
    $('saveRoomBtn').innerHTML = '<i class="bi bi-check-lg"></i> Simpan Kamar';

    $('roomType').value = 'Single';
    $('roomOccupants').value = 0;
    $('roomStatus').value = 'Kosong';

    updateTypeFields(true);
    setSelectedFacilities([]);
    updateDescriptionCount();
    resetPhotoPreview();

    openModal('roomModal');
}

/* ==========================================
   EDIT KAMAR
========================================== */

function openEditModal(id) {
    const room = rooms.find(item => String(item.id) === String(id));

    if (!room) return;

    $('roomForm').reset();

    $('roomId').value = room.id;
    $('roomModalTitle').textContent = 'Edit Data Kamar';
    $('saveRoomBtn').innerHTML = '<i class="bi bi-check-lg"></i> Simpan Perubahan';

    $('roomType').value = room.type;
    $('roomNumber').value = room.number;
    $('roomCapacity').value = room.capacity;
    $('roomOccupants').value = room.occupants;
    $('roomOccupants').max = room.capacity;
    $('occupantHint').textContent = `Kapasitas maksimal ${room.capacity} orang.`;
    $('roomPrice').value = room.price;
    $('roomBathroom').value = room.bathroom;
    $('roomStatus').value = room.status;
    $('roomDescription').value = room.description || '';

    setSelectedFacilities(room.facilities);
    updateDescriptionCount();
    resetPhotoPreview(room.photoUrl);

    openModal('roomModal');
}

/* ==========================================
   DETAIL KAMAR
========================================== */

function openDetailModal(id) {
    const room = rooms.find(item => String(item.id) === String(id));

    if (!room) return;

    $('detailTitle').textContent = `Detail Kamar ${room.number}`;

    const details = [
        ['Nomor Kamar', room.number],
        ['Tipe Kamar', room.type],
        ['Jumlah Penghuni', `${room.occupants} orang`],
        ['Kapasitas', `${room.capacity} orang`],
        ['Harga per Bulan', formatRupiah(room.price)],
        ['Kamar Mandi', room.bathroom],
        ['Status', room.status === 'Kosong' ? 'Tersedia' : room.status]
    ];

    $('detailGrid').innerHTML = details.map(([label, value]) => `
        <div class="detail-item">
            <small>${escapeHTML(label)}</small>
            <strong>${escapeHTML(value)}</strong>
        </div>
    `).join('');

    $('detailFacilities').innerHTML = room.facilities.length
        ? room.facilities.map(item => `<span class="facility-tag">${escapeHTML(item)}</span>`).join('')
        : '<span style="color:#A9B0B8;font-size:11px;">Belum ada fasilitas yang dicatat.</span>';

    $('detailDescription').textContent =
        room.description || 'Tidak ada deskripsi kamar.';

    openModal('detailModal');
}

/* ==========================================
   VALIDASI FORM
========================================== */

function validateRoomForm() {
    const type = $('roomType').value;
    const config = roomConfig[type];

    const number = $('roomNumber').value.trim().toUpperCase();
    const occupants = Number($('roomOccupants').value);
    const price = Number($('roomPrice').value);

    if (!config) {
        showToast('Tipe kamar tidak valid.', true);
        return false;
    }

    if (!new RegExp(`^${config.prefix}[0-9]{2}$`).test(number)) {
        showToast(
            `Nomor kamar ${type} harus menggunakan format ${config.prefix}01, ${config.prefix}02, dan seterusnya.`,
            true
        );
        $('roomNumber').focus();
        return false;
    }

    const currentId = $('roomId').value;

    const duplicate = rooms.some(room =>
        room.number.toUpperCase() === number &&
        String(room.id) !== String(currentId)
    );

    if (duplicate) {
        showToast('Nomor kamar sudah digunakan.', true);
        $('roomNumber').focus();
        return false;
    }

    if (!Number.isInteger(occupants) || occupants < 0 || occupants > config.capacity) {
        showToast(`Jumlah penghuni harus antara 0 sampai ${config.capacity} orang.`, true);
        $('roomOccupants').focus();
        return false;
    }

    if (!Number.isFinite(price) || price < 1) {
        showToast('Harga kamar harus lebih besar dari 0.', true);
        $('roomPrice').focus();
        return false;
    }

    if (!Number.isInteger(price)) {
        showToast('Harga kamar harus berupa angka bulat.', true);
        $('roomPrice').focus();
        return false;
    }

    if (!$('roomBathroom').value) {
        showToast('Jenis kamar mandi wajib dipilih.', true);
        $('roomBathroom').focus();
        return false;
    }

    if ($('roomDescription').value.length > 500) {
        showToast('Deskripsi maksimal 500 karakter.', true);
        $('roomDescription').focus();
        return false;
    }

    const selectedFacilities = getSelectedFacilities();

    if (selectedFacilities.some(facility => !allowedFacilities.includes(facility))) {
        showToast('Terdapat pilihan fasilitas yang tidak valid.', true);
        return false;
    }

    const photo = $('roomPhoto').files?.[0];

    if (photo) {
        if (!allowedPhotoTypes.includes(photo.type)) {
            showToast('Format foto harus JPG, JPEG, PNG, atau WebP.', true);
            $('roomPhoto').focus();
            return false;
        }

        if (photo.size > MAX_PHOTO_SIZE) {
            showToast('Ukuran foto maksimal 2 MB.', true);
            $('roomPhoto').focus();
            return false;
        }
    }

    return true;
}

/* ==========================================
   PAYLOAD DATABASE
========================================== */

function buildPayload() {
    const status = $('roomStatus').value;
    const formData = new FormData();

    formData.append(
        'nomor_kamar',
        $('roomNumber').value.trim().toUpperCase()
    );

    formData.append(
        'tipe',
        $('roomType').value === 'Single' ? 'single' : 'double'
    );

    formData.append('harga', $('roomPrice').value);
    formData.append('kapasitas', $('roomCapacity').value);
    formData.append('jumlah_penghuni', $('roomOccupants').value);

    formData.append(
        'jenis_kamar_mandi',
        $('roomBathroom').value === 'Dalam Kamar'
            ? 'dalam_kamar'
            : 'bersama'
    );

    formData.append(
        'status',
        status === 'Perbaikan'
            ? 'maintenance'
            : (status === 'Terisi' ? 'terisi' : 'tersedia')
    );

    getSelectedFacilities().forEach(facility => {
        formData.append('fasilitas[]', facility);
    });

    formData.append(
        'deskripsi',
        $('roomDescription').value.trim()
    );

    const photo = $('roomPhoto').files?.[0];

    if (photo) {
        formData.append('foto', photo);
    }

    return formData;
}

/* ==========================================
   SIMPAN TAMBAH / EDIT
========================================== */

async function saveRoom(event) {
    event.preventDefault();

    if (!validateRoomForm()) return;

    const id = $('roomId').value;
    const button = $('saveRoomBtn');
    const originalText = button.innerHTML;

    if (button.disabled) return;

    button.disabled = true;
    button.textContent = 'Menyimpan...';

    try {
        const payload = buildPayload();

        if (id) {
            /*
             * Laravel method spoofing:
             * FormData dikirim melalui POST dengan _method=PUT.
             * Cara ini diperlukan agar file upload terbaca saat update.
             */
            payload.append('_method', 'PUT');

            await apiRequest(
                API.update.replace('__ID__', encodeURIComponent(id)),
                'POST',
                payload
            );

            showToast('Data kamar dan foto berhasil diperbarui.');
        } else {
            await apiRequest(
                API.store,
                'POST',
                payload
            );

            showToast('Kamar baru berhasil ditambahkan.');
        }

        closeModal('roomModal');
        await loadRooms();

    } catch (error) {
        showToast(error.message, true);

    } finally {
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

/* ==========================================
   HAPUS KAMAR
========================================== */

async function deleteRoom(id) {
    const room = rooms.find(item => String(item.id) === String(id));

    if (!room) return;

    const confirmed = window.confirm(
        `Yakin ingin menghapus kamar ${room.number}? Data yang dihapus tidak dapat dikembalikan.`
    );

    if (!confirmed) return;

    try {
        await apiRequest(
            API.destroy.replace('__ID__', encodeURIComponent(id)),
            'DELETE'
        );

        showToast(`Kamar ${room.number} berhasil dihapus.`);
        await loadRooms();

    } catch (error) {
        showToast(error.message, true);
    }
}

/* ==========================================
   DESKRIPSI
========================================== */

function updateDescriptionCount() {
    $('descriptionCount').textContent = $('roomDescription').value.length;
}

/* ==========================================
   RESET FILTER
========================================== */

function resetFilters() {
    $('searchInput').value = '';
    $('statusFilter').value = '';
    $('typeFilter').value = '';
    $('sortFilter').value = 'number-asc';

    currentPage = 1;
    renderRooms();
}

/* ==========================================
   SIDEBAR RESPONSIVE
========================================== */

function toggleSidebar() {
    const isOpen = $('sidebar').classList.toggle('open');

    $('mobileBackdrop').classList.toggle('show', isOpen);
    $('menuBtn').setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
}

function closeSidebar() {
    $('sidebar').classList.remove('open');
    $('mobileBackdrop').classList.remove('show');
    $('menuBtn').setAttribute('aria-expanded', 'false');

    if (!document.querySelector('.overlay.show')) {
        document.body.style.overflow = '';
    }
}

/* ==========================================
   EVENT FORM DAN TOMBOL
========================================== */

$('addRoomBtn').addEventListener('click', openAddModal);
$('roomForm').addEventListener('submit', saveRoom);
$('refreshBtn').addEventListener('click', loadRooms);
$('roomPhoto').addEventListener('change', handlePhotoChange);

/* ==========================================
   EVENT TIPE DAN PENGHUNI
========================================== */

$('roomType').addEventListener('change', () => updateTypeFields(true));

$('roomOccupants').addEventListener('input', () => {
    syncStatusFromOccupants();
});

$('roomStatus').addEventListener('change', () => {
    if ($('roomStatus').value !== 'Perbaikan') {
        syncStatusFromOccupants();
    }
});

/* ==========================================
   EVENT FASILITAS
========================================== */

$('selectAllFacilities').addEventListener('change', event => {
    toggleAllFacilities(event.target.checked);
});

$('facilityList').addEventListener('change', event => {
    if (event.target.matches('input[type="checkbox"]')) {
        updateFacilitySelectAll();
    }
});

/* ==========================================
   EVENT DESKRIPSI
========================================== */

$('roomDescription').addEventListener('input', updateDescriptionCount);

/* ==========================================
   EVENT FILTER
========================================== */

$('searchInput').addEventListener('input', () => {
    currentPage = 1;
    renderRooms();
});

['statusFilter', 'typeFilter', 'sortFilter'].forEach(id => {
    $(id).addEventListener('change', () => {
        currentPage = 1;
        renderRooms();
    });
});

$('resetFilterBtn').addEventListener('click', resetFilters);

/* ==========================================
   EVENT AKSI TABEL
========================================== */

$('roomTableBody').addEventListener('click', event => {
    const button = event.target.closest('[data-action]');

    if (!button) return;

    const { action, id } = button.dataset;

    if (action === 'detail') openDetailModal(id);
    if (action === 'edit') openEditModal(id);
    if (action === 'delete') deleteRoom(id);
});

/* ==========================================
   EVENT PAGINATION
========================================== */

$('paginationActions').addEventListener('click', event => {
    const button = event.target.closest('[data-page]');

    if (!button || button.disabled) return;

    const nextPage = Number(button.dataset.page);
    const totalPages = Math.max(
        1,
        Math.ceil(getFilteredRooms().length / ITEMS_PER_PAGE)
    );

    if (nextPage >= 1 && nextPage <= totalPages) {
        currentPage = nextPage;
        renderRooms();
    }
});

/* ==========================================
   TUTUP MODAL
========================================== */

document.querySelectorAll('[data-close]').forEach(button => {
    button.addEventListener('click', () => closeModal(button.dataset.close));
});

document.querySelectorAll('.overlay').forEach(overlay => {
    overlay.addEventListener('click', event => {
        if (event.target === overlay) closeModal(overlay.id);
    });
});

/* ==========================================
   SIDEBAR MOBILE
========================================== */

$('menuBtn').addEventListener('click', toggleSidebar);
$('mobileBackdrop').addEventListener('click', closeSidebar);

/* ==========================================
   TOMBOL ESCAPE
========================================== */

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        closeAllModals();
        closeSidebar();
    }
});

/* ==========================================
   TANGGAL
========================================== */

function setCurrentDate() {
    $('currentDate').textContent = new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date());
}

/* ==========================================
   PEMBERSIHAN PREVIEW
========================================== */

window.addEventListener('beforeunload', () => {
    if (photoPreviewObjectUrl) {
        URL.revokeObjectURL(photoPreviewObjectUrl);
    }
});

/* ==========================================
   INISIALISASI
========================================== */

setCurrentDate();
updateDescriptionCount();
updateFacilitySelectAll();
loadRooms();

</script>

@vite('resources/js/app.js')
</body>
</html>