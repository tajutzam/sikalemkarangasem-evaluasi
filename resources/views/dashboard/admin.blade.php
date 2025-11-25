<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Instansi -->
    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fas fa-building text-primary text-4xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-medium text-gray-500 truncate">Total Instansi</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $totalInstansi }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('instansi.index') }}" class="text-sm text-primary hover:text-blue-800">
                Lihat semua →
            </a>
        </div>
    </div>

    <!-- Total Variabel -->
    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fas fa-clipboard-list text-secondary text-4xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-medium text-gray-500 truncate">Total Variabel</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $totalVariabel }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <span class="text-sm text-gray-500">Variabel evaluasi</span>
        </div>
    </div>

    <!-- Total Evaluations -->
    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fas fa-check-circle text-sixth text-4xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-medium text-gray-500 truncate">Total Lembar Kerja</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $totalEvaluations }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <a href="{{ route('evaluations.index') }}" class="text-sm text-sixth hover:text-purple-800">
                Lihat semua →
            </a>
        </div>
    </div>

    <!-- This Year -->
    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fas fa-calendar-alt text-orange-600 text-4xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-medium text-gray-500 truncate">Tahun {{ date('Y') }}</dt>
                        <dd class="text-3xl font-bold text-gray-900">{{ $evaluationsThisYear }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <span class="text-sm text-gray-500">Lembar kerja tahun ini</span>
        </div>
    </div>
</div>

<!-- Status Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Draft</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ $draftCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Submitted</p>
                    <p class="text-2xl font-semibold text-yellow-600">{{ $submittedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Approved</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $approvedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="small-card">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rejected</p>
                    <p class="text-2xl font-semibold text-red-600">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Pending Approvals -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Menunggu Persetujuan</h3>
        </div>
        <div class="p-6">
            @if($pendingApprovals->count() > 0)
                <div class="space-y-4">
                    @foreach($pendingApprovals as $evaluation)
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $evaluation->instansi->nama_instansi }}</p>
                                <p class="text-xs text-gray-600">{{ $evaluation->user->name }} • Tahun {{ $evaluation->tahun }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $evaluation->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('evaluations.approve', $evaluation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('evaluations.reject', $evaluation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-8">Tidak ada lembar kerja yang menunggu persetujuan</p>
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
                                <p class="text-xs text-gray-600">{{ $evaluation->user->name }} • Tahun {{ $evaluation->tahun }}</p>
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
                                Lihat →
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('evaluations.create') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
            <i class="fas fa-plus-circle text-blue-600 text-3xl mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Tambah Lembar Kerja</p>
                <p class="text-xs text-gray-500">Buat lembar kerja baru</p>
            </div>
        </a>

        <a href="{{ route('instansi.create') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors">
            <i class="fas fa-building text-green-600 text-3xl mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Tambah Instansi</p>
                <p class="text-xs text-gray-500">Daftarkan instansi baru</p>
            </div>
        </a>

        <a href="{{ route('evaluations.index', ['status' => 'submitted']) }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors">
            <i class="fas fa-clipboard-check text-yellow-600 text-3xl mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Review Lembar Kerja</p>
                <p class="text-xs text-gray-500">Lihat lembar kerja pending</p>
            </div>
        </a>
    </div>
</div>
