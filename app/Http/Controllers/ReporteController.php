<?php

namespace App\Http\Controllers;

use App\Models\Colonia; 
use App\Models\Reporte;
use App\Models\TipoReporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{

    public function create()
    {
        $tipos = TipoReporte::orderBy('nombre')->get();
        $colonias = Colonia::orderBy('colonias')->get(); 

        return view('reportes.create', compact('tipos', 'colonias')); 
    }


    public function store(Request $request)
    {
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
        $reporte->save();

        Log::info('Reporte ciudadano creado', ['folio' => $reporte->folio]);

        $request->session()->put('ultimo_folio', $reporte->folio);

        return redirect()->route('reportes.create')
            ->with('exito', 'Tu reporte fue registrado correctamente.')
            ->with('folio', $reporte->folio);
    }

    public function seguimiento(Request $request)
    {
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

    public function estado($folio)
    {
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