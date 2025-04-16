@extends('admin.layouts.app')

@section('title', 'Create Supplier')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create Supplier</h1>

    <!-- Tampilkan pesan sukses -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{--  $table->string('nama');
            $table->string('nomor_whatsapp');
            $table->string('email')->nullable();
            $table->text('catatan')->nullable();
            $table->date('dari_tanggal');
            $table->boolean('status_aktif')->default(true);
            $table->string('jenis_barang'); --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <!-- Form tambah user -->
    <form action="{{ route('admin.store-supplier') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf <!-- Token keamanan -->
        
        <label class="block mb-2 font-semibold">Nama:</label>
        <input type="text" name="nama" class="w-full border p-2 rounded @error('nama') border-red-500 @enderror" value="{{ old('nama') }}">
        @error('nama')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        <label class="block mb-2 font-semibold">Jenis Barang:</label>
        <select name="jenis_barang_id" class="w-full border p-2 rounded @error('jenis_barang_id') border-red-500 @enderror">
            <option value="">-- Pilih Jenis Barang --</option>
            @foreach ($JenisBarangs as $jenis)
                <option value="{{ $jenis->id }}" {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->name }}
                </option>
            @endforeach
        </select>
        @error('jenis_barang_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Telp:</label>
        <input type="string" name="nomor_whatsapp" class="w-full border p-2 rounded @error('nomor_whatsapp') border-red-500 @enderror" value="{{ old('nomor_whatsapp') }}">
        @error('nomor_whatsapp')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
        
        <label class="block mt-4 mb-2 font-semibold">Gmail:</label>
        <input type="email" name="email" class="w-full border p-2 rounded @error('email') border-red-500 @enderror" value="{{ old('email') }}">
        @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Catatan:</label>
        <input type="text" name="catatan" class="w-full border p-2 rounded @error('catatan') border-red-500 @enderror" value="{{ old('catatan') }}">
        @error('catatan')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Date Start:</label>
        <input type="date" name="dari_tanggal" class="w-full border p-2 rounded @error('dari_tanggal') border-red-500 @enderror" value="{{ old('dari_tanggal') }}">
        @error('dari_tanggal')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 w-full">Submit</button>
    </form>
@endsection

