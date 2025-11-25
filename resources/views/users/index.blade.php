@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Data User</h2>
                <a href="{{ route('users.create') }}"
                   class="px-4 py-2 btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah User
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
                                Nama
                            </th>
                            <th class="th">
                                Email
                            </th>
                            <th class="th">
                                Role
                            </th>
                            <th class="th">
                                Instansi
                            </th>
                            <th class="th">
                                Jumlah Lembar Kerja
                            </th>
                            <th class="th-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $user->name }}
                                    @if($user->id === Auth::id())
                                        <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Anda</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->is_admin)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-user-shield mr-1"></i> Admin
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <i class="fas fa-user mr-1"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @if($user->instansi)
                                        {{ $user->instansi->nama_instansi }}
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->evaluations()->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center space-x-3">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('users.edit', $user) }}"
                                           class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
