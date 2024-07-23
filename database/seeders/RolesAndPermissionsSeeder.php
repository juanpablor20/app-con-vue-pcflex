<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $coordinador = Role::create(['name' => 'coordinador']);
        $bibliotecario = Role::create(['name' => 'bibliotecario']);

        // Crear permisos
        $crudBibliotecario = Permission::create(['name' => 'crud.bibliotecario']);
        $gestionarRecursos = Permission::create(['name' => 'gestionar.recursos']);

        // Asignar permisos al rol coordinador
        $coordinador->givePermissionTo($crudBibliotecario);

        // Asignar permisos al rol bibliotecario
        $bibliotecario->givePermissionTo($gestionarRecursos);

        // Opcional: asignar permisos a los roles si lo deseas de manera explícita (esto no es necesario si ya estás usando givePermissionTo)
        $crudBibliotecario->assignRole($coordinador);
        $gestionarRecursos->assignRole($bibliotecario);


        $user = User::find(2); // Encuentra al usuario por su ID (o crea uno si no existe)
        $user->assignRole($coordinador);

        $user2 = User::find(3); // Encuentra otro usuario por su ID
        $user2->assignRole($bibliotecario);
    }
}
