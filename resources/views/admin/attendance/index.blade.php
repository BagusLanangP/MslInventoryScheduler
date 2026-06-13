@extends('admin.layouts.app')

@section('title', 'Absensi Kehadiran')

@section('content')
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Absensi Kehadiran</h2>
            <p class="text-xs text-slate-500 mt-1">Pencatatan jam masuk & pulang kerja karyawan harian secara langsung.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold px-2">✖</button>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl flex justify-between items-center text-sm">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold px-2">✖</button>
        </div>
    @endif

    <!-- Staff Clock In/Out Section -->
    @if(Auth::user()->role !== 'admin')
        @if(!$employee)
            <div class="bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-3xl mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h4 class="font-bold text-base text-slate-900">Akun Belum Terhubung Karyawan</h4>
                        <p class="text-xs text-slate-600 mt-1">Akun login Anda belum dihubungkan ke data Karyawan oleh Admin. Harap hubungi administrator untuk melakukan absensi.</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Live Clock Card -->
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-6 relative overflow-hidden max-w-xl">
                <!-- Glowing decoration shape -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-500/10 blur-[50px] rounded-full pointer-events-none"></div>

                <div class="flex flex-col items-center text-center space-y-4 relative z-10">
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold tracking-wider uppercase rounded-full border border-emerald-500/20">
                        Absen Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})
                    </span>
                    <h3 class="text-slate-400 font-semibold text-sm">{{ $employee->nama }} — <span class="text-emerald-400 font-mono">{{ $employee->nip }}</span></h3>
                    
                    <!-- Digital Live Clock -->
                    <div class="text-4xl sm:text-5xl font-mono font-extrabold tracking-widest text-white drop-shadow" id="live-clock">
                        00:00:00
                    </div>

                    <!-- Absen Form -->
                    <div class="w-full pt-4 max-w-sm space-y-4">
                        @if(!$todayAttendance)
                            <!-- Clock In Form -->
                            <form method="POST" action="{{ route('admin.attendance.checkIn') }}" class="space-y-4">
                                @csrf
                                <div class="space-y-1 text-left">
                                    <label for="keterangan" class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Catatan Kehadiran (Opsional)</label>
                                    <input type="text" name="keterangan" id="keterangan" placeholder="Contoh: Datang tepat waktu" 
                                           class="w-full border border-slate-700/80 bg-slate-950/40 text-white placeholder-slate-500 rounded-xl px-3.5 py-2 text-xs focus:border-emerald-500 outline-none transition">
                                </div>
                                <button type="submit" 
                                        class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/25 transition active:scale-[0.98]">
                                    Clock In (Masuk Kerja)
                                </button>
                            </form>
                        @elseif(!$todayAttendance->jam_keluar)
                            <!-- Clock Out Form -->
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-xs space-y-2 text-left">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Jam Masuk:</span>
                                    <span class="font-bold text-emerald-400 font-mono">{{ \Carbon\Carbon::parse($todayAttendance->jam_masuk)->format('H:i:s') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Status Absen:</span>
                                    <span class="font-bold text-white capitalize">{{ $todayAttendance->status }}</span>
                                </div>
                                @if($todayAttendance->keterangan)
                                    <div class="border-t border-white/5 pt-2 mt-2">
                                        <span class="text-slate-400 block mb-1">Catatan Anda:</span>
                                        <span class="italic text-slate-300">"{{ $todayAttendance->keterangan }}"</span>
                                    </div>
                                @endif
                            </div>
                            
                            <form method="POST" action="{{ route('admin.attendance.checkOut') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-3 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-400 hover:to-red-500 text-white font-bold rounded-2xl shadow-lg shadow-rose-500/25 transition active:scale-[0.98]">
                                    Clock Out (Pulang Kerja)
                                </button>
                            </form>
                        @else
                            <!-- Completed Absen Status -->
                            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-5 text-sm text-emerald-400 space-y-2.5">
                                <p class="font-bold">✔ Kehadiran Hari Ini Selesai!</p>
                                <div class="text-xs space-y-1.5 text-slate-300 text-left border-t border-emerald-500/10 pt-2.5 mt-2.5">
                                    <div class="flex justify-between">
                                        <span>Jam Masuk:</span>
                                        <span class="font-semibold font-mono">{{ \Carbon\Carbon::parse($todayAttendance->jam_masuk)->format('H:i:s') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Jam Pulang:</span>
                                        <span class="font-semibold font-mono">{{ \Carbon\Carbon::parse($todayAttendance->jam_keluar)->format('H:i:s') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- JavaScript Live Clock -->
            <script>
                function updateClock() {
                    const now = new Date();
                    const hh = String(now.getHours()).padStart(2, '0');
                    const mm = String(now.getMinutes()).padStart(2, '0');
                    const ss = String(now.getSeconds()).padStart(2, '0');
                    const clock = document.getElementById('live-clock');
                    if (clock) {
                        clock.innerText = `${hh}:${mm}:${ss}`;
                    }
                }
                setInterval(updateClock, 1000);
                updateClock(); // first run
            </script>
        @endif
    @endif

    <!-- Admin Recap View Section -->
    @if(Auth::user()->role === 'admin')
        <!-- Filters Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm mb-6">
            <form method="GET" action="{{ route('admin.attendance.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="w-full sm:w-48 space-y-1.5">
                    <label for="tanggal" class="block text-xs font-semibold text-slate-500 uppercase">Pilih Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" 
                           value="{{ request('tanggal', \Carbon\Carbon::today()->toDateString()) }}"
                           class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 outline-none transition">
                </div>

                <div class="w-full sm:w-64 space-y-1.5">
                    <label for="employee_id" class="block text-xs font-semibold text-slate-500 uppercase">Filter Karyawan</label>
                    <select name="employee_id" id="employee_id" 
                            class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3 py-2 text-sm focus:border-emerald-500 outline-none transition">
                        <option value="">-- Semua Karyawan --</option>
                        @foreach($allEmployees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->nama }} ({{ $emp->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition">
                    Filter
                </button>
                @if(request('tanggal') || request('employee_id'))
                    <a href="{{ route('admin.attendance.index') }}" class="w-full sm:w-auto px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl text-center transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Attendance Recap Table -->
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Logs Kehadiran Tanggal: {{ \Carbon\Carbon::parse(request('tanggal', \Carbon\Carbon::today()->toDateString()))->translatedFormat('d F Y') }}</h3>
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4">Departemen / Jabatan</th>
                            <th class="px-6 py-4 text-center">Jam Masuk</th>
                            <th class="px-6 py-4 text-center">Jam Pulang</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Catatan / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendances as $att)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $att->employee->nama }}</div>
                                    <div class="text-[10px] font-mono text-slate-400 mt-0.5">{{ $att->employee->nip }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                                    <div>{{ $att->employee->departemen }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $att->employee->jabatan }}</div>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold text-slate-800">
                                    {{ $att->jam_masuk ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold text-slate-800">
                                    {{ $att->jam_keluar ? \Carbon\Carbon::parse($att->jam_keluar)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="mx-auto block w-20 text-center px-2 py-0.5 text-[10px] font-bold rounded border uppercase 
                                        @if($att->status === 'hadir') bg-emerald-50 text-emerald-700 border-emerald-100
                                        @elseif($att->status === 'sakit') bg-indigo-50 text-indigo-700 border-indigo-100
                                        @elseif($att->status === 'izin') bg-amber-50 text-amber-700 border-amber-100
                                        @else bg-rose-50 text-rose-700 border-rose-100
                                        @endif">
                                        {{ $att->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 italic text-xs text-slate-500 max-w-xs truncate">
                                    {{ $att->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">
                                    Belum ada data kehadiran terekam untuk tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
