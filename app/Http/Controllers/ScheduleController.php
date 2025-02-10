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
        //
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
