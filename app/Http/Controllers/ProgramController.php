<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    
    public function index()
    {
        return Inertia::render('programs/Index', [
            'programs' => Programs::paginate()
        ]);
    }
   

    
 
  
    public function store(Request $request)
    {
       request()->validate(Programs::$rules);
       $program = new Programs($request->input());
       $program->save();
       return redirect('programs');
    }

   

   
    public function update(Request $request, string $id)
    {
       
        request()->validate(Programs::$rules);
        $program = Programs::find($id);
        $program->update($request->all());
        // $program = Programs::find($id);
      
        
        return redirect('programs');

    }

  

    


    public function destroy(string $id)
    {
        $program = Programs::findOrFail($id);
    
        // Verificar si el programa tiene fichas activas
        $hasActiveIndexCards = $program->indexCards()->where('status', 'activo')->exists();
    
        if ($hasActiveIndexCards) {
            
            return redirect()->back()->withErrors(['error'  => 'No se puede inactivar el programa porque tiene fichas activas.']);
        }
    
        // Cambiar el estado del programa a inactivo
        $program->status = 'inactivo';
        $program->save();
    
        return redirect('programs');
    }
    

    public function activate(string $id)

    {
    
        $program = Programs::find($id);
        $program->status = 'activo';
        $program->save();
        return redirect('programs');
    }

    public function pdfPrograms()
    {
        $data = [
            'title' => 'Reporte de Programas',
            'programs' => Programs::all(),
        ];                                  
    
        $pdf = Pdf::loadView('report_programs', $data);
        return $pdf->download('reporte_programas.pdf');
    }
    
}
