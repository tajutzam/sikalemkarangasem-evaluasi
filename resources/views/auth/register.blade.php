<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIKALEM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Akun</h2>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Daftar
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
