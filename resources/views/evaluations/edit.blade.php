@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $evaluation->canBeEdited() ? 'Edit' : 'Detail' }} Lembar Kerja
                        </h2>
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

            @if(!$evaluation->canBeEdited())
                <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-md">
                    Lembar kerja ini tidak dapat diedit karena sudah disubmit.
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('evaluations.update', $evaluation) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    @foreach($evaluation->details as $detail)
                        <div class="border border-gray-200 rounded-lg p-6" x-data="{ selectedTingkat: {{ $detail->tingkat_id ?? 'null' }} }">
                            <!-- Variabel Name -->
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                {{ $detail->variabel->kode_variabel }} - {{ $detail->variabel->nama_variabel }}
                            </h3>

                            <!-- Tingkat Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Pilih Tingkat <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-3">
                                    @foreach($detail->variabel->tingkat as $tingkat)
                                        <div class="relative">
                                            <label class="flex items-start p-4 border rounded-lg cursor-pointer transition-colors"
                                                   :class="selectedTingkat === {{ $tingkat->id }} ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                                                <input type="radio"
                                                       name="details[{{ $detail->id }}][tingkat_id]"
                                                       value="{{ $tingkat->id }}"
                                                       {{ $detail->tingkat_id == $tingkat->id ? 'checked' : '' }}
                                                       @click="selectedTingkat = {{ $tingkat->id }}"
                                                       class="mt-1 focus:ring-blue-500 text-blue-600"
                                                       {{ $evaluation->canBeEdited() ? '' : 'disabled' }}>
                                                <div class="ml-3 flex-1">
                                                    <div class="font-medium text-gray-900">
                                                        Tingkat {{ $tingkat->tingkat }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 mt-1">
                                                        {{ $tingkat->deskripsi_indikator }}
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Bukti Dokumen -->
                            <div class="mb-4">
                                <label for="bukti_{{ $detail->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bukti Dokumen
                                </label>

                                @if($detail->bukti_dokumen)
                                    <div class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-md flex items-center justify-between" id="file-container-{{ $detail->id }}">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-file-alt text-blue-500 text-3xl"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ basename($detail->bukti_dokumen) }}
                                                </p>
                                                <p class="text-xs text-gray-500">File saat ini</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('evaluations.download-file', $detail->id) }}"
                                               class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                                Download
                                            </a>
                                            @if($evaluation->canBeEdited())
                                                <button type="button"
                                                        onclick="deleteFile({{ $detail->id }})"
                                                        class="px-3 py-1 text-sm text-red-600 hover:text-red-800 transition-colors">
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($evaluation->canBeEdited())
                                    <input type="file"
                                           name="details[{{ $detail->id }}][bukti_dokumen]"
                                           id="bukti_{{ $detail->id }}"
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                           class="file-custom">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max: 5MB)
                                        @if($detail->bukti_dokumen)
                                            <br>Upload file baru untuk mengganti file yang ada
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <label for="keterangan_{{ $detail->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan
                                </label>
                                <textarea name="details[{{ $detail->id }}][keterangan]"
                                          id="keterangan_{{ $detail->id }}"
                                          rows="3"
                                          placeholder="Tambahkan keterangan atau catatan tambahan..."
                                          class="textarea-custom"
                                          {{ $evaluation->canBeEdited() ? '' : 'disabled' }}>{{ old('details.' . $detail->id . '.keterangan', $detail->keterangan) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('evaluations.index') }}"
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        Kembali
                    </a>

                    @if($evaluation->canBeEdited())
                        <div class="space-x-4">
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteFile(detailId) {
    if (!confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        return;
    }

    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

    $.ajax({
        url: '/evaluation-details/' + detailId + '/delete-file',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Remove file container
                $('#file-container-' + detailId).fadeOut(300, function() {
                    $(this).remove();
                });

                // Show success message
                showMessage('success', response.message);
            } else {
                // Show error message
                showMessage('error', response.message);
                button.disabled = false;
                button.innerHTML = originalText;
            }
        },
        error: function(xhr) {
            let message = 'Terjadi kesalahan saat menghapus file!';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            showMessage('error', message);
            button.disabled = false;
            button.innerHTML = originalText;
        }
    });
}

function showMessage(type, message) {
    const alertClass = type === 'success'
        ? 'bg-green-100 border-green-400 text-green-700'
        : 'bg-red-100 border-red-400 text-red-700';

    const alertHtml = `
        <div class="mb-4 p-4 ${alertClass} border rounded-md alert-message">
            ${message}
        </div>
    `;

    // Insert after header
    $('.max-w-7xl').prepend(alertHtml);

    // Auto remove after 5 seconds
    setTimeout(function() {
        $('.alert-message').fadeOut(300, function() {
            $(this).remove();
        });
    }, 5000);
}
</script>

@endsection
