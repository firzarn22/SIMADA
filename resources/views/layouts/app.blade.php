<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - SIMADA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 flex h-screen font-sans">

    <aside class="w-64 bg-[#1e306e] text-white flex flex-col justify-between">
    <div>
        <!-- INI BAGIAN LOGO -->
        <div class="p-6 border-b border-blue-800 text-center">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Dishub" class="w-20 h-20 mx-auto mb-3 object-contain">
            <h1 class="font-bold text-sm tracking-wide">SIMADA</h1>
            <p class="text-[9px] text-blue-300 uppercase tracking-widest mt-1">Data Management</p>
        </div>
        <!-- AKHIR BAGIAN LOGO -->

        <nav class="p-4 space-y-1">
            @foreach($menus->whereNull('parent_id') as $menu)
                @if($menu->submenus->count() > 0)
                    <!-- Menu dengan Sub-Menu (seperti LLA) -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 text-blue-200 hover:bg-blue-900 rounded-lg text-sm transition">
                            <span class="flex items-center gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> {{ $menu->nama_menu }}
                            </span>
                            <span x-text="open ? '▼' : '▶'" class="text-[10px]"></span>
                        </button>
                        <div x-show="open" class="pl-8 mt-1 space-y-1">
                            @foreach($menu->submenus as $submenu)
                                <a href="{{ url($submenu->url) }}" class="block px-3 py-2 text-blue-300 hover:text-white text-xs transition">
                                    {{ $submenu->nama_menu }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Menu Tunggal -->
                    <a href="{{ url($menu->url) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-900 transition text-sm {{ request()->is(ltrim($menu->url, '/')) ? 'bg-blue-900 text-white' : 'text-blue-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> {{ $menu->nama_menu }}
                    </a>
                @endif
            @endforeach

            <!-- Tombol Manajemen Menu (Hanya untuk Super Admin) -->
            @if(Auth::user()->role === 'superadmin')
                <div class="mt-8 pt-4 border-t border-blue-800">
                    <a href="{{ route('menu.index') }}" class="block w-full py-2 bg-red-800 text-white text-center rounded-lg text-[10px] font-bold hover:bg-red-700 transition">
                        PENGATURAN MENU
                    </a>
                </div>
            @endif
        </nav>
    </div>

    <!-- Bagian bawah sidebar -->
    <div class="p-4 border-t border-blue-800">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
            <div>
                <p class="text-xs font-bold">{{ Auth::user()->name }}</p>
                <p class="text-[9px] text-blue-300 capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2 bg-red-900/30 text-red-500 rounded-lg text-xs font-bold hover:bg-red-800 transition">Keluar Sistem</button>
        </form>
    </div>
</aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8">
            <p class="text-xs text-gray-400">Overview • Selamat datang kembali, {{ Auth::user()->name }}.</p>
            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-blue-600 transition relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <input type="text" placeholder="Cari data..." class="bg-gray-50 rounded-full px-4 py-2 text-xs w-48 border border-gray-200">
            </div>
        </header>

        <main class="p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
