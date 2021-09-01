<?php

namespace Database\Seeders;

use App\Models\TypeOfUser;
use Illuminate\Database\Seeder;

class TypeOfUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfUser::query()->updateOrInsert([
            'description' => 'Administrador'
        ]);
        TypeOfUser::query()->updateOrInsert([
            'description' => 'Aluno'
        ]);
        TypeOfUser::query()->updateOrInsert([
            'description' => 'Professor'
        ]);
        TypeOfUser::query()->updateOrInsert([
            'description' => 'Secretario'
        ]);
    }
}
