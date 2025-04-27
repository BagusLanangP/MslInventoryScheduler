@extends('admin.layouts.app')

@section('title', 'Supplier List')

@section('content')
{{-- $table->id();
$table->string('nama');
$table->string('nomor_whatsapp');
$table->string('email')->nullable();
$table->text('catatan')->nullable();
$table->date('dari_tanggal');
$table->boolean('status_aktif')->default(true);
$table->unsignedBigInteger('jenis_barang_id');
$table->foreign('jenis_barang_id')->references('id')->on('jenis_barangs')->onDelete('cascade');
$table->timestamps(); --}}

<form method="GET" action="{{ route('supplier_index') }}" class="mb-4 flex gap-4 items-end">

    <div>
        <label for="jenis">Jenis Barang</label>
        <select name="jenis" id="jenis" class="border rounded px-3 py-2">
            <option value="">-- Semua Jenis --</option>
            @foreach($JenisBarangs as $jenis)
                <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->name }}
                </option>
            @endforeach
        </select>
    </div>


    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
</form>
<table class="table-fixed border border-gray-300 w-full">
    <thead>
        <tr class="bg-blue-500 text-white">
            <th class="border border-gray-400 px-4 w-[4%] py-2">No</th>
            <th class="border border-gray-400 px-4 w-[25%] py-2">Nama</th>
            <th class="border border-gray-400 px-4 w-[10%] py-2">Jenis Barang</th>
            <th class="border border-gray-400 px-4 w-[17%] py-2">Dari Tanggal</th>
            <th class="border border-gray-400 px-4 w-[31%] py-2">Catatan</th>
            <th class="border border-gray-400 px-4 w-[21%] py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $s)
        {{-- @php
            $isExpSoon = \Carbon\Carbon::parse($s->expired_date)->lessThanOrEqualTo(now()->addMonth());
        @endphp --}}
            <tr class="odd:bg-white even:bg-gray-100 text-sm"  data-status="{{ $s->status ? 'false' : 'true' }}"  class="{{ $s->status == false ? 'bg-gray-100 text-gray-500 opacity-70' : '' }}" >
                <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $s->nama }}</td>
                <td class="border border-gray-400 px-4 py-2">
                    {{ $s->jenisBarang->name ?? 'Tidak Ada Jenis' }}
                </td>
                <td class="border border-gray-400 px-4 py-2">{{ $s->dari_tanggal}}</td>
                <td class="border border-gray-400 px-4 py-2">{{ $s->catatan }}</td>
                <td class="border border-gray-400 px-4 py-2 ">
                    <div class="flex justify-end items-center">
                        <a href="{{ route('supplier.show', $s->id) }}" 
                            class="bg-green-500 me-1 bg-blue-500 text-white rounded-sm p-1 hover:bg-green-600"
                            title="Lihat Detail Inventory">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 fill="none" 
                                 viewBox="0 0 24 24" 
                                 stroke-width="1.5" 
                                 stroke="currentColor" 
                                 class="w-7 h-7">
                                 <path stroke-linecap="round" stroke-linejoin="round" 
                                       d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" 
                                       d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                         </a>

                        <a href="{{ route('supplier.edit', $s->id) }}" class="me-1 bg-blue-500 text-white rounded-sm p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 3l3 3L7.5 18H4.5V15L16.5 3z"/>
                            </svg>
                        </a> 
                        <form action="{{ route('supplier.toggleStatus', $s->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="me-1 bg-red-500 text-white rounded-sm p-1 hover:bg-red-600" title="{{ $s->status ? 'Nonaktifkan' : 'Aktifkan' }}">
                                @if ($s->status)
                                    {{-- Icon Speaker with X (mute) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12.75l-4.5-4.5M15 12.75l4.5-4.5M6.75 8.25H4.5v7.5h2.25L12 21V3L6.75 8.25z" />
                                    </svg>
                                @else
                                    {{-- Icon Speaker (active) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 5.25v13.5m0 0L6 14.25H3.75v-4.5H6l5.25-4.5zM15.75 9a3.75 3.75 0 010 6" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 7.5a6.75 6.75 0 010 9" />
                                    </svg>
                                @endif
                            </button>
                        </form>
                        
                        <form action="{{ route('supplier.destroy', $s->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="p-1 text-white rounded-sm me-1 bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td> 
            </tr>
        @endforeach
    </tbody>
</table>
<div class="flex justify-end">

    <a href="{{route('admin.create-supplier')}}">
        <button class="bg-blue-600 rounded-md text-white px-4 py-2 mt-4 hover:bg-blue-700 justify-self-end">
            Buat Supplier
        </button>
    </a>
               
</div>






@endsection