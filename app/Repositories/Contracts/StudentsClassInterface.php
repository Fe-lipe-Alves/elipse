<?php


namespace App\Repositories\Contracts;


interface StudentsClassInterface
{
    /**
     * Obtém todas as classes de estudantes com seus relacionamentos
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll();
}
