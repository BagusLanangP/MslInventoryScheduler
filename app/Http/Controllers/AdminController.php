<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ApiLibur;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard()
    {
        $dataSchedule = Schedule::all();
        $totalSchedule = Schedule::count(); 
        $users = User::all();
        $completedSchedule = Schedule::where('status', 'completed')->count(); // Menghitung schedule yang selesai
        $userCount = User::count(); // Menghitung total user
        $dataApi = ApiLibur::pluck('name', 'date');
        return view('admin.dashboard', compact('totalSchedule', 'completedSchedule', 'userCount', 'dataApi', 'users'));
    }

    public function createUser()
    {
        return view('admin.createUser');
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
