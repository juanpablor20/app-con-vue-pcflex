<?php

namespace App\Http\Controllers;

use App\Models\Borrower_users;
use App\Models\Contacts;
use App\Models\Addresses;
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
        return Inertia::render('Borrower_users/Create');
    }

    public function store(Request $request)
    {
        request()->validate(Borrower_users::$rules);

        // Crear el usuario
        $user = Borrower_users::create($request->only('name', 'last_name', 'type_identification', 'number_identification', 'sex_user', 'gender_sex', 'roll'));

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
        return to_route('Borrower_users.index');
       // return redirect()->route('Borrower_users.index');
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
        $user = Borrower_users::with('contacts', 'address')->find($id);
        return Inertia::render('Borrower_users/Edit', [
            'user' => $user,
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
        return to_route('Borrower_users.index');
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

