<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Index_cards;
use App\Models\Programs;
use App\Models\Relationships;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexCardController extends Controller
{
 
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Index_cards::query();

        if($search){
            $query->where('name', 'like',  '%' . $search . '%')
            ->orWhere('number', 'like', '%' . $search . '%');
        }
        
        $programs = Programs::where('status', 'activo')->get();

         return Inertia::render('indexCard/Index', [
        'indexCard' => Index_cards::paginate(),
        'search' => $search,
        'programs' => $programs,
         ]);
       
    }

    
      
    
    public function store(Request $request)
    {
       
        request()->validate(Index_cards::$rules);
        $indexCard = new  Index_cards($request->input());
        $indexCard->save();
        return redirect('indexCard');
    }

   
    public function show(string $id)
    {
      return Inertia::render('indexCard/show', [
      'index_card' => Index_cards::findOrFail($id)
      ]);
    }

  
    



    public function update(Request $request, string $id)
    {
        $indexCard = Index_cards::find($id);


        $rules = [
            'number' => 'required|unique:index_cards,number,' . $indexCard->id . '|regex:/^[0-9]{3,}$/',
            'program_id' => 'required',
        ];

        $validatedIndexCard = $request->validate($rules);
        $indexCard->fill($validatedIndexCard);
        $indexCard->saveOrfail();
        return redirect('indexCard');
    }



     // Validar los datos
 

   
  
   
    public function destroy(string $id)
    {
        // Buscar la ficha con sus relaciones y usuarios asociados
        $indexCard = Index_cards::find($id);
    
        if (!$indexCard) {
            return redirect()->back()->withErrors(['error' => 'Registro no encontrado']);
        }
    
        // Obtener los IDs de los usuarios relacionados desde la tabla intermedia
        $userIds = Relationships::where('index_card_id', $id)->pluck('user_rel_id');

      
    
        // Buscar los usuarios relacionados
        $users = Borrower_users::whereIn('id', $userIds)->get();

          

        // Verificar si algún usuario tiene el estado 'con_equipo'
        if($users->contains('status', 'conEquipo')) {
            return redirect()->back()->withErrors(['error' => 'No se puede inactivar la ficha porque hay usuarios con equipos asignados.']);
        }
    
        // Cambiar el estado de los usuarios a 'inactivo'
        Borrower_users::whereIn('id', $userIds)->update(['status' => 'inactivo']);
    
        // Cambiar el estado de la ficha a 'inactivo'
        $indexCard->status = 'inactivo';
        $indexCard->save();
    
        return redirect()->back()->with('success', 'Ficha inactivada correctamente.');
    }


public function active(string $id)
{
    // Buscar la ficha en la base de datos
    $indexCard = Index_cards::find($id);

    if (!$indexCard) {
        return redirect('indexCard')->with('error', 'Registro no encontrado');
    }

    // Obtener los IDs de los usuarios relacionados desde la tabla intermedia
    $userIds = Relationships::where('index_card_id', $id)->pluck('user_rel_id');

    // Activar los usuarios relacionados
    Borrower_users::whereIn('id', $userIds)->update(['status' => 'activo']);

    // Activar la ficha
    $indexCard->status = 'activo';
    $indexCard->save();

    return redirect('indexCard')->with('success', 'Ficha activada correctamente.');
}

public function pdfIndexCard()
{
    $data = [
        'title' => 'Reporte de Fichas',
        'indexCards' => Index_cards::with('programs')->get(),
    ];                                  

    $pdf = Pdf::loadView('report_indexCard', $data);
    return $pdf->download('reporte_usuarios.pdf');
}
}
