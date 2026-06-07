<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_user_management()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $user = User::factory()->create([
            'role' => 'staff'
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));
        
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error', 'Akses ditolak! Halaman ini hanya dapat diakses oleh Super Admin.');
    }

    public function test_admin_can_access_user_management()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'role' => 'operator',
            'telepon' => '08123456789'
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'operator',
            'telepon' => '08123456789'
        ]);
    }

    public function test_admin_can_edit_and_update_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $userToEdit = User::factory()->create([
            'name' => 'Old Name',
            'role' => 'staff'
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $userToEdit->id), [
            'name' => 'Updated Name',
            'email' => $userToEdit->email,
            'role' => 'operator',
            'telepon' => '08999999999'
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $userToEdit->id,
            'name' => 'Updated Name',
            'role' => 'operator',
            'telepon' => '08999999999'
        ]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_other_users()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $userToDelete = User::factory()->create([
            'role' => 'staff'
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $userToDelete->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User berhasil dihapus!');
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
