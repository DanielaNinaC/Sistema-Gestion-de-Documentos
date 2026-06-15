<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_operator_cannot_access_admin_user_index(): void
    {
        $operator = User::factory()->create(['rol' => 'operador']);

        $response = $this->actingAs($operator)->get(route('usuarios.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_user_index(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);

        $response = $this->actingAs($admin)->get(route('usuarios.index'));

        $response->assertOk();
    }
}
