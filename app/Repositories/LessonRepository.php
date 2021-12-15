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

    /**
     * Atualiza o cronograma
     *
     * @param array $schedules
     * @param Lesson $lesson
     */
    public function updateSchedule(array $schedules, Lesson $lesson)
    {
        $lesson->schedules()->delete();

        foreach ($schedules as $schedule) {
            $model = new ClassSchedule(['value' => $schedule, 'lesson_id' => $lesson->id]);
            $model->save();
        }
    }

    /**
     * Deleta um registro de aula
     *
     * @param Lesson $lesson
     * @return array
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->schedules()->delete();
        $deleted = $lesson->delete();

        return['success' => $deleted];
    }

    /**
     * Obtém toddas as aulas de um professor
     *
     * @param $teacher_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllByTeacher($teacher_id)
    {
        return Lesson::query()
            ->where('teacher_id', $teacher_id)
            ->with(['subject', 'teacher', 'studentsClass'])
            ->get();
    }

    /**
     * Obtém um vetor com o cronograma ocupado para o professor e aluno selecionado
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getScheduleAvailable(array $data)
    {
        return ClassSchedule::query()
            ->select('class_schedules.value')
            ->join('lessons', 'class_schedules.lesson_id', '=', 'lessons.id')
            ->join('students_classes', 'lessons.students_class_id', '=', 'students_classes.id')
            ->join('users', 'lessons.teacher_id', '=', 'users.id')
            ->where('students_class_id', $data['students_class_id'])
            ->orWhere('teacher_id', $data['teacher_id'])
            ->get()
            ->transform(function ($item) {
                return $item->value;
            })
            ->toArray();
    }
}
