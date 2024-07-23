<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate()
        ]);
    }
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required',
            'type_identification' => 'required',
            'number_identification' => 'required|unique:users,number_identification',
            'sexo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'type_identification' => $request->type_identification,
            'number_identification' => $request->number_identification,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        return redirect('users');
    }
    public function show(string $id)
    {
        $user = User::find($id);
        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'type_identification' => 'required',
            'number_identification' => 'required|unique:users,number_identification,' . $user->id,
            'sexo' => 'required',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'email' => 'required|email',
        ]);

        // Actualizar el usuario
        $user->update($request->only('name', 'last_name', 'type_identification', 'number_identification', 'sexo', 'telefono', 'direccion', 'email'));
        return to_route('users.index');
    }
    public function destroy(string $id)

    {
        $user = User::find($id);

        $user->delete();
    }
}
