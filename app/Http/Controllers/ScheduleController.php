<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ApiLibur;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSchedule = Schedule::all();
        return view('schedule.index', compact('dataSchedule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataApi = ApiLibur::pluck('name', 'date');
        return view('schedule.create', compact('dataApi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'berulang' => 'required|in:0,1', // Ubah validasi agar menerima 0 atau 1
            'reminder_date' => 'required|date|after_or_equal:date',
        ]);

        // Simpan data ke database
        Schedule::create([
            'name' => $request->name,
            'date' => $request->date,
            'note' => $request->note,
            'berulang' => $request->berulang,
            'reminder_date' => $request->reminder_date,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Schedule berhasil disimpan!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
