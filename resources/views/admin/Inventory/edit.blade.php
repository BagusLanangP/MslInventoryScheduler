@extends('admin.layouts.app')

@section('title', 'Edit Barang Inventaris')

@section('content')
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Edit Barang Inventaris</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui data stok, harga, dan tanggal kadaluarsa barang.</p>
        </div>
        <div>
            <a href="{{ route('inventory_index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-semibold rounded-xl transition duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke List</span>
            </a>
        </div>
    </div>

    <!-- Error Alerts -->
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <span class="font-bold">Gagal memperbarui barang:</span>
                    <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('inventory.update', $item->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Column (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-5">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3">Detail Barang</h3>

                    <!-- Nama Barang -->
                    <div class="space-y-1.5">
                        <label for="nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $item->nama) }}" required 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 @error('nama') border-rose-500 @enderror">
                    </div>

                    <!-- Row: Jenis Barang & Supplier -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="jenis_barang_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Barang</label>
                            <select name="jenis_barang_id" id="jenis_barang_id" required 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('jenis_barang_id') border-rose-500 @enderror">
                                @foreach ($jenisBarangs as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_barang_id', $item->jenis_barang_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label for="supplier_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Supplier</label>
                            <select name="supplier_id" id="supplier_id" required 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('supplier_id') border-rose-500 @enderror">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $item->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Row: Tanggal Masuk & Tanggal Expired -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="tanggal" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Masuk</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $item->tanggal) }}" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('tanggal') border-rose-500 @enderror">
                        </div>

                        <div class="space-y-1.5">
                            <label for="expired_date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Expired (Opsional)</label>
                            <input type="date" name="expired_date" id="expired_date" value="{{ old('expired_date', $item->expired_date) }}" 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('expired_date') border-rose-500 @enderror">
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="space-y-1.5">
                        <label for="keterangan" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan / Catatan</label>
                        <textarea name="keterangan" id="keterangan" rows="2" placeholder="Keterangan tambahan..." 
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring">{{ old('keterangan', $item->keterangan) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="space-y-6">
                <!-- Card: Keuangan & Stok -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-3">Stok & Harga</h3>

                    <!-- Jumlah -->
                    <div class="space-y-1.5">
                        <label for="jumlah" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Stok</label>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $item->jumlah) }}" required 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('jumlah') border-rose-500 @enderror">
                    </div>

                    <!-- Harga Pokok -->
                    <div class="space-y-1.5">
                        <label for="harga_pokok" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Pokok (Beli)</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-400 text-sm">Rp</span>
                            </div>
                            <input type="number" step="0.01" name="harga_pokok" id="harga_pokok" value="{{ old('harga_pokok', $item->harga_pokok) }}" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 pl-9 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('harga_pokok') border-rose-500 @enderror">
                        </div>
                    </div>

                    <!-- Harga Jual -->
                    <div class="space-y-1.5">
                        <label for="harga_jual" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Jual</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-400 text-sm">Rp</span>
                            </div>
                            <input type="number" step="0.01" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $item->harga_jual) }}" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 pl-9 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('harga_jual') border-rose-500 @enderror">
                        </div>
                    </div>

                    <!-- Total Harga -->
                    <div class="space-y-1.5">
                        <label for="total_harga" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Total Nilai Barang</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-400 text-sm">Rp</span>
                            </div>
                            <input type="number" step="0.01" name="total_harga" id="total_harga" value="{{ old('total_harga', $item->total_harga) }}" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 pl-9 pr-3 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('total_harga') border-rose-500 @enderror">
                        </div>
                        <button type="button" onclick="calculateTotalValue()" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 mt-1 block">
                            ⚡ Hitung Otomatis (Jumlah × Harga Pokok)
                        </button>
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5 pt-2">
                        <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Status Barang</label>
                        <select name="status" id="status" required 
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm outline-none transition focus:border-emerald-500 focus:ring @error('status') border-rose-500 @enderror">
                            <option value="belum_diproses" {{ old('status', $item->status) == 'belum_diproses' ? 'selected' : '' }}>Belum Diproses</option>
                            <option value="aktif" {{ old('status', $item->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="ditarik" {{ old('status', $item->status) == 'ditarik' ? 'selected' : '' }}>Ditarik (Out of Stock/Expired)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer Form Actions -->
        <div class="flex justify-end items-center gap-3 pt-5 border-t border-slate-100">
            <a href="{{ route('inventory_index') }}" 
               class="px-6 py-2.5 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-semibold rounded-xl transition duration-150">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-500/10 transition duration-150 active:scale-[0.98]">
                Perbarui Barang
            </button>
        </div>
    </form>

    <script>
        function calculateTotalValue() {
            const qty = parseInt(document.getElementById('jumlah').value) || 0;
            const costPrice = parseFloat(document.getElementById('harga_pokok').value) || 0;
            document.getElementById('total_harga').value = (qty * costPrice).toFixed(2);
        }
    </script>
@endsection
