<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Disability;
use App\Models\Equipment;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class reportsController extends Controller
{
    public function index()
    {
        return Inertia::render('reports/Index', [
            'repors' =>Disability::paginate(),
        ]);
    }
    public function create(Request $request)
    {
        $serviceId = $request->input('service_id', session('serviceId'));
    return Inertia::render('reports/Create', [
        'serviceId' => $serviceId,
    ]);
    }
    
    public function store(Request $request)

    { 
        $currentDate = Carbon::now()->startOfDay();
       

        if (Carbon::parse($request->input('end_date'))->startOfDay()->lessThan($currentDate)) {

            return redirect()->back()->withErrors(['error' => 'la Fecha deve ser posterior ala actual']);

        }
        
        
        $request->validate([
            'description' => 'required|string',
            'end_date' => 'nullable|date',
            'service_id' => 'required',
        ]);

        $service = Services::find($request->input('service_id'));
        $disability = Disability::create([
            'description' => $request->input('description'),
            'end_date' => $request->input('end_date'),
            'service_id' => $request->input('service_id'),
        ]);

        //$this->checkAndFireEndDateEvent($disability);
        $disability->punishment_date = Carbon::now();
        $disability->save();

     //   event(new DisabilityReportCreated($service));

        return redirect()->route('repors.index')->with(['success' => 'Reporte Creado con exito.']);

    }
    public function crear()
    {
        return Inertia::render('reports/Crear');
    }

    public function creacion(Request $request)
    {
        $currentDate = Carbon::now()->startOfDay();

        if (Carbon::parse($request->input('end_date'))->startOfDay()->lessThan($currentDate)) {
            return redirect()->back()->withErrors(['error' => 'La fecha de finalización debe ser posterior a la fecha actual']);
        }

         $request->validate([
            'description' => 'required|string',
            'numero_documento' => 'required',
            'numero_serie' => 'required',
            'end_date' => 'nullable|date',
        ]);

        $numero_serie = $request->input('numero_serie');
        $numero_documento = $request->input('numero_documento');

        $user = Borrower_users::where('number_identification', $numero_documento)->first();
        $date = $request->input('end_date');
        
        if(!$user){
            return redirect()->back()->withErrors(['error' => 'El usuario no se encuentra sancionado']);
        }
        $userId = $user->id;
        $equipment = Equipment::where('serie_equi', $numero_serie)->first();

        if(!$equipment){
            return redirect()->back()->withErrors(['error' => 'El Equipo no se encuentra']);
        }
        $equipmentId = $equipment->id;

        $services = Services::where('user_borrower_id', $userId)
            ->where('equipment_id', $equipmentId)
            ->first();

        if ($services) {
            $serviceId = $services->id;
            $disability = Disability::create([
                'description' => $request->input('description'),
                'end_date' => $request->input('end_date'),
                'service_id' => $serviceId
            ]);
        } else {
           
            return redirect()->back()->withErrors(['error' => 'Servicio no encontrado']);
        }


       // $this->checkAndFireEndDateEvent($disability);

        $disability->punishment_date = Carbon::now();
        $disability->save();

       //  event(new DisabilityReportCreated($services));

        return redirect('repors')->with(['success' => 'Reporte Creado con exito.']);
    }
}
