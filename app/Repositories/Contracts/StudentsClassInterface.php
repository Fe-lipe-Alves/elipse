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

    /**
     * Salva uma nova classe de alunos
     *
     * @param $data
     * @param null $studentsClass
     * @return array
     */
    public function create($data, $studentsClass = null): array;

    /**
     * Aplica regras de validação nos dados recebidos
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data);
}
