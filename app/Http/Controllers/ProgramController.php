<?php

namespace App\Http\Controllers;

use App\Models\Programs;
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
   

    
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
       request()->validate(Programs::$rules);
       $program = new Programs($request->input());
       $program->save();
       return redirect('programs');
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
       
        request()->validate(Programs::$rules);
        $program = Programs::find($id);
        $program->update($request->all());
        // $program = Programs::find($id);
      
        
        return redirect('programs');

    }

  

    


    public function destroy(string $id)
    {
        $program = Programs::findOrFail($id);

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
    
}
