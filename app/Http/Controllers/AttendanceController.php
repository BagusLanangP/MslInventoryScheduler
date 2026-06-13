<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = null;
        $todayAttendance = null;

        // If not admin, check if employee record exists for user
        if ($user->role !== 'admin') {
            $employee = Employee::where('user_id', $user->id)->first();
            if ($employee) {
                $todayAttendance = Attendance::where('employee_id', $employee->id)
                    ->where('tanggal', Carbon::today()->toDateString())
                    ->first();
            }
        }

        // Rekap absensi for Admin
        $attendancesQuery = Attendance::with('employee');

        if ($request->filled('tanggal')) {
            $attendancesQuery->where('tanggal', $request->tanggal);
        } else {
            $attendancesQuery->where('tanggal', Carbon::today()->toDateString());
        }

        if ($request->filled('employee_id')) {
            $attendancesQuery->where('employee_id', $request->employee_id);
        }

        $allEmployees = Employee::all();
        $attendances = $attendancesQuery->orderBy('created_at', 'desc')->get();

        return view('admin.attendance.index', compact('employee', 'todayAttendance', 'attendances', 'allEmployees'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $existing = Attendance::where('employee_id', $employee->id)
            ->where('tanggal', Carbon::today()->toDateString())
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi masuk hari ini!');
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => Carbon::now()->toTimeString(),
            'status' => 'hadir',
            'keterangan' => $request->keterangan ?? 'Hadir tepat waktu',
        ]);

        return redirect()->back()->with('success', 'Berhasil melakukan absen masuk!');
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('tanggal', Carbon::today()->toDateString())
            ->firstOrFail();

        if ($attendance->jam_keluar) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi pulang hari ini!');
        }

        $attendance->update([
            'jam_keluar' => Carbon::now()->toTimeString(),
        ]);

        return redirect()->back()->with('success', 'Berhasil melakukan absen pulang!');
    }
}
