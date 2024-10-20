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

    
    
    public function index()
    {
        return Inertia::render('equipments/Index', [
            'equipments' => equipment::paginate()
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
   // $equipments = Equipment::all();

   // dd($data);
    // Generar el PDF con la vista 'report.blade.php'
    $pdf = Pdf::loadView('report', $data);
    return $pdf->download('reporte_equipos.pdf');

    // Guarda el PDF temporalmente en el sistema de archivos (carpeta 'public/pdfs')
    $pdfPath = 'pdfs/reporte_equipos_' . time() . '.pdf';
    Storage::disk('public')->put($pdfPath, $pdf->output());

    // Genera la URL pública del archivo
    $pdfUrl = Storage::url($pdfPath);

    $pdf = Pdf::loadView('pdf.invoice', $data);
    return redirect()->away($pdfUrl);
}
}
