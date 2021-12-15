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

    /**
     * Atualiza o cronograma
     *
     * @param array $schedules
     * @param Lesson $lesson
     */
    public function updateSchedule(array $schedules, Lesson $lesson);

    /**
     * Deleta um registro de aula
     *
     * @param Lesson $lesson
     * @return array
     */
    public function destroy(Lesson $lesson);

    /**
     * Obtém toddas as aulas de um professor
     *
     * @param $teacher_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllByTeacher($teacher_id);

    /**
     * Obtém um vetor com o cronograma ocupado para o professor e aluno selecionado
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getScheduleAvailable(array $data);
}
