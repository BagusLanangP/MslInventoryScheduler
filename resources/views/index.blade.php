@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')
<div class="relative mt-10 bg-cover bg-center" style="height: 100vh;">
    <!-- Gambar dengan efek blur -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/toko.png') }}'); filter: blur(5px);"></div>
    
    <!-- Overlay untuk memberikan efek gelap -->
    <div class="absolute inset-0 bg-black opacity-30"></div>

    <!-- Konten lainnya -->
    
    
    <section class="relative mt-14 max-w-4xl mx-auto p-14   rounded-lg shadow-md px-4">

        <div class="mt-14 bg-white bg-opacity-30 backdrop-blur-lg p-4 rounded-lg">
            <div class="flex justify-center">
                <img src="/img/logo.png" alt="Logo" class="h-24 w-auto">
            </div>
            <div class="flex justify-center">
                <img src="/img/font.png" alt="Logo" class="h-24 w-auto">
            </div>
            <hr class="mt-2">
            <div class="flex justify-center">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mt-4 text-white">Fitur Utama</h3>
                </div>
                <ul class="list-disc ml-6 mt-2 text-gray-600 text-white">
                    <li>Manajemen Inventaris yang Akurat</li>
                    <li>Penjadwalan Karyawan dan Operasional</li>
                    <li>Laporan Analitik dan Statistik</li>
                    <li>Notifikasi untuk Stok Barang Habis</li>
                </ul>
            </div>
            <div class="mt-8 flex justify-center mb-4">
                <button>
                    <a href="/schedule" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4 mr-2">Lihat Jadwal</a>
                </button>
                <button>
                    <a href="/schedule" class="bg-green-500 text-white px-4 py-2 rounded-md mt-4">dashboard</a>
                </button>
            </div>
        </div>
        

        
        
    </section>
</div>

    </div>

    


@endsection