<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - SIMADA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 flex h-screen font-sans overflow-hidden">

    <aside class="h-screen bg-[#1e306e] text-white flex flex-col justify-between overflow-y-auto"
           style="width: 256px !important; min-width: 256px !important; max-width: 256px !important; flex-shrink: 0 !important;">
        <div>
            <div class="p-6 border-b border-blue-800 text-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Dishub" class="w-20 h-20 mx-auto mb-3 object-contain">
                <h1 class="font-bold text-sm tracking-wide">SIMADA</h1>
                <p class="text-[9px] text-blue-300 uppercase tracking-widest mt-1">Data Management</p>
            </div>
<nav class="p-4 space-y-1">
    @foreach($menus->whereNull('parent_id') as $menu)
        @if($menu->submenus->count() > 0)
            <div x-data="{ open: false }" class="w-full group/main">
                <div class="w-full flex items-center justify-between px-3 py-2 text-blue-200 hover:bg-blue-900 rounded-lg text-sm transition group">
                    <button @click="open = !open" class="flex-1 flex items-center gap-3 truncate text-left focus:outline-none">
                        <div class="w-3.5 h-3.5 text-blue-400 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-90' : ''">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-full h-full">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="truncate font-medium group-hover:text-white">{{ $menu->nama_menu }}</span>
                    </button>

                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu utama ini beserta seluruh sub-menu di dalamnya?')" class="opacity-0 group-hover:opacity-100 transition-opacity duration-150 flex-shrink-0 ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-500 p-1 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div x-show="open" x-transition class="pl-8 mt-1 space-y-1">
                    @foreach($menu->submenus as $submenu)
                        <div class="w-full flex items-center justify-between px-3 py-1.5 rounded-lg text-xs hover:bg-blue-900/50 group/sub transition">
                            <a href="{{ route('dynamic-table.show', $submenu->id) }}" class="flex-1 flex items-center gap-2 text-blue-300 hover:text-white truncate">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 flex-shrink-0"></span>
                                <span class="block flex-1 truncate">{{ $submenu->nama_menu }}</span>
                            </a>

                            <form action="{{ route('menu.destroy', $submenu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sub-menu ini?')" class="opacity-0 group-hover/sub:opacity-100 transition-opacity duration-150 flex-shrink-0 ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 p-0.5 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-blue-900 group transition text-sm {{ request()->is(ltrim($menu->url, '/')) ? 'bg-blue-900 text-white' : 'text-blue-200' }}">
                <a href="{{ url($menu->url) }}" class="flex-1 flex items-center gap-3 truncate">
                    <div class="w-3.5 h-3.5 flex-shrink-0"></div>
                    <span class="truncate font-medium group-hover:text-white">{{ $menu->nama_menu }}</span>
                </a>

                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')" class="opacity-0 group-hover:opacity-100 transition-opacity duration-150 flex-shrink-0 ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-500 p-1 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
        @endif
    @endforeach

    @if(Auth::check() && (Auth::user()->role === 'superadmin' || Auth::user()->role === 'super'))
        <div class="mt-6 pt-4 border-t border-blue-800">
            <a href="{{ route('menu.index') }}" class="block w-full py-2 bg-red-800 text-white text-center rounded-lg text-[10px] font-bold hover:bg-red-700 transition tracking-wider uppercase">
                TAMBAH DATA
            </a>
        </div>
    @endif
</nav>
        </div>

        <div class="p-4 border-t border-blue-800 bg-[#1a2a60] flex-shrink-0">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white uppercase">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
                <div class="truncate flex-1 min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-blue-300 capitalize truncate">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 bg-red-900/30 text-red-500 rounded-lg text-xs font-bold hover:bg-red-800 hover:text-white transition">Keluar Sistem</button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
            <p class="text-xs text-gray-400">Overview • Selamat datang kembali, {{ Auth::user()->name }}.</p>
            <div class="flex items-center gap-6">
            </div>
        </header>

        <main class="p-8 overflow-y-auto flex-1">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
