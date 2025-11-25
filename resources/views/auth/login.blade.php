<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKALEM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-md p-8">

                <h1 class="text-center text-4xl font-bold text-primary">SIKALEM</h1>
                <p class="text-center text-xl text-gray-500 pb-5">Kabupaten Karangasem</p>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Username</label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            autofocus
                            placeholder="andrian"
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
                            placeholder="Masukan password"
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn-primary w-full py-2 px-4"
                    >
                        Login
                    </button>
                </form>

                {{-- <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Daftar</a>
                    </p>
                </div> --}}
            </div>
        </div>
    </div>
</body>
</html>
