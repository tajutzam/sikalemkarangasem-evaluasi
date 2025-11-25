@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Lembar Kerja Baru</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluations.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Instansi -->
                    <div>
                        <label for="instansi_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Instansi <span class="text-red-500">*</span>
                        </label>
                        <select name="instansi_id"
                                id="instansi_id"
                                class="w-full select-custom @error('instansi_id') border-red-500 @enderror"
                                {{ isset($userInstansiId) && $userInstansiId ? 'disabled' : '' }}
                                required>
                            <option value="">Pilih Instansi</option>
                            @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}"
                                    {{ (old('instansi_id', $userInstansiId ?? null) == $instansi->id) ? 'selected' : '' }}>
                                    {{ $instansi->nama_instansi }}
                                </option>
                            @endforeach
                        </select>
                        @if(isset($userInstansiId) && $userInstansiId)
                            <!-- Hidden field to submit the value when select is disabled -->
                            <input type="hidden" name="instansi_id" value="{{ $userInstansiId }}">
                            <p class="mt-1 text-xs text-blue-600">
                                <i class="fas fa-info-circle mr-1"></i> Anda hanya dapat membuat lembar kerja untuk instansi yang sudah di-mapping ke akun Anda.
                            </p>
                        @endif
                        @error('instansi_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="tahun"
                               id="tahun"
                               value="{{ old('tahun', $currentYear) }}"
                               min="2000"
                               max="{{ $currentYear + 1 }}"
                               class="input-custom @error('tahun') border-red-500 @enderror"
                               required>
                        @error('tahun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Tahun lembar kerja yang akan dilakukan
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex">
                            <div class="shrink-0">
                                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Setelah lembar kerja dibuat, Anda akan diarahkan ke halaman pengisian detail lembar kerja untuk setiap variabel.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('evaluations.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Buat Lembar Kerja
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
