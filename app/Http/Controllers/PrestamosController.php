<?php
namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Disabilities;
use App\Models\Equipment;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestamosController extends Controller
{
   
    public function store(Request $request)
    {
        request()->validate(Services::$rules);
        $equipment = Equipment::where('serie_equi', $request->equipment_id)->first();
        $user = Borrower_users::where('number_identification', $request->user_borrower_id)->first();
        $environment = $request->environment_id;

        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'El equipo no existe.']);
        }

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'El usuario no existe']);
        }

        switch ($equipment->status) {
            case 'prestado':
                return redirect()->back()->withErrors(['error' => 'El equipo ya esta marcado como prestado']);
            case 'inactivo':
                return redirect()->back()->withErrors(['error' => 'El equipo esta inactivo']);
            case 'reparacion':
                return redirect()->back()->withErrors(['error' => 'el equipo esta marcado en estado de reparacion']);
        }

        $equiposSimilares = Equipment::where('type_equi', $equipment->type_equi)->get();
        $prestamoMismoTipoCaracteristicas = Services::where('user_borrower_id', $user->id)
            ->whereIn('equipment_id', $equiposSimilares->pluck('id')->toArray())
            ->where('status', 'pendiente')
            ->first();

        if ($prestamoMismoTipoCaracteristicas) {
            return redirect()->back()->withErrors(['error', 'No se puede prestar dos veces un equipo con características similares.']);
        }

        $serviceId = Services::where('user_borrower_id', $user->id)->pluck('id');
        $resultado = Disabilities::whereIn('service_id', $serviceId)
            ->where('status', 'activo')
            ->exists();

        if ($resultado) {
            return redirect()->back()->withErrors(['error' => 'el usuario está sancionado.']);
        }

        DB::beginTransaction();

        try {
            // Crear el registro del préstamo
            $newService = Services::create([
                'user_borrower_id' => $user->id,
                'equipment_id' => $equipment->id,
                'librarian_borrower_id' => Auth::id(),
                'date_ser' => Carbon::now(),
                'status' => 'pendiente',
                'environment_id' => $environment,
                // Otros campos que sean necesarios...
            ]);

            // Actualizar el estado del equipo y del usuario
            $equipment->status = 'prestado';
            $equipment->save();

            $user->status = 'conEquipo';
            $user->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'prestamo registrado con exito']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'uuuuppss. ocurrio un error al registrar el prestamo']);
        }
    }
}
