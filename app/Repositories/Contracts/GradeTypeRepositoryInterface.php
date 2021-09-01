<?php


namespace App\Repositories\Contracts;


use App\Models\GradeType;

interface GradeTypeRepositoryInterface
{
    /**
     * Obtém uma lista com todas os tipos de ensino
     *
     * @return GradeType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll();
}
