<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Contacts;
use App\Models\Addresses;
use App\Models\Index_cards;
use App\Models\Relationships;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class Borrower_usersController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Borrower_users::query();

    if ($search) {
        $query->where('name', 'like', '%' . $search . '%')
              ->orWhere('number_identification', 'like', '%' . $search . '%');
             
    }

    $users = $query->with('contacts', 'address')->paginate(10);

    return Inertia::render('Borrower_users/Index', [
        'users' => $users,
        'search' => $search,
    ]);
}

 
   

   
    public function create()
    {
        $indexCards = Index_cards::where('status', 'activo')->get();
        return Inertia::render('Borrower_users/Create', [
            'index_cards' => $indexCards
        ]);
    }
    public function store(Request $request)
    {
        request()->validate(Borrower_users::$rules);
       
        // Crear el usuario
        $user = Borrower_users::create($request->only
        ('name', 
        'last_name',
         'type_identification',
          'number_identification',
           'sex_user',
            'gender_sex',
             'roll'));
             $user->save();
        // Crear el contacto asociado
        Contacts::create([
            'id_user_con' => $user->id,
            'telephone_con' => $request->telephone_con,
            'email_con' => $request->email_con,
        ]);

        // Crear la dirección asociada
        Addresses::create([
            'id_user_add' => $user->id,
            'addres_add' => $request->address_add,
        ]);


        $request->validate([
            'index_card_id' => [
                'required_if:roll,aprendiz', // Esta regla solo hace obligatorio index_card_id si el rol es aprendiz
            ],
        ]);
   
        if($user->roll === 'aprendiz')
        {
            Relationships::create([
                'index_card_id' => $request->index_card_id,
                'user_rel_id' => $user->id,
   
           ]);
        }
        return to_route('Borrower_users.index')->with('success', 'Usuario Creado con exito con éxito.');
      
    }
 

    public function show(string $id)
    {
        $user = Borrower_users::with(['contacts', 'address', 'indexCards'])
        ->findOrFail($id);
        return Inertia::render('Borrower_users/Show', [
            'user' => $user,
        ]);
    }

    public function edit(string $id)
    {
        $user = Borrower_users::with('contacts', 'address', 'indexCards', 'prueba')->find($id);
        $index_Cards = Index_cards::where('status', 'activo')->get();
        
        return Inertia::render('Borrower_users/Edit', [
            'user' => $user,
            'index_cards' => $index_Cards // Asegúrate de que esta línea esté aquí
        ]);
    }
    
    

    public function update(Request $request, string $id)
    {
        $user = Borrower_users::findOrFail($id);
        $currentRole = $user->roll;
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'type_identification' => 'required',
            'number_identification' => 'required|unique:Borrower_users,number_identification,' . $user->id,
            'sex_user' => 'required|string',
            'gender_sex' => 'required|string',
            'telephone_con' => 'required|string',
            'address_add' => 'required|string',
            'email_con' => 'required|email',
        ]);
    
        // Actualizar el usuario
        $user->update($request->only('name', 'last_name', 'type_identification', 'number_identification', 'sex_user', 'gender_sex', 'roll'));
    
        // Actualizar el contacto asociado
        if ($user->contacts) {
            $user->contacts->update([
                'telephone_con' => $request->telephone_con,
                'email_con' => $request->email_con,
            ]);
        }
    
        // Actualizar la dirección asociada
        if ($user->address) {
            $user->address->update([
                'address_add' => $request->address_add,
            ]);
        }
        $request->validate([
            'index_card_id' => [
                'required_if:roll,aprendiz', // Esta regla solo hace obligatorio index_card_id si el rol es aprendiz
            ],
        ]);
        if($user->roll === 'aprendiz'){
            if($user->prueba){
                $user->prueba->update([
                    'index_card_id' => $request->index_card_id,
                ]);
            }
        }
       
       
        
        
        if ($currentRole !== 'aprendiz' && $request->roll === 'aprendiz') {
            // Si el nuevo rol es "aprendiz", se crea la relación
            $user->indexCards()->sync([$request->index_card_id]);
        } elseif ($currentRole === 'aprendiz' && $request->roll !== 'aprendiz') {
            // Si el nuevo rol no es "aprendiz", se elimina la relación
            $user->indexCards()->detach();
        }
      
       // return to_route('Borrower_users.index')->withErrors(['success' => 'usuario editado con exito']);
       return to_route('Borrower_users.index')->with('success', 'Usuario actualizado con éxito.');
       //return redirect()->route('user.dashboard')->withMessage('It works');
    }
    

    public function destroy(string $id)
    {
        $user = Borrower_users::findOrFail($id);
        if($user->status !== 'activo'){
            return redirect()->route('Borrower_users.index')->withErrors(['error' => 'No se puede inactivar este usuario']);  // Puedes personalizar este mensaje según tu necesidad.
        }
        $user->status = 'inactivo';
        $user->save();
        return to_route('Borrower_users.index');
       
    }

    public function activate(string $id)
    {
        $user = Borrower_users::find($id);
        $user->status = 'activo';
        $user->save();
        return to_route('Borrower_users.index');
    }

    public function pdfUsuarios()
    {
        $data = [
            'title' => 'Reporte de Usuarios',
        'users' => Borrower_users::with('contacts', 'address')->where('status', 'activo')->get(),
    ];                                  

    $pdf = Pdf::loadView('report_users', $data);
    return $pdf->download('reporte_usuarios.pdf');

    }
}

