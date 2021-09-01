<?php


namespace App\Repositories;


use App\Models\Grade;
use App\Repositories\Contracts\GradeRepositoryInterface;
use App\Support\Traits\HasModel;


class GradeRepository implements GradeRepositoryInterface
{
    /**
     * Obtém uma lista com todas as séries
     *
     * @param false $relationship
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll($relationship = false)
    {
        $query = Grade::query();

        if ($relationship) {
            $query->with('gradeType');
        }

        return $query->get();
    }
}
