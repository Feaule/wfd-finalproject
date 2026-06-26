<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel Admin - Sistem Manajemen Apartemen">
    <title>@yield('title', 'Dashboard') | Admin Apartemen</title>
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
            --bg-sidebar: #0D1526;
            --accent: #6366F1;
            --accent-hover: #4F46E5;
            --accent-light: rgba(99,102,241,0.15);
            --teal: #14B8A6;
            --teal-light: rgba(20,184,166,0.15);
            --emerald: #10B981;
            --emerald-light: rgba(16,185,129,0.15);
            --amber: #F59E0B;
            --amber-light: rgba(245,158,11,0.15);
            --rose: #F43F5E;
            --rose-light: rgba(244,63,94,0.15);
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --border: rgba(255,255,255,0.07);
            --border-hover: rgba(255,255,255,0.15);
            --shadow: 0 4px 24px rgba(0,0,0,0.35);
            --sidebar-w: 260px;
            --radius: 14px;
            --radius-sm: 8px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand h1 {
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366F1, #14B8A6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.3px;
        }

        .sidebar-brand p {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-user {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--teal));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
            color: white;
        }

        .sidebar-user-info small {
            font-size: 0.65rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .sidebar-user-info strong {
            display: block;
            font-size: 0.82rem;
            color: var(--text-primary);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 12px 24px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 24px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s;
            position: relative;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--accent-light);
        }

        .nav-link.active {
            color: var(--accent);
            background: var(--accent-light);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-link .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 16px;
            border: 1px solid var(--rose);
            background: var(--rose-light);
            color: var(--rose);
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: var(--rose);
            color: white;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 64px;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .topbar-breadcrumb {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-wrapper {
            flex: 1;
            padding: 32px;
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
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-body {
            padding: 24px;
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .stat-card:hover { border-color: var(--border-hover); transform: translateY(-2px); }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-icon.indigo { background: var(--accent-light); color: var(--accent); }
        .stat-icon.teal   { background: var(--teal-light); color: var(--teal); }
        .stat-icon.emerald{ background: var(--emerald-light); color: var(--emerald); }
        .stat-icon.amber  { background: var(--amber-light); color: var(--amber); }
        .stat-icon.rose   { background: var(--rose-light); color: var(--rose); }

        .stat-info p { font-size: 0.75rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-info h3 { font-size: 1.8rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-top: 4px; }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 13px 18px;
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
            padding: 14px 18px;
            font-size: 0.875rem;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover td {
            background: rgba(255,255,255,0.02);
            color: var(--text-primary);
        }

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
        .badge-aktif  { background: var(--emerald-light); color: var(--emerald); }
        .badge-nonaktif { background: rgba(100,116,139,0.15); color: var(--text-muted); }
        .badge-sewa       { background: var(--accent-light); color: var(--accent); }
        .badge-listrik    { background: var(--amber-light); color: var(--amber); }
        .badge-air        { background: var(--teal-light); color: var(--teal); }
        .badge-kebersihan { background: var(--emerald-light); color: var(--emerald); }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary   { background: var(--accent); color: white; }
        .btn-primary:hover  { background: var(--accent-hover); transform: translateY(-1px); }
        .btn-secondary { background: rgba(255,255,255,0.07); color: var(--text-secondary); border: 1px solid var(--border); }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: var(--text-primary); }
        .btn-success   { background: var(--emerald); color: white; }
        .btn-success:hover { opacity: 0.9; }
        .btn-warning   { background: var(--amber); color: #1a1a1a; }
        .btn-warning:hover { opacity: 0.9; }
        .btn-danger    { background: var(--rose); color: white; }
        .btn-danger:hover  { opacity: 0.9; }
        .btn-teal      { background: var(--teal); color: white; }
        .btn-teal:hover{ opacity: 0.9; }
        .btn-sm { padding: 6px 12px; font-size: 0.78rem; }
        .btn-icon { padding: 8px; width: 34px; height: 34px; justify-content: center; }

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
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-control::placeholder { color: var(--text-muted); }

        select.form-control option { background: var(--bg-card); color: var(--text-primary); }

        .form-text { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }
        .form-error { font-size: 0.75rem; color: var(--rose); margin-top: 5px; }

        /* ===== FILTERS ===== */
        .filter-bar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-bar .form-group { margin-bottom: 0; }
        .filter-bar .form-control { min-width: 180px; }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pagination-wrapper .pagination { display: flex; gap: 6px; list-style: none; }
        .pagination .page-item .page-link {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.05);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid var(--border);
        }
        .pagination .page-item.active .page-link { background: var(--accent); color: white; border-color: var(--accent); }
        .pagination .page-item .page-link:hover { background: var(--accent-light); color: var(--accent); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1><i class="fa-solid fa-building-columns"></i> ApartemenApp</h1>
            <p>Panel Administrator</p>
        </div>

        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <small>Administrator</small>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                Dashboard
            </a>

            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.lantai.index') }}"
               class="nav-link {{ request()->routeIs('admin.lantai.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-layer-group"></i></span>
                Data Lantai
            </a>
            <a href="{{ route('admin.unit.index') }}"
               class="nav-link {{ request()->routeIs('admin.unit.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-building"></i></span>
                Data Unit
            </a>
            <a href="{{ route('admin.penghuni.index') }}"
               class="nav-link {{ request()->routeIs('admin.penghuni.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                Data Penghuni
            </a>
            <a href="{{ route('admin.pengaduan.index') }}"
               class="nav-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-headset"></i></span>
                Pengaduan
            </a>

            <div class="nav-section-label">Keuangan</div>
            <a href="{{ route('admin.tagihan.index') }}"
               class="nav-link {{ request()->routeIs('admin.tagihan.index') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                Daftar Tagihan
            </a>
            <a href="{{ route('admin.tagihan.generate.form') }}"
               class="nav-link {{ request()->routeIs('admin.tagihan.generate.form') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bolt"></i></span>
                Generate Tagihan
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <header class="topbar">
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-breadcrumb">@yield('breadcrumb', 'Admin / Dashboard')</div>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fa-solid fa-circle-info"></i>
                    {{ session('info') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
