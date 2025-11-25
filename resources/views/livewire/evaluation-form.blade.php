<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                {{ $evaluationId ? 'Edit' : 'Buat' }} Lembar Kerja Evaluasi
            </h2>

            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="instansi_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Instansi <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="instansi_id" id="instansi_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            {{ $status !== 'draft' ? 'disabled' : '' }}>
                        <option value="">Pilih Instansi</option>
                        @foreach($instansiList as $instansi)
                            <option value="{{ $instansi->id }}">{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </select>
                    @error('instansi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number" wire:model="tahun" id="tahun" min="2000" max="2100"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           {{ $status !== 'draft' ? 'disabled' : '' }}>
                    @error('tahun')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Evaluasi Form -->
            <div class="space-y-8">
                @foreach($variabels as $variabel)
                    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                        <!-- Variabel Header -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $variabel->kode_variabel }}. {{ $variabel->nama_variabel }}
                            </h3>
                        </div>

                        <!-- Tingkat Options -->
                        <div class="space-y-3 mb-4">
                            @foreach($variabel->tingkat as $tingkat)
                                <label class="flex items-start p-4 border rounded-lg cursor-pointer transition-all
                                       {{ isset($details[$variabel->id]['tingkat_id']) && $details[$variabel->id]['tingkat_id'] == $tingkat->id
                                          ? 'bg-blue-50 border-blue-500'
                                          : 'bg-white border-gray-300 hover:bg-gray-50' }}"
                                       {{ $status !== 'draft' ? 'onclick="return false;"' : '' }}>
                                    <input type="radio"
                                           wire:model="details.{{ $variabel->id }}.tingkat_id"
                                           value="{{ $tingkat->id }}"
                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500"
                                           {{ $status !== 'draft' ? 'disabled' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <span class="font-medium text-gray-700">Tingkat {{ $tingkat->tingkat }}</span>
                                        <p class="mt-1 text-sm text-gray-600">{{ $tingkat->deskripsi_indikator }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Bukti Dokumen -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Dokumen
                            </label>
                            @if($status === 'draft')
                                <input type="file"
                                       wire:model="uploadedFiles.{{ $variabel->id }}"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @endif
                            @if(isset($details[$variabel->id]['bukti_dokumen']) && $details[$variabel->id]['bukti_dokumen'])
                                <p class="mt-2 text-sm text-gray-600">
                                    File: <a href="{{ asset('storage/' . $details[$variabel->id]['bukti_dokumen']) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 underline">
                                        Lihat Dokumen
                                    </a>
                                </p>
                            @endif
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan
                            </label>
                            <textarea wire:model="details.{{ $variabel->id }}.keterangan"
                                      rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Masukkan keterangan tambahan..."
                                      {{ $status !== 'draft' ? 'disabled' : '' }}></textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            @if($status === 'draft')
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button"
                            wire:click="saveDraft"
                            class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Simpan Draft
                    </button>
                    <button type="button"
                            wire:click="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Submit Evaluasi
                    </button>
                </div>
            @else
                <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                    <p class="text-sm text-yellow-800">
                        Status: <span class="font-semibold">{{ strtoupper($status) }}</span> -
                        Evaluasi tidak dapat diedit.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
