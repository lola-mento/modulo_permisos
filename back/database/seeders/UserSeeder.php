<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create
        (
            [
                'persona_id' => '1',
                'usuario' => 'eleop',
                'clave' => '123'
            ]
            );

        User::factory(9)->create();
    }
}
