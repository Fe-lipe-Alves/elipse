<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    private $grades = [
        // Ensino Fundamental
        ['grade_type_id' => 1, 'year' => 6],
        ['grade_type_id' => 1, 'year' => 7],
        ['grade_type_id' => 1, 'year' => 8],
        ['grade_type_id' => 1, 'year' => 9],

        // Ensino Médio
        ['grade_type_id' => 2, 'year' => 1],
        ['grade_type_id' => 2, 'year' => 2],
        ['grade_type_id' => 2, 'year' => 3],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->grades as $value) {
            Grade::query()->updateOrInsert($value);
        }
    }
}
