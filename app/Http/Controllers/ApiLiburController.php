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
        // Panggil API hari libur
        $response = Http::get('https://api-harilibur.vercel.app/api');
        // if ($response->successful()) {
        //     $data = $response->json();
        //     dd($data); // Debug hasilnya
        // } else {
        //     dd($response->status(), $response->body()); // Cek error code
        // }

        // Konversi ke array
        $holidays = $response->json();

        // Simpan ke database
        foreach ($holidays as $holiday) {
            ApiLibur::updateOrCreate(
                ['date' => $holiday['holiday_date']], // Gunakan tanggal sebagai unique key
                ['name' => $holiday['holiday_name']],
            );
        }

        return response()->json(['message' => 'Holidays updated successfully']);
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
