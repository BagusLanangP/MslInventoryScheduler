@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    
    <!-- Alert Messages -->
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Welcome Greeting Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
        <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan status operasional dan inventaris sistem Anda hari ini.</p>
    </div>

    <!-- Responsive Stats Widgets Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Users Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Total Users</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $userCount }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        <!-- Schedule Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Jadwal Selesai</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $completedSchedule }} <span class="text-sm font-medium text-slate-400">/ {{ $totalSchedule }}</span></h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Jenis Barang Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Jenis Barang</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $jenisBarangs }}</h3>
            </div>
            <div class="p-3 bg-amber-50 text-amber-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" />
                </svg>
            </div>
        </div>

        <!-- Supplier Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Total Supplier</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $supplier }}</h3>
            </div>
            <div class="p-3 bg-rose-50 text-rose-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Inventory Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Item Inventory</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $Inventory }}</h3>
            </div>
            <div class="p-3 bg-sky-50 text-sky-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <!-- Messages Widget -->
        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between group">
            <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-400">Pesan Masuk</p>
                <h3 class="text-2xl font-bold text-slate-900">30</h3>
            </div>
            <div class="p-3 bg-teal-50 text-teal-500 rounded-2xl group-hover:scale-110 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- Financial Analytics Dashboard -->
    <div class="mt-8 space-y-6">
        <!-- Analytics Title -->
        <div>
            <h3 class="text-lg font-bold text-slate-900">Analisis Keuangan & Anggaran</h3>
            <p class="text-xs text-slate-500 mt-1">Pemantauan keuntungan barang dan pengeluaran operasional secara real-time.</p>
        </div>

        <!-- Financial Widgets Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Saldo Kas Utama Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-5 rounded-2xl shadow-sm border border-slate-700 relative overflow-hidden flex items-center gap-4">
                <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="p-3 bg-emerald-500/20 text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Saldo Kas Utama</p>
                    <h4 class="text-lg font-bold text-white mt-0.5 truncate">Rp{{ number_format($totalCashPool, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Profits Card -->
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-emerald-100 transition-colors">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 11h2m0 0h2m-4 1a3 3 0 013 3M12 11a3 3 0 00-3-3" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Untung Bulanan</p>
                    <h4 class="text-lg font-bold text-slate-900 mt-0.5 truncate">Rp{{ number_format($totalGrossProfit, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-rose-100 transition-colors">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Beban Anggaran</p>
                    <h4 class="text-lg font-bold text-slate-900 mt-0.5 truncate">Rp{{ number_format($totalExpenses, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Net Margin Card -->
            <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex items-center gap-4 group hover:border-blue-100 transition-colors">
                @php
                    $netMargin = $totalGrossProfit - $totalExpenses;
                    $isPositive = $netMargin >= 0;
                @endphp
                <div class="p-3 rounded-xl group-hover:scale-110 transition-transform {{ $isPositive ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Keuntungan Bersih</p>
                    <h4 class="text-lg font-bold mt-0.5 truncate {{ $isPositive ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp{{ number_format($netMargin, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line/Bar Chart (Profits vs Expenses) -->
            <div class="lg:col-span-2 bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Tren Bulanan Keuntungan & Pengeluaran</h4>
                <div class="h-64 relative">
                    <canvas id="profitExpenseChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart (Categories Budget) -->
            <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Distribusi Budget Agenda Kategori</h4>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="categoryBudgetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert / Critical Tables -->
    <div class="space-y-8 mt-8">
        
        <!-- Table 1: Stok Mendekati Expired -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-rose-50/40 border-b border-slate-200/60 flex items-center gap-3">
                <span class="p-2 bg-rose-100 text-rose-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <div>
                    <h4 class="text-base font-bold text-slate-900">Peringatan Kadaluarsa</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Stok barang yang akan kadaluarsa dalam waktu kurang dari 7 hari.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Tanggal Expired</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($expiredSoon as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->nama }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100 rounded-lg">
                                        {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <a href="{{ route('inventory.edit', $item->id) }}" class="px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                                        Perbarui
                                    </a>
                                    <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tidak ada stok barang mendekati tanggal kadaluarsa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 2: Schedule Terdekat -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-emerald-50/40 border-b border-slate-200/60 flex items-center gap-3">
                <span class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <h4 class="text-base font-bold text-slate-900">Jadwal Mendatang (7 hari)</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Jadwal kegiatan atau agenda yang direncanakan dalam minggu ini.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Kegiatan</th>
                            <th class="px-6 py-4">Tanggal Pelaksanaan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($ScheduleinWeek as $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('schedule.edit', $item->id) }}" class="px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                                        Edit Jadwal
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Tidak ada jadwal mendesak dalam minggu ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 3: User List -->
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-indigo-50/40 border-b border-slate-200/60 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-indigo-100 text-indigo-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Daftar Pengguna Sistem</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Pengguna yang memiliki otorisasi akses ke dasbor admin.</p>
                    </div>
                </div>
                @if(Auth::user() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-sm">
                    Tambah User
                </a>
                @endif
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 w-[10%]">No</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Dibuat Pada</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $index => $user)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profit & Expenses Chart
            const trendCtx = document.getElementById('profitExpenseChart').getContext('2d');
            const trendLabels = @json($chartLabels);
            const profitData = @json($chartProfits);
            const expenseData = @json($chartExpenses);
            const netMarginData = @json($chartNetMargins);
 
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [
                        {
                            label: 'Keuntungan Bersih',
                            data: netMarginData,
                            backgroundColor: 'rgba(79, 70, 229, 0.15)', // indigo-600
                            borderColor: 'rgb(79, 70, 229)',
                            borderWidth: 2.5,
                            pointBackgroundColor: 'rgb(79, 70, 229)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Keuntungan Kotor',
                            data: profitData,
                            backgroundColor: 'rgba(16, 185, 129, 0.12)', // emerald-500
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(16, 185, 129)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Pengeluaran Anggaran',
                            data: expenseData,
                            backgroundColor: 'rgba(244, 63, 94, 0.12)', // rose-500
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
                // If no budget data is available
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
                                '#8b5cf6'  // violet-500
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
        });
    </script>
    
@endsection
