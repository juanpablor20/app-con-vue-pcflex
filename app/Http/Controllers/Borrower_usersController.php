<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Contacts;
use App\Models\Addresses;
use App\Models\Index_cards;
use App\Models\Relationships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class Borrower_usersController extends Controller
{
    public function index()
    {
        return Inertia::render('Borrower_users/Index', [
            'users' => Borrower_users::with('contacts', 'address')->paginate(),
           

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
      
        return to_route('Borrower_users.index');
    }
 

    public function show(string $id)
    {
        $user = Borrower_users::with('contacts', 'address')->find($id);

        return Inertia::render('Borrower_users/Show', [
            'user' => $user,
        ]);
    }

    public function edit(string $id)
    {
        $user = Borrower_users::with('contacts', 'address', 'indexCards')->find($id);
        $index_Cards = Index_cards::where('status', 'activo')->get();
        
        return Inertia::render('Borrower_users/Edit', [
            'user' => $user,
            'index_cards' => $index_Cards // Asegúrate de que esta línea esté aquí
        ]);
    }
    
    

    public function update(Request $request, string $id)
    {
        $user = Borrower_users::findOrFail($id);
        
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
      
       // return to_route('Borrower_users.index')->withErrors(['success' => 'usuario editado con exito']);
       return to_route('Borrower_users.index')->with('success', 'Usuario actualizado con éxito.');
       //return redirect()->route('user.dashboard')->withMessage('It works');
    }
    

    public function destroy(string $id)
    {
        $user = Borrower_users::findOrFail($id);
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
}

