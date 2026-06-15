<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuarioManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);

        $response = $this->actingAs($admin)->post(route('usuarios.store'), [
            'name' => 'Operador Uno',
            'email' => 'operador1@example.com',
            'password' => 'ClaveSegura1',
            'password_confirmation' => 'ClaveSegura1',
            'rol' => 'operador',
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Operador Uno',
            'email' => 'operador1@example.com',
            'rol' => 'operador',
        ]);

        $user = User::where('email', 'operador1@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('ClaveSegura1', $user->password));
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);

        $response = $this->actingAs($admin)->delete(route('usuarios.destroy', $admin));

        $response->assertRedirect(route('usuarios.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_update_user_data(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $target = User::factory()->create([
            'email' => 'before@example.com',
            'rol' => 'operador',
        ]);

        $response = $this->actingAs($admin)->put(route('usuarios.update', $target), [
            'name' => 'Nombre Editado',
            'email' => 'after@example.com',
            'rol' => 'admin',
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'name' => 'Nombre Editado',
            'email' => 'after@example.com',
            'rol' => 'admin',
        ]);
    }
}
