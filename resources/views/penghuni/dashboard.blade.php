<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penghuni - ApartIn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-black text-white px-8 py-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-2">
            <span class="text-yellow-400 text-xl font-black">Apart</span>
            <span class="text-white text-xl font-black">In</span>
            <span class="ml-3 text-xs bg-white text-black font-bold px-2 py-0.5 rounded">PENGHUNI</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-400 text-sm">{{ auth()->user()->name }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="flex">
        {{-- SIDEBAR --}}
        <aside class="w-56 bg-black min-h-screen text-white pt-6 px-4">
            <ul class="space-y-1">
                <li>
                    <a href="/penghuni/dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-yellow-400 text-black font-semibold text-sm">
                        🏠 Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 text-sm transition">
                        🏢 Unit Saya
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 text-sm transition">
                        💳 Tagihan
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 text-sm transition">
                        🔧 Pengaduan
                    </a>
                </li>
            </ul>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-black text-gray-900 mb-1">Dashboard Penghuni</h1>
            <p class="text-gray-500 text-sm mb-8">Selamat datang, {{ auth()->user()->name }}!</p>

            {{-- INFO CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-black text-white rounded-2xl p-6">
                    <p class="text-gray-400 text-xs mb-1">Unit Kamu</p>
                    <p class="text-xl font-black text-yellow-400">Belum ada</p>
                    <p class="text-gray-500 text-xs mt-1">hubungi admin</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <p class="text-gray-500 text-xs mb-1">Tagihan Bulan Ini</p>
                    <p class="text-xl font-black text-gray-900">Rp 0</p>
                    <p class="text-gray-400 text-xs mt-1">belum ada tagihan</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <p class="text-gray-500 text-xs mb-1">Pengaduan Aktif</p>
                    <p class="text-xl font-black text-orange-500">0</p>
                    <p class="text-gray-400 text-xs mt-1">sedang diproses</p>
                </div>
            </div>

            {{-- STATUS AKUN --}}
            <div class="bg-yellow-50 border border-yellow-300 rounded-2xl p-6 mb-6">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">✅</span>
                    <div>
                        <p class="font-bold text-yellow-800">Akun Kamu Sudah Aktif</p>
                        <p class="text-yellow-700 text-sm mt-1">Kamu sudah bisa menggunakan semua fitur ApartIn. Fitur lengkap sedang dikembangkan oleh tim.</p>
                    </div>
                </div>
            </div>

            {{-- PLACEHOLDER --}}
            <div class="bg-white rounded-2xl p-8 border border-gray-200 text-center">
                <p class="text-4xl mb-3">🚧</p>
                <p class="text-gray-700 font-semibold">Fitur sedang dikembangkan</p>
                <p class="text-gray-400 text-sm mt-1">Halaman ini akan diisi oleh anggota tim lainnya.</p>
            </div>
        </main>
    </div>

</body>
</html>
