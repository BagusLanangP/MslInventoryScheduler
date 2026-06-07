<?php

namespace App\Http\Controllers;

use App\Models\ApiLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ApiLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('test');
    }

    public function fetchHolidays()
    {
        // Panggil API hari libur yang aktif
        $response = Http::get('https://api-hari-libur.vercel.app/api');

        if (!$response->successful()) {
            return response()->json(['success' => false, 'error' => 'Gagal mengambil data dari API hari libur.'], 500);
        }

        // Konversi ke array data
        $body = $response->json();
        $holidays = $body['data'] ?? [];

        // Simpan ke database
        foreach ($holidays as $holiday) {
            ApiLibur::updateOrCreate(
                ['date' => $holiday['date']], // Gunakan tanggal sebagai unique key
                ['name' => $holiday['description']],
            );
        }

        // Ambil semua hari libur yang ter-update
        $allHolidays = ApiLibur::orderBy('date', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Hari libur berhasil disinkronisasi!',
            'data' => $allHolidays
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiLibur $apiLibur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiLibur $apiLibur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiLibur $apiLibur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiLibur $apiLibur)
    {
        //
    }
}
