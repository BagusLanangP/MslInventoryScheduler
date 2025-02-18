@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')
<div class="relative bg-cover bg-center" style="height: 100vh;">
    <!-- Gambar dengan efek blur -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/toko.png') }}'); filter: blur(8px);"></div>
    
    <!-- Overlay untuk memberikan efek gelap -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Konten lainnya -->
    <header class="relative text-center px-4">
        <h1 class="text-lg text-white text-gray-700">Membantu Anda mengelola inventaris dan jadwal operasional dengan lebih mudah dan efisien.</h1>
    </header>
    
    <section class="relative mt-10 max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md px-4">
        <h2 class="text-2xl font-semibold text-gray-800">Tentang Sistem Ini</h2>
        <p class="mt-2 text-gray-600">
            Sistem ini dirancang untuk membantu pemilik toko dalam mengelola stok barang serta penjadwalan operasional dan karyawan. 
            Dengan fitur otomatisasi, Anda dapat memonitor stok secara real-time, mengatur jadwal kerja, serta menganalisis laporan inventaris.
        </p>
        <h3 class="text-xl font-semibold text-gray-800 mt-4">Fitur Utama</h3>
        <ul class="list-disc ml-6 mt-2 text-gray-600">
            <li>Manajemen Inventaris yang Akurat</li>
            <li>Penjadwalan Karyawan dan Operasional</li>
            <li>Laporan Analitik dan Statistik</li>
            <li>Notifikasi untuk Stok Barang Habis</li>
        </ul>
    </section>
</div>

    </div>

    


@endsection