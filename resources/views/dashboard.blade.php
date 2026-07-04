@extends('layouts.app', ['title' => 'Dashboard Utama'])

@section('content')
<div class="bg-gradient-to-r from-[#1e306e] to-[#2d4a8c] text-white p-8 rounded-2xl mb-8 shadow-lg">
    <h2 class="text-2xl font-bold">Dashboard Eksekutif</h2>
    <p class="text-sm opacity-80 mt-1">Pantau kinerja pengelolaan data secara real-time.</p>
</div>

<h3 class="font-bold mb-4 flex items-center gap-2 text-sm text-gray-700 uppercase tracking-wider">
    📄 Volume Data
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($stats as $stat)
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        </div>
        <p class="text-3xl font-black text-gray-800">{{ $stat->jumlah }}</p>
        <p class="text-xs text-gray-500 font-medium uppercase mt-1">{{ $stat->label }}</p>
    </div>
    @endforeach
</div>
@endsection
