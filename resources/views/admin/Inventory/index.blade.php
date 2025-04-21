@extends('admin.layouts.app')

@section('title', 'Inventory List')

@section('content')


<form method="GET" action="{{ route('inventory_index') }}" class="mb-4 flex gap-4 items-end">
    <div>
        <label for="supplier">Supplier</label>
        <select name="supplier" id="supplier" class="border rounded px-3 py-2">
            <option value="">-- Semua Supplier --</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="jenis">Jenis Barang</label>
        <select name="jenis" id="jenis" class="border rounded px-3 py-2">
            <option value="">-- Semua Jenis --</option>
            @foreach($jenisBarang as $jenis)
                <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="filter">Expiring</label>
        <select name="filter" id="filter" class="border rounded px-3 py-2">
            <option value="">Semua</option>
            <option value="exp-soon" {{ request('filter') == 'exp-soon' ? 'selected' : '' }}>Kurang dari 1 Bulan</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
</form>
<table class="table-fixed border border-gray-300 w-full">
    <thead>
        <tr class="bg-blue-500 text-white">
            <th class="border border-gray-400 px-4 w-[4%] py-2">No</th>
            <th class="border border-gray-400 px-4 w-[25%] py-2">Nama</th>
            <th class="border border-gray-400 px-4 w-[10%] py-2">Tanggal</th>
            <th class="border border-gray-400 px-4 w-[11%] py-2">Supplier</th>
            <th class="border border-gray-400 px-4 w-[10%] py-2">exp</th>
            <th class="border border-gray-400 px-4 w-[33%] py-2">Status</th>
            <th class="border border-gray-400 px-4 w-[16%] py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $inventory)
        @php
            $isExpSoon = \Carbon\Carbon::parse($inventory->expired_date)->lessThanOrEqualTo(now()->addMonth());
        @endphp
            <tr class="odd:bg-white even:bg-gray-100 text-sm"  data-status="{{ $inventory->status ? 'false' : 'true' }}" >
                <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $inventory->nama }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $inventory->tanggal}}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $inventory->supplier->nama }}</td>
                <td class="border border-gray-400 px-4 py-2 {{ $isExpSoon ? 'bg-red-500 text-white font-bold' : '' }}">
                    {{ $inventory->expired_date }}
                </td>
                <td class="border border-gray-400 px-4 py-2">{{ $inventory->keterangan }}</td>
                <td class="border border-gray-400 px-4 py-2 ">
                    <div class="flex justify-end items-center">

                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="me-1 bg-blue-500 text-white rounded-sm p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 3l3 3L7.5 18H4.5V15L16.5 3z"/>
                            </svg>
                        </a> 
                        
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="p-1 text-white rounded-sm me-1 bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                        <form action="/kirim/email/{{ $inventory->id }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white rounded-sm bg-green-500 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="  w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12L21.75 3l-9.75 9.75 9.75 9.75-19.5-9.75z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>{{-- <td class="border border-gray-400 px-4 py-2 ">
                    <div class="flex justify-end items-center">
                        <input type="checkbox" 
                        onchange="toggleStatus({{ $inventory->id }})"
                        class="w-5 h-5 cursor-pointer me-2"
                        {{ $inventory->status ? 'checked' : '' }}>

                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="me-1 bg-blue-500 text-white rounded-sm p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 3l3 3L7.5 18H4.5V15L16.5 3z"/>
                            </svg>
                        </a>
                        
                        
                        
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus inventory ini?')" class="p-1 text-white rounded-sm me-1 bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                        <form action="/kirim/email/{{ $inventory->id }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white rounded-sm bg-green-500 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="  w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12L21.75 3l-9.75 9.75 9.75 9.75-19.5-9.75z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
<div class="flex justify-end">

    <a href="{{route('inventory_checkings.create')}}">
        <button class="bg-blue-600 rounded-md text-white px-4 py-2 mt-4 hover:bg-blue-700 justify-self-end">
            Buat Inventory
        </button>
    </a>
               
</div>






@endsection