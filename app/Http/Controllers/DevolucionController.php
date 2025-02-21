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
    
        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'El equipo no existe']);
        }
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'El usuario no existe']);
        }
    
        switch ($equipment->status) {
            case 'inactivo':
                return redirect()->back()->withErrors(['error' => 'Este equipo está marcado como inactivo']);
            case 'reparacion':
                return redirect()->back()->withErrors(['error' => 'Este equipo está en reparación']);
            case 'disponible':
                return redirect()->back()->withErrors(['error' => 'Este equipo no está marcado como prestado']);
        }
    
        $service = Services::where('equipment_id', $equipment->id)
            ->where('status', 'pendiente')
            ->first();
    
        if (!$service) {
            return redirect()->back()->withErrors(['error' => 'Servicio no encontrado']);
        }
    
        $usuarioPrestatario = Borrower_users::find($service->user_borrower_id);

       
        if (!$usuarioPrestatario) {
            return redirect()->back()->withErrors(['error' => 'Este usuario no tiene préstamos']);
        }
    
        // Se inicia la transacción en la base de datos
        DB::beginTransaction();
        try {
            // Actualizar el estado del equipo
            $equipment->status = 'disponible';
            $equipment->save();
    
            // Actualizar el servicio
            $returnDate = Carbon::now();
            $service->status = 'devuelto';
            $service->return_ser = $returnDate;
            $service->environment_id = 4;
    
            // Asignar el bibliotecario que realiza la devolución
            $bibliotecario = Auth::id();
            $service->librarian_borrower_id = $bibliotecario;
    
            // Si el usuario que devuelve es diferente al que prestó
            if ($usuarioPrestatario->id !== $user->id) {
                $service->user_returner_id = $user->id;
                $service->save(); // Guardar los cambios antes de redirigir
                DB::commit(); // Confirmar la transacción
                return redirect()->route('reports.create', ['service_id' => $service->id]); // Redirigir a reports.create
            }
    
            // Si el usuario que devuelve es el mismo que prestó
            $service->save();
            DB::commit();
    
            return redirect()->back()->with(['success' => 'Devolución exitosa.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}