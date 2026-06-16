<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Penghuni - Sistem Manajemen Apartemen">
    <title>@yield('title', 'Portal Penghuni') | ApartemenApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--teal), var(--accent));
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }

        .brand-text h1 { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
        .brand-text p  { font-size: 0.68rem; color: var(--text-muted); }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text-primary); }
        .nav-item.active { background: var(--teal-light); color: var(--teal); font-weight: 600; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
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
        }

        .btn-logout-nav:hover { background: var(--rose); color: white; }

        /* ===== MAIN ===== */
        .main-content {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px;
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
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
        .card-body  { padding: 24px; }

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
            padding: 10px 20px;
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
    </style>
    @stack('styles')
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="brand-logo"><i class="fa-solid fa-building" style="color:white"></i></div>
            <div class="brand-text">
                <h1>ApartemenApp</h1>
                <p>Portal Penghuni</p>
            </div>
        </div>

        <div class="navbar-nav">
            <a href="{{ route('penghuni.tagihan.index') }}"
               class="nav-item {{ request()->routeIs('penghuni.tagihan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Tagihan Saya
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

    @stack('scripts')
</body>
</html>
