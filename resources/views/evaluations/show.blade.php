@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Detail Lembar Kerja</h2>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Instansi:</span> {{ $evaluation->instansi->nama_instansi }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Tahun:</span> {{ $evaluation->tahun }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Evaluator:</span> {{ $evaluation->user->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Tanggal:</span> {{ $evaluation->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($evaluation->isDraft())
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                Draft
                            </span>
                        @elseif($evaluation->isSubmitted())
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Submitted
                            </span>
                        @elseif($evaluation->isApproved())
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Approved
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @endif
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                Progress: <span class="font-semibold">{{ $evaluation->getCompletionPercentage() }}%</span>
                            </p>
                            <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-blue-600 h-2 rounded-full"
                                     style="width: {{ $evaluation->getCompletionPercentage() }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Evaluation Details -->
            <div class="space-y-8">
                @foreach($evaluation->details as $detail)
                    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                        <!-- Variabel Name -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            {{ $detail->variabel->kode_variabel }} - {{ $detail->variabel->nama_variabel }}
                        </h3>

                        <!-- Tingkat Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Tingkat Terpilih
                            </label>
                            @if($detail->tingkat_id)
                                <div class="p-4 border-2 border-blue-500 bg-blue-50 rounded-lg">
                                    <div class="font-medium text-gray-900">
                                        Tingkat {{ $detail->tingkat->tingkat }}
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        {{ $detail->tingkat->deskripsi_indikator }}
                                    </div>
                                </div>

                                <!-- Show all tingkat options (read-only) -->
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500 mb-2">Pilihan tingkat lainnya:</p>
                                    <div class="space-y-2">
                                        @foreach($detail->variabel->tingkat as $tingkat)
                                            @if($tingkat->id != $detail->tingkat_id)
                                                <div class="p-3 border border-gray-200 bg-white rounded-lg opacity-60">
                                                    <div class="text-sm font-medium text-gray-700">
                                                        Tingkat {{ $tingkat->tingkat }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $tingkat->deskripsi_indikator }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">Belum dipilih</p>
                            @endif
                        </div>

                        <!-- Bukti Dokumen -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Dokumen
                            </label>
                            @if($detail->bukti_dokumen)
                                <div class="p-3 bg-white border border-gray-200 rounded-md flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file-alt text-blue-500 text-2xl"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ basename($detail->bukti_dokumen) }}
                                            </p>
                                            <p class="text-xs text-gray-500">File bukti</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('evaluations.download-file', $detail->id) }}"
                                       class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">Tidak ada file</p>
                            @endif
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan
                            </label>
                            @if($detail->keterangan)
                                <div class="p-3 bg-white border border-gray-200 rounded-md">
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $detail->keterangan }}</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">Tidak ada keterangan</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('evaluations.index') }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if(Auth::user()->is_admin && $evaluation->isSubmitted())
                    <div class="space-x-4">
                        <form action="{{ route('evaluations.reject', $evaluation) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menolak lembar kerja ini?');"
                              class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-times-circle mr-2"></i> Reject
                            </button>
                        </form>

                        <form action="{{ route('evaluations.approve', $evaluation) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menyetujui lembar kerja ini?');"
                              class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-check-circle mr-2"></i> Approve
                            </button>
                        </form>
                    </div>
                @elseif($evaluation->canBeEdited())
                    <a href="{{ route('evaluations.edit', $evaluation) }}"
                       class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-edit mr-2"></i> Edit Lembar Kerja
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
