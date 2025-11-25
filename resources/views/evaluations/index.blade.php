@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Data Lembar Kerja</h2>
                <a href="{{ route('evaluations.create') }}"
                   class="px-4 py-2 btn-primary">
                   <i class="fa fa-plus-circle"></i> Tambah Lembar Kerja
                </a>
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

            <!-- Filters -->
            <div class="mb-6">
                <form method="GET" action="{{ route('evaluations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari instansi..."
                               class="input-custom">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status" class="w-full select-custom">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Year Filter -->
                    <div>
                        <select name="tahun" class="w-full select-custom">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-2">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('evaluations.index') }}"
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="thead">
                        <tr>
                            <th class="th">
                                No
                            </th>
                            <th class="th">
                                Instansi
                            </th>
                            <th class="th">
                                Tahun
                            </th>
                            <th class="th">
                                Evaluator
                            </th>
                            <th class="th">
                                Progress
                            </th>
                            <th class="th">
                                Status
                            </th>
                            <th class="th-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ($evaluations->currentPage() - 1) * $evaluations->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $evaluation->instansi->nama_instansi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $evaluation->tahun }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $evaluation->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full"
                                                 style="width: {{ $evaluation->getCompletionPercentage() }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $evaluation->getCompletionPercentage() }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($evaluation->isDraft())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Draft
                                        </span>
                                    @elseif($evaluation->isSubmitted())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Submitted
                                        </span>
                                    @elseif($evaluation->isApproved())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <!-- Tombol Lihat Detail -->
                                        <a href="{{ route('evaluations.show', $evaluation) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>

                                        @if($evaluation->canBeEdited())
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('evaluations.edit', $evaluation) }}"
                                               class="text-green-600 hover:text-green-900 transition-colors">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>

                                            <!-- Tombol Submit -->
                                            <form action="{{ route('evaluations.submit', $evaluation) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin submit lembar kerja ini?');"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="text-purple-600 hover:text-purple-900 transition-colors">
                                                    <i class="fas fa-paper-plane mr-1"></i> Submit
                                                </button>
                                            </form>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('evaluations.destroy', $evaluation) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus lembar kerja ini?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data lembar kerja. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($evaluations->hasPages())
                <div class="mt-6">
                    {{ $evaluations->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
