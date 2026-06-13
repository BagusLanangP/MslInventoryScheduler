<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\DailyTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HrmAndPayrollTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_hrm_routes()
    {
        $response = $this->get(route('admin.attendance.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('admin.employees.index'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('admin.payroll.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_employees_and_payroll()
    {
        $staffUser = User::factory()->create(['role' => 'staff']);

        // Staff CAN access attendance page
        $response = $this->actingAs($staffUser)->get(route('admin.attendance.index'));
        $response->assertStatus(200);

        // Staff CANNOT access employees index
        $response = $this->actingAs($staffUser)->get(route('admin.employees.index'));
        $response->assertRedirect(route('admin.dashboard'));

        // Staff CANNOT access payroll index
        $response = $this->actingAs($staffUser)->get(route('admin.payroll.index'));
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_access_employees_and_payroll()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($adminUser)->get(route('admin.employees.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($adminUser)->get(route('admin.payroll.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_employee()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $staffUser = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($adminUser)->post(route('admin.employees.store'), [
            'nip' => 'EMP-001',
            'nama' => 'John Doe',
            'departemen' => 'Gudang',
            'jabatan' => 'Staff Gudang',
            'gaji_pokok' => 4500000,
            'tunjangan' => 200000,
            'potongan_kasbon' => 0,
            'status_karyawan' => 'kontrak',
            'tanggal_masuk' => '2026-06-01',
            'user_id' => $staffUser->id,
            'rekening_bank' => 'BCA 12345'
        ]);

        $response->assertRedirect(route('admin.employees.index'));
        $this->assertDatabaseHas('employees', [
            'nip' => 'EMP-001',
            'nama' => 'John Doe',
            'user_id' => $staffUser->id,
        ]);
    }

    public function test_staff_can_clock_in_and_out()
    {
        $staffUser = User::factory()->create(['role' => 'staff']);
        $employee = Employee::create([
            'nip' => 'EMP-002',
            'nama' => 'Jane Smith',
            'departemen' => 'Kasir',
            'jabatan' => 'Kasir',
            'gaji_pokok' => 3500000,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => '2026-06-01',
            'user_id' => $staffUser->id
        ]);

        // Clock In
        $response = $this->actingAs($staffUser)->post(route('admin.attendance.checkIn'), [
            'keterangan' => 'Masuk tepat waktu'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'employee_id' => $employee->id,
            'status' => 'hadir',
            'keterangan' => 'Masuk tepat waktu'
        ]);

        // Clock Out
        $response = $this->actingAs($staffUser)->post(route('admin.attendance.checkOut'));
        $response->assertRedirect();
        
        $attendance = Attendance::where('employee_id', $employee->id)->first();
        $this->assertNotNull($attendance->jam_keluar);
    }

    public function test_admin_can_generate_and_pay_payroll()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $employee = Employee::create([
            'nip' => 'EMP-003',
            'nama' => 'Budi Santoso',
            'departemen' => 'Keuangan',
            'jabatan' => 'Staff Keuangan',
            'gaji_pokok' => 5000000,
            'tunjangan' => 500000,
            'potongan_kasbon' => 100000,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => '2026-06-01'
        ]);

        $periode = '2026-06';

        // 1. Generate Payroll
        $response = $this->actingAs($adminUser)->post(route('admin.payroll.generate'), [
            'periode' => $periode
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'periode' => $periode,
            'gaji_pokok' => 5000000,
            'tunjangan' => 500000,
            'potongan_kasbon' => 100000,
            'total_diterima' => 5400000, // 5000000 + 500000 - 100000
            'status_pembayaran' => 'pending'
        ]);

        $payroll = Payroll::first();

        // 2. Pay Payroll
        $response = $this->actingAs($adminUser)->post(route('admin.payroll.pay', $payroll->id));
        $response->assertRedirect();

        $payroll->refresh();
        $this->assertEquals('dibayar', $payroll->status_pembayaran);
        $this->assertNotNull($payroll->tanggal_dibayar);

        // 3. Assert automated transaction registered in daily_transactions
        $this->assertDatabaseHas('daily_transactions', [
            'tipe' => 'pengeluaran',
            'kategori' => 'Operasional',
            'nominal' => 5400000
        ]);
    }
}
