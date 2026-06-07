<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\JenisBarang;


class SupplierController extends Controller
{
    // public function index(Request $request) 
    // {
    //     $query = Supplier::with('jenisBarang'); // Perbaiki nama relasi!

    //     if ($request->filled('jenis')) {
    //         $query->where('jenis_barang_id', $request->jenis);
    //     }
    //     // $data = $query->get();
    //     $data = $query->get(); // satu query saja
    //     $JenisBarangs = JenisBarang::all(); // untuk isi dropdown filter
    //     dd($JenisBarangs);

    //     return view('admin.Supplier.index', compact('data', 'JenisBarangs'));
    // }

    public function index(Request $request)
    {
        $query = Supplier::with(['jenisBarang']);

        
        if ($request->filled('jenis')) {
            $query->where('jenis_barang_id', $request->jenis); // ✅ Benar
        }

        $data = $query->get();
        $JenisBarangs = JenisBarang::all();
        $suppliers = Supplier::with(['jenisBarang'])->get();
        return view('admin.Supplier.index', compact('suppliers', 'data', 'JenisBarangs'));
    }

    public function create()
    {
        $JenisBarangs = JenisBarang::all();
        return view('admin.createSupplier', compact('JenisBarangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email',
            'catatan' => 'nullable|string',
            'dari_tanggal' => 'required|date',
            'status_aktif' => 'boolean',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'nullable|string|max:500',
            'pic' => 'nullable|string|max:255',
        ]);
        Supplier::create([
            'nama' => $request->nama,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'email' => $request->email,
            'catatan' => $request->catatan,
            'dari_tanggal' => $request->dari_tanggal,
            'status_aktif' => true,
            'jenis_barang_id' => $request->jenis_barang_id,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
        ]);

        return redirect()->route('supplier_index')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show($id)
    {
        return redirect()->route('inventory_index', ['supplier' => $id]);
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $JenisBarangs = JenisBarang::all();
        return view('admin.createSupplier', compact('supplier', 'JenisBarangs'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email',
            'catatan' => 'nullable|string',
            'dari_tanggal' => 'required|date',
            'status_aktif' => 'boolean',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'nullable|string|max:500',
            'pic' => 'nullable|string|max:255',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier_index')->with('success', 'Supplier berhasil diperbarui');
    }

    public function toggleStatus($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->status_aktif = !$supplier->status_aktif;
        $supplier->save();

        return redirect()->back()->with('success', 'Status supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier_index')->with('success', 'Supplier berhasil dihapus');
    }
}