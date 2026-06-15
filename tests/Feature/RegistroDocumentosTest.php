<?php

namespace Tests\Feature;

use App\Models\Empleado;
use App\Models\Registro;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistroDocumentosTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_documents_for_existing_employee(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['rol' => 'operador']);
        Empleado::create([
            'codigo' => 'EMP123',
            'nombre' => 'Ana Torres',
        ]);
        TipoDocumento::create(['nombre' => 'Contrato']);

        $file = UploadedFile::fake()->create('contrato.pdf', 250, 'application/pdf');

        $response = $this->actingAs($user)->post(route('documentos.store'), [
            'codigo' => 'EMP123',
            'archivo_nombre' => ['Contrato Laboral'],
            'archivo_tipo' => ['Contrato'],
            'archivo' => [$file],
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('documentos', [
            'codigo' => 'EMP123',
            'empleado' => 'Ana Torres',
            'archivo_nombre' => 'Contrato Laboral',
            'archivo_tipo' => 'Contrato',
        ]);

        $registro = Registro::where('codigo', 'EMP123')->firstOrFail();
        Storage::disk('public')->assertExists($registro->ruta_archivo);
    }

    public function test_store_rejects_more_than_five_files(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['rol' => 'operador']);
        Empleado::create([
            'codigo' => 'EMP456',
            'nombre' => 'Luis Diaz',
        ]);
        TipoDocumento::create(['nombre' => 'Contrato']);

        $files = [];
        $nombres = [];
        $tipos = [];

        for ($i = 1; $i <= 6; $i++) {
            $files[] = UploadedFile::fake()->create("doc{$i}.pdf", 200, 'application/pdf');
            $nombres[] = "Documento {$i}";
            $tipos[] = 'Contrato';
        }

        $response = $this->actingAs($user)
            ->from(route('documentos.create'))
            ->post(route('documentos.store'), [
                'codigo' => 'EMP456',
                'archivo_nombre' => $nombres,
                'archivo_tipo' => $tipos,
                'archivo' => $files,
            ]);

        $response->assertRedirect(route('documentos.create'));
        $response->assertSessionHasErrors('archivo');
        $this->assertDatabaseCount('documentos', 0);
    }

    public function test_update_replaces_existing_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['rol' => 'operador']);
        TipoDocumento::create(['nombre' => 'Contrato']);

        Storage::disk('public')->put('documentos/old.pdf', 'old-content');

        $registro = Registro::create([
            'codigo' => 'EMP500',
            'empleado' => 'Pedro Mora',
            'archivo_nombre' => 'Contrato Inicial',
            'archivo_tipo' => 'Contrato',
            'ruta_archivo' => 'documentos/old.pdf',
        ]);

        $newFile = UploadedFile::fake()->create('nuevo.pdf', 300, 'application/pdf');

        $response = $this->actingAs($user)->put(route('documentos.update', $registro), [
            'archivo_nombre' => 'Contrato Actualizado',
            'archivo_tipo' => 'Contrato',
            'archivo' => $newFile,
        ]);

        $response->assertRedirect(route('documentos.index'));

        $registro->refresh();
        Storage::disk('public')->assertMissing('documentos/old.pdf');
        Storage::disk('public')->assertExists($registro->ruta_archivo);

        $this->assertDatabaseHas('documentos', [
            'id' => $registro->id,
            'archivo_nombre' => 'Contrato Actualizado',
        ]);
    }

    public function test_admin_can_delete_document_and_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['rol' => 'admin']);
        Storage::disk('public')->put('documentos/delete-me.pdf', 'content');

        $registro = Registro::create([
            'codigo' => 'EMP999',
            'empleado' => 'Diego Silva',
            'archivo_nombre' => 'Documento a eliminar',
            'archivo_tipo' => 'Contrato',
            'ruta_archivo' => 'documentos/delete-me.pdf',
        ]);

        $response = $this->actingAs($admin)->delete(route('documentos.destroy', $registro));

        $response->assertRedirect(route('documentos.index'));
        $this->assertDatabaseMissing('documentos', ['id' => $registro->id]);
        Storage::disk('public')->assertMissing('documentos/delete-me.pdf');
    }
}
