@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                {{ isset($instansi) ? 'Edit' : 'Tambah' }} Instansi
            </h2>

            <form action="{{ isset($instansi) ? route('instansi.update', $instansi) : route('instansi.store') }}"
                  method="POST">
                @csrf
                @if(isset($instansi))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Nama Instansi -->
                    <div>
                        <label for="nama_instansi" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Instansi <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_instansi"
                               id="nama_instansi"
                               value="{{ old('nama_instansi', $instansi->nama_instansi ?? '') }}"
                               class="input-custom @error('nama_instansi') border-red-500 @enderror"
                               placeholder="Masukkan nama instansi"
                               required>
                        @error('nama_instansi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea name="alamat"
                                  id="alamat"
                                  rows="3"
                                  class="textarea-custom @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $instansi->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon
                        </label>
                        <input type="text"
                               name="telepon"
                               id="telepon"
                               value="{{ old('telepon', $instansi->telepon ?? '') }}"
                               class="input-custom @error('telepon') border-red-500 @enderror"
                               placeholder="Contoh: (0361) 123456">
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('instansi.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        {{ isset($instansi) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
