<?php

// app/Http/Controllers/InventoryCheckingController.php

namespace App\Http\Controllers;
use App\Models\InventoryChecking;
use App\Models\JenisBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;


class InventoryCheckingController extends Controller
{
    // Tampilkan semua data
    public function index(Request $request)
    {
        $query = InventoryChecking::with(['supplier', 'jenisBarang']);

        // Filter berdasarkan supplier
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        // Filter berdasarkan jenis barang
        if ($request->filled('jenis')) {
            $query->where('jenis_barang_id', $request->jenis); // ✅ Benar
        }
        

        // Filter expiring
        if ($request->filter === 'exp-soon') {
            $query->whereDate('expired_date', '<=', Carbon::now()->addMonth());
        }

        $data = $query->get();

        // Ambil data untuk dropdown
        $suppliers = Supplier::all();
        $jenisBarang = JenisBarang::all();
        return view('admin.inventory.index', compact('data', 'suppliers', 'jenisBarang'));
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
            'total_harga' => 'required|numeric',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $validated['status'] = 'belum_diproses';

        $item = InventoryChecking::create($validated);
        
        // Sinkronisasi otomatis ke agenda schedule
        $this->syncExpirySchedule($item);

        return redirect()->route('admin.dashboard')->with('success', 'Data berhasil ditambahkan!');
    }

    // Edit form
    public function edit($id)
    {
        $item = InventoryChecking::findOrFail($id);
        $jenisBarangs = JenisBarang::all();
        $suppliers = Supplier::all();
        return view('admin.Inventory.edit', compact('item', 'jenisBarangs', 'suppliers'));
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
            'total_harga' => 'required|numeric',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:belum_diproses,aktif,ditarik',
        ]);

        $item->update($validated);
        
        // Sinkronisasi otomatis ke agenda schedule
        $this->syncExpirySchedule($item);

        return redirect()->route('inventory_index')->with('success', 'Data berhasil diubah!');
    }

    // Hapus data
    public function destroy($id)
    {
        $item = InventoryChecking::findOrFail($id);
        
        // Hapus agenda schedule yang terkait terlebih dahulu
        \App\Models\Schedule::where('inventory_checking_id', $item->id)->delete();
        
        $item->delete();

        return redirect()->route('inventory_index')->with('success', 'Data berhasil dihapus!');
    }

    // Tampilkan detail jika dibutuhkan
    public function show($id)
    {
        $item = InventoryChecking::with(['jenisBarang', 'supplier'])->findOrFail($id);
        return view('inventory_checkings.show', compact('item'));
    }

    // Helper sinkronisasi hari kedaluwarsa ke agenda schedule
    private function syncExpirySchedule(InventoryChecking $item)
    {
        if ($item->expired_date) {
            // Dapatkan atau buat kategori baru "Kedaluwarsa Barang"
            $jenisSchedule = \App\Models\JenisSchedule::where('nama', 'Kedaluwarsa Barang')->first();
            if (!$jenisSchedule) {
                $jenisSchedule = new \App\Models\JenisSchedule();
                $jenisSchedule->nama = 'Kedaluwarsa Barang';
                $jenisSchedule->status_aktif = true;
                $jenisSchedule->save();
            }

            $expiry = \Carbon\Carbon::parse($item->expired_date);
            
            // Tanggal pengingat (reminder_date) adalah tanggal expired aktual
            // Tanggal pelaksanaan agenda (date) adalah 30 hari sebelum expired
            $executionDate = $expiry->copy()->subDays(30);
            
            // Amankan agar tanggal pelaksanaan tidak mendahului tanggal masuk barang
            $entryDate = \Carbon\Carbon::parse($item->tanggal);
            if ($executionDate->lt($entryDate)) {
                $executionDate = $entryDate->copy();
            }

            \App\Models\Schedule::updateOrCreate(
                ['inventory_checking_id' => $item->id],
                [
                    'name' => 'Kedaluwarsa: ' . $item->nama . ' (' . $item->jumlah . ' Unit)',
                    'jenis_schedule_id' => $jenisSchedule->id,
                    'date' => $executionDate->toDateString(),
                    'reminder_date' => $expiry->toDateString(),
                    'note' => 'Barang ' . $item->nama . ' (Stok: ' . $item->jumlah . ' unit) akan kedaluwarsa pada tanggal ' . $expiry->format('d M Y') . '.',
                    'budget' => 0,
                    'berulang' => false,
                    'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                ]
            );
        } else {
            // Jika expired_date kosong/dihapus, hapus schedule terkait
            \App\Models\Schedule::where('inventory_checking_id', $item->id)->delete();
        }
    }
}



