<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register - Sistem Manajemen Apartemen">
    <title>Register | ApartIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F172A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            padding: 40px 20px;
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

        .register-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-logo {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #6366F1, #14B8A6);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 20px;
            box-shadow: 0 8px 32px rgba(99,102,241,0.4);
        }

        .register-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -0.5px;
        }

        .register-header p {
            color: #64748B;
            font-size: 0.875rem;
            margin-top: 6px;
        }

        .form-group { margin-bottom: 18px; }

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
        }

        .alert-danger ul {
            margin-left: 20px;
            margin-top: 8px;
        }

        .alert-danger li {
            margin-bottom: 4px;
        }

        .alert-info {
            background: rgba(20,184,166,0.1);
            border: 1px solid rgba(20,184,166,0.3);
            color: #14B8A6;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            display: flex;
            align-items: start;
            gap: 10px;
        }

        .btn-register {
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
            margin-top: 6px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.45);
        }

        .btn-register:active { transform: translateY(0); }

        .register-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.06);
            color: #475569;
            font-size: 0.85rem;
        }

        .register-footer a {
            color: #14B8A6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-footer a:hover {
            color: #0D9488;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .back-link a {
            color: #64748B;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #14B8A6;
        }
    </style>
</head>
<body>
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <div class="register-card">
        <div class="register-header">
            <div class="register-logo">
                <i class="fa-solid fa-building-columns" style="color:white"></i>
            </div>
            <h1>Daftar Akun Baru</h1>
            <p>Buat akun penghuni ApartIn</p>
        </div>

        <div class="alert-info">
            <i class="fa-solid fa-circle-info" style="font-size:1.1rem;margin-top:2px"></i>
            <div>
                <strong>Info:</strong> Akun Anda akan diverifikasi oleh admin sebelum dapat digunakan untuk login.
            </div>
        </div>

        @if($errors->any())
            <div class="alert-danger">
                <i class="fa-solid fa-circle-xmark"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input id="name" type="text" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Nama lengkap Anda"
                           required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" class="form-control"
                           value="{{ old('email') }}" placeholder="email@example.com"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="no_ktp">Nomor KTP</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-id-card input-icon"></i>
                    <input id="no_ktp" type="text" name="no_ktp" class="form-control"
                           value="{{ old('no_ktp') }}" placeholder="16 digit nomor KTP"
                           maxlength="16" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input id="password" type="password" name="password" class="form-control"
                           placeholder="Minimal 8 karakter" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
            </button>
        </form>

        <div class="register-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>

        <div class="back-link">
            <a href="/"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
