<?php

namespace App\Http\Controllers;

use App\Models\Disability;
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
    public function create()
    {
        return Inertia::render('reports/Create');
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

        //return redirect()->route('disabilities.index')->with('success', 'Reporte Creado con exito.');

    }
}
