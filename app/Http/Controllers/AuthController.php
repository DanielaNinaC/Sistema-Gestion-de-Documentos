<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email:rfc|max:255',
        'password' => 'required|max:255',
    ], [
        'email.required' => 'El correo es requerido.',
        'email.email' => 'El correo debe ser un email válido.',
        'email.max' => 'El correo es demasiado largo.',
        'password.required' => 'La contraseña es requerida.',
        'password.max' => 'La contraseña es demasiado larga.',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate(); // 🔥 MUY IMPORTANTE

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}
