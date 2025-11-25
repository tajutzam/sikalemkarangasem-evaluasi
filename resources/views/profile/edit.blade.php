@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Profile</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Update informasi profile Anda
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Email (Read Only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email"
                               id="email"
                               value="{{ $user->email }}"
                               disabled
                               class="input-custom-disabled">
                        <p class="mt-1 text-xs text-gray-500">
                            Email tidak dapat diubah
                        </p>
                    </div>

                    <!-- Role (Read Only) -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role
                        </label>
                        <input type="text"
                               id="role"
                               value="{{ $user->is_admin ? 'Admin' : 'User' }}"
                               disabled
                               class="input-custom-disabled">
                        <p class="mt-1 text-xs text-gray-500">
                            Role tidak dapat diubah
                        </p>
                    </div>

                    <!-- Instansi (Read Only for non-admin) -->
                    @if(!$user->is_admin && $user->instansi)
                        <div>
                            <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">
                                Instansi
                            </label>
                            <input type="text"
                                   id="instansi"
                                   value="{{ $user->instansi->nama_instansi }}"
                                   disabled
                                   class="w-full select-custom">
                            <p class="mt-1 text-xs text-gray-500">
                                Instansi tidak dapat diubah
                            </p>
                        </div>
                    @endif

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="input-custom"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                            <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="input-custom"
                               placeholder="Minimal 8 karakter">
                        <p class="mt-1 text-xs text-gray-500">
                            Password minimal 8 karakter
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="input-custom"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
