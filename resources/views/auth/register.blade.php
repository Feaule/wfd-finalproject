<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ApartIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-black min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">

        {{-- LOGO --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <span class="text-yellow-400 text-4xl font-black">Apart</span>
                <span class="text-white text-4xl font-black">In</span>
            </a>
            <p class="text-gray-400 mt-2 text-sm">Buat akun penghuni baru</p>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Daftar Akun</h2>
            <p class="text-gray-500 text-sm mb-6">Akun kamu akan diverifikasi admin sebelum bisa login.</p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                {{-- NAMA --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="Nama lengkap kamu"
                    >
                </div>

                {{-- EMAIL --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="email@contoh.com"
                    >
                </div>

                {{-- NO KTP --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor KTP</label>
                    <input
                        type="text"
                        name="no_ktp"
                        value="{{ old('no_ktp') }}"
                        required
                        maxlength="16"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="16 digit nomor KTP"
                    >
                </div>

                {{-- PASSWORD --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="Ulangi password"
                    >
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-3 rounded-xl transition text-sm">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Sudah punya akun?
                <a href="/login" class="text-yellow-500 font-semibold hover:underline">Login di sini</a>
            </p>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            <a href="/" class="hover:text-yellow-400 transition">← Kembali ke Beranda</a>
        </p>

    </div>
</body>
</html>
