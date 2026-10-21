<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;

class ReporteAdminController extends Controller
{
    private $estados = [
        'pendiente'  => 'Pendiente',
        'en_proceso' => 'En proceso',
        'atendido'   => 'Atendido',
    ];

    public function index(Request $request)
    {
        $usuario = $request->user();
        $consulta = Reporte::with(['tipo', 'colonia'])->latest();

        if (! $usuario->esSuper()) {
            $consulta->where('tipo_reporte_id', $usuario->tipo_reporte_id);
        }

        if ($request->filled('estado') && array_key_exists($request->estado, $this->estados)) {
            $consulta->where('estado', $request->estado);
        }

        $reportes = $consulta->get();
        $estados = $this->estados;

        return view('admin.reportes.index', compact('reportes', 'estados'));
    }

    public function actualizarEstado(Request $request, Reporte $reporte)
    {
        $usuario = $request->user();

        if (! $usuario->esSuper() && $reporte->tipo_reporte_id != $usuario->tipo_reporte_id) {
            return redirect()->route('admin.reportes.index')
                ->with('error', 'No tienes permiso para modificar ese reporte.');
        }

        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,atendido',
        ], [
            'required' => 'Selecciona un estado.',
            'in'       => 'Selecciona un estado válido.',
        ]);

        $reporte->estado = $request->estado;
        $reporte->save();

        return back()->with('aviso', 'El reporte ' . $reporte->folio . ' ahora está: ' . $reporte->nombreEstado() . '.');
    }
}
