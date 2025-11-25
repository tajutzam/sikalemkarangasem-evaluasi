@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ isset($user) ? 'Edit User' : 'Tambah User Baru' }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ isset($user) ? 'Update informasi user' : 'Isi form di bawah untuk menambahkan user baru' }}
                </p>
            </div>

            <!-- Alert Messages -->
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
            <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}"
                  method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name ?? '') }}"
                               required
                               class="input-custom"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email ?? '') }}"
                               required
                               class="input-custom"
                               placeholder="contoh@email.com">
                    </div>


                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="email"
                               value="{{ old('username', $user->username ?? '') }}"
                               required
                               class="input-custom"
                               placeholder="contoh">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                            @if(!isset($user))
                                <span class="text-red-500">*</span>
                            @else
                                <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                            @endif
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               {{ isset($user) ? '' : 'required' }}
                               class="input-custom"
                               placeholder="Minimal 8 karakter">
                        <p class="mt-1 text-xs text-gray-500">
                            Password minimal 8 karakter
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                            @if(!isset($user))
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               {{ isset($user) ? '' : 'required' }}
                               class="input-custom"
                               placeholder="Ulangi password">
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="is_admin" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="is_admin"
                                id="is_admin"
                                required
                                onchange="toggleInstansiField()"
                                class="w-full select-custom">
                            <option value="0" {{ old('is_admin', $user->is_admin ?? 0) == 0 ? 'selected' : '' }}>
                                <i class="fas fa-user"></i> User
                            </option>
                            <option value="1" {{ old('is_admin', $user->is_admin ?? 0) == 1 ? 'selected' : '' }}>
                                <i class="fas fa-user-shield"></i> Admin
                            </option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Admin dapat mengelola semua data termasuk user. User hanya dapat mengelola lembar kerja.
                        </p>
                    </div>

                    <!-- Instansi (Only for non-admin users) -->
                    <div id="instansi-field">
                        <label for="instansi_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Instansi <span class="text-red-500" id="instansi-required">*</span>
                        </label>
                        <select name="instansi_id"
                                id="instansi_id"
                                class="w-full select-custom">
                            <option value="">Pilih Instansi</option>
                            @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}" {{ old('instansi_id', $user->instansi_id ?? '') == $instansi->id ? 'selected' : '' }}>
                                    {{ $instansi->nama_instansi }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            User akan di-mapping ke instansi ini dan hanya bisa membuat lembar kerja untuk instansi tersebut.
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('users.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save mr-2"></i> {{ isset($user) ? 'Update User' : 'Simpan User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleInstansiField() {
    const isAdmin = document.getElementById('is_admin').value === '1';
    const instansiField = document.getElementById('instansi-field');
    const instansiSelect = document.getElementById('instansi_id');
    const instansiRequired = document.getElementById('instansi-required');

    if (isAdmin) {
        instansiField.style.display = 'none';
        instansiSelect.removeAttribute('required');
        instansiRequired.style.display = 'none';
        instansiSelect.value = '';
    } else {
        instansiField.style.display = 'block';
        instansiSelect.setAttribute('required', 'required');
        instansiRequired.style.display = 'inline';
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleInstansiField();
});
</script>

@endsection
