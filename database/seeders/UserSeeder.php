<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            'name' => 'Administrador',
                'email' => 'administrador@elipse.com',
            'password' => Hash::make('123456'),
            'type_of_user_id' => 1
        ];

        if (! User::query()->where(Arr::only($attributes, 'email'))->exists()) {
            User::query()->create($attributes);
        }
    }
}
