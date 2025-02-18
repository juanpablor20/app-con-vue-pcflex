<?php

namespace App\Http\Controllers;

use App\Models\Environments;
use App\Models\Services;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PanelPrincipalController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');
    
        // Crear la consulta base
        $query = Services::with(['equipment', 'users', 'environment'])
            ->where('status', 'pendiente'); // Filtro por estado "pendiente"
    
        // Aplicar filtros de búsqueda si existe un término
        if ($search) {
            $query->whereHas('equipment', function ($q) use ($search) {
                $q->where('serie_equi', 'like', '%' . $search . '%');
            })
            ->orWhereHas('users', function ($q) use ($search) {
                $q->where('number_identification', 'like', '%' . $search . '%');
            })
            ->orWhereHas('environment', function ($q) use ($search) {
                $q->where('names', 'like', '%' . $search . '%');
            });
        }
    
        // Paginar los resultados
        $services = $query->paginate(10); // Paginación de 10 registros por página
    
        // Obtener los ambientes activos
        $environments = Environments::where('status', 'activo')->get();
    
        // Pasar los datos a la vista con Inertia
        return Inertia::render('Dashboard', [
            'services' => $services,
            'environments' => $environments,
            'search' => $search,
        ]);
    }

    public function pdfservices()
    {
        $data = [
            'title' => 'Reporte de Prestamos',
            'services' => Services::where('status', 'pendiente')->with('equipment', 'environment', 'users')->get(),
        ];
        $pdf = Pdf::loadView('report_services', $data);
        return $pdf->download('reporte_prestamos.pdf');

    }


                                






    
}
