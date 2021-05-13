<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('tipo_usuarios')->insert([
            [
                'nombre' => 'Solicitante',
            ],
            [
                'nombre' => 'Prestador',
            ],
        ]);
        DB::table('users')->insert([
            [
                'razon_social' => 'Luis J',
                'email' => 'luis@luis.com',
                'password' => Hash::make(12345678),
            ],
            [
                'razon_social' => 'Jorge Perez',
                'email' => 'jorge@email.com',
                'password' => Hash::make(12345678),
            ],
        ]);
    }
}
