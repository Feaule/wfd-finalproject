<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Manajemen Apartemen">
    <title>Login | ApartemenApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F172A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Background animated blobs */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }
        .bg-blob-1 { width: 500px; height: 500px; background: #6366F1; top: -200px; left: -200px; animation-delay: 0s; }
        .bg-blob-2 { width: 400px; height: 400px; background: #14B8A6; bottom: -150px; right: -150px; animation-delay: 3s; }
        .bg-blob-3 { width: 300px; height: 300px; background: #F59E0B; top: 50%; left: 50%; animation-delay: 6s; opacity: 0.1; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.05); }
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-logo {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #6366F1, #14B8A6);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 20px;
            box-shadow: 0 8px 32px rgba(99,102,241,0.4);
        }

        .login-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #64748B;
            font-size: 0.875rem;
            margin-top: 6px;
        }

        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #94A3B8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 0.85rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 42px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            color: #F1F5F9;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #6366F1;
            background: rgba(99,102,241,0.08);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-control::placeholder { color: #475569; }

        .alert-danger {
            background: rgba(244,63,94,0.1);
            border: 1px solid rgba(244,63,94,0.4);
            color: #F43F5E;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #6366F1;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 0.82rem;
            color: #94A3B8;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #6366F1, #4F46E5);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.35);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.45);
        }

        .btn-login:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.06);
            color: #475569;
            font-size: 0.78rem;
        }

        .login-footer strong { color: #64748B; }
    </style>
</head>
<body>
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fa-solid fa-building-columns" style="color:white"></i>
            </div>
            <h1>ApartemenApp</h1>
            <p>Masuk ke sistem manajemen apartemen</p>
        </div>

        @if($errors->any())
            <div class="alert-danger">
                <i class="fa-solid fa-circle-xmark"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="admin@apartemen.com"
                           required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input id="password" type="password" name="password" class="form-control"
                           placeholder="••••••••" required>
                </div>
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya selama 30 hari</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>

        <div class="login-footer">
            Sistem Manajemen Apartemen &copy; {{ date('Y') }}
        </div>
    </div>
</body>
</html>
