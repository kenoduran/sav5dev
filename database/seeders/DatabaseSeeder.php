<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar la clase Hash

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 25 clientes
        Customer::factory()->count(25)->create();

        // Crear 15 proveedores
        Supplier::factory()->count(15)->create();

        // Crear 8 empleados
        Employee::factory()->count(8)->create();

        // Crear un usuario con nombre "Keno Duran", email "keno@mail.com" y contraseña "1234"
        User::create([
            'name' => 'Keno Duran',
            'email' => 'keno@mail.com',
            'password' => Hash::make('1234'),
        ]);
    }
}
