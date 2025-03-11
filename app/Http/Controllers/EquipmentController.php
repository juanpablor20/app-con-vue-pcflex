<?php

namespace App\Http\Controllers;


use App\Models\Equipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


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





  

    public function store(Request $request)
    {
        request()->validate(Equipment::$rules);
        $equipments = new Equipment($request->input());
        $equipments->save();
        return redirect('equipments');
    }



    public function update(Request $request, string $id)
    {
        // Encontrar el equipo por ID
        $equipment = Equipment::findOrFail($id);

        if ($equipment->status === 'prestado') {
            return redirect()->back()->withErrors(['error' => 'Lo sentimos mucho pero cuando el Equipo esta prestado no se puede editar']);
        }

        // Reglas de validación
        $rules = [
            'type_equi' => 'required|string',
            'characteristics' => 'required|string',
            'serie_equi' => 'required|unique:equipment,serie_equi,' . $equipment->id . '|regex:/^[0-9]{3,}$/',
        ];

        // Validar los datos
        $validatedData = $request->validate($rules);


        $equipment->fill($validatedData);
        $equipment->saveOrFail();

        // Redirigir después de la actualización
        return redirect('equipments');
    }



    public function destroy(string $id)
    {
        $equipments = Equipment::find($id);

        if ($equipments->status !== 'disponible') {
            return redirect()->back()->withErrors(['error' => 'El equipo debe estar disponible para ser inactivado']);
        }

        $equipments->status = 'inactivo';
        $equipments->save();
        return redirect('equipments');
    }

    public function active(string $id)
    {
        $equipments = Equipment::find($id);

        $equipments->status = 'disponible';
        $equipments->save();
        return redirect('equipments');
    }

    public function reparation(string $id)
    {

        $equipments = equipment::find($id);

        if ($equipments->status !== 'disponible') {
            return redirect()->back()->withErrors(['error' => 'El Equipo no esta disponible para enviar a reparacion']);
        }
        $equipments->status = 'reparacion';
        $equipments->save();
        return redirect('equipments');
    }


    public function pdfequipos()
    {

        $data = [
            'title' => 'Reporte de Equipos',
            'equipments' => equipment::all(),
        ];

        $pdf = Pdf::loadView('report', $data);
        return $pdf->download('reporte_equipos.pdf');
    }
}
