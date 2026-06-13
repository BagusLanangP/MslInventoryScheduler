<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\DailyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->filled('periode') ? $request->periode : Carbon::now()->format('Y-m');

        $payrolls = Payroll::with('employee')->where('periode', $periode)->get();

        $generatedEmployeeIds = $payrolls->pluck('employee_id')->toArray();
        $missingEmployeesCount = Employee::whereNotIn('id', $generatedEmployeeIds)->count();

        $totalPaid = floatval($payrolls->where('status_pembayaran', 'dibayar')->sum('total_diterima'));
        $totalPending = floatval($payrolls->where('status_pembayaran', 'pending')->sum('total_diterima'));
        $totalCost = $totalPaid + $totalPending;

        return view('admin.payroll.index', compact('payrolls', 'periode', 'missingEmployeesCount', 'totalPaid', 'totalPending', 'totalCost'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'periode' => 'required|string|regex:/^\d{4}-\d{2}$/',
        ]);

        $periode = $request->periode;
        $employees = Employee::all();
        $generatedCount = 0;

        foreach ($employees as $emp) {
            $exists = Payroll::where('employee_id', $emp->id)
                ->where('periode', $periode)
                ->exists();

            if (!$exists) {
                Payroll::create([
                    'employee_id' => $emp->id,
                    'periode' => $periode,
                    'gaji_pokok' => $emp->gaji_pokok,
                    'tunjangan' => $emp->tunjangan ?? 0,
                    'potongan_kasbon' => $emp->potongan_kasbon ?? 0,
                    'total_diterima' => $emp->gaji_pokok + ($emp->tunjangan ?? 0) - ($emp->potongan_kasbon ?? 0),
                    'status_pembayaran' => 'pending',
                ]);
                $generatedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil men-generate {$generatedCount} slip gaji untuk periode {$periode}!");
    }

    public function updateDetails(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        if ($payroll->status_pembayaran === 'dibayar') {
            return redirect()->back()->with('error', 'Gaji yang sudah dibayar tidak dapat diedit!');
        }

        $request->validate([
            'tunjangan' => 'required|numeric|min:0',
            'potongan_kasbon' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
        ]);

        $gaji_pokok = floatval($payroll->gaji_pokok);
        $tunjangan = floatval($request->tunjangan);
        $potongan_kasbon = floatval($request->potongan_kasbon);
        $total_diterima = $gaji_pokok + $tunjangan - $potongan_kasbon;

        $payroll->update([
            'tunjangan' => $tunjangan,
            'potongan_kasbon' => $potongan_kasbon,
            'total_diterima' => $total_diterima,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Rincian gaji berhasil diperbarui!');
    }

    public function pay(Request $request, $id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);

        if ($payroll->status_pembayaran === 'dibayar') {
            return redirect()->back()->with('error', 'Gaji ini sudah dibayar sebelumnya!');
        }

        $payroll->update([
            'status_pembayaran' => 'dibayar',
            'tanggal_dibayar' => Carbon::today()->toDateString(),
        ]);

        DailyTransaction::create([
            'tanggal' => Carbon::today()->toDateString(),
            'nama' => 'Pembayaran Gaji Karyawan - ' . $payroll->employee->nama . ' (Periode ' . $payroll->periode . ')',
            'tipe' => 'pengeluaran',
            'kategori' => 'Operasional',
            'nominal' => $payroll->total_diterima,
            'sumber' => 'manual',
            'keterangan' => 'Gaji Pokok: Rp' . number_format($payroll->gaji_pokok, 0, ',', '.') . 
                            ', Tunjangan: Rp' . number_format($payroll->tunjangan, 0, ',', '.') . 
                            ', Potongan: Rp' . number_format($payroll->potongan_kasbon, 0, ',', '.') . '.',
        ]);

        return redirect()->back()->with('success', 'Gaji berhasil dibayar dan otomatis terdaftar sebagai pengeluaran operasional!');
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);

        if ($payroll->status_pembayaran === 'dibayar') {
            return redirect()->back()->with('error', 'Gaji yang sudah dibayar tidak dapat dihapus!');
        }

        $payroll->delete();

        return redirect()->back()->with('success', 'Slip gaji berhasil dihapus.');
    }
}
