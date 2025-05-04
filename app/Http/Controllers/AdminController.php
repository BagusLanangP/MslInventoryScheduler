<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ApiLibur;
use App\Models\InventoryChecking;
use App\Models\Supplier;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $expiredSoon = InventoryChecking::whereDate('expired_date', '<=', now()->addDays(7))->get();
        // dd($expiredSoon);
        $ScheduleinWeek = Schedule::whereDate('date', '<=', now()->addDays(7))->get();
        $dataSchedule = Schedule::all();
        $totalSchedule = Schedule::count(); 
        $users = User::all();
        $jenisBarangs = JenisBarang::count();
        $completedSchedule = Schedule::where('status', 'completed')->count(); // Menghitung schedule yang selesai
        $userCount = User::count(); // Menghitung total user
        $dataApi = ApiLibur::pluck('name', 'date');
        $Inventory = InventoryChecking::count();
        $supplier = Supplier::count(); 
        // $InventoryProb = InventoryChecking::all();
        return view('admin.dashboard', compact('totalSchedule', 'completedSchedule', 'userCount', 'dataApi', 'users', 'Inventory', 'supplier', 'expiredSoon', 'jenisBarangs', 'ScheduleinWeek'));
    }

    public function createUser()
    {
        return view('admin.createUser');
    }

    public function createSupplier()
    {
        return view('admin.createSupplier');
    }


    public function addGmail()
    {
        return view('admin.addGmail');
    }

    public function storeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Simpan user ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'created_at' => now(), // Menambahkan timestamp
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.create-user')->with('success', 'User berhasil ditambahkan!');
    }


}
