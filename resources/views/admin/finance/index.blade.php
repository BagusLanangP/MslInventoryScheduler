@extends('admin.layouts.app')

@section('title', 'Kelola Keuangan & Budgeting')

@section('content')
    <!-- Alerts / Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Analisis Kesehatan Anggaran</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau profitabilitas inventaris, pembagian alokasi dana 50/30/20, serta analisis per periodenya secara dinamis.</p>
        </div>
        <div class="flex items-center gap-3 self-start">
            <!-- Period Selector Form -->
            <form action="{{ route('admin.finance.index') }}" method="GET" class="flex items-center gap-3 bg-white border border-slate-200/80 p-2 rounded-xl shadow-sm">
                <label class="text-xs font-semibold text-slate-500 pl-2">Periode Analisis:</label>
                <select name="periode" class="bg-slate-50 text-slate-700 text-xs font-bold rounded-lg border border-slate-200/60 p-1.5 focus:outline-none focus:border-emerald-500" onchange="this.form.submit()">
                    @foreach($availablePeriods as $period)
                        <option value="{{ $period }}" {{ $selectedMonth === $period ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($period . '-01')->translatedFormat('F Y') }}
                        </option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('admin.finance.exportPdf', ['periode' => $selectedMonth]) }}" target="_blank" class="flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-3 rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Ekspor PDF
            </a>
            <div class="text-xs text-slate-400 bg-white border border-slate-100 px-3 py-2.5 rounded-xl">
                Integrasi API POS: <span class="text-emerald-500 font-semibold">Aktif</span>
            </div>
        </div>
    </div>

    <!-- 1. TOP SUMMARY CARDS (4 COLUMNS) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Saldo Kas Utama Card -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-5 rounded-2xl shadow-md border border-slate-700 relative overflow-hidden flex items-center gap-4">
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="p-3.5 bg-emerald-500/15 text-emerald-400 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Saldo Kas Utama</p>
                <h4 class="text-xl font-bold text-white mt-0.5 truncate">Rp{{ number_format($totalCashPool, 0, ',', '.') }}</h4>
                <span class="text-[10px] text-emerald-400 font-semibold">Kas Operasional Aktif</span>
            </div>
        </div>

        <!-- Profits Card -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-emerald-100 transition-colors">
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 11h2m0 0h2m-4 1a3 3 0 013 3M12 11a3 3 0 00-3-3" />
                </svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Untung Kotor Bulanan</p>
                <h4 class="text-xl font-bold text-slate-900 mt-0.5 truncate">Rp{{ number_format($totalGrossProfit, 0, ',', '.') }}</h4>
                <span class="text-[10px] text-slate-400">Periode {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}</span>
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-rose-100 transition-colors">
            <div class="p-3.5 bg-rose-50 text-rose-600 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Beban Anggaran Bulanan</p>
                <h4 class="text-xl font-bold text-slate-900 mt-0.5 truncate">Rp{{ number_format($totalExpenses, 0, ',', '.') }}</h4>
                <span class="text-[10px] text-slate-400">Periode {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}</span>
            </div>
        </div>

        <!-- Net Profit Card -->
        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-blue-100 transition-colors">
            @php
                $isPositive = $netMargin >= 0;
            @endphp
            <div class="p-3.5 rounded-xl group-hover:scale-110 transition-transform {{ $isPositive ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keuntungan Bersih Bulanan</p>
                <h4 id="net-margin-value" class="text-xl font-bold mt-0.5 truncate {{ $isPositive ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp{{ number_format($netMargin, 0, ',', '.') }}
                </h4>
                <span id="net-margin-status" class="text-[10px] {{ $isPositive ? 'text-emerald-500' : 'text-rose-500' }} font-medium">
                    {{ $isPositive ? 'Surplus Bersih' : 'Defisit Anggaran' }}
                </span>
            </div>
        </div>
    </div>

    <!-- 2. HEALTH ADVISOR & 50/30/20 BLOCK -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Cash Flow Health Advisor Card -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between lg:col-span-2 relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-40 h-40 bg-slate-50 rounded-full opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400">Kesehatan Finansial ({{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }})</h3>
                    
                    <span id="health-badge" class="px-3 py-1 text-xs font-bold rounded-lg uppercase border 
                        @if($healthColor === 'emerald' || $healthColor === 'green') bg-emerald-50 text-emerald-700 border-emerald-200
                        @elseif($healthColor === 'amber') bg-amber-50 text-amber-700 border-amber-200
                        @else bg-rose-50 text-rose-700 border-rose-200 @endif">
                        {{ $healthStatus }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <!-- Gauge Meter -->
                    <div class="flex flex-col items-center justify-center border-r border-slate-100/80 pr-2">
                        <div class="relative w-28 h-28 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path id="health-progress" class="
                                    @if($healthColor === 'emerald' || $healthColor === 'green') text-emerald-500
                                    @elseif($healthColor === 'amber') text-amber-500
                                    @else text-rose-500 @endif transition-all duration-500" 
                                    stroke-dasharray="{{ $healthRating }}, 100" 
                                    stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <div class="absolute text-center">
                                <span id="health-score" class="text-2xl font-bold text-slate-800">{{ $healthRating }}</span>
                                <span class="text-slate-400 text-xs block">/ 100</span>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 mt-2 font-medium">Skor Kelayakan</span>
                    </div>

                    <!-- Description & Recommendations -->
                    <div class="md:col-span-2 space-y-2">
                        <h4 class="text-slate-800 font-bold text-sm">Rekomendasi Penasihat Finansial:</h4>
                        <p id="health-recommendation" class="text-xs text-slate-500 leading-relaxed">
                            {{ $healthRecommendation }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Operating Ratio Progress Bar -->
            <div class="mt-6 border-t border-slate-100 pt-4 flex items-center justify-between gap-4 text-xs">
                <div class="flex-1">
                    <div class="flex justify-between mb-1">
                        <span class="text-slate-400">Rasio Beban Operasional (vs Profit)</span>
                        <span id="ratio-text" class="font-semibold text-slate-700">{{ number_format($ratio, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div id="ratio-progress-bar" class="h-full rounded-full transition-all duration-500 
                            @if($ratio < 50) bg-emerald-500 
                            @elseif($ratio <= 80) bg-green-500 
                            @elseif($ratio <= 100) bg-amber-500 
                            @else bg-rose-500 @endif" 
                            style="width: {{ min($ratio, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 50/30/20 Rule Card (Stacked) -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Metode Alokasi (50/30/20)</h3>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">Pembagian ideal anggaran bulanan vs realisasi belanja periode ini.</p>
            </div>

            <div class="space-y-3.5 mt-4">
                <!-- NEEDS -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs">
                        <span class="font-bold text-slate-600">Needs (50%)</span>
                        <span id="needs-pct-label" class="font-semibold {{ $needsPct > 50 ? 'text-rose-600' : 'text-slate-500' }}">{{ number_format($needsPct, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div id="needs-progress-bar" class="h-full rounded-full {{ $needsPct > 50 ? 'bg-rose-500' : 'bg-indigo-500' }}" style="width: {{ min($needsPct, 100) }}%"></div>
                    </div>
                </div>

                <!-- WANTS -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs">
                        <span class="font-bold text-slate-600">Wants (30%)</span>
                        <span id="wants-pct-label" class="font-semibold {{ $wantsPct > 30 ? 'text-rose-600' : 'text-slate-500' }}">{{ number_format($wantsPct, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div id="wants-progress-bar" class="h-full rounded-full {{ $wantsPct > 30 ? 'bg-rose-500' : 'bg-amber-500' }}" style="width: {{ min($wantsPct, 100) }}%"></div>
                    </div>
                </div>

                <!-- SAVINGS -->
                <div class="space-y-1">
                    <div class="flex justify-between text-xs">
                        <span class="font-bold text-slate-600">Savings (20%)</span>
                        <span id="savings-pct-label" class="font-semibold {{ $savingsPct < 20 ? 'text-rose-600' : 'text-emerald-600' }}">{{ number_format($savingsPct, 1) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div id="savings-progress-bar" class="h-full rounded-full {{ $savingsPct < 20 ? 'bg-amber-500' : 'bg-emerald-500' }}" style="width: {{ min($savingsPct, 100) }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                <span>Status Aturan:</span>
                @if($needsPct <= 50 && $wantsPct <= 30 && $savingsPct >= 20)
                    <span class="text-emerald-600 font-bold">✓ SANGAT PATUH</span>
                @elseif($savingsPct >= 20)
                    <span class="text-emerald-500 font-bold">✓ CUKUP PATUH</span>
                @else
                    <span class="text-rose-600 font-bold">⚠️ KURANG PATUH</span>
                @endif
            </div>
        </div>
    </div>


    <!-- 3. VISUAL CHARTS Bulanan & Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Monthly Financial Performance (Trend) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div class="mb-4">
                <h4 class="text-sm font-bold text-slate-800">Tren Keuangan Bulanan (6 Bulan Terakhir)</h4>
                <p class="text-xs text-slate-400">Arus perkembangan laba kotor, beban anggaran, dan keuntungan bersih kumulatif.</p>
            </div>
            <div class="h-64 relative">
                <canvas id="profitExpenseChart"></canvas>
            </div>
        </div>

        <!-- Budget Distribution per Category -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div class="mb-4">
                <h4 class="text-sm font-bold text-slate-800">Distribusi Pengeluaran Kategori ({{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }})</h4>
                <p class="text-xs text-slate-400">Proporsi total dana yang terserap per kategori bulan ini.</p>
            </div>
            <div class="h-64 relative flex items-center justify-center">
                <canvas id="categoryBudgetChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 4. INTERACTIVE BUDGET SIMULATOR WIDGET WITH 50/30/20 SIMULATION -->
    <div class="bg-slate-900 text-white rounded-3xl p-6 md:p-8 mb-8 shadow-xl relative overflow-hidden border border-slate-800">
        <div class="absolute -left-1/4 -bottom-1/2 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -right-1/4 -top-1/2 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <!-- Simulator description -->
            <div class="space-y-3">
                <span class="px-2.5 py-1 text-[10px] font-bold bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 rounded-lg uppercase tracking-wider">Fitur Interaktif</span>
                <h3 class="text-lg font-bold">Simulator Anggaran Baru</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Ketik rencana budget agenda baru untuk mensimulasikan kepatuhan terhadap aturan **50/30/20** dan kesehatan keuangan secara real-time.
                </p>
                <div class="pt-2 flex flex-col gap-1.5 text-xs text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                        <span>Menganalisis pergeseran rasio alokasi Needs & Wants.</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>Menghitung estimasi saldo akhir operasional.</span>
                    </div>
                </div>
            </div>

            <!-- Simulation Input Form -->
            <div class="bg-white/5 backdrop-blur-md border border-white/10 p-5 rounded-2xl space-y-4">
                <h4 class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Parameter Rencana</h4>
                
                <div>
                    <label class="block text-slate-400 text-[10px] font-medium mb-1.5">Estimasi Nominal Budget (Rp)</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-xs">Rp</span>
                        </div>
                        <input type="number" id="sim-budget-amount" class="w-full bg-slate-950/40 text-white border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="Contoh: 3000000">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 text-[10px] font-medium mb-1.5">Kategori Agenda Rencana</label>
                    <select id="sim-budget-category" class="w-full bg-slate-950/40 text-white border border-white/10 rounded-xl py-2.5 px-3.5 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        <option class="bg-slate-900" value="Operasional">Operasional (Needs)</option>
                        <option class="bg-slate-900" value="Maintenance">Maintenance (Needs)</option>
                        <option class="bg-slate-900" value="Pembelian Barang / Restocking">Pembelian Barang / Restocking (Wants)</option>
                    </select>
                </div>
            </div>

            <!-- Simulation Result Preview -->
            <div class="bg-slate-950/40 border border-slate-800 p-6 rounded-2xl flex flex-col justify-between h-full min-h-[220px]">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Hasil Kelayakan Anggaran</span>
                    
                    <div class="flex items-baseline gap-2 mt-2">
                        <h4 id="sim-result-status" class="text-xl font-bold text-emerald-400">Sangat Sehat</h4>
                        <span id="sim-result-score" class="text-[10px] text-slate-500 font-medium">(Skor: 95/100)</span>
                    </div>

                    <p id="sim-result-recommendation" class="text-xs text-slate-400 mt-2.5 leading-relaxed">
                        Arus kas Anda tetap dalam kondisi sangat sehat pasca-pengeluaran ini. Anggaran baru layak dilaksanakan.
                    </p>
                </div>

                <!-- Simulation Delta Indicators -->
                <div class="border-t border-slate-800/80 pt-3.5 mt-3.5 grid grid-cols-2 gap-x-4 gap-y-2 text-[10px] text-slate-500">
                    <div>
                        <span>Sisa Saldo Baru:</span>
                        <span id="sim-result-margin" class="block font-bold text-white text-[11px] mt-0.5">Rp{{ number_format($netMargin, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span>Rasio Beban Baru:</span>
                        <span id="sim-result-ratio" class="block font-bold text-white text-[11px] mt-0.5">{{ number_format($ratio, 1) }}%</span>
                    </div>
                    <div class="col-span-2 border-t border-slate-800/40 pt-2 flex justify-between text-slate-400 font-medium">
                        <span>Alokasi Kebutuhan (Needs) Baru:</span>
                        <span id="sim-result-needs" class="text-white font-bold">{{ number_format($needsPct, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4.5 BUDGET VARIANCE ANALYSIS TABLE (Rencana vs Realisasi) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Analisis Varians Anggaran (Rencana vs Realisasi)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Bandingkan batas alokasi anggaran bulanan dengan pengeluaran aktual per kategori untuk mengontrol pemborosan.</p>
                </div>
            </div>
            <div class="text-[10px] uppercase font-bold text-slate-400 bg-slate-100 px-2.5 py-1.5 rounded-lg border border-slate-200/50">
                Periode: {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50/30 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Kategori Pengeluaran</th>
                        <th class="px-6 py-4 text-right">Batas Anggaran (Rencana)</th>
                        <th class="px-6 py-4 text-right">Belanja Aktual (Realisasi)</th>
                        <th class="px-6 py-4 text-right">Sisa Dana</th>
                        <th class="px-6 py-4 text-center">Status & Deviasi (Varians)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($budgetVariance as $item)
                        @php
                            $isOverBudget = $item['actual'] > $item['limit'];
                            $isLimitZero = $item['limit'] == 0;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item['kategori'] }}</td>
                            <td class="px-6 py-4 text-right font-medium text-slate-900">
                                @if($isLimitZero)
                                    <span class="text-slate-400 italic">Tidak Dianggarkan</span>
                                @else
                                    Rp{{ number_format($item['limit'], 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-900">
                                Rp{{ number_format($item['actual'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold {{ $item['remaining'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                @if($item['remaining'] < 0)
                                    -Rp{{ number_format(abs($item['remaining']), 0, ',', '.') }}
                                @else
                                    Rp{{ number_format($item['remaining'], 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($isLimitZero)
                                    @if($item['actual'] > 0)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase bg-rose-50 text-rose-700 border border-rose-100 inline-block">
                                            ⚠️ Melebihi (+100.0%)
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-lg uppercase bg-slate-100 text-slate-500 border border-slate-200 inline-block">
                                            Sesuai (0.0%)
                                        </span>
                                    @endif
                                @else
                                    @if($isOverBudget)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase bg-rose-50 text-rose-700 border border-rose-100 inline-block animate-pulse">
                                            ⚠️ Over Budget (+{{ number_format($item['deviation'], 1) }}%)
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase bg-emerald-50 text-emerald-700 border border-emerald-100 inline-block">
                                            ✓ Aman ({{ number_format($item['deviation'], 1) }}%)
                                        </span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Tidak ada kategori anggaran operasional pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 5. DUAL SCOPE TRANSACTION TABLES (Daily <= 30 Days & Monthly summaries > 30 Days) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden mb-8">
        
        <!-- Tab Headers -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200/80 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Rincian Buku Kas (Ledger)</h3>
                <p class="text-xs text-slate-500 mt-0.5">Rincian transaksi masuk/keluar untuk periode terpilih dan rekap bulanan historis.</p>
            </div>
            
            <!-- Tab Buttons -->
            <div class="flex bg-slate-200/60 p-1 rounded-xl text-xs font-semibold">
                <button id="btn-tab-daily" class="px-4 py-2 rounded-lg bg-white text-slate-800 shadow-sm transition-all duration-150" onclick="switchTab('daily')">
                    Transaksi Periode Terpilih
                </button>
                <button id="btn-tab-monthly" class="px-4 py-2 rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-150" onclick="switchTab('monthly')">
                    Ringkasan Bulanan Historis
                </button>
            </div>
        </div>

        <!-- TAB CONTENT 1: DAILY TRANSACTION LOGS -->
        <div id="tab-daily" class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Nama Transaksi</th>
                        <th class="px-6 py-4 text-center">Tipe</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dailyTransactions as $tx)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">{{ $tx['tanggal'] }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $tx['nama'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded border 
                                    @if($tx['tipe'] === 'Pemasukan') bg-emerald-50 text-emerald-700 border-emerald-100
                                    @else bg-rose-50 text-rose-700 border-rose-100 @endif">
                                    {{ $tx['tipe'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs">{{ $tx['kategori'] }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400 max-w-[200px] truncate">{{ $tx['keterangan'] }}</td>
                            <td class="px-6 py-4 text-right font-bold {{ $tx['tipe'] === 'Pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx['tipe'] === 'Pemasukan' ? '+' : '-' }}Rp{{ number_format($tx['nominal'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Belum ada aktivitas keuangan harian dalam 30 hari terakhir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TAB CONTENT 2: GROUPED MONTHLY SUMMARIES -->
        <div id="tab-monthly" class="overflow-x-auto hidden">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Periode Bulan</th>
                        <th class="px-6 py-4 text-right text-emerald-600">Total Pendapatan</th>
                        <th class="px-6 py-4 text-right text-rose-600">Total Pengeluaran</th>
                        <th class="px-6 py-4">Beban Detail Kategori (>30 Hari)</th>
                        <th class="px-6 py-4 text-right">Surplus/Defisit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($monthlySummaries as $mKey => $summary)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $summary['label'] }}</td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-600">Rp{{ number_format($summary['pemasukan'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right font-bold text-rose-600">Rp{{ number_format($summary['pengeluaran'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($summary['detail_pengeluaran'] as $cat => $val)
                                        <span class="px-2 py-0.5 text-[10px] bg-slate-100 text-slate-600 rounded-md whitespace-nowrap border border-slate-200/50">
                                            {{ $cat }}: Rp{{ number_format($val, 0, ',', '.') }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-300">Tidak ada rincian pengeluaran</span>
                                    @endforelse
                                </div>
                            </td>
                            @php
                                $diff = $summary['pemasukan'] - $summary['pengeluaran'];
                            @endphp
                            <td class="px-6 py-4 text-right font-bold {{ $diff >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                Rp{{ number_format($diff, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Belum ada data transaksi yang diarsipkan ke ringkasan bulanan (> 30 hari).
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profit & Expenses Chart
            const trendCtx = document.getElementById('profitExpenseChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Keuntungan Bersih (Net Profit)',
                            data: @json($chartNetMargins),
                            backgroundColor: 'rgba(79, 70, 229, 0.15)', 
                            borderColor: 'rgb(79, 70, 229)',
                            borderWidth: 2.5,
                            pointBackgroundColor: 'rgb(79, 70, 229)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Keuntungan Kotor (Income)',
                            data: @json($chartProfits),
                            backgroundColor: 'rgba(16, 185, 129, 0.12)', 
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(16, 185, 129)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Anggaran Beban (Expense)',
                            data: @json($chartExpenses),
                            backgroundColor: 'rgba(244, 63, 94, 0.12)', 
                            borderColor: 'rgb(244, 63, 94)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(244, 63, 94)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 11,
                                    weight: '500'
                                },
                                padding: 15
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 10
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

            // Budget Categories Chart
            const categoryCtx = document.getElementById('categoryBudgetChart').getContext('2d');
            const categoryLabels = @json($catLabels);
            const categoryValues = @json($catValues);

            if (categoryLabels.length === 0) {
                categoryCtx.font = "12px Plus Jakarta Sans";
                categoryCtx.fillStyle = "#94a3b8";
                categoryCtx.textAlign = "center";
                categoryCtx.fillText("Belum ada alokasi budget agenda.", 150, 100);
            } else {
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryValues,
                            backgroundColor: [
                                '#4f46e5', // indigo-600
                                '#059669', // emerald-600
                                '#f59e0b', // amber-500
                                '#ec4899', // pink-500
                                '#06b6d4', // cyan-500
                                '#8b5cf6', // violet-500
                                '#f43f5e'  // rose-500
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    font: {
                                        family: 'Plus Jakarta Sans',
                                        size: 10,
                                        weight: '500'
                                    },
                                    padding: 10
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            // SIMULATOR INTERACTIVE JS LOGIC WITH 50/30/20 SIMULATION
            const initialProfit = {{ $totalGrossProfit }};
            const initialExpense = {{ $totalExpenses }};
            const initialNeeds = {{ $needsExpense }};
            const initialWants = {{ $wantsExpense }};

            const inputSimAmount = document.getElementById('sim-budget-amount');
            const selectSimCategory = document.getElementById('sim-budget-category');
            
            const statusLabel = document.getElementById('sim-result-status');
            const scoreLabel = document.getElementById('sim-result-score');
            const recommendationLabel = document.getElementById('sim-result-recommendation');
            const marginLabel = document.getElementById('sim-result-margin');
            const ratioLabel = document.getElementById('sim-result-ratio');
            const needsLabel = document.getElementById('sim-result-needs');

            function runSimulation() {
                const simValue = parseFloat(inputSimAmount.value) || 0;
                const simCategory = selectSimCategory.value;

                let simNeeds = initialNeeds;
                let simWants = initialWants;

                // Tentukan porsi Needs vs Wants
                if (['Operasional', 'Maintenance'].includes(simCategory)) {
                    simNeeds += simValue;
                } else {
                    simWants += simValue;
                }

                const newExpenses = initialExpense + simValue;
                const newMargin = initialProfit - newExpenses;
                const newRatio = initialProfit > 0 ? (newExpenses / initialProfit) * 100 : (newExpenses > 0 ? 100 : 0);

                const newNeedsPct = initialProfit > 0 ? (simNeeds / initialProfit) * 100 : 0;
                const newWantsPct = initialProfit > 0 ? (simWants / initialProfit) * 100 : 0;

                // Update text values
                marginLabel.innerText = 'Rp ' + Math.round(newMargin).toLocaleString('id-ID');
                ratioLabel.innerText = newRatio.toFixed(1) + '%';
                needsLabel.innerText = newNeedsPct.toFixed(1) + '%';

                // Determine health rating / status
                let status = '';
                let colorClass = '';
                let ratingVal = 0;
                let rec = '';

                if (newMargin >= 0) {
                    if (newRatio < 50) {
                        status = 'Sangat Sehat';
                        colorClass = 'text-emerald-400';
                        ratingVal = 95;
                        rec = 'Arus kas Anda tetap dalam kondisi SANGAT SEHAT. Rasio Needs (' + newNeedsPct.toFixed(0) + '%) dan Wants (' + newWantsPct.toFixed(0) + '%) berada jauh di bawah batas limit ideal budgeting.';
                    } else if (newRatio <= 80) {
                        status = 'Sehat';
                        colorClass = 'text-green-400';
                        ratingVal = 75;
                        rec = 'Arus kas berada pada level STABIL & SEHAT. Rencana budget baru masih selaras dengan kapasitas anggaran bulanan Anda.';
                    } else {
                        status = 'Kurang Sehat';
                        colorClass = 'text-amber-400';
                        ratingVal = 45;
                        rec = 'Rasio pengeluaran melampaui 80% dari laba kotor. Aturan alokasi 50/30/20 mulai melanggar ambang batas aman. Disarankan menunda.';
                    }
                } else {
                    const defectPercentage = initialProfit > 0 ? (Math.abs(newMargin) / initialProfit) * 100 : 100;
                    if (defectPercentage < 20) {
                        status = 'Kurang Sehat (Defisit)';
                        colorClass = 'text-amber-500';
                        ratingVal = 35;
                        rec = 'Rencana ini akan memicu defisit kas operasional ringan. Alokasi Needs (' + newNeedsPct.toFixed(0) + '%) telah memakan habis laba kotor.';
                    } else {
                        status = 'Kritis (Defisit Tinggi)';
                        colorClass = 'text-rose-500';
                        ratingVal = 15;
                        rec = 'TINDAKAN BERBAHAYA! Anggaran baru memicu defisit kas tinggi. Aturan alokasi 50/30/20 dilanggar sepenuhnya. Sangat tidak direkomendasikan.';
                    }
                }

                // Update UI elements
                statusLabel.innerText = status;
                statusLabel.className = 'text-xl font-bold ' + colorClass;
                scoreLabel.innerText = '(Skor: ' + ratingVal + '/100)';
                recommendationLabel.innerText = rec;
            }

            inputSimAmount.addEventListener('input', runSimulation);
            selectSimCategory.addEventListener('change', runSimulation);
        });

        // Tab Switching Logic
        function switchTab(tab) {
            const btnDaily = document.getElementById('btn-tab-daily');
            const btnMonthly = document.getElementById('btn-tab-monthly');
            const tabDaily = document.getElementById('tab-daily');
            const tabMonthly = document.getElementById('tab-monthly');

            if (tab === 'daily') {
                btnDaily.className = 'px-4 py-2 rounded-lg bg-white text-slate-800 shadow-sm transition-all duration-150';
                btnMonthly.className = 'px-4 py-2 rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-150';
                tabDaily.classList.remove('hidden');
                tabMonthly.classList.add('hidden');
            } else {
                btnMonthly.className = 'px-4 py-2 rounded-lg bg-white text-slate-800 shadow-sm transition-all duration-150';
                btnDaily.className = 'px-4 py-2 rounded-lg text-slate-500 hover:text-slate-800 transition-all duration-150';
                tabMonthly.classList.remove('hidden');
                tabDaily.classList.add('hidden');
            }
        }
    </script>
@endsection
