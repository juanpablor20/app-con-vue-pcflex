<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear tres usuarios usando la fábrica de usuarios
        User::factory()->create();
        
        // Llamar al seeder de roles y permisos
       

        // Crear usuarios específicos
        User::factory()->create([
            'name' => 'juan P',
            'last_name' => 'ramos',
            'type_identification' => 'cc',
            'number_identification' => '1004250142',
            'sexo' => 'masculino',
            'telefono' => '3224110856',
            'direccion' => 'la plata',
            'email' => 'juan@example.com', 
            'password' => Hash::make('password123'), 
        ]);

        User::factory()->create([
            'name' => 'wimer',
            'last_name' => 'vargas',
            'type_identification' => 'cc',
            'number_identification' => '1004250143', 
            'sexo' => 'masculino',
            'telefono' => '3224110857',
            'direccion' => 'la plata',
            'email' => 'wimer@example.com', 
            'password' => Hash::make('password123'), 
        ]);
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
