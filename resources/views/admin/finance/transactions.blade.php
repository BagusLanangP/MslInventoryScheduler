@extends('admin.layouts.app')

@section('title', 'Transaksi Harian')

@section('content')
    <!-- Alerts / Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Description & Controls -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Buku Harian Arus Kas</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau rincian arus kas harian, impor log transaksi kasir POS, atau ekspor data bulanan.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Period Selector -->
            <form action="{{ route('admin.finance.transactions') }}" method="GET" class="flex items-center gap-2 bg-white border border-slate-200 p-2 rounded-xl shadow-sm">
                <label class="text-xs font-semibold text-slate-400 pl-1">Bulan:</label>
                <input type="month" name="periode" value="{{ $selectedMonth }}" 
                       class="bg-slate-50 text-slate-700 text-xs font-bold rounded-lg border border-slate-200 p-1.5 focus:outline-none focus:border-emerald-500"
                       onchange="this.form.submit()">
            </form>

            <!-- Export CSV -->
            <a href="{{ route('admin.finance.exportTransactions', ['periode' => $selectedMonth]) }}" 
               class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition duration-150 flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Ekspor CSV</span>
            </a>

            <!-- Import CSV toggle -->
            <button onclick="toggleElement('csv-import-box')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition duration-150 flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Impor CSV POS</span>
            </button>
        </div>
    </div>

    <!-- CSV IMPORT FORM BOX (HIDDEN BY DEFAULT) -->
    <div id="csv-import-box" class="hidden bg-white border border-slate-100 p-6 rounded-2xl shadow-sm mb-8 transition-all duration-300">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Unggah File Log Transaksi (CSV)</h3>
            <button onclick="toggleElement('csv-import-box')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form action="{{ route('admin.finance.importTransactions') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            @csrf
            <div class="md:col-span-2">
                <input type="file" name="csv_file" required
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <span class="text-[10px] text-slate-400 mt-2 block">Format Kolom CSV: `tanggal (YYYY-MM-DD)`, `nama`, `tipe (pemasukan/pengeluaran)`, `kategori`, `nominal`, `keterangan (opsional)`</span>
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs transition duration-150 shadow-md shadow-indigo-500/10">
                Unggah & Proses Log
            </button>
        </form>
    </div>

    <!-- FLOW SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Income Summary -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pemasukan Harian</p>
                <h4 class="text-lg font-bold text-slate-900 mt-0.5">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- Expenses Summary -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pengeluaran Harian</p>
                <h4 class="text-lg font-bold text-slate-900 mt-0.5">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- Net Flow Summary -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            @php $isPos = $netFlow >= 0; @endphp
            <div class="p-3 rounded-xl {{ $isPos ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Arus Kas Bersih Harian</p>
                <h4 class="text-lg font-bold mt-0.5 {{ $isPos ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp{{ number_format($netFlow, 0, ',', '.') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- TRANSACTIONS LEDGER TABLE (2 Columns) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Jurnal Transaksi Harian</h3>
                    <span class="text-xs font-bold text-slate-400">{{ $transactions->count() }} Transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-center">Tipe</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4 text-center">Sumber</th>
                                <th class="px-6 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-slate-500">
                                        {{ $tx->tanggal->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 text-xs">{{ $tx->nama }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5 truncate max-w-[150px]">{{ $tx->keterangan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-0.5 text-[9px] font-bold rounded border uppercase
                                            @if($tx->tipe === 'pemasukan') bg-emerald-50 text-emerald-700 border-emerald-100
                                            @else bg-rose-50 text-rose-700 border-rose-100 @endif">
                                            {{ $tx->tipe }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium">{{ $tx->kategori }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-0.5 text-[9px] font-semibold bg-slate-100 text-slate-500 rounded border border-slate-200">
                                            {{ strtoupper($tx->sumber) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold {{ $tx->tipe === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx->tipe === 'pemasukan' ? '+' : '-' }}Rp{{ number_format($tx->nominal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Belum ada data transaksi harian di bulan ini. Silakan input manual atau unggah file CSV kasir.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MANUAL ENTRY FORM CARD (1 Column) -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between self-start">
            <div>
                <h3 class="text-base font-bold text-slate-900 mb-1">Catat Transaksi Manual</h3>
                <p class="text-xs text-slate-400 mb-6">Input manual arus pemasukan/pengeluaran kas yang tidak dicatat sistem pos.</p>

                <form action="{{ route('admin.finance.storeTransaction') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Transaksi</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                               class="w-full bg-slate-50 text-slate-800 border border-slate-200 rounded-xl py-2 px-3 text-xs focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Transaksi</label>
                        <input type="text" name="nama" required placeholder="Contoh: Pembelian Sabun Cuci"
                               class="w-full bg-white text-slate-800 border border-slate-200 rounded-xl py-2 px-3 text-xs focus:outline-none focus:border-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Arus</label>
                            <select name="tipe" required
                                    class="w-full bg-slate-50 text-slate-800 border border-slate-200 rounded-xl py-2 px-3 text-xs focus:outline-none">
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                            <input type="text" name="kategori" required placeholder="Operasional, ATK, dll"
                                   class="w-full bg-white text-slate-800 border border-slate-200 rounded-xl py-2 px-3 text-xs focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nominal (Rp)</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-xs">Rp</span>
                            </div>
                            <input type="number" name="nominal" required placeholder="0"
                                   class="w-full bg-white text-slate-800 border border-slate-200 rounded-xl py-2 pl-8 pr-3 text-xs focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan / Catatan</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan opsional..."
                                  class="w-full bg-slate-50 text-slate-600 border border-slate-200 rounded-xl py-2 px-3 text-xs focus:outline-none focus:border-emerald-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-xs transition duration-150 shadow-md shadow-emerald-500/10">
                        Simpan Transaksi
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Script to toggle elements -->
    <script>
        function toggleElement(id) {
            const el = document.getElementById(id);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        }
    </script>
@endsection
