<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\Equipment as ModelsEquipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EquipmentController extends Controller
{

    
    
    public function index(Request $request)
{
    $search = $request->input('search'); // Capturamos el valor 'search'
    
    $query = Equipment::query();

    if ($search) {
        $query->where('serie_equi', 'like', '%' . $search . '%')
              ->orWhere('type_equi', 'like', '%' . $search . '%')
              ->orWhere('characteristics', 'like', '%' . $search . '%');
    }

    $equipments = $query->paginate(10);

    return inertia('equipments/Index', [
        'equipments' => $equipments,
        'search' => $search,  // Pasamos el valor de 'search' a la vista
    ]);
}

    
    
    

    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        request()->validate(Equipment::$rules);
        $equipments = new Equipment($request->input());
        $equipments->save();
        return redirect('equipments');
    }

    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
       $equipments = Equipment::find($id);
       $equipments->fill($request->input())->saveOrFail();
       return redirect('equipments');
    }

   
    public function destroy(string $id)
    {
      $equipments = Equipment::find($id);
      

      $equipments->status = 'inactivo';
      $equipments->save();
      return redirect('equipments');
    }

    public function active( string $id)
    {
        $equipments = Equipment::find($id);

        $equipments->status = 'disponible';
        $equipments->save();
        return redirect('equipments');
    }

    public function reparation(string $id)
    {
       
        $equipments = equipment::find($id);
        $equipments->status = 'reparacion';
        $equipments->save();
        return redirect('equipments');
    }


    public function pdfequipos()
{
   
    $data = [
        'title' => 'Reporte de Equipos',
        'equipments' => Equipment::all(), 
    ];

    $pdf = Pdf::loadView('report', $data);
    return $pdf->download('reporte_equipos.pdf');

}
}
