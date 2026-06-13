@extends('admin.layouts.app')

@section('title', 'Manajemen Penggajian (Payroll)')

@section('content')
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Penggajian (Payroll)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola gaji pokok bulanan, tunjangan bonus, potongan kasbon, dan rekonsiliasi pengeluaran kas.</p>
        </div>
    </div>

    <!-- Alerts -->
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

    <!-- Period & Generate Section -->
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <form method="GET" action="{{ route('admin.payroll.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="w-full sm:w-48 space-y-1.5">
                <label for="periode" class="block text-xs font-semibold text-slate-500 uppercase">Periode Penggajian</label>
                <input type="month" name="periode" id="periode" value="{{ $periode }}"
                       class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 outline-none transition">
            </div>
            <button type="submit" class="px-5 py-2 bg-slate-950 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition">
                Pilih Periode
            </button>
        </form>

        @if($missingEmployeesCount > 0)
            <form method="POST" action="{{ route('admin.payroll.generate') }}">
                @csrf
                <input type="hidden" name="periode" value="{{ $periode }}">
                <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-md shadow-emerald-500/10 active:scale-[0.98] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                    </svg>
                    <span>Generate Slip Gaji ({{ $missingEmployeesCount }} Karyawan Baru)</span>
                </button>
            </form>
        @endif
    </div>

    <!-- Summary Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <!-- Widget 1: Total Paid -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gaji Telah Dibayar</h3>
            <p class="text-2xl font-black text-emerald-600 mt-2">Rp{{ number_format($totalPaid, 0, ',', '.') }}</p>
            <div class="text-[10px] text-slate-400 mt-1">Status transfer selesai & terintegrasi pengeluaran</div>
        </div>

        <!-- Widget 2: Total Pending -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gaji Belum Dibayar</h3>
            <p class="text-2xl font-black text-amber-600 mt-2">Rp{{ number_format($totalPending, 0, ',', '.') }}</p>
            <div class="text-[10px] text-slate-400 mt-1">Menunggu approval pembayaran kas</div>
        </div>

        <!-- Widget 3: Total Cost -->
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm bg-gradient-to-tr from-slate-50 to-slate-100">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Beban Gaji</h3>
            <p class="text-2xl font-black text-slate-900 mt-2">Rp{{ number_format($totalCost, 0, ',', '.') }}</p>
            <div class="text-[10px] text-slate-500 mt-1">Jumlah slip keseluruhan periode ini</div>
        </div>
    </div>

    <!-- Payroll Table -->
    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Daftar Slip Gaji Periode: {{ \Carbon\Carbon::parse($periode.'-01')->translatedFormat('F Y') }}</h3>
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Karyawan</th>
                        <th class="px-6 py-4">Gaji Pokok</th>
                        <th class="px-6 py-4">Tunjangan (+)</th>
                        <th class="px-6 py-4">Potongan (-)</th>
                        <th class="px-6 py-4">Gaji Bersih (Diterima)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payrolls as $pay)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $pay->employee->nama }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $pay->employee->nip }} — {{ $pay->employee->departemen }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">Rp{{ number_format($pay->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-emerald-600 font-medium">+Rp{{ number_format($pay->tunjangan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-rose-600 font-medium">-Rp{{ number_format($pay->potongan_kasbon, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-extrabold text-slate-900">Rp{{ number_format($pay->total_diterima, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="mx-auto block w-20 text-center px-2 py-0.5 text-[10px] font-bold rounded border uppercase 
                                    @if($pay->status_pembayaran === 'dibayar') bg-emerald-50 text-emerald-700 border-emerald-100
                                    @else bg-amber-50 text-amber-700 border-amber-100
                                    @endif">
                                    {{ $pay->status_pembayaran }}
                                </span>
                                @if($pay->status_pembayaran === 'dibayar')
                                    <span class="block text-[9px] text-center font-mono text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($pay->tanggal_dibayar)->format('d/m/Y') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-1.5 items-center">
                                @if($pay->status_pembayaran === 'pending')
                                    <!-- Edit Button (triggering inline modal script) -->
                                    <button onclick="openEditModal({{ json_encode($pay) }}, '{{ $pay->employee->nama }}')"
                                            class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl transition duration-150"
                                            title="Edit Nominal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.83 20.062a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    <!-- Pay Slip Button -->
                                    <form action="{{ route('admin.payroll.pay', $pay->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin telah mentransfer dana gaji ini? Tindakan ini akan secara otomatis mencatat pengeluaran operasional di keuangan utama.')">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition shadow-md shadow-emerald-500/10 active:scale-[0.98]">
                                            Bayar Gaji
                                        </button>
                                    </form>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.payroll.destroy', $pay->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slip gaji ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition duration-150" title="Hapus Slip">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic font-medium">Lunas</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400 italic">
                                Belum ada slip gaji digenerate untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal Adjust Gaji -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center p-4 transition-all duration-300">
        <div class="bg-white border border-slate-100 rounded-3xl max-w-md w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200" id="edit-modal-card">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">
                    Edit Rincian Gaji — <span id="modal-employee-name" class="text-emerald-600">-</span>
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <form id="edit-form" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4 text-sm text-slate-700">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs text-slate-600 space-y-1.5 mb-2">
                        <div class="flex justify-between">
                            <span>Gaji Pokok:</span>
                            <span class="font-bold text-slate-900" id="modal-gaji-pokok">Rp0</span>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="modal-tunjangan" class="block text-xs font-semibold text-slate-500 uppercase">Tunjangan / Bonus Periode Ini</label>
                        <input type="number" name="tunjangan" id="modal-tunjangan" required min="0"
                               class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 outline-none transition">
                    </div>

                    <div class="space-y-1.5">
                        <label for="modal-potongan" class="block text-xs font-semibold text-slate-500 uppercase">Potongan Kasbon Periode Ini</label>
                        <input type="number" name="potongan_kasbon" id="modal-potongan" required min="0"
                               class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 outline-none transition">
                    </div>

                    <div class="space-y-1.5">
                        <label for="modal-catatan" class="block text-xs font-semibold text-slate-500 uppercase">Catatan Slip (Opsional)</label>
                        <input type="text" name="catatan" id="modal-catatan" placeholder="Contoh: Bonus lembur proyek"
                               class="w-full border border-slate-200 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 outline-none transition">
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition">
                        Simpan Slip
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Modal Handlers -->
    <script>
        function openEditModal(pay, employeeName) {
            document.getElementById('modal-employee-name').innerText = employeeName;
            document.getElementById('modal-gaji-pokok').innerText = `Rp${new Intl.NumberFormat('id-ID').format(pay.gaji_pokok)}`;
            document.getElementById('modal-tunjangan').value = pay.tunjangan;
            document.getElementById('modal-potongan').value = pay.potongan_kasbon;
            document.getElementById('modal-catatan').value = pay.catatan || '';

            // Update form action URL
            document.getElementById('edit-form').action = `/admin/hrm/payroll/${pay.id}/update-details`;

            const modal = document.getElementById('edit-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                document.getElementById('edit-modal-card').classList.remove('scale-95');
                document.getElementById('edit-modal-card').classList.add('scale-100');
            }, 10);
        }

        function closeEditModal() {
            document.getElementById('edit-modal-card').classList.remove('scale-100');
            document.getElementById('edit-modal-card').classList.add('scale-95');
            setTimeout(() => {
                const modal = document.getElementById('edit-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 150);
        }
    </script>
@endsection
