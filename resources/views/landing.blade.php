<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApartIn - Sistem Manajemen Apartemen Modern</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F172A;
            color: #F1F5F9;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding-top: 74px;
        }

        /* Background animated blobs */
        .bg-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.2;
            animation: float 12s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }
        .bg-blob-1 { width: 600px; height: 600px; background: #6366F1; top: -300px; left: -200px; animation-delay: 0s; }
        .bg-blob-2 { width: 500px; height: 500px; background: #14B8A6; bottom: -200px; right: -100px; animation-delay: 4s; }
        .bg-blob-3 { width: 400px; height: 400px; background: #F59E0B; top: 40%; right: 10%; animation-delay: 8s; opacity: 0.15; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 16px 0;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #6366F1, #14B8A6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
        }

        .brand-text {
            font-size: 1.3rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -0.5px;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid rgba(20,184,166,0.5);
            color: #14B8A6;
        }

        .btn-outline:hover {
            background: rgba(20,184,166,0.1);
            border-color: #14B8A6;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366F1, #4F46E5);
            color: white;
            border: none;
            box-shadow: 0 4px 20px rgba(99,102,241,0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.4);
        }

        /* Hero Section */
        .hero {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 24px 60px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
            margin-bottom: 24px;
        }

        .hero .highlight {
            background: linear-gradient(135deg, #14B8A6, #6366F1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            color: #94A3B8;
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Features Section */
        .features {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 50px;
            letter-spacing: -0.5px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99,102,241,0.4);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #6366F1, #14B8A6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 8px 32px rgba(99,102,241,0.3);
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #F1F5F9;
        }

        .feature-card p {
            color: #94A3B8;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta {
            position: relative;
            z-index: 10;
            max-width: 900px;
            margin: 0 auto;
            padding: 80px 24px;
            text-align: center;
        }

        .cta-card {
            background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(20,184,166,0.2));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .cta p {
            font-size: 1.1rem;
            color: #94A3B8;
            margin-bottom: 32px;
        }

        /* Footer */
        .footer {
            position: relative;
            z-index: 10;
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 30px 24px;
            text-align: center;
            color: #64748B;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero h1 { font-size: 3rem; }
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; letter-spacing: -0.5px; }
            .hero p { font-size: 1rem; }
            .section-title { font-size: 1.8rem; }
            .feature-grid { grid-template-columns: 1fr; gap: 20px; }
            .nav-buttons { gap: 8px; }
            .btn { padding: 9px 18px; font-size: 0.85rem; }
            .cta-card { padding: 40px 24px; }
            .cta h2 { font-size: 1.8rem; }
            .hero { padding: 40px 20px; }
            .features { padding: 20px 20px 60px; }
            .bg-blob-1 { width: 350px; height: 350px; }
            .bg-blob-2 { width: 300px; height: 300px; }
            .bg-blob-3 { display: none; }
        }

        @media (max-width: 480px) {
            .hero h1 { font-size: 1.8rem; }
            .hero { padding: 30px 16px; }
            .hero p { font-size: 0.95rem; }
            .section-title { font-size: 1.5rem; margin-bottom: 30px; }
            .features { padding: 20px 16px 50px; }
            .cta { padding: 40px 16px; }
            .cta-card { padding: 30px 20px; border-radius: 20px; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .hero-buttons .btn { width: 100%; max-width: 260px; justify-content: center; }
            .navbar-container { padding: 0 16px; }
            .brand-text { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
    <!-- Background Blobs -->
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="brand">
                <div class="brand-logo">
                    <i class="fa-solid fa-building-columns" style="color:white"></i>
                </div>
                <span class="brand-text">ApartIn</span>
            </a>
            <div class="nav-buttons">
                <a href="/login" class="btn btn-outline">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
                <a href="/register" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Daftar
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>
            Kelola Apartemen<br>
            <span class="highlight">Lebih Mudah & Modern</span>
        </h1>
        <p>
            Platform manajemen apartemen terlengkap — kelola unit, tagihan, pembayaran, 
            hingga pengaduan dalam satu sistem yang terintegrasi.
        </p>
        <div class="hero-buttons">
            <a href="/register" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem;">
                <i class="fa-solid fa-rocket"></i> Mulai Sekarang
            </a>
            <a href="/login" class="btn btn-outline" style="padding: 14px 32px; font-size: 1rem;">
                <i class="fa-solid fa-arrow-right"></i> Login
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-building" style="color:white"></i>
                </div>
                <h3>Manajemen Unit</h3>
                <p>Kelola semua unit dan lantai apartemen dengan mudah. Lengkap dengan foto, deskripsi, dan status ketersediaan.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-file-invoice-dollar" style="color:white"></i>
                </div>
                <h3>Tagihan Otomatis</h3>
                <p>Generate tagihan bulanan otomatis untuk sewa, listrik, air, dan kebersihan. Pantau status pembayaran real-time.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-credit-card" style="color:white"></i>
                </div>
                <h3>Pembayaran Digital</h3>
                <p>Penghuni dapat upload bukti pembayaran langsung. Admin verifikasi dengan mudah dan cepat.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-users" style="color:white"></i>
                </div>
                <h3>Data Penghuni</h3>
                <p>Catat dan kelola data penghuni secara lengkap. Approval otomatis untuk pendaftaran akun baru.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset" style="color:white"></i>
                </div>
                <h3>Pengaduan Online</h3>
                <p>Penghuni bisa membuat pengaduan dengan foto. Admin merespon dan update status secara real-time.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-chart-line" style="color:white"></i>
                </div>
                <h3>Dashboard Analytics</h3>
                <p>Statistik lengkap untuk admin: total tagihan, pembayaran, penghuni aktif, dan pengaduan pending.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-card">
            <h2>Siap Bergabung?</h2>
            <p>Daftarkan diri Anda sekarang dan nikmati kemudahan manajemen apartemen modern.</p>
            <a href="/register" class="btn btn-primary" style="padding: 14px 40px; font-size: 1.05rem;">
                <i class="fa-solid fa-user-plus"></i> Daftar Gratis Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} ApartIn. Sistem Manajemen Apartemen Modern.</p>
    </footer>
</body>
</html>
