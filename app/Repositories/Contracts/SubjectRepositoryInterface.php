<?php

namespace App\Repositories\Contracts;

use App\Models\Subject;

interface SubjectRepositoryInterface
{
    /**
     * Obtém todas as disciplinas cadastradas
     *
     * @return Subject[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Valida, atualiza ou cria um novo registro de disciplina
     *
     * @param array $data
     * @param Subject|null $subject
     * @return array
     */
    public function store(array $data, Subject $subject = null);

    /**
     * Aplica regra de validações nos dados recebidos
     *
     * @param array $data
     * @param Subject|null $subject
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Subject $subject = null);
}
