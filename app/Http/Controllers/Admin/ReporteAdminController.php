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

    // Lista los reportes: el super ve todos; el de área, solo los de su tipo
    public function index(Request $request)
    {
        $usuario = $request->user();

        // Collections: se cuenta cuántos reportes hay por estado para el resumen
        $todos = Reporte::query();
        if (! $usuario->esSuper()) {
            $todos->where('tipo_reporte_id', $usuario->tipo_reporte_id);
        }
        $resumen = $todos->pluck('estado')->countBy();

        // Lista que se muestra en la tabla
        $consulta = Reporte::with(['tipo', 'colonia'])->latest();

        if (! $usuario->esSuper()) {
            $consulta->where('tipo_reporte_id', $usuario->tipo_reporte_id);
        }

        if ($request->filled('estado') && array_key_exists($request->estado, $this->estados)) {
            $consulta->where('estado', $request->estado);
        }

        // 10 reportes por página; withQueryString conserva el filtro al cambiar de página
        $reportes = $consulta->paginate(10)->withQueryString();
        $estados = $this->estados;

        return view('admin.reportes.index', compact('reportes', 'estados', 'resumen'));
    }

    // Cambia el estado de un reporte
    public function actualizarEstado(Request $request, Reporte $reporte)
    {
        $usuario = $request->user();

        // Un administrador de área no puede tocar reportes de otro tipo (aunque escriba la URL)
        if (! $usuario->esSuper() && $reporte->tipo_reporte_id != $usuario->tipo_reporte_id) {
            Log::warning('Intento no autorizado de modificar un reporte', [
                'usuario' => $usuario->email,
                'folio'   => $reporte->folio,
            ]);

            return redirect()->route('admin.reportes.index')
                ->with('error', 'No tienes permiso para modificar ese reporte.');
        }

        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,atendido',
        ], [
            'required' => 'Selecciona un estado.',
            'in'       => 'Selecciona un estado válido.',
        ]);

        try {
            $reporte->estado = $request->estado;
            $reporte->save();
        } catch (\Exception $e) {
            Log::error('No se pudo actualizar el estado del reporte', [
                'folio' => $reporte->folio,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'No se pudo actualizar el reporte. Intenta de nuevo.');
        }

        Log::info('Estado de reporte modificado', [
            'folio'   => $reporte->folio,
            'estado'  => $reporte->estado,
            'usuario' => $usuario->email,
        ]);

        return back()->with('aviso', 'El reporte ' . $reporte->folio . ' ahora está: ' . $reporte->nombreEstado() . '.');
    }

    // Elimina un reporte (la ruta ya es solo para el administrador general)
    public function destroy(Request $request, Reporte $reporte)
    {
        // Solo se pueden eliminar los reportes que ya fueron atendidos
        if ($reporte->estado != 'atendido') {
            return back()->with('error', 'Solo se pueden eliminar reportes con estado Atendido.');
        }

        $folio = $reporte->folio;

        try {
            $reporte->delete();
        } catch (\Exception $e) {
            Log::error('No se pudo eliminar el reporte', ['folio' => $folio, 'error' => $e->getMessage()]);

            return back()->with('error', 'No se pudo eliminar el reporte. Intenta de nuevo.');
        }

        Log::info('Reporte eliminado', ['folio' => $folio, 'usuario' => $request->user()->email]);

        return back()->with('aviso', 'El reporte ' . $folio . ' fue eliminado.');
    }
}
