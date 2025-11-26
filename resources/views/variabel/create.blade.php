@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white p-8 shadow-lg rounded-xl border border-gray-200">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Variabel</h2>

            <form action="{{ route('variabel.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Kode Variabel --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Kode Variabel
                    </label>
                    <input type="text" name="kode_variabel"
                        class="w-full px-2 py-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        value="{{ old('kode_variabel') }}">
                    @error('kode_variabel')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Variabel --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Variabel
                    </label>
                    <input type="text" name="nama_variabel"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        value="{{ old('nama_variabel') }}">
                    @error('nama_variabel')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Urutan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Urutan
                    </label>
                    <input type="number" name="urutan"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        value="{{ old('urutan') }}">
                    @error('urutan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end pt-4">
                    <a href="{{ route('variabel.index') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition mr-3">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection