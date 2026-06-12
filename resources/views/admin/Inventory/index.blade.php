@extends('admin.layouts.app')

@section('title', 'Peringatan Inventaris (POS Synced)')

@section('content')
    <!-- Alerts / Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('warning'))
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('warning') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Description -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Pusat Peringatan Inventaris</h2>
                <p class="text-sm text-slate-500 mt-1">Data disinkronisasi secara otomatis dari sistem Kasir POS. Lakukan tindakan segera pada stok kritis atau produk kedaluwarsa.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="alert('Sinkronisasi data API sedang diproses... (Tahap Development)')" 
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-xl text-xs flex items-center gap-2 shadow-md shadow-emerald-500/10 transition active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.2" />
                    </svg>
                    <span>Sinkronisasi Data POS</span>
                </button>

                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200/60 rounded-xl px-4 py-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>POS Sinkronisasi Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABS NAVIGATION -->
    <div class="mb-6 border-b border-slate-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="inventoryTabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg transition-all duration-200 active-tab text-emerald-600 border-emerald-500 font-bold" 
                        id="low-stock-tab" onclick="switchTab('low-stock')" type="button" role="tab">
                    ⚠️ Stok Kritis ({{ $lowStockItems->count() }})
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg transition-all duration-200 hover:text-slate-600 hover:border-slate-300 text-slate-400 font-semibold" 
                        id="expiring-tab" onclick="switchTab('expiring')" type="button" role="tab">
                    ⏰ Mendekati Kedaluwarsa ({{ $expiringSoonItems->count() }})
                </button>
            </li>
        </ul>
    </div>

    <!-- TABS CONTENT -->
    <div id="inventoryTabContent">
        
        <!-- TAB 1: STOK KRITIS -->
        <div class="tab-pane" id="low-stock-content" role="tabpanel">
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Daftar Barang Dengan Stok Tipis</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 w-[15%]">SKU</th>
                                <th class="px-6 py-4 w-[25%]">Nama Barang</th>
                                <th class="px-6 py-4 w-[20%]">Supplier</th>
                                <th class="px-6 py-4 text-center w-[12%]">Stok Aktual</th>
                                <th class="px-6 py-4 text-center w-[12%]">Batas Minim</th>
                                <th class="px-6 py-4 text-right w-[16%]">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($lowStockItems as $item)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500 font-bold">
                                        {{ $item->sku ?? 'NO SKU' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 text-sm">{{ $item->nama }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">Kategori: {{ $item->jenisBarang->name ?? 'Umum' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800 text-xs">{{ $item->supplier->nama ?? 'Supplier Umum' }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">{{ $item->supplier->kontak ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 rounded-lg">
                                            {{ $item->jumlah }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-400 text-xs">
                                        {{ $item->min_stock }}
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2 items-center">
                                        <!-- Hubungi Supplier (Mailto) -->
                                        @php
                                            $subject = rawurlencode('[RESTOCK] Permintaan Pasokan Ulang: ' . $item->nama);
                                            $body = rawurlencode("Halo " . ($item->supplier->nama ?? 'Supplier') . ",\n\nKami ingin memesan kembali produk berikut:\n- Nama: " . $item->nama . "\n- SKU: " . ($item->sku ?? '-') . "\n- Stok Tersisa saat ini: " . $item->jumlah . " unit (batas minimum: " . $item->min_stock . " unit).\n\nMohon informasi ketersediaan pasokan dan pengiriman sesegera mungkin.\n\nTerima kasih,\n" . (Auth::user()->name ?? 'Manajer MSL'));
                                            $email = $item->supplier->kontak && filter_var($item->supplier->kontak, FILTER_VALIDATE_EMAIL) ? $item->supplier->kontak : 'supplier@example.com';
                                        @endphp
                                        <a href="mailto:{{ $email }}?subject={{ $subject }}&body={{ $body }}" 
                                           class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl transition duration-150 flex items-center gap-1 text-xs font-semibold"
                                           title="Hubungi Supplier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>Email</span>
                                        </a>

                                        <!-- Buat Agenda Restock -->
                                        @php
                                            $scheduleQuery = http_build_query([
                                                'name' => 'Restock: ' . $item->nama,
                                                'note' => 'Pemesanan ulang otomatis untuk ' . $item->nama . ' (SKU: ' . ($item->sku ?? '-') . ') karena stok tersisa ' . $item->jumlah . ' unit.',
                                                'date' => date('Y-m-d')
                                            ]);
                                        @endphp
                                        <a href="{{ route('schedule.create') }}?{{ $scheduleQuery }}" 
                                           class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl transition duration-150 flex items-center gap-1 text-xs font-semibold"
                                           title="Jadwalkan Restock">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Jadwal</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Semua stok aman! Tidak ada barang dengan kondisi stok di bawah batas minimal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: MENDEKATI KEDALUWARSA -->
        <div class="tab-pane hidden" id="expiring-content" role="tabpanel">
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Daftar Barang Mendekati Masa Kedaluwarsa</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 w-[15%]">SKU</th>
                                <th class="px-6 py-4 w-[25%]">Nama Barang</th>
                                <th class="px-6 py-4 w-[15%] text-center">Stok Unit</th>
                                <th class="px-6 py-4 w-[18%]">Tanggal Kedaluwarsa</th>
                                <th class="px-6 py-4 text-center w-[12%]">Hari Tersisa</th>
                                <th class="px-6 py-4 text-right w-[15%]">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($expiringSoonItems as $item)
                                @php
                                    $expDate = \Carbon\Carbon::parse($item->expired_date);
                                    $daysRemaining = max(0, intval(now()->diffInDays($expDate, false)));
                                @endphp
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500 font-bold">
                                        {{ $item->sku ?? 'NO SKU' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 text-sm">{{ $item->nama }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">Supplier: {{ $item->supplier->nama ?? 'Supplier Umum' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700 text-xs">
                                        {{ $item->jumlah }} Unit
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg border bg-rose-50 text-rose-600 border-rose-100">
                                            {{ $expDate->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-xs text-rose-600">
                                        {{ $daysRemaining }} Hari
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2 items-center">
                                        <!-- Buat Agenda Retur -->
                                        @php
                                            $returnQuery = http_build_query([
                                                'name' => 'Retur Kedaluwarsa: ' . $item->nama,
                                                'note' => 'Kembalikan produk ' . $item->nama . ' (SKU: ' . ($item->sku ?? '-') . ') sebanyak ' . $item->jumlah . ' unit ke supplier ' . ($item->supplier->nama ?? 'Umum') . ' karena akan kedaluwarsa pada ' . $expDate->format('d M Y') . '.',
                                                'date' => $expDate->copy()->subDays(10)->toDateString()
                                            ]);
                                        @endphp
                                        <a href="{{ route('schedule.create') }}?{{ $returnQuery }}" 
                                           class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-xl transition duration-150 flex items-center gap-1 text-xs font-semibold"
                                           title="Jadwalkan Retur">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <span>Retur</span>
                                        </a>

                                        <!-- Hapus Item Peringatan -->
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inventaris ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition duration-150" title="Singkirkan Item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Aman! Tidak ada produk yang mendekati tanggal kadaluarsa dalam waktu dekat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Switch Tab Javascript -->
    <script>
        function switchTab(tabId) {
            const lowStockTab = document.getElementById('low-stock-tab');
            const expiringTab = document.getElementById('expiring-tab');
            const lowStockContent = document.getElementById('low-stock-content');
            const expiringContent = document.getElementById('expiring-content');

            if (tabId === 'low-stock') {
                // Style tabs
                lowStockTab.className = "inline-block p-4 border-b-2 rounded-t-lg transition-all duration-200 active-tab text-emerald-600 border-emerald-500 font-bold";
                expiringTab.className = "inline-block p-4 border-b-2 border-transparent rounded-t-lg transition-all duration-200 hover:text-slate-600 hover:border-slate-300 text-slate-400 font-semibold";
                
                // Show/hide content
                lowStockContent.classList.remove('hidden');
                expiringContent.classList.add('hidden');
            } else if (tabId === 'expiring') {
                // Style tabs
                expiringTab.className = "inline-block p-4 border-b-2 rounded-t-lg transition-all duration-200 active-tab text-emerald-600 border-emerald-500 font-bold";
                lowStockTab.className = "inline-block p-4 border-b-2 border-transparent rounded-t-lg transition-all duration-200 hover:text-slate-600 hover:border-slate-300 text-slate-400 font-semibold";
                
                // Show/hide content
                expiringContent.classList.remove('hidden');
                lowStockContent.classList.add('hidden');
            }
        }
    </script>
@endsection