@extends('admin.layouts.app')

@section('title', 'Create Inventory')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create Inventory</h1>

    <!-- Tampilkan pesan sukses -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

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

    <!-- Form Inventory Checking -->
    <form action="{{ route('admin.store-inventory') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <label class="block mb-2 font-semibold">Nama Barang:</label>
        <input type="text" name="nama" class="w-full border p-2 rounded @error('nama') border-red-500 @enderror" value="{{ old('nama') }}">
        @error('nama')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Jenis Barang:</label>
        <select name="jenis_barang_id" class="w-full border p-2 rounded @error('jenis_barang_id') border-red-500 @enderror">
            <option value="">-- Pilih Jenis Barang --</option>
            @foreach ($jenisBarangs as $jenis)
                <option value="{{ $jenis->id }}" {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->name }}
                </option>
            @endforeach
        </select>
        @error('jenis_barang_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Supplier:</label>
        <select name="supplier_id" class="w-full border p-2 rounded @error('supplier_id') border-red-500 @enderror">
            <option value="">-- Pilih Supplier --</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->nama }}
                </option>
            @endforeach
        </select>
        @error('supplier_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Tanggal Masuk:</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded @error('tanggal') border-red-500 @enderror" value="{{ old('tanggal') }}">
        @error('tanggal')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Tanggal Expired (Opsional):</label>
        <input type="date" name="expired_date" class="w-full border p-2 rounded @error('expired_date') border-red-500 @enderror" value="{{ old('expired_date') }}">
        @error('expired_date')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Jumlah:</label>
        <input type="number" name="jumlah" class="w-full border p-2 rounded @error('jumlah') border-red-500 @enderror" value="{{ old('jumlah') }}">
        @error('jumlah')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Total Harga:</label>
        <input type="number" name="total_harga" class="w-full border p-2 rounded @error('total_harga') border-red-500 @enderror" value="{{ old('total_harga') }}">
        @error('total_harga')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Harga Pokok:</label>
        <input type="number" name="harga_pokok" class="w-full border p-2 rounded @error('harga_pokok') border-red-500 @enderror" value="{{ old('harga_pokok') }}">
        @error('harga_pokok')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Harga Jual:</label>
        <input type="number" name="harga_jual" class="w-full border p-2 rounded @error('harga_jual') border-red-500 @enderror" value="{{ old('harga_jual') }}">
        @error('harga_jual')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Keterangan (Opsional):</label>
        <input type="text" name="keterangan" class="w-full border p-2 rounded @error('keterangan') border-red-500 @enderror" value="{{ old('keterangan') }}">
        @error('keterangan')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 w-full">Simpan</button>
    </form>
@endsection
