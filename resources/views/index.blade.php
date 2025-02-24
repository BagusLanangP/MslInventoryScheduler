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
        <div class="text-5xl font-semibold text-white text-white ">
            Selamat Datang Admin!
        </div>

        <div class="mt-14 bg-white bg-opacity-30 p-4 rounded-lg">
            <p class="text-white">
                Sistem ini dirancang untuk membantu pemilik toko dalam mengelola stok barang serta penjadwalan operasional dan karyawan. 
                Dengan fitur otomatisasi, Anda dapat memonitor stok secara real-time, mengatur jadwal kerja, serta menganalisis laporan inventaris.
            </p>
            <h3 class="text-xl font-semibold text-gray-800 mt-4 text-white">Fitur Utama</h3>
            <ul class="list-disc ml-6 mt-2 text-gray-600 text-white">
                <li>Manajemen Inventaris yang Akurat</li>
                <li>Penjadwalan Karyawan dan Operasional</li>
                <li>Laporan Analitik dan Statistik</li>
                <li>Notifikasi untuk Stok Barang Habis</li>
            </ul>
        </div>
        <div class="mt-8 flex justify-end">
            <button>
                <a href="/schedule" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Lihat Jadwal</a>
            </button>
        </div>
        
        
    </section>
</div>

    </div>

    


@endsection