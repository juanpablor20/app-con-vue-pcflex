<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\Equipment as ModelsEquipment;
use Illuminate\Http\Request;
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
}
