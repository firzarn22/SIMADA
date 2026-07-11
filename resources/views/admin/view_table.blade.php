@extends('layouts.app')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>
<div class="max-w-6xl mx-auto" x-data="{
    search: '',
    isEdit: false,
    isChartVisible: false,
    selectedName: '',
    chartInstance: null,
    kolom: {{ $tableData ? $tableData->jumlah_kolom : 3 }},
    baris: {{ $tableData ? $tableData->jumlah_baris : 2 }},
    headers: {{ Illuminate\Support\Js::from($tableData ? $tableData->headers : []) }},
    rows: {{ Illuminate\Support\Js::from($tableData ? $tableData->rows : []) }},

    init() {
        if(this.headers.length === 0) {
            this.headers = Array(parseInt(this.kolom)).fill('');
        }
        if(this.rows.length === 0) {
            this.rows = Array(parseInt(this.baris)).fill(0).map(() => Array(parseInt(this.kolom)).fill(''));
        }
    },

    updateGrid() {
        let k = parseInt(this.kolom) || 1;
        let b = parseInt(this.baris) || 1;

        if (this.headers.length < k) {
            this.headers.push(...Array(k - this.headers.length).fill(''));
        } else if (this.headers.length > k) {
            this.headers = this.headers.slice(0, k);
        }

        this.rows = this.rows.map(row => {
            if (row.length < k) {
                return [...row, ...Array(k - row.length).fill('')];
            } else {
                return row.slice(0, k);
            }
        });

        if (this.rows.length < b) {
            while(this.rows.length < b) {
                this.rows.push(Array(k).fill(''));
            }
        } else if (this.rows.length > b) {
            this.rows = this.rows.slice(0, b);
        }
    },

    showChartFor(name, value) {
        this.isChartVisible = true;
        this.selectedName = name;
        this.$nextTick(() => {
            const ctx = document.getElementById('detailChart').getContext('2d');
            if (this.chartInstance) this.chartInstance.destroy();
            this.chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Nilai Data'],
                    datasets: [{
                        label: name,
                        data: [value],
                        backgroundColor: '#1e306e'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    },

    hapusBaris(index) {
        this.rows.splice(index, 1);
        this.baris = this.rows.length;
    },

    hapusKolom(index) {
        this.headers.splice(index, 1);
        this.rows = this.rows.map(row => {
            row.splice(index, 1);
            return row;
        });
        this.kolom = this.headers.length;
    }
}">

    @if(session('success_table'))
        <div class="mb-4 p-3 bg-green-50 text-green-600 rounded-lg text-xs font-semibold border border-green-200">
            {{ session('success_table') }}
        </div>
    @endif

    @if($tableData)
        <div x-show="!isEdit" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[10px] font-bold uppercase tracking-wider">Halaman: {{ $menu->nama_menu }}</span>
                    <h2 class="text-xl font-bold text-gray-800 mt-2">{{ $tableData->judul_tabel }}</h2>
                    <p class="text-xs text-gray-400 mt-1">{{ $tableData->deskripsi_tabel ?? 'Tidak ada deskripsi.' }}</p>
                </div>

            <div class="flex gap-3">
        <a href="{{ url('dashboard/export-tabel/' . $menu->id) }}"
        class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-semibold rounded-md transition-all duration-200 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export
        </a>

        <form action="{{ route('dynamic-table.import', $menu->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
            @csrf
            <input type="file" name="file" accept=".csv" class="hidden" id="importFile" onchange="this.form.submit()">
            <label for="importFile" class="cursor-pointer flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200 text-xs font-semibold rounded-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import CSV
            </label>
        </form>

        <button @click="isEdit = true"
                class="flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-700 hover:bg-slate-100 border border-slate-200 text-xs font-semibold rounded-md transition-all duration-200 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </button>

        <form action="{{ route('dynamic-table.destroy', $tableData->id) }}" method="POST" onsubmit="return confirm('Hapus tabel ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 text-xs font-semibold rounded-md transition-all duration-200 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus
            </button>
        </form>
    </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="mb-4">
                    <input type="text"
                        x-model="search"
                        placeholder="🔍 Cari data di tabel..."
                        class="w-full md:w-64 px-4 py-2 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 shadow-sm">
                </div>

    <div class="overflow-x-auto border border-gray-100 rounded-xl">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-[#1e306e] text-white">
                    @foreach($tableData->headers as $header)
                        <th class="px-4 py-3 font-semibold uppercase tracking-wider border border-blue-900">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-600">
                @foreach($tableData->rows as $rowIndex => $row)
                    <tr @click="showChartFor('{{ $row[0] }}', {{ is_numeric($row[1]) ? $row[1] : 0 }})"
                        x-show="`{{ implode(' ', $row) }}`.toLowerCase().includes(search.toLowerCase())"
                        class="{{ $rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-50/50' }} hover:bg-blue-50 cursor-pointer transition">

                        @foreach($row as $cell)
                            <td class="px-4 py-3 border border-gray-100 whitespace-nowrap">{{ $cell ?? '-' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div x-show="isChartVisible"
            x-cloak
            class="mt-8 p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-700">Analisis: <span x-text="selectedName" class="text-blue-600"></span></h3>
                <button @click="isChartVisible = false" class="text-slate-400 hover:text-slate-600 font-bold">✕ Tutup</button>
            </div>
            <div class="h-64">
                <canvas id="detailChart"></canvas>
            </div>
        </div>

        <div x-show="isEdit" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100" x-cloak>
            <div class="mb-6 flex justify-between items-center border-b pb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Mode Ubah Struktur & Data Tabel</h2>
                    <p class="text-xs text-gray-400">Silakan ubah data langsung di kotak input bawah.</p>
                </div>
               <button @click="isEdit = false"
                    class="flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 text-xs font-semibold rounded-md transition-all duration-200 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batalkan
            </button>
            </div>

            <form action="{{ route('dynamic-table.update', $tableData->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Judul Tabel</label>
                        <input type="text" name="judul_tabel" value="{{ $tableData->judul_tabel }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi / Catatan Tabel</label>
                        <input type="text" name="deskripsi_tabel" value="{{ $tableData->deskripsi_tabel }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none">
                    </div>
                </div>

                <div class="flex gap-4 bg-gray-50 p-3 rounded-lg border text-xs">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-600">Jumlah Kolom:</span>
                        <input type="number" name="jumlah_kolom" x-model="kolom" @input="updateGrid()" min="1" class="w-16 p-1 border rounded text-center bg-white">
                        <button type="button" @click="kolom++; updateGrid()" class="px-2 py-0.5 bg-blue-100 text-blue-700 font-bold rounded">+</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-600">Jumlah Baris Data:</span>
                        <input type="number" name="jumlah_baris" x-model="baris" @input="updateGrid()" min="1" class="w-16 p-1 border rounded text-center bg-white">
                        <button type="button" @click="baris++; updateGrid()" class="px-2 py-0.5 bg-blue-100 text-blue-700 font-bold rounded">+</button>
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl max-w-full mt-4">
                    <table class="w-full text-left border-collapse text-xs bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <template x-for="(header, hIndex) in headers" :key="'eh-'+hIndex">
                                    <th class="p-2 border border-gray-200 min-w-[150px]">
                                        <div class="flex flex-col gap-1">
                                            <input type="text" name="headers[]" x-model="headers[hIndex]" class="w-full p-1.5 border border-amber-300 rounded font-bold text-center bg-amber-50 focus:outline-none shadow-sm" required>
                                            <button type="button" @click="hapusKolom(hIndex)" class="text-[10px] text-red-500 hover:underline text-center font-normal">❌ Hapus Kolom</button>
                                        </div>
                                    </th>
                                </template>
                                <th class="w-12 bg-gray-100 border-b"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, rIndex) in rows" :key="'er-'+rIndex">
                                <tr class="hover:bg-gray-50/50">
                                    <template x-for="(cell, cIndex) in row" :key="'er-'+rIndex+'-ec-'+cIndex">
                                        <td class="p-2 border border-gray-200">
                                            <input type="text" :name="'rows['+rIndex+'][]'" x-model="rows[rIndex][cIndex]" class="w-full p-1.5 border border-gray-200 rounded focus:outline-none">
                                        </td>
                                    </template>
                                    <td class="p-2 border border-gray-200 text-center">
                                        <button type="button" @click="hapusBaris(rIndex)" class="text-slate-400 hover:text-red-600 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="text-right pt-2">
                    <button type="submit"
                        class="flex items-center justify-center gap-2 px-8 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-md transition-all duration-200 shadow-sm hover:shadow-md active:scale-95 border border-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Perubahan Tabel
                </button>
                </div>
            </form>
        </div>

    @else
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <div class="mb-6">
                <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded text-[10px] font-bold uppercase tracking-wider">Konfigurasi Baru</span>
                <h2 class="text-xl font-bold text-gray-800 mt-2">Buat Tabel untuk Halaman "{{ $menu->nama_menu }}"</h2>
                <p class="text-xs text-gray-400 mt-1">Halaman sub-menu ini belum memiliki tabel data. Tentukan jumlah baris & kolomnya.</p>
            </div>

            <form action="{{ route('dynamic-table.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Judul Tabel</label>
                        <input type="text" name="judul_tabel" placeholder="Contoh: Daftar Inventaris {{ $menu->nama_menu }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi / Catatan Tabel (Opsional)</label>
                        <input type="text" name="deskripsi_tabel" placeholder="Tulis catatan pendek..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-amber-50/40 p-4 rounded-xl border border-amber-100">
                    <div>
                        <label class="block text-xs font-semibold text-amber-900 mb-1">Jumlah Kolom</label>
                        <input type="number" name="jumlah_kolom" x-model="kolom" @input="updateGrid()" min="1" class="w-full bg-white border border-amber-200 rounded-lg px-3 py-2 text-xs focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-amber-900 mb-1">Jumlah Baris Isi</label>
                        <input type="number" name="jumlah_baris" x-model="baris" @input="updateGrid()" min="1" class="w-full bg-white border border-amber-200 rounded-lg px-3 py-2 text-xs focus:outline-none" required>
                    </div>
                </div>

                <div class="mt-6 border-t pt-4">
                    <div class="overflow-x-auto border border-gray-200 rounded-xl max-w-full">
                        <table class="w-full text-left border-collapse bg-white text-xs">
                            <thead class="bg-gray-100">
                                <tr>
                                    <template x-for="(header, hIndex) in headers" :key="'nh-'+hIndex">
                                        <th class="p-2 border border-gray-200 min-w-[140px]">
                                            <input type="text" name="headers[]" x-model="headers[hIndex]" placeholder="Nama Kolom" class="w-full p-1.5 border border-amber-300 rounded font-bold text-gray-700 bg-amber-50 text-center focus:outline-none shadow-sm" required>
                                        </th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(row, rIndex) in rows" :key="'nr-'+rIndex">
                                    <tr class="hover:bg-gray-50/50">
                                        <template x-for="(cell, cIndex) in row" :key="'nr-'+rIndex+'-nc-'+cIndex">
                                            <td class="p-2 border border-gray-200">
                                                <input type="text" :name="'rows['+rIndex+'][]'" x-model="rows[rIndex][cIndex]" placeholder="..." class="w-full p-1.5 border border-gray-200 rounded focus:outline-none">
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-right pt-4">
                 <button type="submit"
                            class="flex items-center justify-center gap-2 px-8 py-3 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-md transition-all duration-200 shadow-sm hover:shadow-md active:scale-95 border border-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan & Kunci Tabel
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
@endsection
