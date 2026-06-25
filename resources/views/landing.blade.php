<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApartIn - Sistem Manajemen Apartemen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-white text-gray-900 font-sans">

    {{-- NAVBAR --}}
    <nav class="bg-black text-white px-8 py-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-2">
            <span class="text-yellow-400 text-2xl font-black tracking-tight">Apart</span>
            <span class="text-white text-2xl font-black tracking-tight">In</span>
        </div>
        <div class="flex gap-3">
            <a href="/login" class="px-5 py-2 rounded-lg border border-yellow-400 text-yellow-400 font-semibold hover:bg-yellow-400 hover:text-black transition">Login</a>
            <a href="/register" class="px-5 py-2 rounded-lg bg-yellow-400 text-black font-semibold hover:bg-yellow-300 transition">Daftar</a>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="bg-black text-white py-24 px-8 text-center">
        <h1 class="text-5xl font-black mb-4 leading-tight">
            Kelola Apartemen <span class="text-yellow-400">Lebih Mudah</span>
        </h1>
        <p class="text-gray-400 text-lg max-w-xl mx-auto mb-10">
            Platform manajemen apartemen modern — dari tagihan, unit, hingga pengaduan, semua dalam satu tempat.
        </p>
        <div class="flex justify-center gap-4">
            <a href="/register" class="px-8 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 transition text-lg">Mulai Sekarang</a>
            <a href="/login" class="px-8 py-3 border border-white text-white font-bold rounded-xl hover:bg-white hover:text-black transition text-lg">Login</a>
        </div>
    </section>

    {{-- FITUR --}}
    <section class="py-20 px-8 bg-white">
        <h2 class="text-3xl font-black text-center mb-12">Fitur Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-black text-white rounded-2xl p-8 text-center hover:scale-105 transition">
                <div class="text-yellow-400 text-4xl mb-4">🏢</div>
                <h3 class="text-xl font-bold mb-2">Manajemen Unit</h3>
                <p class="text-gray-400 text-sm">Kelola semua unit dan lantai apartemen dengan mudah dan terstruktur.</p>
            </div>
            <div class="bg-yellow-400 text-black rounded-2xl p-8 text-center hover:scale-105 transition">
                <div class="text-black text-4xl mb-4">💳</div>
                <h3 class="text-xl font-bold mb-2">Tagihan Otomatis</h3>
                <p class="text-gray-800 text-sm">Generate tagihan bulanan otomatis: sewa, listrik, air, dan kebersihan.</p>
            </div>
            <div class="bg-black text-white rounded-2xl p-8 text-center hover:scale-105 transition">
                <div class="text-yellow-400 text-4xl mb-4">🔧</div>
                <h3 class="text-xl font-bold mb-2">Pengaduan Online</h3>
                <p class="text-gray-400 text-sm">Penghuni bisa lapor kerusakan dan pantau status penanganannya langsung.</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-yellow-400 py-16 px-8 text-center">
        <h2 class="text-3xl font-black text-black mb-4">Siap Bergabung?</h2>
        <p class="text-gray-800 mb-8">Daftarkan diri kamu sekarang dan nikmati kemudahan manajemen apartemen.</p>
        <a href="/register" class="px-10 py-3 bg-black text-yellow-400 font-bold rounded-xl hover:bg-gray-900 transition text-lg">Daftar Gratis</a>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-black text-gray-500 text-center py-6 text-sm">
        &copy; {{ date('Y') }} ApartIn. All rights reserved.
    </footer>

</body>
</html>
