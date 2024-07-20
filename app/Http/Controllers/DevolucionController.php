<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Equipment;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    public function update(Request $request)
    {
        request()->validate(Services::$Rules);

        $equipment = Equipment::where('serie_equi', $request->equipment_id)->first();
        $user = Borrower_users::where('number_identification', $request->user_returner_id)->first();

        if(!$equipment)
        {
            return redirect()->back()->withErrors(['error' => 'El equipo  no existe']);
        }
        if(!$user)
        {
            return redirect()->back()->withErrors(['error' => 'El usuario no existe']);
        }
        switch($equipment->status)
        {
            case 'inactivo':
                return redirect()->back()->withErrors(['error' => 'Este equipo esta marcado como inactivo']);
                case 'reparacion':
                    return redirect()->back()->withErrors(['error' => 'Este equipo esta en reparacion']);
                    case 'disponible':
                        return redirect()->back()->withErrors(['error' => 'este equipo no esta marcado como prestado']);
        }
      $service = Services::where('equipment_id', $equipment->id)
      ->where('status', 'pendiente')
      ->first();
      if(!$service){
        return redirect()->back()->withErrors(['error' => 'servicio no encontrado']);
      }
        $usuarioPrestatario = Borrower_users::find($service->user_borrower_id);
        if(!$usuarioPrestatario)
        {
            return redirect()->back()->withErrors(['error' => 'este usuario no tiene prestamos']);
        }
        //se inicia la tranciccion en base de datos 
        DB::beginTransaction();
        try {
        $equipment->status = 'disponible';
        $equipment->save();

        $returnDate = Carbon::now();
       $service->status = 'devuelto';
       $service->return_ser = $returnDate;
       $service->environment_id = 4;
       $service->save();

            DB::commit();

            $bibliotecario = Auth::id();
            $service = Services::where('librarian_borrower_id', $bibliotecario)->first();
            
            if (!$service) {

                $service->librarian_borrower_id = $bibliotecario;
                $service->save();
            }
            if($usuarioPrestatario->id !==  $user->id)
            {
                $service->user_returner_id = $user->id;
                $service->save();
                return "enviar ala ruta";
                //return redirect()->route('disabilities.create', ['service_id' => $service->id]);

            }
            return redirect()->back()->with(['success' => 'Devolucion Exitosa..']);

        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
