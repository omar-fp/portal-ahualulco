<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function create() {
        return view('auth.login');
    }

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

            return redirect()->intended(route('admin.reportes.index'));
        }

        return back()
            ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
            ->onlyInput('email');
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('aviso', 'Sesión cerrada correctamente.');
    }
}
