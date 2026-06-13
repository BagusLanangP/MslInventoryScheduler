<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('departemen', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $assignedUserIds = Employee::whereNotNull('user_id')->pluck('user_id')->toArray();
        $availableUsers = User::whereNotIn('id', $assignedUserIds)->get();
        return view('admin.employees.create', compact('availableUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:255|unique:employees,nip',
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan_kasbon' => 'nullable|numeric|min:0',
            'status_karyawan' => 'required|string|in:kontrak,tetap,magang',
            'tanggal_masuk' => 'required|date',
            'user_id' => 'nullable|exists:users,id|unique:employees,user_id',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'rekening_bank' => 'nullable|string|max:255',
        ]);

        $data = $request->except('berkas');

        if ($request->hasFile('berkas')) {
            $path = $request->file('berkas')->store('contracts', 'public');
            $data['berkas'] = $path;
        }

        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        
        $assignedUserIds = Employee::whereNotNull('user_id')
            ->where('id', '!=', $id)
            ->pluck('user_id')
            ->toArray();
            
        $availableUsers = User::whereNotIn('id', $assignedUserIds)->get();
        
        return view('admin.employees.create', compact('employee', 'availableUsers'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'nip' => 'required|string|max:255|unique:employees,nip,' . $id,
            'nama' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan_kasbon' => 'nullable|numeric|min:0',
            'status_karyawan' => 'required|string|in:kontrak,tetap,magang',
            'tanggal_masuk' => 'required|date',
            'user_id' => 'nullable|exists:users,id|unique:employees,user_id,' . $id,
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'rekening_bank' => 'nullable|string|max:255',
        ]);

        $data = $request->except('berkas');

        if ($request->hasFile('berkas')) {
            if ($employee->berkas) {
                Storage::disk('public')->delete($employee->berkas);
            }
            $path = $request->file('berkas')->store('contracts', 'public');
            $data['berkas'] = $path;
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        
        if ($employee->berkas) {
            Storage::disk('public')->delete($employee->berkas);
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}
