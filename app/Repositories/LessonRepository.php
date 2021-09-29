<?php

namespace App\Repositories;

use App\Models\ClassSchedule;
use App\Models\Lesson;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Support\Traits\HasModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LessonRepository implements LessonRepositoryInterface
{
    use HasModel;

    private $modelClass = Lesson::class;

    /**
     * Obtém todas as aulas com suas relações
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Lesson::query()->with(['subject', 'teacher', 'studentsClass'])->get();
    }

    /**
     * Cria ou atualiza um registro de aula
     *
     * @param array $data
     * @param Lesson|null $lesson
     * @return array
     */
    public function store(array $data, Lesson $lesson = null)
    {
        $validator = $this->validate($data, $lesson);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        if (is_null($lesson)) {
            $lesson = new Lesson();
        }

        $lesson->fill($data)->save();

        $this->updateSchedule($data['class_schedule'], $lesson);

        return [
            'success' => true,
            'lesson' => $lesson,
        ];
    }

    /**
     * Aplica regras de validação nos dados do formulário
     *
     * @param array $data
     * @param Lesson|null $lesson
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Lesson $lesson = null)
    {
        return Validator::make(
            $data,
            [
                'subject_id' => ['required', Rule::exists('subjects', 'id')],
                'teacher_id' => ['required', Rule::exists('users', 'id')],
                'students_class_id' => ['required', Rule::exists('students_classes', 'id')],
            ],
            [
                'subject_id.required' => 'O campo disciplina é obrigatório',
                'teacher_id.required' => 'O campo professor é obrigatório',
                'students_class_id.required' => 'O campo turma é obrigatório',
            ]
        );
    }

    public function updateSchedule(array $schedules, Lesson $lesson)
    {
        $lesson->schedules()->delete();

        foreach ($schedules as $schedule) {
            $model = new ClassSchedule(['value' => $schedule, 'lesson_id' => $lesson->id]);
            $model->save();
        }
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->schedules()->delete();
        $deleted = $lesson->delete();

        return['success' => $deleted];
    }
}
