<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIMADA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        .bg-simada-navy { background-color: #1e306e; }
        .text-simada-navy { color: #1e306e; }
        .bg-simada-orange { background-color: #f2a900; }
        .bg-simada-orange-hover { background-color: #d99700; }
    </style>
</head>
<body class="h-screen w-screen flex items-center justify-center font-sans antialiased relative bg-slate-900 overflow-hidden">

    <div class="absolute inset-0 z-0 w-full h-full">
        <img src="{{ asset('image/bg-dinas.png') }}" alt="Background Dishub" class="w-full h-full object-cover filter brightness-40 blur-[2px] scale-105">
    </div>

    <div class="relative z-10 w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden mx-4 flex flex-col bg-white">

        <div class="bg-simada-navy pt-8 pb-6 text-center flex flex-col items-center justify-center rounded-t-2xl">
            <div class="w-20 h-20 mb-3 flex items-center justify-center bg-white/10 rounded-full p-2.5 backdrop-blur-md shadow-lg border border-white/20">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Kemenhub" class="w-full h-full object-contain filter drop-shadow-[0_2px_8px_rgba(255,255,255,0.15)]">
            </div>

            <h2 class="text-2xl font-bold tracking-wider text-white">SIMADA</h2>
            <p class="text-[9px] text-slate-300 uppercase tracking-widest mt-0.5 px-4">Sistem Manajemen Data Perhubungan</p>
        </div>

        <div class="p-6 text-slate-700 w-full">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r-lg shadow-sm mb-4">
                    <p class="text-xs font-medium text-red-700">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-500 mb-1">Email Dinas</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input id="email" class="block w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-simada-navy focus:border-transparent transition-all" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@dinas.go.id" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-500 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <input id="password" class="block w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-simada-navy focus:border-transparent transition-all" type="password" name="password" required placeholder="••••••••••••" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-simada-orange hover:bg-simada-orange-hover text-simada-navy font-bold py-2.5 px-4 rounded-lg shadow-md uppercase tracking-wider text-xs transition-all active:scale-[0.99] cursor-pointer">
                        Masuk Dashboard
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center flex flex-col items-center justify-center border-t border-slate-100 pt-4">
                <div class="bg-slate-100 rounded-full px-3 py-1 flex items-center space-x-1.5 text-[9px] text-slate-500 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-slate-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>
                    <span>DEVELOPED BY</span>
                    <span class="font-bold text-slate-700">R.F • USK Developer Team</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-1.5">&copy; 2026 Dinas Perhubungan Kota Banda Aceh</p>
            </div>
        </div>

    </div>

</body>
</html>
