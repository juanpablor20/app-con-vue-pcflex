<?php

namespace App\Http\Controllers;

use App\Models\Environments;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnvironmentController extends Controller
{
  
    public function index()
    {
        return Inertia::render('classroom/Index', [
            'environments' =>  Environments::paginate()
        ]);
    }
   
   
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(Environments::$rules);
        $environment = new Environments($request->input());
        $environment->save();
        return redirect('environments');
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
        $environment = Environments::find($id);
        $environment->fill($request->input())->saveOrFail();
        
        return redirect('environments');
    }
  

    public function destroy(string $id)
    {
        $environment = Environments::find($id);
        $environment->status = 'inactivo';
        $environment->save();
        return redirect('environments');

    }
    
    public function active(string $id)
    {
        $environment = Environments::find($id);
        $environment->status = 'activo';
        $environment->save();
        return redirect('environments');

    }
}

