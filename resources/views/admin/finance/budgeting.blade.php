@extends('admin.layouts.app')

@section('title', 'Rencana Budgeting Bulanan')

@section('content')
    <!-- Alerts / Messages -->
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Description -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Perencanaan Anggaran Bulanan</h2>
            <p class="text-sm text-slate-500 mt-1">Definisikan plafon anggaran operasional bulanan bersumber dari ketersediaan saldo kas Anda.</p>
        </div>
        
        <!-- Period Selector form -->
        <form action="{{ route('admin.finance.budgeting') }}" method="GET" class="flex items-center gap-3 bg-white border border-slate-200/80 p-2 rounded-xl shadow-sm self-start">
            <label class="text-xs font-semibold text-slate-500 pl-2">Periode:</label>
            <input type="month" name="periode" value="{{ $selectedMonth }}" 
                   class="bg-slate-50 text-slate-700 text-xs font-bold rounded-lg border border-slate-200/60 p-1.5 focus:outline-none focus:border-emerald-500"
                   onchange="this.form.submit()">
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- BUDGETING FORM CARD (2 Columns) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm relative">
            <h3 class="text-base font-bold text-slate-900 mb-2">Buat Rencana Anggaran Baru</h3>
            <p class="text-xs text-slate-400 mb-6">Tentukan dana yang akan ditarik dari kas dan distribusikan ke setiap kategori pengeluaran.</p>

            <form action="{{ route('admin.finance.storeBudget') }}" method="POST" id="budgetForm" class="space-y-6">
                @csrf
                <!-- Hidden inputs -->
                <input type="hidden" name="periode" value="{{ $selectedMonth }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50 p-5 rounded-2xl border border-slate-100 mb-6">
                    <!-- Cash Vault (Kas Tersedia) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">1. Saldo Kas Kumulatif (Kas Awal)</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-xs font-semibold">Rp</span>
                            </div>
                            <input type="number" name="total_kas" id="total_kas" value="{{ $calculatedCash }}" readonly
                                   class="w-full bg-slate-100 text-slate-700 font-bold border border-slate-200/60 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none">
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1.5 block">Dihitung otomatis dari total surplus laba sebelum {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}.</span>
                    </div>

                    <!-- Target Allocation Limit (Anggaran Rencana) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">2. Tarik Dana Anggaran Bulan Ini</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="text-slate-500 text-xs font-bold">Rp</span>
                            </div>
                            <input type="number" name="alokasi_anggaran" id="alokasi_anggaran" value="{{ old('alokasi_anggaran', $currentBudget ? (int)$currentBudget->alokasi_anggaran : 0) }}" required
                                   class="w-full bg-white text-slate-900 font-bold border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1.5 block">Total kas maksimal yang diizinkan untuk digunakan di periode ini.</span>
                    </div>

                    <!-- Remaining Cash Assets (Sisa Saldo Kas Utama) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">3. Sisa Saldo Kas Utama</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="text-slate-400 text-xs font-semibold">Rp</span>
                            </div>
                            <input type="text" id="sisa_kas_utama" readonly
                                   class="w-full bg-slate-100 text-slate-700 font-bold border border-slate-200/60 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none">
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1.5 block">Sisa saldo aset kas setelah dikurangi rencana anggaran bulan ini.</span>
                    </div>
                </div>

                <!-- CATEGORIES ALLOCATIONS SPLIT -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">3. Pembagian Kategori Anggaran</h4>
                        <span id="allocation-checker" class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                            Terdistribusi: Rp0 / Rp0
                        </span>
                    </div>

                    <div id="allocation-limit-alert" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-xs px-4 py-2.5 rounded-xl">
                        ⚠️ Total pembagian kategori melebihi total dana anggaran yang ditarik!
                    </div>

                    <div class="divide-y divide-slate-100/60 max-h-[300px] overflow-y-auto pr-1">
                        @foreach($categories as $index => $cat)
                            @php
                                $existingAlloc = $currentAllocations->get($cat->id);
                                $nominalLimit = $existingAlloc ? (int)$existingAlloc->nominal_limit : 0;
                                $catatan = $existingAlloc ? $existingAlloc->catatan : '';
                            @endphp
                            <div class="py-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                <div>
                                    <span class="font-bold text-sm text-slate-800 block">{{ $cat->nama }}</span>
                                    <span class="text-[10px] text-slate-400">
                                        @if(in_array($cat->nama, ['Operasional', 'Gaji Karyawan', 'Maintenance']))
                                            Kebutuhan Dasar (Needs)
                                        @else
                                            Rencana Belanja (Wants)
                                        @endif
                                    </span>
                                </div>

                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-xs">Rp</span>
                                    </div>
                                    <input type="hidden" name="allocations[{{ $index }}][jenis_schedule_id]" value="{{ $cat->id }}">
                                    <input type="number" name="allocations[{{ $index }}][nominal_limit]" id="alloc-limit-{{ $index }}" value="{{ old('allocations.'.$index.'.nominal_limit', $nominalLimit) }}"
                                           class="alloc-input w-full bg-white text-slate-800 border border-slate-200 rounded-xl py-2 px-8 text-xs focus:outline-none focus:border-emerald-500" placeholder="0">
                                </div>

                                <div>
                                    <input type="text" name="allocations[{{ $index }}][catatan]" value="{{ old('allocations.'.$index.'.catatan', $catatan) }}" placeholder="Catatan singkat (opsional)" 
                                           class="w-full bg-slate-50 text-slate-600 border border-slate-200/60 rounded-xl py-2 px-3 text-xs focus:outline-none focus:border-emerald-500">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <div class="text-xs text-slate-400">
                        Periode aktif: <span class="font-semibold text-slate-600">{{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}</span>
                    </div>
                    <button type="submit" id="btnSubmitBudget" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl transition duration-150 shadow-md shadow-emerald-500/10">
                        Simpan Rencana Budget
                    </button>
                </div>
            </form>
        </div>

        <!-- HISTORICAL SAVED BUDGETS (1 Column) -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 mb-1">Budget Tersimpan</h3>
                <p class="text-xs text-slate-400 mb-6">Daftar rencana budgeting bulanan yang sudah disahkan sebelumnya.</p>
                
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-1">
                    @forelse($savedBudgets as $budget)
                        <!-- Stored Budget Item -->
                        <div class="border border-slate-100 rounded-xl p-4 bg-slate-50/50 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-700 uppercase">
                                    {{ \Carbon\Carbon::parse($budget->periode.'-01')->translatedFormat('F Y') }}
                                </span>
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded">
                                    Aktif
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-y-1.5 text-xs text-slate-500 mb-3 border-b border-slate-200/40 pb-2">
                                <div>Saldo Awal Kas:</div>
                                <div class="font-semibold text-slate-800 text-right">Rp{{ number_format($budget->total_kas, 0, ',', '.') }}</div>
                                <div>Total Anggaran:</div>
                                <div class="font-bold text-emerald-600 text-right">Rp{{ number_format($budget->alokasi_anggaran, 0, ',', '.') }}</div>
                                <div>Sisa Saldo Kas:</div>
                                <div class="font-bold text-slate-800 text-right">Rp{{ number_format($budget->total_kas - $budget->alokasi_anggaran, 0, ',', '.') }}</div>
                            </div>

                            <!-- Budget allocations nested list -->
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pembagian Kategori:</span>
                                @foreach($budget->allocations as $alloc)
                                    <div class="flex justify-between items-center text-[11px] text-slate-500">
                                        <span>• {{ $alloc->jenisSchedule->nama ?? 'Umum' }}</span>
                                        <span class="font-bold text-slate-700">Rp{{ number_format($alloc->nominal_limit, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 text-xs">
                            <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 00-2 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Belum ada rencana budget yang disimpan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Client-side Calculation & Validation Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputAllocationLimit = document.getElementById('alokasi_anggaran');
            const totalKasInput = document.getElementById('total_kas');
            const inputs = document.querySelectorAll('.alloc-input');
            const checker = document.getElementById('allocation-checker');
            const alertBox = document.getElementById('allocation-limit-alert');
            const submitBtn = document.getElementById('btnSubmitBudget');

            function calculateTotals() {
                const maxBudget = parseFloat(inputAllocationLimit.value) || 0;
                const totalKas = parseFloat(totalKasInput.value) || 0;
                let allocatedSum = 0;

                inputs.forEach(input => {
                    allocatedSum += parseFloat(input.value) || 0;
                });

                // Calculate remaining cash assets
                const remainingCash = totalKas - maxBudget;
                const remainingCashInput = document.getElementById('sisa_kas_utama');
                
                if (remainingCash < 0) {
                    remainingCashInput.value = '-' + Math.abs(remainingCash).toLocaleString('id-ID');
                    remainingCashInput.className = 'w-full bg-rose-50 text-rose-600 font-bold border border-rose-200 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none';
                } else {
                    remainingCashInput.value = remainingCash.toLocaleString('id-ID');
                    remainingCashInput.className = 'w-full bg-slate-100 text-slate-700 font-bold border border-slate-200/60 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none';
                }

                // Update text
                checker.innerText = 'Terdistribusi: Rp ' + allocatedSum.toLocaleString('id-ID') + ' / Rp ' + maxBudget.toLocaleString('id-ID');

                // Validation indicators
                if (allocatedSum > maxBudget) {
                    alertBox.classList.remove('hidden');
                    checker.className = 'text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-lg border border-rose-100';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    alertBox.classList.add('hidden');
                    checker.className = 'text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg';
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Check monthly limit against overall reserves
                if (maxBudget > totalKas) {
                    inputAllocationLimit.classList.add('border-rose-400');
                    inputAllocationLimit.classList.remove('border-slate-200');
                } else {
                    inputAllocationLimit.classList.remove('border-rose-400');
                    inputAllocationLimit.classList.add('border-slate-200');
                }
            }

            inputAllocationLimit.addEventListener('input', calculateTotals);
            inputs.forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Initial trigger
            calculateTotals();
        });
    </script>
@endsection
