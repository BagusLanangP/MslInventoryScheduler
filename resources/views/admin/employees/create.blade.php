@extends('admin.layouts.app')

@section('title', isset($employee) ? 'Edit Karyawan' : 'Tambah Karyawan Baru')

@section('content')
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">
                {{ isset($employee) ? 'Edit Data Karyawan' : 'Tambah Karyawan Baru' }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                {{ isset($employee) ? 'Perbarui profil dan rincian hak/tanggung jawab staf kepegawaian.' : 'Daftarkan profil baru kepegawaian staf lengkap dengan rincian kontrak dan penggajian.' }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-semibold rounded-xl transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke List</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-sm max-w-3xl">
        <form method="POST" 
              action="{{ isset($employee) ? route('admin.employees.update', $employee->id) : route('admin.employees.store') }}" 
              class="space-y-6" 
              enctype="multipart/form-data">
            
            @csrf
            @if(isset($employee))
                @method('PUT')
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-sm space-y-1">
                    <p class="font-bold">Perbaiki kesalahan berikut sebelum menyimpan:</p>
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- NIP -->
                <div class="space-y-1.5">
                    <label for="nip" class="block text-xs font-semibold text-slate-500 uppercase">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" id="nip" 
                           value="{{ old('nip', $employee->nip ?? 'EMP-'.date('Ymd').'-'.rand(1000, 9999)) }}" 
                           required 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Nama -->
                <div class="space-y-1.5">
                    <label for="nama" class="block text-xs font-semibold text-slate-500 uppercase">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" 
                           value="{{ old('nama', $employee->nama ?? '') }}" 
                           required 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Departemen -->
                <div class="space-y-1.5">
                    <label for="departemen" class="block text-xs font-semibold text-slate-500 uppercase">Departemen</label>
                    <select name="departemen" id="departemen" required 
                            class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach(['Keuangan', 'Operasional', 'Gudang', 'Kasir', 'Umum'] as $dept)
                            <option value="{{ $dept }}" {{ old('departemen', $employee->departemen ?? '') === $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jabatan -->
                <div class="space-y-1.5">
                    <label for="jabatan" class="block text-xs font-semibold text-slate-500 uppercase">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" 
                           placeholder="Contoh: Manager, Kasir Utama, Staf Gudang" 
                           value="{{ old('jabatan', $employee->jabatan ?? '') }}" 
                           required 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Status Karyawan -->
                <div class="space-y-1.5">
                    <label for="status_karyawan" class="block text-xs font-semibold text-slate-500 uppercase">Status Karyawan</label>
                    <select name="status_karyawan" id="status_karyawan" required 
                            class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                        <option value="kontrak" {{ old('status_karyawan', $employee->status_karyawan ?? '') === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="tetap" {{ old('status_karyawan', $employee->status_karyawan ?? '') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="magang" {{ old('status_karyawan', $employee->status_karyawan ?? '') === 'magang' ? 'selected' : '' }}>Magang</option>
                    </select>
                </div>

                <!-- Tanggal Masuk -->
                <div class="space-y-1.5">
                    <label for="tanggal_masuk" class="block text-xs font-semibold text-slate-500 uppercase">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" 
                           value="{{ old('tanggal_masuk', $employee->tanggal_masuk ?? date('Y-m-d')) }}" 
                           required 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Gaji Pokok -->
                <div class="space-y-1.5">
                    <label for="gaji_pokok" class="block text-xs font-semibold text-slate-500 uppercase">Gaji Pokok (Rupiah)</label>
                    <input type="number" name="gaji_pokok" id="gaji_pokok" 
                           value="{{ old('gaji_pokok', $employee->gaji_pokok ?? '') }}" 
                           required min="0" 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Tunjangan Default -->
                <div class="space-y-1.5">
                    <label for="tunjangan" class="block text-xs font-semibold text-slate-500 uppercase">Tunjangan Bulanan (Rupiah)</label>
                    <input type="number" name="tunjangan" id="tunjangan" 
                           value="{{ old('tunjangan', $employee->tunjangan ?? 0) }}" 
                           min="0" 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Potongan Kasbon Default -->
                <div class="space-y-1.5">
                    <label for="potongan_kasbon" class="block text-xs font-semibold text-slate-500 uppercase">Potongan Kasbon Bulanan (Rupiah)</label>
                    <input type="number" name="potongan_kasbon" id="potongan_kasbon" 
                           value="{{ old('potongan_kasbon', $employee->potongan_kasbon ?? 0) }}" 
                           min="0" 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Rekening Bank -->
                <div class="space-y-1.5">
                    <label for="rekening_bank" class="block text-xs font-semibold text-slate-500 uppercase">Rekening Bank (Nama Bank & No Rek)</label>
                    <input type="text" name="rekening_bank" id="rekening_bank" 
                           placeholder="Contoh: BCA 12345678 a.n Budi" 
                           value="{{ old('rekening_bank', $employee->rekening_bank ?? '') }}" 
                           class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                </div>

                <!-- Akun User Login -->
                <div class="space-y-1.5">
                    <label for="user_id" class="block text-xs font-semibold text-slate-500 uppercase">Hubungkan ke Akun Login</label>
                    <select name="user_id" id="user_id" 
                            class="w-full border border-slate-200/80 bg-slate-50/50 rounded-xl px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/10 outline-none transition duration-150">
                        <option value="">-- Jangan Hubungkan (Staff tanpa Akses Aplikasi) --</option>
                        @if(isset($employee) && $employee->user)
                            <option value="{{ $employee->user_id }}" selected>{{ $employee->user->name }} ({{ $employee->user->email }})</option>
                        @endif
                        @foreach($availableUsers as $usr)
                            <option value="{{ $usr->id }}" {{ old('user_id') == $usr->id ? 'selected' : '' }}>
                                {{ $usr->name }} ({{ $usr->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Unggah Berkas Kontrak -->
                <div class="space-y-1.5">
                    <label for="berkas" class="block text-xs font-semibold text-slate-500 uppercase">Berkas Kontrak (PDF/JPG/PNG, Max 2MB)</label>
                    <input type="file" name="berkas" id="berkas" 
                           class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200/80 rounded-xl p-1 outline-none transition bg-slate-50/50">
                    @if(isset($employee) && $employee->berkas)
                        <div class="text-[10px] text-emerald-600 mt-1">
                            ✔ Ada berkas terunggah: <a href="/storage/{{ $employee->berkas }}" target="_blank" class="underline font-bold hover:text-emerald-700">Lihat Berkas Saat Ini</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.employees.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-md shadow-emerald-500/10 active:scale-[0.98]">
                    {{ isset($employee) ? 'Simpan Perubahan' : 'Daftarkan Karyawan' }}
                </button>
            </div>
        </form>
    </div>
@endsection
