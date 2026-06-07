@extends('layouts.index')

@section('title', 'Homepage')

@section('content')
<div class="relative min-h-screen py-24 px-4 flex flex-col justify-center items-center">
    
    <!-- Background blurred store image with high visibility (opacity) and blur to prevent white edge artifacts -->
    <div class="fixed inset-0 bg-cover bg-center -z-20" style="background-image: url('{{ asset('img/toko.png') }}'); filter: blur(12px); transform: scale(1.1); opacity: 0.95;"></div>
    
    <!-- Soft bright light-emerald backdrop gradient layer with lower opacity to let the store image show through clearly -->
    <div class="fixed inset-0 bg-gradient-to-tr from-white/45 via-white/30 to-emerald-50/20 -z-10"></div>

    <!-- Hero Section -->
    <section class="max-w-4xl w-full mx-auto relative z-10 space-y-10">

        <!-- Intro Card (Light Glassmorphic Theme) -->
        <div class="bg-white/80 backdrop-blur-2xl border border-white/60 p-8 sm:p-12 rounded-3xl shadow-xl">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-emerald-50 border border-emerald-100 rounded-3xl flex items-center justify-center shadow-md mb-6">
                    <img src="/img/logo.png" alt="Logo" class="h-12 w-auto">
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-none">
                    MSL Inventory <span class="text-emerald-600">&</span> Scheduler
                </h1>
                <p class="text-sm sm:text-base text-slate-500 mt-3 max-w-xl mx-auto font-medium">
                    Sistem penjadwalan terintegrasi dan pelacakan inventaris gudang yang akurat untuk efisiensi bisnis Anda.
                </p>

                <!-- Divider -->
                <div class="w-full border-t border-slate-200/60 my-8"></div>

                <!-- Main Features Grid -->
                <div class="text-left w-full max-w-2xl mx-auto space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-3 text-center sm:text-left">Fitur Utama Sistem</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 bg-white/40 border border-white/50 p-4 rounded-2xl shadow-sm">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700 font-semibold">Manajemen Inventaris</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/40 border border-white/50 p-4 rounded-2xl shadow-sm">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700 font-semibold">Penjadwalan & Hari Libur</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/40 border border-white/50 p-4 rounded-2xl shadow-sm">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700 font-semibold">Laporan Analitik</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/40 border border-white/50 p-4 rounded-2xl shadow-sm">
                            <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </span>
                            <span class="text-sm text-slate-700 font-semibold">Notifikasi Expired Email</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4 w-full sm:w-auto">
                    <a href="/schedule" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-semibold rounded-2xl shadow-lg shadow-emerald-500/20 transition duration-150 transform hover:-translate-y-0.5 text-center">
                        Lihat Jadwal
                    </a>
                    <a href="/admin/dashboard" class="w-full sm:w-auto px-8 py-3.5 bg-white/80 hover:bg-white text-emerald-700 border border-emerald-200 hover:border-emerald-300 font-semibold rounded-2xl shadow-md transition duration-150 transform hover:-translate-y-0.5 text-center">
                        Masuk Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Live System Statistics Card (Light Glassmorphic Theme) -->
        <div class="bg-white/80 backdrop-blur-2xl border border-white/60 p-8 sm:p-12 rounded-3xl shadow-xl text-center">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Statistik Sistem Terkini</h2>  
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto">
                
                <!-- Supplier Stats Widget -->
                <div class="bg-white/50 border border-white/60 p-6 rounded-2xl flex flex-col items-center shadow-sm hover:shadow-md transition duration-150">
                    <span class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Supplier</h3>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $totalSuppliers }}</p>
                </div>

                <!-- Inventory Stats Widget -->
                <div class="bg-white/50 border border-white/60 p-6 rounded-2xl flex flex-col items-center shadow-sm hover:shadow-md transition duration-150">
                    <span class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" />
                        </svg>
                    </span>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Inventory</h3>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $totalInventory }}</p>
                </div>

            </div>
        </div>
        
    </section>
</div>
@endsection