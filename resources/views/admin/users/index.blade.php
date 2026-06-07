@extends('admin.layouts.app')

@section('title', 'Manajemen User')

@section('content')

    <!-- Header Actions -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Pengguna</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar semua akun pengguna yang terdaftar dalam sistem dan tingkat akses mereka.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition duration-150 shadow-md shadow-emerald-500/10 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User Baru
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 flex justify-between items-center text-sm">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Users Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs font-semibold uppercase text-slate-400 bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 w-[8%]">No</th>
                        <th class="px-6 py-4">Nama / Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">No. Telepon</th>
                        <th class="px-6 py-4">Otorisasi / Role</th>
                        <th class="px-6 py-4 text-center w-[15%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100/50 flex items-center justify-center font-bold text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block">{{ $user->name }}</span>
                                        @if(Auth::id() === $user->id)
                                            <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-semibold uppercase tracking-wider">Akun Saya</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $user->telepon ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="px-2.5 py-1 text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100 rounded-lg">
                                        Super Admin
                                    </span>
                                @elseif($user->role === 'operator')
                                    <span class="px-2.5 py-1 text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 rounded-lg">
                                        Manager
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold bg-slate-50 text-slate-700 border border-slate-100 rounded-lg">
                                        Staff / Operator
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100/50 rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-100/50 rounded-lg transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1.5 text-xs font-semibold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed select-none" title="Anda tidak bisa menghapus akun sendiri">
                                            Hapus
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
