@extends('admin.layouts.app')

@section('title', isset($supplier) ? 'Edit Supplier' : 'Buat Supplier')

@section('content')

    <!-- Header Actions -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">{{ isset($supplier) ? 'Edit Data Supplier' : 'Buat Supplier Baru' }}</h2>
        <p class="text-xs text-slate-500 mt-1">Lengkapi informasi profile supplier untuk menghubungkannya dengan stok barang inventaris.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Container Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm max-w-2xl">
        <form action="{{ isset($supplier) ? route('supplier.update', $supplier->id) : route('admin.store-supplier') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @if(isset($supplier))
                @method('PUT')
            @endif

            <!-- Form Row 1: Nama Supplier & Jenis Barang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Nama Perusahaan / Supplier</label>
                    <input type="text" name="nama" value="{{ old('nama', $supplier->nama ?? '') }}" required 
                        placeholder="e.g. PT. Makmur Sentosa"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('nama') border-rose-500 @enderror">
                    @error('nama')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Jenis Barang / Kategori</label>
                    <select name="jenis_barang_id" required class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('jenis_barang_id') border-rose-500 @enderror">
                        <option value="">-- Pilih Jenis Barang --</option>
                        @foreach ($JenisBarangs as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_barang_id', $supplier->jenis_barang_id ?? '') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_barang_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 2: PIC & Telp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Nama PIC / Kontak Person</label>
                    <input type="text" name="pic" value="{{ old('pic', $supplier->pic ?? '') }}" 
                        placeholder="e.g. Budi Santoso"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('pic') border-rose-500 @enderror">
                    @error('pic')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">No. Telp / WhatsApp</label>
                    <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp', $supplier->nomor_whatsapp ?? '') }}" required 
                        placeholder="e.g. 08123456789"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('nomor_whatsapp') border-rose-500 @enderror">
                    @error('nomor_whatsapp')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 3: Email & Date Start -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Alamat Email / Gmail</label>
                    <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" 
                        placeholder="e.g. supplier@gmail.com"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Tanggal Mulai Kerjasama</label>
                    <input type="date" name="dari_tanggal" value="{{ old('dari_tanggal', isset($supplier) && $supplier->dari_tanggal ? $supplier->dari_tanggal->format('Y-m-d') : '') }}" required 
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('dari_tanggal') border-rose-500 @enderror">
                    @error('dari_tanggal')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 4: Alamat Fisik -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-500 uppercase">Alamat Kantor / Gudang</label>
                <textarea name="alamat" rows="2" placeholder="e.g. Jl. Industri No. 12, Jakarta"
                    class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('alamat') border-rose-500 @enderror">{{ old('alamat', $supplier->alamat ?? '') }}</textarea>
                @error('alamat')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Row 5: Catatan Tambahan -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-500 uppercase">Catatan Tambahan</label>
                <input type="text" name="catatan" value="{{ old('catatan', $supplier->catatan ?? '') }}" 
                    placeholder="e.g. Pengiriman hari senin, diskon 10%"
                    class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('catatan') border-rose-500 @enderror">
                @error('catatan')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100 pt-4 flex justify-end gap-2">
                <a href="{{ route('supplier_index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition duration-150 text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition duration-150 shadow-md shadow-emerald-500/10">
                    {{ isset($supplier) ? 'Perbarui Supplier' : 'Simpan Supplier' }}
                </button>
            </div>

        </form>
    </div>

@endsection
