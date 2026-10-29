<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Models\Reporte;
use App\Models\TipoReporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller {
    public function create() {
        $tipos = TipoReporte::orderBy('nombre')->get();
        $colonias = Colonia::orderBy('colonias')->get();

        return view('reportes.create', compact('tipos', 'colonias'));
    }

    // Quita etiquetas HTML y espacios sobrantes de un texto
    private function limpiar($texto) {
        if (! is_string($texto)) {
            return '';
        }

        return trim(strip_tags($texto));
    }

    public function store(Request $request) {
        // Se quitan las etiquetas HTML de lo que escribe el ciudadano
        $request->merge([
            'nombre_ciudadano' => $this->limpiar($request->input('nombre_ciudadano')),
            'calle'            => $this->limpiar($request->input('calle')),
            'descripcion'      => $this->limpiar($request->input('descripcion')),
        ]);

        // Validación de los datos enviados
        $request->validate([
            'tipo_reporte_id'  => 'required|exists:tipo_reportes,id',
            'nombre_ciudadano' => 'required|min:3|max:100',
            'calle'            => 'required|max:120',
            'colonia_id'       => 'required|exists:colonias,id',
            'descripcion'      => 'required|min:10|max:1000',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'min'      => 'El campo :attribute debe tener al menos :min caracteres.',
            'max'      => 'El campo :attribute no debe tener más de :max caracteres.',
            'exists'   => 'Selecciona un valor válido.',
        ], [
            'tipo_reporte_id'  => 'tipo de problema',
            'nombre_ciudadano' => 'nombre',
            'colonia_id'       => 'colonia',
            'descripcion'      => 'descripción',
        ]);

        $reporte = new Reporte();
        $reporte->folio = Reporte::generarFolio();
        $reporte->tipo_reporte_id = $request->input('tipo_reporte_id');
        $reporte->nombre_ciudadano = $request->input('nombre_ciudadano');
        $reporte->calle = $request->input('calle');
        $reporte->colonia_id = $request->input('colonia_id');
        $reporte->descripcion = $request->input('descripcion');

        // Si falla el guardado, se avisa al usuario y se registra el error en el log
        try {
            $reporte->save();
        } catch (\Exception $e) {
            Log::error('No se pudo guardar el reporte', ['error' => $e->getMessage()]);

            return back()->withInput()
                ->with('error', 'No se pudo registrar tu reporte. Intenta de nuevo más tarde.');
        }

        Log::info('Reporte ciudadano creado', ['folio' => $reporte->folio]);

        $request->session()->put('ultimo_folio', $reporte->folio);

        return redirect()->route('reportes.create')
            ->with('exito', 'Tu reporte fue registrado correctamente.')
            ->with('folio', $reporte->folio);
    }

    public function seguimiento(Request $request) {
        $reporte = null;
        $buscado = false;
        $folio = '';

        if ($request->filled('folio')) {
            $request->validate([
                'folio' => 'alpha_num|size:8',
            ], [
                'alpha_num' => 'El folio solo puede tener letras y números.',
                'size'      => 'El folio debe tener 8 caracteres.',
            ]);

            $folio = strtoupper($request->query('folio'));
            $reporte = Reporte::where('folio', $folio)->first();
            $buscado = true;

            if ($reporte == null) {
                Log::warning('Consulta de folio inexistente', ['folio' => $folio]);
            }
        }

        return view('reportes.seguimiento', compact('reporte', 'buscado', 'folio'));
    }

    public function estado($folio) {
        $reporte = Reporte::where('folio', strtoupper($folio))->first();

        if ($reporte == null) {
            return response()->json(['encontrado' => false, 'mensaje' => 'Folio no encontrado'], 404);
        }

        return response()->json([
            'encontrado' => true,
            'folio'      => $reporte->folio,
            'estado'     => $reporte->nombreEstado(),
        ]);
    }
}
