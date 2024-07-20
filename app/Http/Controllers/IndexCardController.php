<?php

namespace App\Http\Controllers;

use App\Models\Index_cards;
use App\Models\Programs;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexCardController extends Controller
{
 
    public function index()
    {
        
        $programs = Programs::where('status', 'activo')->get();
         return Inertia::render('indexCard/Index', [
        'indexCard' => Index_cards::paginate(),
        'programs' => $programs,
         ]);
       
    }


  

    public function create()
    {
        //
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

  
    public function edit(string $id)
    {
       
    }



    public function update(Request $request, string $id)
    {
        $indexCard = Index_cards::find($id);
        $indexCard->fill($request->input())->saveOrFail();
        return redirect('indexCard');
    }

  
    public function destroy(string $id)
    {
       $indexCard = Index_cards::find($id);
       $indexCard->status = 'inactivo';
       $indexCard->save();
       return redirect('indexCard');
    }

    public function active(string $id)
    {
        $indexCard = Index_cards::find($id);
        $indexCard->status = 'activo';
        $indexCard->save();
        return redirect('indexCard');

    }
}
