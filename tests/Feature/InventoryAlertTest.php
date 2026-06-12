<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JenisBarang;
use App\Models\Supplier;
use App\Models\InventoryChecking;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class InventoryAlertTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create testing categories
        JenisBarang::firstOrCreate(['name' => 'Elektronik']);
        JenisBarang::firstOrCreate(['name' => 'Obat']);

        // Create testing supplier
        $obatCategory = JenisBarang::where('name', 'Obat')->first();
        Supplier::firstOrCreate([
            'nama' => 'PT Kimia Farma'
        ], [
            'nomor_whatsapp' => '081234567890',
            'email' => 'kimiafarma@example.com',
            'dari_tanggal' => Carbon::now()->toDateString(),
            'jenis_barang_id' => $obatCategory->id,
            'status_aktif' => true,
            'alamat' => 'Jakarta',
            'pic' => 'Budi'
        ]);
    }

    public function test_sync_stocks_api_requires_valid_token()
    {
        $response = $this->postJson('/api/inventory/sync-stocks', [
            'items' => [
                [
                    'sku' => 'TEST-001',
                    'nama' => 'Item Test',
                    'kategori' => 'Obat',
                    'supplier_nama' => 'PT Kimia Farma',
                    'jumlah' => 10,
                    'min_stock' => 5,
                    'harga_pokok' => 1000,
                    'harga_jual' => 1500
                ]
            ]
        ], [
            'X-API-TOKEN' => 'wrong_token'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Token otorisasi API kasir tidak valid.'
        ]);
    }

    public function test_sync_stocks_api_creates_and_updates_items_successfully()
    {
        // 1. Create a new item via Sync API
        $response = $this->postJson('/api/inventory/sync-stocks', [
            'items' => [
                [
                    'sku' => 'SKU-NEW-01',
                    'nama' => 'Item Baru',
                    'kategori' => 'Obat',
                    'supplier_nama' => 'PT Kimia Farma',
                    'jumlah' => 5,
                    'min_stock' => 10,
                    'harga_pokok' => 5000,
                    'harga_jual' => 7500,
                    'expired_date' => Carbon::now()->addDays(20)->toDateString(),
                    'keterangan' => 'Sync Baru'
                ]
            ]
        ], [
            'X-API-TOKEN' => 'kasir_secret_token'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => '1 data stok barang berhasil disinkronkan!'
        ]);

        $this->assertDatabaseHas('inventory_checkings', [
            'sku' => 'SKU-NEW-01',
            'nama' => 'Item Baru',
            'jumlah' => 5,
            'min_stock' => 10,
            'harga_pokok' => 5000,
            'harga_jual' => 7500,
            'status' => 'aktif'
        ]);

        // Verify that it automatically triggered the creation of a schedule reminder
        $this->assertDatabaseHas('schedules', [
            'name' => 'Kedaluwarsa: Item Baru (5 Unit)'
        ]);

        // 2. Update the same item (update quantity to 0, which should disable/delete its schedule alert)
        $response2 = $this->postJson('/api/inventory/sync-stocks', [
            'items' => [
                [
                    'sku' => 'SKU-NEW-01',
                    'nama' => 'Item Baru',
                    'kategori' => 'Obat',
                    'supplier_nama' => 'PT Kimia Farma',
                    'jumlah' => 0, // Stock is empty now
                    'min_stock' => 10,
                    'harga_pokok' => 5000,
                    'harga_jual' => 7500,
                    'expired_date' => Carbon::now()->addDays(20)->toDateString(),
                    'keterangan' => 'Stok Habis'
                ]
            ]
        ], [
            'X-API-TOKEN' => 'kasir_secret_token'
        ]);

        $response2->assertStatus(200);
        $this->assertDatabaseHas('inventory_checkings', [
            'sku' => 'SKU-NEW-01',
            'jumlah' => 0,
            'status' => 'belum_diproses'
        ]);

        // Verify that the schedule reminder was deleted because stock is 0
        $this->assertDatabaseMissing('schedules', [
            'name' => 'Kedaluwarsa: Item Baru (5 Unit)'
        ]);
    }

    public function test_admin_can_access_alerts_dashboard()
    {
        // Setup a critical stock item and an expiring item in the database
        $kategori = JenisBarang::first();
        $supplier = Supplier::first();

        // 1. Critical stock item
        $lowStock = InventoryChecking::create([
            'sku' => 'SKU-LOW',
            'nama' => 'Item Stok Tipis',
            'jenis_barang_id' => $kategori->id,
            'supplier_id' => $supplier->id,
            'tanggal' => Carbon::now()->toDateString(),
            'jumlah' => 2,
            'min_stock' => 10,
            'harga_pokok' => 100,
            'total_harga' => 200,
            'harga_jual' => 150,
            'status' => 'aktif'
        ]);

        // 2. Expiring soon item
        $expiring = InventoryChecking::create([
            'sku' => 'SKU-EXP',
            'nama' => 'Item Expiring',
            'jenis_barang_id' => $kategori->id,
            'supplier_id' => $supplier->id,
            'tanggal' => Carbon::now()->toDateString(),
            'expired_date' => Carbon::now()->addDays(15)->toDateString(),
            'jumlah' => 50,
            'min_stock' => 10,
            'harga_pokok' => 100,
            'total_harga' => 5000,
            'harga_jual' => 150,
            'status' => 'aktif'
        ]);

        $response = $this->actingAs($this->admin)->get(route('inventory_index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.inventory.index');

        // Check if both alerts render in the view
        $response->assertSee('Item Stok Tipis');
        $response->assertSee('Item Expiring');
        
        // Ensure manual create buttons are not shown anymore
        $response->assertDontSee('+ Tambah Inventory');
    }
}
