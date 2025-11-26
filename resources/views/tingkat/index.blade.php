@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="bg-white p-8 shadow rounded-xl border border-gray-200">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Data Tingkat</h2>
                <a href="{{ route('tingkat.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Tambah Tingkat
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">No</th>
                        <th class="p-3 border">Variabel</th>
                        <th class="p-3 border">Tingkat</th>
                        <th class="p-3 border">Deskripsi</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tingkat as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ ($tingkat->currentPage() - 1) * $tingkat->perPage() + $loop->iteration }}
                            </td>
                            <td class="p-3 border">{{ $t->variabel->nama_variabel }}</td>
                            <td class="p-3 border">{{ $t->tingkat }}</td>
                            <td class="p-3 border">{{ Str::limit($t->deskripsi_indikator, 40) }}</td>

                            <td class="p-3 border text-center">
                                <div class="flex justify-center space-x-3">
                                    <a href="{{ route('tingkat.edit', $t) }}" class="text-green-600 hover:text-green-800">
                                        Edit
                                    </a>

                                    <form action="{{ route('tingkat.destroy', $t) }}" method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data tingkat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $tingkat->links() }}
            </div>

        </div>
    </div>
@endsection