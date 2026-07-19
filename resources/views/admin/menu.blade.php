@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Manajemen Menu & Struktur Data</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-600 rounded-lg text-xs font-semibold border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(in_array(Auth::user()->role, ['superadmin', 'operator']))
        <form action="{{ route('menu.store') }}" method="POST" class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="nama_menu" placeholder="Nama Menu (e.g. Lokasi Halte)" class="p-2 border rounded-lg text-sm bg-white focus:outline-none focus:border-blue-500" required>
                <input type="text" name="url" placeholder="URL (e.g. /lla/halte)" class="p-2 border rounded-lg text-sm bg-white focus:outline-none focus:border-blue-500" required>
                <select name="parent_id" class="p-2 border rounded-lg text-sm bg-white col-span-1 md:col-span-2 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Menu Induk (Kosongkan jika ingin jadi Menu Utama) --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_menu }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 text-sm transition shadow-sm">
                Simpan
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
