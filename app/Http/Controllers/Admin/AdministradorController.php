<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoReporte;
use App\Models\User;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = User::with('tipoReporte')->orderBy('name')->get();

        return view('admin.administradores.index', compact('administradores'));
    }

    // Formulario para agregar un administrador
    public function create()
    {
        $tipos = TipoReporte::orderBy('nombre')->get();

        return view('admin.administradores.create', compact('tipos'));
    }

    // Guarda el nuevo administrador
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|min:3|max:100',
            'email'           => 'required|email|max:100|unique:users,email',
            'password'        => 'required|min:8|confirmed',
            'rol'             => 'required|in:super,area',
            'tipo_reporte_id' => 'required_if:rol,area|nullable|exists:tipo_reportes,id',
        ], [
            'required'    => 'El campo :attribute es obligatorio.',
            'required_if' => 'Selecciona el tipo de reporte que atenderá.',
            'min'         => 'El campo :attribute debe tener al menos :min caracteres.',
            'max'         => 'El campo :attribute no debe tener más de :max caracteres.',
            'email'       => 'El correo no tiene un formato válido.',
            'unique'      => 'Ya existe un administrador con ese correo.',
            'confirmed'   => 'La confirmación de la contraseña no coincide.',
            'in'          => 'Selecciona una opción válida.',
            'exists'      => 'Selecciona un valor válido.',
        ], [
            'name'            => 'nombre',
            'email'           => 'correo',
            'password'        => 'contraseña',
            'rol'             => 'tipo de administrador',
            'tipo_reporte_id' => 'tipo de reporte',
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password; // se guarda con hash automáticamente
        $usuario->rol = $request->rol;
        $usuario->tipo_reporte_id = $request->rol == 'area' ? $request->tipo_reporte_id : null;
        $usuario->save();

        return redirect()->route('admin.administradores.index')
            ->with('aviso', 'Administrador creado correctamente.');
    }
}
