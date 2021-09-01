<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Support\Permissions;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Permissions::all() as $key => $permission) {
            Permission::query()->updateOrInsert([
                'id' => $key,
                'description' => $permission,
            ]);
        }
    }
}
