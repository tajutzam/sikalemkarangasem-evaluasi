@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Data Variabel</h2>

                    <a href="{{ route('variabel.create') }}" class="px-4 py-2 btn-primary">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Variabel
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="thead">
                            <tr>
                                <th class="th">No</th>
                                <th class="th">Kode Variabel</th>
                                <th class="th">Nama Variabel</th>
                                <th class="th">Urutan</th>
                                <th class="th-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($variabel as $v)
                                <tr class="hover:bg-gray-50">
                                    <td class="td">
                                        {{ ($variabel->currentPage() - 1) * $variabel->perPage() + $loop->iteration }}</td>
                                    <td class="td">{{ $v->kode_variabel }}</td>
                                    <td class="td">{{ $v->nama_variabel }}</td>
                                    <td class="td">{{ $v->urutan }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('variabel.edit', $v) }}"
                                                class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>

                                            <form action="{{ route('variabel.destroy', $v) }}" method="POST"
                                                onsubmit="return confirm('Hapus variabel ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">
                                        Belum ada data variabel.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($variabel->hasPages())
                    <div class="mt-6">
                        {{ $variabel->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection