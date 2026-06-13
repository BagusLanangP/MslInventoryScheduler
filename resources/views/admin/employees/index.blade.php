@extends('admin.layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Karyawan</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola profil staf, posisi jabatan, rekening bank, departemen, dan berkas kontrak.</p>
        </div>
        <div>
            <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition duration-150 shadow-md shadow-emerald-500/10 active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>+ Tambah Karyawan</span>
            </a>
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex justify-between items-center text-sm">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold px-2">✖</button>
        </div>
    @endif

    <!-- Search Card -->
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.employees.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari karyawan berdasarkan nama, NIP, departemen, atau jabatan..." 
                       class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 bg-slate-50/50 rounded-xl focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.employees.index') }}" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl text-center transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Employees List Table -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Departemen</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Gaji Pokok</th>
                        <th class="px-6 py-4">Akun Login</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-700">{{ $emp->nip }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $emp->nama }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">Masuk: {{ \Carbon\Carbon::parse($emp->tanggal_masuk)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-600">{{ $emp->departemen }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $emp->jabatan }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase border 
                                    @if($emp->status_karyawan === 'tetap') bg-emerald-50 text-emerald-700 border-emerald-100
                                    @elseif($emp->status_karyawan === 'kontrak') bg-indigo-50 text-indigo-700 border-indigo-100
                                    @else bg-amber-50 text-amber-700 border-amber-100
                                    @endif">
                                    {{ $emp->status_karyawan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                Rp{{ number_format($emp->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($emp->user)
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-medium text-slate-700">{{ $emp->user->email }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum terhubung</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-1.5 items-center">
                                <!-- Detail Button -->
                                <button onclick="showDetail({{ json_encode($emp) }}, '{{ $emp->user ? $emp->user->email : '' }}')"
                                        class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-xl transition duration-150"
                                        title="Detail Karyawan">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.employees.edit', $emp->id) }}"
                                   class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl transition duration-150"
                                   title="Edit Karyawan">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.062a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition duration-150" title="Hapus Karyawan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-400 italic">
                                Belum ada data karyawan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $employees->links() }}
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center p-4 transition-all duration-300">
        <div class="bg-white border border-slate-100 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200" id="modal-card">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Lengkap Karyawan
                </h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6 space-y-4 text-sm text-slate-700">
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">NIP</span>
                    <span class="col-span-2 font-mono font-bold text-slate-800" id="det-nip">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Nama Karyawan</span>
                    <span class="col-span-2 font-bold text-slate-900" id="det-nama">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Departemen</span>
                    <span class="col-span-2 text-slate-800 font-medium" id="det-departemen">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Jabatan</span>
                    <span class="col-span-2 text-slate-800" id="det-jabatan">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Status / Masuk</span>
                    <span class="col-span-2 text-slate-800" id="det-status">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Gaji Pokok</span>
                    <span class="col-span-2 font-bold text-slate-900" id="det-gaji">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Tunjangan / Kasbon</span>
                    <span class="col-span-2 text-slate-700" id="det-tunj-pot">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Akun Terkoneksi</span>
                    <span class="col-span-2 text-slate-700" id="det-email">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-2.5">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Rekening Bank</span>
                    <span class="col-span-2 text-slate-800 font-medium" id="det-rekening">-</span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <span class="text-slate-400 font-semibold uppercase text-[10px]">Berkas Kontrak</span>
                    <div class="col-span-2" id="det-berkas">-</div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button onclick="closeModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Details Script -->
    <script>
        function showDetail(emp, email) {
            document.getElementById('det-nip').innerText = emp.nip || '-';
            document.getElementById('det-nama').innerText = emp.nama || '-';
            document.getElementById('det-departemen').innerText = emp.departemen || '-';
            document.getElementById('det-jabatan').innerText = emp.jabatan || '-';
            
            const rawDate = new Date(emp.tanggal_masuk);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            const formattedDate = rawDate.toLocaleDateString('id-ID', options);
            document.getElementById('det-status').innerText = `${emp.status_karyawan.toUpperCase()} (Mulai ${formattedDate})`;
            
            document.getElementById('det-gaji').innerText = `Rp${new Intl.NumberFormat('id-ID').format(emp.gaji_pokok)}`;
            document.getElementById('det-tunj-pot').innerText = `Tunj: Rp${new Intl.NumberFormat('id-ID').format(emp.tunjangan || 0)} / Pot: Rp${new Intl.NumberFormat('id-ID').format(emp.potongan_kasbon || 0)}`;
            document.getElementById('det-email').innerText = email || 'Belum terhubung ke akun aplikasi';
            document.getElementById('det-rekening').innerText = emp.rekening_bank || '-';

            const berkasCell = document.getElementById('det-berkas');
            if (emp.berkas) {
                berkasCell.innerHTML = `<a href="/storage/${emp.berkas}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:text-emerald-700 font-bold hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Unduh/Buka Berkas Kontrak
                </a>`;
            } else {
                berkasCell.innerHTML = `<span class="text-xs text-slate-400 italic">Tidak ada berkas diunggah</span>`;
            }

            const modal = document.getElementById('detail-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                document.getElementById('modal-card').classList.remove('scale-95');
                document.getElementById('modal-card').classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            document.getElementById('modal-card').classList.remove('scale-100');
            document.getElementById('modal-card').classList.add('scale-95');
            setTimeout(() => {
                const modal = document.getElementById('detail-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 150);
        }
    </script>
@endsection
