<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Muestra el formulario (solo se llega escribiendo /login)
    public function create() {
        return view('auth.login');
    }

    // Revisa las credenciales e inicia la sesión
    public function store(Request $request) {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'email'    => 'El correo no tiene un formato válido.',
        ], [
            'email'    => 'correo',
            'password' => 'contraseña',
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            Log::info('Inicio de sesión correcto', ['email' => $credenciales['email'], 'ip' => $request->ip()]);

            return redirect()->intended(route('admin.reportes.index'));
        }

        Log::warning('Intento de inicio de sesión fallido', ['email' => $credenciales['email'], 'ip' => $request->ip()]);

        return back()
            ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
            ->onlyInput('email');
    }

    // Cierra la sesión
    public function destroy(Request $request) {
        Log::info('Cierre de sesión', ['email' => Auth::user()->email]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('aviso', 'Cerraste sesión correctamente.');
    }
}