<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CuentaController extends Controller
{
    // Formulario para cambiar la contraseña del usuario con sesión iniciada
    public function editarContrasena()
    {
        return view('admin.cuenta.contrasena');
    }

    public function actualizarContrasena(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password'        => 'required|min:8|confirmed|different:password_actual',
        ], [
            'required'  => 'El campo :attribute es obligatorio.',
            'min'       => 'La contraseña nueva debe tener al menos :min caracteres.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
            'different' => 'La contraseña nueva debe ser distinta a la actual.',
        ], [
            'password_actual' => 'contraseña actual',
            'password'        => 'contraseña nueva',
        ]);

        $usuario = $request->user();

        // Se compara lo que escribió con el hash guardado en la base de datos
        if (! Hash::check($request->password_actual, $usuario->password)) {
            Log::warning('Cambio de contraseña con contraseña actual incorrecta', ['email' => $usuario->email]);

            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        // Al guardarla, Laravel le aplica el hash automáticamente
        $usuario->password = $request->password;
        $usuario->save();

        Log::info('Contraseña cambiada por el usuario', ['email' => $usuario->email]);

        return back()->with('aviso', 'Tu contraseña se actualizó correctamente.');
    }
}
