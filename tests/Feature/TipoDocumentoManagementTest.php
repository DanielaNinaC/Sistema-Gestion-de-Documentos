<?php

namespace Tests\Feature;

use App\Models\Registro;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TipoDocumentoManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_tipo_documento(): void
    {
        $user = User::factory()->create(['rol' => 'operador']);

        $response = $this->actingAs($user)
            ->from(route('tipos-documentos.index'))
            ->post(route('tipos-documentos.store'), [
                'nombre' => 'Factura',
            ]);

        $response->assertRedirect(route('tipos-documentos.index'));
        $this->assertDatabaseHas('tipos_documentos', [
            'nombre' => 'Factura',
        ]);
    }

    public function test_admin_cannot_delete_tipo_with_related_records(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $tipo = TipoDocumento::create(['nombre' => 'Contrato']);

        Registro::create([
            'codigo' => 'EMP300',
            'empleado' => 'Eva Mora',
            'archivo_nombre' => 'Contrato 2026',
            'archivo_tipo' => 'Contrato',
            'ruta_archivo' => 'documentos/contrato-2026.pdf',
        ]);

        $response = $this->actingAs($admin)->delete(route('tipos-documentos.destroy', $tipo));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('tipos_documentos', ['id' => $tipo->id]);
    }

    public function test_admin_can_delete_tipo_without_related_records(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $tipo = TipoDocumento::create(['nombre' => 'Memorando']);

        $response = $this->actingAs($admin)->delete(route('tipos-documentos.destroy', $tipo));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('tipos_documentos', ['id' => $tipo->id]);
    }
}
