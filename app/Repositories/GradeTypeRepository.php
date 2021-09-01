<?php


namespace App\Repositories;


use App\Models\GradeType;
use App\Repositories\Contracts\GradeTypeRepositoryInterface;


class GradeTypeRepository implements GradeTypeRepositoryInterface
{
    /**
     * Obtém uma lista com todas os tipos de ensino
     *
     * @return GradeType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return GradeType::all();
    }
}
