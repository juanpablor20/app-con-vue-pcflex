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
    // Validación inicial
    request()->validate(Services::$rules);

    // Obtener equipo y usuario en una sola consulta
    $equipment = Equipment::where('serie_equi', $request->equipment_id)->first();
    $user = Borrower_users::where('number_identification', $request->user_borrower_id)->first();
    $environment = $request->environment_id;

    // Validaciones de existencia
    if (!$equipment) {
        return redirect()->back()->withErrors(['error' => 'El equipo no existe.']);
    }

    if (!$user) {
        return redirect()->back()->withErrors(['error' => 'El usuario no existe.']);
    }

    // Validaciones de estado del equipo
    switch ($equipment->status) {
        case 'prestado':
            return redirect()->back()->withErrors(['error' => 'El equipo ya está prestado.']);
        case 'inactivo':
            return redirect()->back()->withErrors(['error' => 'El equipo está inactivo.']);
        case 'reparacion':
            return redirect()->back()->withErrors(['error' => 'El equipo está en reparación.']);
    }

    // Validaciones de estado del usuario
    switch ($user->status) {
        case 'inactivo':
            return redirect()->back()->withErrors(['error' => 'El usuario está inactivo y no puede solicitar préstamos.']);
        case 'reportado':
            return redirect()->back()->withErrors(['error' => 'El usuario está sancionado y no puede solicitar préstamos.']);
    }

    // Validación de sanciones activas en la tabla Disabilities
    $tieneSancion = Disabilities::whereIn('service_id', function ($query) use ($user) {
        $query->select('id')
            ->from('services')
            ->where('user_borrower_id', $user->id);
    })->where('status', 'activo')->exists();

    if ($tieneSancion) {
        return redirect()->back()->withErrors(['error' => 'El usuario tiene una sanción activa.']);
    }

    // Validación para evitar múltiples préstamos de equipos similares
    $prestamoMismoTipo = Services::where('user_borrower_id', $user->id)
        ->whereIn('equipment_id', function ($query) use ($equipment) {
            $query->select('id')->from('equipment')->where('type_equi', $equipment->type_equi);
        })
        ->where('status', 'pendiente')
        ->exists();

    if ($prestamoMismoTipo) {
        return redirect()->back()->withErrors(['error' => 'No se puede prestar dos veces un equipo con características similares.']);
    }

    // Comprobar que el usuario no tenga demasiados préstamos pendientes
    $cantidadPrestamos = Services::where('user_borrower_id', $user->id)
        ->where('status', 'pendiente')
        ->count();

    if ($cantidadPrestamos >= 3) { // Puedes cambiar el límite según tu negocio
        return redirect()->back()->withErrors(['error' => 'El usuario ya tiene el número máximo de equipos permitidos en préstamo.']);
    }

    // Iniciar transacción
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
        ]);

        // Actualizar el estado del equipo y del usuario dentro de la transacción
        Equipment::where('id', $equipment->id)->update(['status' => 'prestado']);
        Borrower_users::where('id', $user->id)->update(['status' => 'conEquipo']);

        // Confirmar transacción
        DB::commit();

        return redirect()->back()->with(['success' => 'Préstamo registrado con éxito.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Ocurrió un error al registrar el préstamo.']);
    }
}

}
