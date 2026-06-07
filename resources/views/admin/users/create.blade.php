@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')

    <!-- Header Actions -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">Tambah User Baru</h2>
        <p class="text-xs text-slate-500 mt-1">Buat akun pengguna baru dengan tingkat otorisasi tertentu untuk mengelola dasbor.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Container Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <!-- Form Row 1: Username & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Username / Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        placeholder="e.g. Admin staff"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Gmail / Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        placeholder="e.g. user@gmail.com"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 2: Telepon & Role -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">No. Telepon / WhatsApp</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" 
                        placeholder="e.g. 08123456789"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('telepon') border-rose-500 @enderror">
                    @error('telepon')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Otorisasi / Role</label>
                    <select name="role" required class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('role') border-rose-500 @enderror">
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff / Operator</option>
                        <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 3: Password -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-500 uppercase">Password Akun (Min. 6 Karakter)</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100 pt-4 flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition duration-150 text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition duration-150 shadow-md shadow-emerald-500/10">
                    Simpan User
                </button>
            </div>

        </form>
    </div>

@endsection
