<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\JenisBarang;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.createSupplier', compact('suppliers'));
    }

    public function create()
    {
        $JenisBarangs = JenisBarang::all();
        return view('admin.createSupplier', compact('JenisBarangs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email',
            'catatan' => 'nullable|string',
            'dari_tanggal' => 'required|date',
            'status_aktif' => 'boolean',
            'jenis_barang_id' => 'required'
        ]);
        Supplier::create([
            'nama' => $request->nama,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'email' => $request->email,
            'catatan' => $request->catatan,
            'dari_tanggal' => $request->dari_tanggal,
            'status_aktif' => true,
            'jenis_barang_id' => $request->jenis_barang_id,
        ]);

        

        // Supplier::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email',
            'catatan' => 'nullable|string',
            'dari_tanggal' => 'required|date',
            'status_aktif' => 'boolean',
            'jenis_barang' => 'required|string'
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus');
    }
}