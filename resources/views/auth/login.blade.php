<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ApartIn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- LOGO --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <span class="text-yellow-400 text-4xl font-black">Apart</span>
                <span class="text-white text-4xl font-black">In</span>
            </a>
            <p class="text-gray-400 mt-2 text-sm">Selamat datang kembali!</p>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <h2 class="text-2xl font-black text-gray-900 mb-6">Login</h2>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-5">
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

                {{-- PASSWORD --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        placeholder="••••••••"
                    >
                </div>

                {{-- BUTTON --}}
                <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-3 rounded-xl transition text-sm">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun?
                <a href="/register" class="text-yellow-500 font-semibold hover:underline">Daftar di sini</a>
            </p>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            <a href="/" class="hover:text-yellow-400 transition">← Kembali ke Beranda</a>
        </p>

    </div>
</body>
</html>
