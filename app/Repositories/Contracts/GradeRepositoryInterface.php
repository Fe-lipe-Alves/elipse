<?php


namespace App\Repositories\Contracts;


interface GradeRepositoryInterface
{
    /**
     * Obtém uma lista com todas as séries
     *
     * @param false $relationship
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll($relationship = false);
}
