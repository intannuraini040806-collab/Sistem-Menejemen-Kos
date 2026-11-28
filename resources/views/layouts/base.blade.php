
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', 'Dashboard') - KosHaven</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --kh-bg: #10151C;
            --kh-sidebar: #171D25;
            --kh-card: #1C242E;
            --kh-border: rgba(255,255,255,.08);
            --kh-text: #F4F1EA;
            --kh-muted: #AEB7C0;
            --kh-gold: #D9B77A;
            --kh-danger: #D58F8F;
            --kh-sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--kh-bg);
            color: var(--kh-text);
            font-family: 'DM Sans', sans-serif;
        }

        button, input, select, textarea {
            font: inherit;
        }

        .kh-layout {
            min-height: 100vh;
        }

        .kh-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            width: var(--kh-sidebar-width);
            padding: 25px 18px;
            background: var(--kh-sidebar);
            border-right: 1px solid var(--kh-border);
            transition: transform .25s ease;
        }

        .kh-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            border-bottom: 1px solid var(--kh-border);
        }

        .kh-brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            color: #171D25;
            background: var(--kh-gold);
            border-radius: 12px;
            font-size: 21px;
        }

        .kh-brand-name {
            color: var(--kh-text);
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
        }

        .kh-brand-caption {
            margin-top: 2px;
            color: var(--kh-muted);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .kh-role {
            margin: 24px 10px 12px;
            color: var(--kh-muted);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .kh-sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            overflow-y: auto;
        }

        .kh-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 13px;
            color: var(--kh-muted);
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            text-decoration: none;
            transition: .2s ease;
        }

        .kh-sidebar-nav a:hover,
        .kh-sidebar-nav a.active {
            color: var(--kh-gold);
            background: rgba(217,183,122,.08);
            border-color: rgba(217,183,122,.12);
        }

        .kh-sidebar-nav a i {
            width: 19px;
            font-size: 16px;
            text-align: center;
        }

        .kh-sidebar-bottom {
            padding-top: 18px;
            border-top: 1px solid var(--kh-border);
        }

        .kh-main {
            min-height: 100vh;
            margin-left: var(--kh-sidebar-width);
        }

        .kh-topbar {
            position: sticky;
            top: 0;
            z-index: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            padding: 15px 30px;
            background: rgba(16,21,28,.94);
            border-bottom: 1px solid var(--kh-border);
            backdrop-filter: blur(12px);
        }

        .kh-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .kh-page-heading {
            margin: 0;
            color: var(--kh-text);
            font-size: 18px;
            font-weight: 700;
        }

        .kh-page-subtitle {
            margin: 4px 0 0;
            color: var(--kh-muted);
            font-size: 11px;
        }

        .kh-role-badge {
            padding: 7px 12px;
            color: var(--kh-gold);
            background: rgba(217,183,122,.09);
            border: 1px solid rgba(217,183,122,.16);
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .kh-content {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px;
        }

        .kh-menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            color: var(--kh-text);
            background: var(--kh-card);
            border: 1px solid var(--kh-border);
            border-radius: 8px;
            cursor: pointer;
        }

        .kh-sidebar-backdrop {
            display: none;
        }

        .kh-logout-component-wrapper {
            width: 100%;
        }

        .kh-logout-component-wrapper .kh-logout-trigger {
            display: flex;
            justify-content: flex-start;
            width: 100%;
            padding: 12px 13px;
            color: var(--kh-danger);
            background: rgba(213,143,143,.07);
            border: 1px solid rgba(213,143,143,.12);
            border-radius: 9px;
        }

        .kh-logout-component-wrapper .kh-logout-trigger:hover {
            color: #E5AAAA;
            background: rgba(213,143,143,.15);
            border-color: rgba(213,143,143,.25);
        }

        .kh-logout-component-wrapper .kh-logout-trigger i {
            width: 19px;
            font-size: 16px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .kh-sidebar {
                transform: translateX(-100%);
            }

            .kh-sidebar.is-open {
                transform: translateX(0);
            }

            .kh-main {
                margin-left: 0;
            }

            .kh-menu-toggle {
                display: inline-flex;
            }

            .kh-sidebar-backdrop.is-visible {
                position: fixed;
                inset: 0;
                z-index: 900;
                display: block;
                background: rgba(0,0,0,.55);
            }
        }

        @media (max-width: 600px) {
            .kh-topbar {
                min-height: 65px;
                padding: 12px 16px;
            }

            .kh-page-heading {
                font-size: 15px;
            }

            .kh-page-subtitle {
                font-size: 10px;
            }

            .kh-role-badge {
                padding: 6px 9px;
                font-size: 10px;
            }

            .kh-content {
                padding: 18px 15px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="kh-layout">

    <aside class="kh-sidebar" id="khSidebar">
        <div class="kh-brand">
            <div class="kh-brand-icon">
                <i class="bi bi-house-heart-fill"></i>
            </div>

            <div>
                <div class="kh-brand-name">KosHaven</div>
                <div class="kh-brand-caption">Boarding House</div>
            </div>
        </div>

        <div class="kh-role">
            @yield('role-label', 'Pengguna')
        </div>

        <nav class="kh-sidebar-nav">
            @yield('sidebar')
        </nav>

        <div class="kh-sidebar-bottom">
            <div class="kh-logout-component-wrapper">
                @include('components.logout-modal')
            </div>
        </div>
    </aside>

    <div class="kh-sidebar-backdrop" id="khSidebarBackdrop"></div>

    <main class="kh-main">
        <header class="kh-topbar">
            <div class="kh-topbar-left">
                <button
                    type="button"
                    class="kh-menu-toggle"
                    id="khMenuToggle"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h1 class="kh-page-heading">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <p class="kh-page-subtitle">
                        @yield('page-subtitle', 'Selamat datang di KosHaven')
                    </p>
                </div>
            </div>

            <div class="kh-role-badge">
                @yield('role-label', 'Pengguna')
            </div>
        </header>

        <section class="kh-content">
            @yield('content')
        </section>
    </main>
</div>

<script>
(function () {
    const sidebar = document.getElementById('khSidebar');
    const toggle = document.getElementById('khMenuToggle');
    const backdrop = document.getElementById('khSidebarBackdrop');

    if (!sidebar || !toggle || !backdrop) return;

    function openSidebar() {
        sidebar.classList.add('is-open');
        backdrop.classList.add('is-visible');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        backdrop.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    backdrop.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeSidebar();
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) closeSidebar();
    });
})();
</script>

@stack('scripts')
</body>
</html>
