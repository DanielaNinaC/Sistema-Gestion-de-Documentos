<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Empleado;
use App\Models\TipoDocumento;
use App\Http\Requests\StoreRegistroRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->query('q', ''));

        $documentos = Registro::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($subQuery) use ($busqueda) {
                    $subQuery->where('codigo', 'like', "%{$busqueda}%")
                        ->orWhere('empleado', 'like', "%{$busqueda}%")
                        ->orWhere('archivo_nombre', 'like', "%{$busqueda}%")
                        ->orWhere('archivo_tipo', 'like', "%{$busqueda}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('documentos', compact('documentos'));
    }

    public function create()
    {
        $tipos = TipoDocumento::orderBy('nombre')->get();

        return view('registro', compact('tipos'));
    }

    public function edit(Registro $registro)
    {
        $tipos = TipoDocumento::orderBy('nombre')->get();

        return view('documentos-editar', compact('registro', 'tipos'));
    }

    public function update(Request $request, Registro $registro)
    {
        $request->validate([
            'archivo_nombre' => 'required|string|min:3|max:255',
            'archivo_tipo' => ['required', Rule::exists('tipos_documentos', 'nombre')],
            'archivo' => 'nullable|mimes:pdf,doc,docx|max:20480|min:1',
        ]);

        $data = [
            'archivo_nombre' => trim($request->archivo_nombre),
            'archivo_tipo' => $request->archivo_tipo,
        ];

        if ($request->hasFile('archivo')) {
            if ($registro->ruta_archivo) {
                Storage::disk('public')->delete($registro->ruta_archivo);
            }

            $data['ruta_archivo'] = $this->storeWithOriginalName($request->file('archivo'));
        }

        $registro->update($data);

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado correctamente');
    }

    public function tipos()
    {
        $tipos = TipoDocumento::query()
            ->leftJoin('documentos', 'documentos.archivo_tipo', '=', 'tipos_documentos.nombre')
            ->select('tipos_documentos.id', 'tipos_documentos.nombre', DB::raw('count(documentos.id) as total'))
            ->groupBy('tipos_documentos.id', 'tipos_documentos.nombre')
            ->orderBy('tipos_documentos.nombre')
            ->get();

        return view('tipo-documentos', compact('tipos'));
    }

    public function storeTipo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:100|unique:tipos_documentos,nombre',
        ]);

        TipoDocumento::create([
            'nombre' => trim($request->nombre),
        ]);

        return back()->with('success', 'Tipo de documento registrado correctamente');
    }

    public function store(StoreRegistroRequest $request)
    {
        $validated = $request->validated();
        
        $empleado = Empleado::where('codigo', $validated['codigo'])->first();

        $archivos = $request->file('archivo');
        $nombres = $validated['archivo_nombre'];
        $tipos = $validated['archivo_tipo'];

        foreach ($archivos as $index => $archivo) {
            $ruta = $this->storeWithOriginalName($archivo);

            Registro::create([
                'codigo' => $validated['codigo'],
                'empleado' => $empleado->nombre,
                'archivo_nombre' => $nombres[$index],
                'archivo_tipo' => $tipos[$index],
                'ruta_archivo' => $ruta,
            ]);
        }

        return back()->with('success', 'Documentos registrados correctamente');
    }

    private function storeWithOriginalName(UploadedFile $archivo): string
    {
        $disk = Storage::disk('public');
        $folder = 'documentos';
        $originalName = $archivo->getClientOriginalName();

        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $candidateName = $originalName;
        $counter = 1;

        while ($disk->exists($folder . '/' . $candidateName)) {
            $suffix = '-' . $counter;
            $candidateName = $extension
                ? $nameWithoutExtension . $suffix . '.' . $extension
                : $nameWithoutExtension . $suffix;
            $counter++;
        }

        return $archivo->storeAs($folder, $candidateName, 'public');
    }

    public function destroy(Registro $registro)
    {
        if ($registro->ruta_archivo) {
            Storage::disk('public')->delete($registro->ruta_archivo);
        }

        $registro->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente');
    }

    public function updateTipo(Request $request, TipoDocumento $tipoDocumento)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:3', 'max:100', Rule::unique('tipos_documentos', 'nombre')->ignore($tipoDocumento->id)],
        ]);

        $tipoDocumento->update(['nombre' => trim($request->nombre)]);

        return back()->with('success', 'Tipo de documento actualizado correctamente');
    }

    public function editTipo(TipoDocumento $tipoDocumento)
    {
        return view('tipos-documentos-editar', compact('tipoDocumento'));
    }

    public function destroyTipo(TipoDocumento $tipoDocumento)
    {
        if ($tipoDocumento->documentos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un tipo de documento que tiene documentos asociados.');
        }

        $tipoDocumento->delete();

        return back()->with('success', 'Tipo de documento eliminado correctamente');
    }
}

