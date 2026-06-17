<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ApartIn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-black text-white px-8 py-4 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-2">
            <span class="text-yellow-400 text-xl font-black">Apart</span>
            <span class="text-white text-xl font-black">In</span>
            <span class="ml-3 text-xs bg-yellow-400 text-black font-bold px-2 py-0.5 rounded">ADMIN</span>
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
                    <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-yellow-400 text-black font-semibold text-sm">
                        🏠 Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 text-sm transition">
                        🏢 Lantai & Unit
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-400 hover:bg-gray-800 text-sm transition">
                        👥 Penghuni
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
            <h1 class="text-2xl font-black text-gray-900 mb-1">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mb-8">Selamat datang, {{ auth()->user()->name }}!</p>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-black text-white rounded-2xl p-6">
                    <p class="text-gray-400 text-xs mb-1">Total Unit</p>
                    <p class="text-3xl font-black text-yellow-400">0</p>
                    <p class="text-gray-500 text-xs mt-1">unit terdaftar</p>
                </div>
                <div class="bg-yellow-400 text-black rounded-2xl p-6">
                    <p class="text-gray-800 text-xs mb-1">Unit Terisi</p>
                    <p class="text-3xl font-black">0</p>
                    <p class="text-gray-700 text-xs mt-1">penghuni aktif</p>
                </div>
                <div class="bg-white text-gray-900 rounded-2xl p-6 border border-gray-200">
                    <p class="text-gray-500 text-xs mb-1">Tagihan Belum Lunas</p>
                    <p class="text-3xl font-black text-red-500">0</p>
                    <p class="text-gray-400 text-xs mt-1">perlu diverifikasi</p>
                </div>
                <div class="bg-white text-gray-900 rounded-2xl p-6 border border-gray-200">
                    <p class="text-gray-500 text-xs mb-1">Pengaduan Pending</p>
                    <p class="text-3xl font-black text-orange-500">0</p>
                    <p class="text-gray-400 text-xs mt-1">belum ditangani</p>
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
