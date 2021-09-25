<?php

namespace App\Repositories\Contracts;

use App\Models\Lesson;

interface LessonRepositoryInterface
{
    /**
     * Obtém todas as aulas com suas relações
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Cria ou atualiza um registro de aula
     *
     * @param array $data
     * @param Lesson|null $lesson
     * @return array
     */
    public function store(array $data, Lesson $lesson = null);

    /**
     * Aplica regras de validação nos dados do formulário
     *
     * @param array $data
     * @param Lesson|null $lesson
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Lesson $lesson = null);
}
