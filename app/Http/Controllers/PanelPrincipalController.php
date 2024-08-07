<?php

namespace App\Http\Controllers;

use App\Models\Environments;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PanelPrincipalController extends Controller
{
    public function index()
    {
      
        $services = Services::where('status', 'pendiente')->with('equipment', 'environment', 'users')->paginate();
        
        // Obtener los ambientes activos
        $environments = Environments::where('status', 'activo')->get();

        // Pasar los datos a la vista con Inertia
        return Inertia::render('Dashboard', [
            'services' => $services,
            'environments' => $environments,
           
        ]);
    }
}
