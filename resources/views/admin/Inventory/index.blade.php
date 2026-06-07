@extends('admin.layouts.app')

@section('title', 'Inventory List')

@section('content')

    <!-- Header Actions -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Inventaris</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar stok barang, harga pokok, harga jual, dan status kadaluarsa barang.</p>
        </div>
        <a href="{{ route('inventory_checkings.create') }}" class="w-full sm:w-auto px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl text-center shadow-md shadow-emerald-500/10 transition duration-150 active:scale-[0.98]">
            + Tambah Inventory
        </a>
    </div>

    <!-- Responsive Filter Form -->
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm mb-6">
        <form method="GET" action="{{ route('inventory_index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            
            <div class="space-y-1.5">
                <label for="supplier" class="block text-xs font-semibold text-slate-500 uppercase">Filter Supplier</label>
                <select name="supplier" id="supplier" class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                    <option value="">-- Semua Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="jenis" class="block text-xs font-semibold text-slate-500 uppercase">Filter Jenis Barang</label>
                <select name="jenis" id="jenis" class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenisBarang as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="filter" class="block text-xs font-semibold text-slate-500 uppercase">Kadaluarsa</label>
                <select name="filter" id="filter" class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                    <option value="">Semua</option>
                    <option value="exp-soon" {{ request('filter') == 'exp-soon' ? 'selected' : '' }}>Kurang dari 1 Bulan</option>
                </select>
            </div>

            <div class="flex gap-2 w-full">
                <button type="submit" class="flex-1 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition duration-150">
                    Filter Data
                </button>
                @if(request('supplier') || request('jenis') || request('filter'))
                    <a href="{{ route('inventory_index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl text-center transition duration-150">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Inventory Table Container -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 w-[5%]">No</th>
                        <th class="px-6 py-4 w-[20%]">Nama Barang</th>
                        <th class="px-6 py-4 w-[12%]">Tanggal Masuk</th>
                        <th class="px-6 py-4 w-[15%]">Supplier</th>
                        <th class="px-6 py-4 w-[13%]">Kadaluarsa</th>
                        <th class="px-6 py-4 w-[8%]">Jumlah</th>
                        <th class="px-6 py-4 w-[12%]">Harga Pokok / Jual</th>
                        <th class="px-6 py-4 w-[15%] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($data as $inventory)
                        @php
                            $isExpSoon = $inventory->expired_date ? \Carbon\Carbon::parse($inventory->expired_date)->lessThanOrEqualTo(now()->addMonth()) : false;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $inventory->nama }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">Kategori: {{ $inventory->jenisBarang->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($inventory->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-900 font-medium">
                                {{ $inventory->supplier->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($inventory->expired_date)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg border {{ $isExpSoon ? 'bg-rose-50 text-rose-600 border-rose-100 animate-pulse' : 'bg-slate-50 text-slate-600 border-slate-150' }}">
                                        {{ \Carbon\Carbon::parse($inventory->expired_date)->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Tanpa Exp</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $inventory->jumlah }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-400">Pokok: <span class="font-semibold text-slate-700">Rp{{ number_format($inventory->harga_pokok, 0, ',', '.') }}</span></div>
                                <div class="text-xs text-slate-400 mt-0.5">Jual: <span class="font-semibold text-emerald-600">Rp{{ number_format($inventory->harga_jual, 0, ',', '.') }}</span></div>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-1.5 items-center">
                                
                                <!-- Edit Button -->
                                <a href="{{ route('inventory.edit', $inventory->id) }}" 
                                   class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl transition duration-150"
                                   title="Edit Barang">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.062a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inventaris ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition duration-150" title="Hapus Barang">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>

                                <!-- Email Notifier Button -->
                                <form action="{{ route('email.inventory', $inventory->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl transition duration-150" title="Kirim Notifikasi Email">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection