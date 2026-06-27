<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Penghuni - Sistem Manajemen Apartemen">
    <title>@yield('title', 'Portal Penghuni') | ApartIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary: #0F172A;
            --bg-secondary: #1E293B;
            --bg-card: #1E293B;
            --teal: #14B8A6;
            --teal-dark: #0D9488;
            --teal-light: rgba(20,184,166,0.15);
            --emerald: #10B981;
            --emerald-light: rgba(16,185,129,0.15);
            --amber: #F59E0B;
            --amber-light: rgba(245,158,11,0.15);
            --rose: #F43F5E;
            --rose-light: rgba(244,63,94,0.15);
            --accent: #6366F1;
            --accent-light: rgba(99,102,241,0.15);
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --border: rgba(255,255,255,0.07);
            --radius: 14px;
            --radius-sm: 8px;
            --navbar-h: 68px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            height: var(--navbar-h);
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--teal), var(--accent));
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .brand-text h1 { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
        .brand-text p  { font-size: 0.68rem; color: var(--text-muted); }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text-primary); }
        .nav-item.active { background: var(--teal-light); color: var(--teal); font-weight: 600; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 999px;
        }

        .avatar-sm {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
        }

        .user-pill-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
        .user-pill-role { font-size: 0.68rem; color: var(--teal); }

        .btn-logout-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--rose-light);
            border: 1px solid var(--rose);
            color: var(--rose);
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-logout-nav:hover { background: var(--rose); color: white; }

        /* ===== HAMBURGER BUTTON ===== */
        .btn-hamburger {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.07);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .btn-hamburger:hover {
            background: var(--teal-light);
            color: var(--teal);
            border-color: var(--teal);
        }

        /* ===== MOBILE DRAWER ===== */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 199;
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-overlay.active {
            display: block;
            opacity: 1;
        }

        .mobile-drawer {
            position: fixed;
            top: 0; right: 0; bottom: 0;
            width: 280px;
            background: var(--bg-secondary);
            border-left: 1px solid var(--border);
            z-index: 200;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .mobile-drawer.open {
            transform: translateX(0);
        }

        .drawer-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .drawer-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-close-drawer {
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.07);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-close-drawer:hover {
            background: var(--rose-light);
            color: var(--rose);
        }

        .drawer-nav {
            flex: 1;
            padding: 16px 0;
        }

        .drawer-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .drawer-nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text-primary); }
        .drawer-nav-item.active { background: var(--teal-light); color: var(--teal); font-weight: 600; border-left: 3px solid var(--teal); }

        .drawer-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        /* ===== MAIN ===== */
        .main-content {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 20px;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success { background: var(--emerald-light); border: 1px solid var(--emerald); color: var(--emerald); }
        .alert-warning { background: var(--amber-light); border: 1px solid var(--amber); color: var(--amber); }
        .alert-danger  { background: var(--rose-light); border: 1px solid var(--rose); color: var(--rose); }
        .alert-info    { background: var(--teal-light); border: 1px solid var(--teal); color: var(--teal); }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .card:hover { border-color: rgba(255,255,255,0.12); }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
        .card-body  { padding: 20px; }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .badge-belum  { background: var(--rose-light); color: var(--rose); }
        .badge-tunggu { background: var(--amber-light); color: var(--amber); }
        .badge-lunas  { background: var(--emerald-light); color: var(--emerald); }
        .badge-sewa       { background: var(--accent-light); color: var(--accent); }
        .badge-listrik    { background: var(--amber-light); color: var(--amber); }
        .badge-air        { background: var(--teal-light); color: var(--teal); }
        .badge-kebersihan { background: var(--emerald-light); color: var(--emerald); }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary { background: var(--teal); color: white; }
        .btn-primary:hover { background: var(--teal-dark); transform: translateY(-1px); }
        .btn-secondary { background: rgba(255,255,255,0.07); color: var(--text-secondary); border: 1px solid var(--border); }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); }
        .btn-danger { background: var(--rose); color: white; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-sm { padding: 7px 14px; font-size: 0.78rem; }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 11px 15px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 0.875rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(20,184,166,0.15);
        }

        .form-control::placeholder { color: var(--text-muted); }
        select.form-control option { background: var(--bg-card); }
        .form-error { font-size: 0.75rem; color: var(--rose); margin-top: 5px; }
        .form-text  { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 480px;
        }

        thead th {
            padding: 14px 16px;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }

        tbody td {
            padding: 14px 16px;
            font-size: 0.875rem;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }

        tbody tr:hover td {
            color: var(--text-primary);
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .stat-card:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-2px); }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .stat-icon.teal   { background: var(--teal-light); color: var(--teal); }
        .stat-icon.emerald{ background: var(--emerald-light); color: var(--emerald); }
        .stat-icon.amber  { background: var(--amber-light); color: var(--amber); }
        .stat-icon.rose   { background: var(--rose-light); color: var(--rose); }

        .stat-info p { font-size: 0.72rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-info h3 { font-size: 1.6rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-top: 4px; }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .main-content { padding: 24px 16px; }
            .navbar-nav .nav-item span { display: none; }
            .navbar-nav .nav-item { padding: 8px 10px; }
        }

        @media (max-width: 768px) {
            .navbar-nav { display: none; }
            .user-pill { display: none; }
            .btn-logout-nav { display: none; }
            .btn-hamburger { display: flex; }

            .main-content { padding: 20px 14px; }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .card-body { padding: 16px; }
            .card-header { padding: 14px 16px; }

            .stat-info h3 { font-size: 1.3rem; }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .main-content { padding: 16px 12px; }

            .stat-card { padding: 14px 16px; }
            .brand-text p { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- MOBILE OVERLAY -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeDrawer()"></div>

    <!-- MOBILE DRAWER -->
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <div class="drawer-user">
                <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-pill-name">{{ auth()->user()->name }}</div>
                    <div class="user-pill-role">Penghuni</div>
                </div>
            </div>
            <button class="btn-close-drawer" onclick="closeDrawer()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <nav class="drawer-nav">
            <a href="{{ route('penghuni.dashboard') }}"
               class="drawer-nav-item {{ request()->routeIs('penghuni.dashboard') ? 'active' : '' }}"
               onclick="closeDrawer()">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('penghuni.unit') }}"
               class="drawer-nav-item {{ request()->routeIs('penghuni.unit') ? 'active' : '' }}"
               onclick="closeDrawer()">
                <i class="fa-solid fa-door-open"></i> Unit Saya
            </a>
            <a href="{{ route('penghuni.tagihan.index') }}"
               class="drawer-nav-item {{ request()->routeIs('penghuni.tagihan.*') || request()->routeIs('penghuni.pembayaran.*') ? 'active' : '' }}"
               onclick="closeDrawer()">
                <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan
            </a>
            <a href="{{ route('penghuni.pengaduan.index') }}"
               class="drawer-nav-item {{ request()->routeIs('penghuni.pengaduan.*') ? 'active' : '' }}"
               onclick="closeDrawer()">
                <i class="fa-solid fa-headset"></i> Pengaduan
            </a>
        </nav>

        <div class="drawer-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-nav" style="width:100%; justify-content:center;">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="brand-logo"><i class="fa-solid fa-building-columns" style="color:white"></i></div>
            <div class="brand-text">
                <h1>ApartIn</h1>
                <p>Portal Penghuni</p>
            </div>
        </div>

        <div class="navbar-nav">
            <a href="{{ route('penghuni.dashboard') }}"
               class="nav-item {{ request()->routeIs('penghuni.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('penghuni.unit') }}"
               class="nav-item {{ request()->routeIs('penghuni.unit') ? 'active' : '' }}">
                <i class="fa-solid fa-door-open"></i> Unit Saya
            </a>
            <a href="{{ route('penghuni.tagihan.index') }}"
               class="nav-item {{ request()->routeIs('penghuni.tagihan.*') || request()->routeIs('penghuni.pembayaran.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan
            </a>
            <a href="{{ route('penghuni.pengaduan.index') }}"
               class="nav-item {{ request()->routeIs('penghuni.pengaduan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-headset"></i> Pengaduan
            </a>
        </div>

        <div class="navbar-right">
            <div class="user-pill">
                <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-pill-name">{{ auth()->user()->name }}</div>
                    <div class="user-pill-role">Penghuni</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-nav">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
            <button class="btn-hamburger" onclick="openDrawer()" aria-label="Buka Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('warning') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function openDrawer() {
            document.getElementById('mobileDrawer').classList.add('open');
            document.getElementById('mobileOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            document.getElementById('mobileDrawer').classList.remove('open');
            document.getElementById('mobileOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeDrawer();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
