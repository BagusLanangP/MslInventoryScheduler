<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Keuangan_{{ $selectedMonth }}.pdf</title>
    
    <!-- Tailwind CSS (Offline-friendly CDN if browser can fetch, or simple fallback styles) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
                padding-top: 0 !important;
            }
            .print-hide {
                display: none !important;
            }
            .print-card {
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
                background-color: #ffffff !important;
                page-break-inside: avoid;
            }
            .print-break-avoid {
                page-break-inside: avoid;
            }
            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="pt-24 pb-12 px-4 md:px-8 max-w-5xl mx-auto">

    <!-- Sticky Print Control Bar -->
    <div class="print-hide fixed top-0 left-0 right-0 bg-slate-900/95 backdrop-blur-md text-white px-6 py-4 flex items-center justify-between shadow-lg z-50 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center font-bold text-white text-sm">
                MS
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block">Pratinjau Dokumen Cetak</span>
                <h2 class="text-xs font-bold text-white">Laporan Keuangan Periode {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}</h2>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
            <button onclick="window.close()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition-all">
                Tutup
            </button>
        </div>
    </div>

    <!-- MAIN REPORT PAGE CONTAINER -->
    <div class="bg-white border border-slate-200 p-8 md:p-12 rounded-3xl shadow-sm print-card">
        
        <!-- REPORT HEADER -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-start border-b-2 border-slate-900 pb-6 mb-8">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <img src="/img/logo.png" alt="MSL Logo" class="h-8 w-auto error-fallback" onerror="this.style.display='none'">
                    <span class="text-xl font-extrabold tracking-wider text-slate-900">{{ strtoupper(config('app.name')) }}</span>
                </div>
                <h1 class="text-base font-bold uppercase tracking-wider text-slate-800">Laporan Kinerja Keuangan Bulanan</h1>
                <p class="text-xs text-slate-500">Status Operasional, Restocking, dan Rekapitulasi Anggaran Bulanan</p>
            </div>
            
            <div class="mt-4 md:mt-0 text-left md:text-right space-y-1 text-xs">
                <div class="bg-slate-100 px-3 py-1.5 rounded-lg inline-block font-bold text-slate-700 border border-slate-200">
                    Periode: {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}
                </div>
                <p class="text-slate-400 mt-1">Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
                <p class="text-slate-400">Petugas Cetak: {{ Auth::user()->name ?? 'Administrator' }}</p>
            </div>
        </div>

        <!-- 1. KPI SUMMARY -->
        <div class="mb-8">
            <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">I. Ringkasan Kinerja Utama</h2>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="border border-slate-200 p-4 rounded-xl">
                    <span class="text-[9px] uppercase font-bold text-slate-400 tracking-wider block">Saldo Kas Utama</span>
                    <span class="text-sm font-extrabold text-slate-900 block mt-1">Rp{{ number_format($totalCashPool, 0, ',', '.') }}</span>
                </div>
                <div class="border border-slate-200 p-4 rounded-xl">
                    <span class="text-[9px] uppercase font-bold text-slate-400 tracking-wider block">Untung Kotor (Income)</span>
                    <span class="text-sm font-extrabold text-emerald-600 block mt-1">Rp{{ number_format($totalGrossProfit, 0, ',', '.') }}</span>
                </div>
                <div class="border border-slate-200 p-4 rounded-xl">
                    <span class="text-[9px] uppercase font-bold text-slate-400 tracking-wider block">Beban Bulanan (Expense)</span>
                    <span class="text-sm font-extrabold text-rose-600 block mt-1">Rp{{ number_format($totalExpenses, 0, ',', '.') }}</span>
                </div>
                <div class="border border-slate-200 p-4 rounded-xl">
                    <span class="text-[9px] uppercase font-bold text-slate-400 tracking-wider block">Keuntungan Bersih (Net)</span>
                    <span class="text-sm font-extrabold block mt-1 {{ $netMargin >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp{{ number_format($netMargin, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Health summary note -->
            <div class="mt-4 border border-slate-200/80 bg-slate-50/50 p-4 rounded-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Status Kesehatan Finansial</span>
                    <span class="text-xs font-bold text-slate-800 block mt-0.5">Rating: {{ $healthStatus }} (Skor {{ $healthRating }} / 100)</span>
                </div>
                <div class="text-xs text-slate-500 leading-relaxed max-w-xl">
                    Sisa dana anggaran yang terselamatkan akan kembali mengalir mengisi saldo kas operasional utama di awal periode berikutnya secara otomatis.
                </div>
            </div>
        </div>

        <!-- 2. BUDGET VARIANCE ANALYSIS -->
        <div class="mb-8 print-break-avoid">
            <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">II. Analisis Varians Anggaran</h2>
            
            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3 text-right">Batas Anggaran (Rencana)</th>
                            <th class="px-4 py-3 text-right">Belanja Aktual (Realisasi)</th>
                            <th class="px-4 py-3 text-right">Sisa Dana</th>
                            <th class="px-4 py-3 text-center">Varians</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($budgetVariance as $v)
                            @php
                                $over = $v['actual'] > $v['limit'];
                                $isZero = $v['limit'] == 0;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $v['kategori'] }}</td>
                                <td class="px-4 py-3 text-right text-slate-600">
                                    {{ $isZero ? 'Tidak Dianggarkan' : 'Rp' . number_format($v['limit'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right text-slate-800 font-medium">Rp{{ number_format($v['actual'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-bold {{ $v['remaining'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    @if($v['remaining'] < 0)
                                        -Rp{{ number_format(abs($v['remaining']), 0, ',', '.') }}
                                    @else
                                        Rp{{ number_format($v['remaining'], 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-bold {{ $over ? 'text-rose-600' : 'text-emerald-600' }}">
                                    @if($isZero)
                                        {{ $v['actual'] > 0 ? '+100%' : '0%' }}
                                    @else
                                        {{ $over ? '+' : '' }}{{ number_format($v['deviation'], 1) }}%
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. DETAILED SECTOR SPENDING -->
        <div class="space-y-8">
            
            <!-- A. RESTOCKING DETAILS -->
            <div class="print-break-avoid">
                <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">III. Rincian Pembelian Barang & Restocking</h2>
                
                @if($restockItems->count() > 0)
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Nama Barang</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3 text-right">Qty</th>
                                    <th class="px-4 py-3 text-right">Harga Pokok</th>
                                    <th class="px-4 py-3 text-right">Harga Jual</th>
                                    <th class="px-4 py-3 text-right">Total Biaya (Modal)</th>
                                    <th class="px-4 py-3 text-right">Estimasi Laba Kotor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($restockItems as $item)
                                    @php
                                        $cost = floatval($item->harga_pokok) * intval($item->jumlah);
                                        $revenue = floatval($item->harga_jual) * intval($item->jumlah);
                                        $estProfit = $revenue - $cost;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-slate-900">{{ $item->nama }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $item->jenisBarang->name ?? 'General' }}</td>
                                        <td class="px-4 py-3 text-right">{{ $item->jumlah }}</td>
                                        <td class="px-4 py-3 text-right text-slate-500">Rp{{ number_format($item->harga_pokok, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-slate-500">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-slate-800 font-semibold">Rp{{ number_format($cost, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-emerald-600 font-semibold">Rp{{ number_format($estProfit, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Tidak ada aktivitas belanja restocking barang tercatat pada periode ini.</p>
                @endif
            </div>

            <!-- B. OPERATIONAL DETAILS -->
            <div class="print-break-avoid">
                <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">IV. Rincian Beban Operasional</h2>
                
                @if($opsSchedules->count() > 0 || $opsTransactions->count() > 0)
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Nama Pengeluaran</th>
                                    <th class="px-4 py-3">Sumber</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                    <th class="px-4 py-3 text-right">Biaya Keluar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($opsSchedules as $s)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-0.5 text-[9px] bg-indigo-50 text-indigo-700 border border-indigo-100 rounded">Jadwal</span></td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $s->note ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($s->budget, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @foreach($opsTransactions as $tx)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->tanggal)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $tx->nama }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-0.5 text-[9px] bg-slate-100 text-slate-700 border border-slate-200 rounded">Harian ({{ ucfirst($tx->sumber) }})</span></td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $tx->keterangan ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Tidak ada rincian beban operasional operasional tercatat pada periode ini.</p>
                @endif
            </div>

            <!-- C. MAINTENANCE DETAILS -->
            <div class="print-break-avoid">
                <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">V. Rincian Biaya Pemeliharaan & Maintenance</h2>
                
                @if($maintSchedules->count() > 0 || $maintTransactions->count() > 0)
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Nama Pengeluaran</th>
                                    <th class="px-4 py-3">Sumber</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                    <th class="px-4 py-3 text-right">Biaya Keluar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($maintSchedules as $s)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-0.5 text-[9px] bg-indigo-50 text-indigo-700 border border-indigo-100 rounded">Jadwal</span></td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $s->note ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($s->budget, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @foreach($maintTransactions as $tx)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->tanggal)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $tx->nama }}</td>
                                        <td class="px-4 py-3"><span class="px-2 py-0.5 text-[9px] bg-slate-100 text-slate-700 border border-slate-200 rounded">Harian ({{ ucfirst($tx->sumber) }})</span></td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $tx->keterangan ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Tidak ada rincian biaya pemeliharaan / maintenance tercatat pada periode ini.</p>
                @endif
            </div>

            <!-- D. OTHER EXPENSES DETAILS -->
            @if($otherSchedules->count() > 0 || $otherTransactions->count() > 0)
                <div class="print-break-avoid">
                    <h2 class="text-sm font-bold uppercase text-slate-900 tracking-wider mb-4 border-l-4 border-slate-900 pl-2">VI. Pengeluaran Kategori Lainnya</h2>
                    
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Nama Pengeluaran</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                    <th class="px-4 py-3 text-right">Biaya Keluar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($otherSchedules as $s)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $s->name }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $s->jenisSchedule->nama ?? 'Umum' }}</td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $s->note ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($s->budget, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @foreach($otherTransactions as $tx)
                                    <tr>
                                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->tanggal)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $tx->nama }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $tx->kategori }}</td>
                                        <td class="px-4 py-3 text-slate-400 truncate max-w-[200px]">{{ $tx->keterangan ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-rose-600 font-semibold">Rp{{ number_format($tx->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- 4. SIGNATURE FOOTER -->
        <div class="mt-16 pt-8 border-t border-slate-200 grid grid-cols-2 text-center text-xs print-break-avoid">
            <div class="space-y-12">
                <p class="text-slate-500">Disiapkan Oleh:</p>
                <div>
                    <p class="font-bold text-slate-800 underline">________________________</p>
                    <p class="text-[10px] text-slate-400 mt-1">Manager Keuangan MSL</p>
                </div>
            </div>
            <div class="space-y-12">
                <p class="text-slate-500">Disetujui Oleh:</p>
                <div>
                    <p class="font-bold text-slate-800 underline">________________________</p>
                    <p class="text-[10px] text-slate-400 mt-1">Direktur Utama / Owner</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Print Script to Auto-Trigger Dialog -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Delay triggering print slightly to allow rendering
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
