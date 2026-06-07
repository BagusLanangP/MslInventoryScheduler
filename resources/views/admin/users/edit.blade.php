@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

    <!-- Header Actions -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">Edit User: {{ $user->name }}</h2>
        <p class="text-xs text-slate-500 mt-1">Ubah informasi akun pengguna atau ubah tingkat otorisasi akses mereka.</p>
    </div>

    <!-- Form Container Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm max-w-2xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Form Row 1: Username & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Username / Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        placeholder="e.g. Admin staff"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Gmail / Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
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
                    <input type="text" name="telepon" value="{{ old('telepon', $user->telepon) }}" 
                        placeholder="e.g. 08123456789"
                        class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('telepon') border-rose-500 @enderror">
                    @error('telepon')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-500 uppercase">Otorisasi / Role</label>
                    <select name="role" required class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('role') border-rose-500 @enderror">
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff / Operator</option>
                        <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Row 3: Password (Optional) -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-500 uppercase">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full border border-slate-200/80 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150 @error('password') border-rose-500 @enderror">
                <p class="text-[11px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah password saat ini.</p>
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
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

@endsection
