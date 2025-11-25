<!-- Status Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Draft</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ $myDraft }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Submitted</p>
                    <p class="text-2xl font-semibold text-yellow-600">{{ $mySubmitted }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Approved</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $myApproved }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rejected</p>
                    <p class="text-2xl font-semibold text-red-600">{{ $myRejected }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Draft Evaluations (In Progress) -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Lembar Kerja Dalam Proses</h3>
            @if($myDraft > 0)
                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">{{ $myDraft }} draft</span>
            @endif
        </div>
        <div class="p-6">
            @if($draftEvaluations->count() > 0)
                <div class="space-y-4">
                    @foreach($draftEvaluations as $evaluation)
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $evaluation->instansi->nama_instansi }}</p>
                                <p class="text-xs text-gray-600 mt-1">Tahun {{ $evaluation->tahun }}</p>
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $evaluation->getCompletionPercentage() }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $evaluation->getCompletionPercentage() }}% selesai</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('evaluations.edit', $evaluation) }}" class="ml-4 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                Lanjutkan
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada lembar kerja dalam proses</p>
                    <a href="{{ route('evaluations.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Buat Lembar Kerja Baru
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Evaluations -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Lembar Kerja Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentEvaluations->count() > 0)
                <div class="space-y-4">
                    @foreach($recentEvaluations as $evaluation)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $evaluation->instansi->nama_instansi }}</p>
                                <p class="text-xs text-gray-600">Tahun {{ $evaluation->tahun }}</p>
                                <div class="mt-1">
                                    @if($evaluation->isDraft())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                    @elseif($evaluation->isSubmitted())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Submitted</span>
                                    @elseif($evaluation->isApproved())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('evaluations.edit', $evaluation) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                {{ $evaluation->canBeEdited() ? 'Edit' : 'Lihat' }} →
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-8">Belum ada lembar kerja</p>
            @endif
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('evaluations.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Lihat semua lembar kerja →
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('evaluations.create') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
            <i class="fas fa-plus-circle text-blue-600 text-3xl mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Buat Lembar Kerja</p>
                <p class="text-xs text-gray-500">Mulai lembar kerja baru</p>
            </div>
        </a>

        <a href="{{ route('evaluations.index', ['status' => 'draft']) }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors">
            <i class="fas fa-edit text-yellow-600 text-3xl mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Draft Saya</p>
                <p class="text-xs text-gray-500">Lanjutkan lembar kerja</p>
            </div>
        </a>
    </div>
</div>
