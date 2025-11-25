@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Data Instansi</h2>
                <a href="{{ route('instansi.create') }}"
                   class="px-6 py-2 btn-primary">
                   <i class="fa fa-plus-circle"></i> Tambah Instansi
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

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="thead">
                        <tr>
                            <th class="th">
                                No
                            </th>
                            <th class="th">
                                Nama Instansi
                            </th>
                            <th class="th">
                                Alamat
                            </th>
                            <th class="th">
                                Telepon
                            </th>
                            <th class="th-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($instansi as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ($instansi->currentPage() - 1) * $instansi->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->nama_instansi }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $item->alamat ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->telepon ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('instansi.edit', $item) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                           <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('instansi.destroy', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus instansi ini?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data instansi. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($instansi->hasPages())
                <div class="mt-6">
                    {{ $instansi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
