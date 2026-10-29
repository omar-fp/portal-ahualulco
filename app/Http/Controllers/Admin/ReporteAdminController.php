<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReporteAdminController extends Controller
{
    private $estados = [
        'pendiente'  => 'Pendiente',
        'en_proceso' => 'En proceso',
        'atendido'   => 'Atendido',
    ];

    public function index(Request $request) {
        $usuario = $request->user();

        $consulta = Reporte::with(['tipo', 'colonia'])->latest();

        if (! $usuario->esSuper()) {
            $consulta->where('tipo_reporte_id', $usuario->tipo_reporte_id);
        }

        if ($request->filled('estado') && array_key_exists($request->estado, $this->estados)) {
            $consulta->where('estado', $request->estado);
        }

        $reportes = $consulta->paginate(10)->withQueryString();
        $estados = $this->estados;

        return view('admin.reportes.index', compact('reportes', 'estados'));
    }

    public function actualizarEstado(Request $request, Reporte $reporte) {
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

    // Eliminar un reporte (solo el administrador general y solo si ya fue atendido)
    public function destroy(Reporte $reporte)
    {
        if ($reporte->estado != 'atendido') {
            return back()->with('error', 'Solo se pueden eliminar reportes con estado Atendido.');
        }

        $folio = $reporte->folio;
        $reporte->delete();

        Log::info('Reporte eliminado', ['folio' => $folio]);

        return back()->with('aviso', 'El reporte ' . $folio . ' fue eliminado.');
    }
}
