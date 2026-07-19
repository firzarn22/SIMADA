@extends('layouts.app', ['title' => 'Dashboard Utama'])

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-[#1e306e] to-[#2d4a8c] text-white p-8 rounded-2xl mb-8 shadow-lg">
    <h2 class="text-2xl font-bold">Dashboard Eksekutif</h2>
    <p class="text-sm opacity-80 mt-1">Pantau kinerja pengelolaan data secara real-time.</p>
</div>

<!-- Menu Navigasi & Submenu -->
<h3 class="font-bold mb-4 flex items-center gap-2 text-sm text-gray-700 uppercase tracking-wider">
    ⚙️ Menu Navigasi & Submenu
</h3>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($menus as $menu)
        {{-- Kita tambah filter ini agar "Dashboard Utama" tidak muncul sebagai kotak --}}
        @if($menu->nama_menu !== 'Dashboard Utama')
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-xl text-blue-600">{!! $menu->icon ?? '📁' !!}</div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $menu->nama_menu }}</h2>
                </div>

                <ul class="space-y-2 border-t pt-3 flex-grow">
                    @foreach($menu->submenus as $submenu)
                        <li>
                           <a href="{{ url('/dashboard/view-data/' . $submenu->id) }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                                {{ $submenu->nama_menu }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
</div>
@endsection
