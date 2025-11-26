@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white p-8 shadow rounded-xl border border-gray-200">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Tingkat</h2>

            <form action="{{ route('tingkat.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="font-semibold text-gray-700">Variabel</label>
                    <select name="variabel_id"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih Variabel --</option>
                        @foreach($variabel as $v)
                            <option value="{{ $v->id }}">{{ $v->nama_variabel }}</option>
                        @endforeach
                    </select>
                    @error('variabel_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Tingkat</label>
                    <input type="number" name="tingkat" min="1" max="5"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('tingkat') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi_indikator" rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
                    @error('deskripsi_indikator') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('tingkat.index') }}" class="px-4 py-2 border rounded-lg mr-3 hover:bg-gray-100">
                        Kembali
                    </a>
                    <button class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection