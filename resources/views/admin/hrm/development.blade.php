@extends('admin.layouts.app')

@section('title', 'Fitur Dalam Pengembangan')

@section('content')
    <div class="min-h-[70vh] flex flex-col justify-center items-center px-4 text-center">
        <!-- Glowing Ambient Background Deco -->
        <div class="w-64 h-64 bg-emerald-500/10 blur-[80px] rounded-full absolute pointer-events-none"></div>

        <div class="relative z-10 max-w-md mx-auto space-y-6">
            <!-- Icon Construction -->
            <div class="mx-auto w-24 h-24 bg-emerald-50 border border-emerald-100 rounded-3xl flex items-center justify-center shadow-md animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-emerald-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.67 2.67 0 1113.5 22.5l-5.83-5.83M11.42 15.17l2.42-2.42M11.42 15.17L7 21H3v-4l5.83-5.83M13.84 12.75l2.42-2.42m0 0L21 15v4h-4l-5.83-5.83m5.83-5.83L15.17 7M15.17 7l-2.42-2.42m0 0L15 3h4v4l-5.83 5.83M12.75 4.58L10.33 7m0 0L7 3.5m3.33 3.5L8.5 11.42" />
                </svg>
            </div>

            <!-- Heading -->
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Fitur Dalam Pengembangan</h2>
                <span class="inline-block px-3 py-1 bg-amber-50 border border-amber-100 text-amber-700 text-[10px] font-bold uppercase rounded-xl tracking-wider">
                    Under Development (Dev Mode)
                </span>
            </div>

            <!-- Description -->
            <p class="text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
                Modul Kepegawaian & Gaji (HRM & Payroll) saat ini sedang dalam tahap uji coba internal dan dinonaktifkan sementara demi alasan keamanan data.
            </p>

            <!-- Back CTA -->
            <div class="pt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-950 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition shadow-md shadow-slate-950/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>
@endsection
