<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(15);
        return view('usuarios', compact('usuarios'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()
                ->route('usuarios.index')
                ->with('success', 'Usuario registrado correctamente.');
    }

    public function edit(User $user)
    {
        return view('usuarios-editar', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc|max:255|unique:users,email,' . $user->id,
            'rol' => 'required|in:admin,operador',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        return redirect()
                ->route('usuarios.index')
                ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                    ->route('usuarios.index')
                    ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()
                ->route('usuarios.index')
                ->with('success', 'Usuario eliminado correctamente.');
    }
}