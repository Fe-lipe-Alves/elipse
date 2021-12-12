<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\TypeOfUser;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            'Artes',
            'Biologia',
            'Ciências',
            'Educação Física',
            'Filosofia',
            'Fisica',
            'Geografia',
            'História',
            'Inglês',
            'Lingua Portuguesa',
            'Matemática',
            'Química',
            'Sociologia',
        ];

        foreach ($subjects as $subject) {
            Subject::query()->updateOrInsert([
                'description' => $subject
            ]);
        }
    }
}
