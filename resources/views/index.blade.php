@extends('layouts.index')

@section('tittle', 'homepage')
@section('content')
    <header class="text-center mt-10 px-4">
        <h1 class="text-4xl font-bold text-blue-700">Selamat Datang di Sistem Inventaris & Penjadwalan Toko</h1>
        <p class="text-lg text-gray-700 mt-2">Membantu Anda mengelola inventaris dan jadwal operasional dengan lebih mudah dan efisien.</p>
    </header>
    
    <section class="mt-10 max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md px-4">
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


@endsection