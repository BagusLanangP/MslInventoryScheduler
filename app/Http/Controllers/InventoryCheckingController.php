<?php

// app/Http/Controllers/InventoryCheckingController.php

namespace App\Http\Controllers;

use App\Models\InventoryChecking;
use App\Models\JenisBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryCheckingController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $data = InventoryChecking::with(['jenisBarang', 'supplier'])->get();
        return view('inventory_checkings.index', compact('data'));
    }

    // Tampilkan form create
    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        $suppliers = Supplier::all();
        // dd($suppliers);
        return view('admin.createInventoryChecking', compact('jenisBarangs', 'suppliers'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'expired_date' => 'nullable|date',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
            'satuan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga'];
        $validated['status'] = 'belum_diproses';

        InventoryChecking::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Data berhasil ditambahkan!');
    }

    // Edit form
    public function edit($id)
    {
        $item = InventoryChecking::findOrFail($id);
        $jenisBarangs = JenisBarang::all();
        $suppliers = Supplier::all();
        return view('inventory_checkings.edit', compact('item', 'jenisBarangs', 'suppliers'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $item = InventoryChecking::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'expired_date' => 'nullable|date',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
            'satuan' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga'];

        $item->update($validated);

        return redirect()->route('inventory_checkings.index')->with('success', 'Data berhasil diubah!');
    }

    // Hapus data
    public function destroy($id)
    {
        $item = InventoryChecking::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory_checkings.index')->with('success', 'Data berhasil dihapus!');
    }

    // Tampilkan detail jika dibutuhkan
    public function show($id)
    {
        $item = InventoryChecking::with(['jenisBarang', 'supplier'])->findOrFail($id);
        return view('inventory_checkings.show', compact('item'));
    }
}



