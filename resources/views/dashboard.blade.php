@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">
            Selamat datang, {{ Auth::user()->name }}!
            @if(Auth::user()->is_admin)
                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Admin</span>
            @endif
        </p>
    </div>

    @if(Auth::user()->is_admin)
        @include('dashboard.admin')
    @else
        @include('dashboard.user')
    @endif
</div>
@endsection
