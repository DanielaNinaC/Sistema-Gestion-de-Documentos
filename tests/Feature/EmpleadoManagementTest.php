<?php

namespace Tests\Feature;

use App\Models\Empleado;
use App\Models\Registro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmpleadoManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_empleado(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);

        $response = $this->actingAs($user)->post(route('empleados.store'), [
            'codigo' => 'EMP001',
            'nombre' => 'Juan Perez',
        ]);

        $response->assertRedirect(route('empleados.index'));
        $this->assertDatabaseHas('empleados', [
            'codigo' => 'EMP001',
            'nombre' => 'Juan Perez',
        ]);
    }

    public function test_buscar_por_codigo_returns_200_when_found(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);
        Empleado::create([
            'codigo' => 'EMP777',
            'nombre' => 'Maria Lopez',
        ]);

        $response = $this->actingAs($user)->get(route('empleados.buscar', 'EMP777'));

        $response->assertOk();
        $response->assertJson([
            'codigo' => 'EMP777',
            'nombre' => 'Maria Lopez',
        ]);
    }

    public function test_buscar_por_codigo_returns_404_when_not_found(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);

        $response = $this->actingAs($user)->get(route('empleados.buscar', 'NOEXISTE'));

        $response->assertNotFound();
    }

    public function test_admin_cannot_delete_empleado_with_associated_documents(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $empleado = Empleado::create([
            'codigo' => 'EMP900',
            'nombre' => 'Carlos Ruiz',
        ]);

        Registro::create([
            'codigo' => 'EMP900',
            'empleado' => 'Carlos Ruiz',
            'archivo_nombre' => 'Contrato',
            'archivo_tipo' => 'Legal',
            'ruta_archivo' => 'documentos/contrato.pdf',
        ]);

        $response = $this->actingAs($admin)->delete(route('empleados.destroy', $empleado));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('empleados', ['id' => $empleado->id]);
    }
}
