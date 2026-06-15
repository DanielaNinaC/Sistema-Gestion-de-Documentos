<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    @vite('resources/css/login.css')
</head>
<body class="bg-gradient-to-br from-slate-950 via-blue-950 to-blue-800 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-3xl shadow-xl w-96">
        <h2 class="text-2xl font-bold text-center mb-6">Bienvenido al Sistema</h2>
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

        @if(session('error'))
            <p class="text-red-500 text-center mb-4">{{ session('error') }}</p>
        @endif

        @if($errors->has('email'))
            <p class="text-red-500 text-center mb-4">{{ $errors->first('email') }}</p>
        @endif

        @if(session('status') === 'token_mismatch')
            <p class="text-yellow-600 text-center mb-4">La sesión expiró. Por favor intenta de nuevo.</p>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email"
                    class="w-full border border-gray-300 rounded-2xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium">Contraseña</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-2xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white p-2 rounded-2xl hover:bg-blue-700 transition">
                Ingresar
            </button>
        </form>
    </div>

</body>
</html>
