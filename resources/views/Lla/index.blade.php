@extends('layouts.app', ['title' => 'Bidang LLA'])

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Bidang LLA</h2>
            <p class="text-sm text-gray-500">Manajemen data Lalu Lintas dan Angkutan.</p>
        </div>
        <button class="bg-[#1e306e] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-900 transition">
            + Tambah Data
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 text-xs uppercase border-b">
                    <th class="pb-4 font-medium">No</th>
                    <th class="pb-4 font-medium">Nama Data</th>
                    <th class="pb-4 font-medium">Keterangan</th>
                    <th class="pb-4 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($data as $index => $item)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-4">{{ $index + 1 }}</td>
                    <td class="py-4 font-medium">{{ $item->nama }}</td>
                    <td class="py-4 text-gray-500">{{ $item->keterangan }}</td>
                    <td class="py-4 text-center">
                        <button class="text-blue-600 hover:underline mr-2">Edit</button>
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
