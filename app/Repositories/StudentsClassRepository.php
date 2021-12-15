<?php


namespace App\Repositories;


use App\Models\StudentsClass;
use App\Models\User;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Support\Consts\GradeTypes;
use App\Support\Consts\TypeOfUsers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class StudentsClassRepository implements StudentsClassInterface
{

    /**
     * Obtém todas as classes de estudantes com seus relacionamentos
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return StudentsClass::query()->with('grade', function (BelongsTo $query) {
            $query->with('gradeType');
        })->get();
    }

    /**
     * Salva uma nova classe de alunos
     *
     * @param $data
     * @param null $studentsClass
     * @return array
     */
    public function create($data, $studentsClass = null): array
    {
        $validate = $this->validate($data);

        if ($validate->fails()) {
            return [
                'success' => false,
                'errors' => $validate->errors()
            ];
        }

        if (is_null($studentsClass)) {
            $studentsClass = new StudentsClass();
        }

        $studentsClass->fill([
            'grade_id' => $data['grade_id'],
            'name' => $data['name'],
            'active' => true
        ]);
        $studentsClass->save();

        $studentsClass->students()->sync($data['students']);
        return [
            'success' => true,
            'studentsClass' => $studentsClass,
        ];
    }

    /**
     * Aplica regras de validação nos dados recebidos
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => [
                    'required',
                ],
                'grade_id' => ['required'],
                'students' => ['required', 'array']
            ],
            [
                'name.required' => 'Nome é obrigatório',
                'students.required' => 'informe os estudantes desta turma'
            ]
        );
    }

    public function resolveNameGrade(StudentsClass $studentsClass)
    {
        return $studentsClass->grade->year .
            ($studentsClass->grade->grade_type_id == GradeTypes::ELEMENTARY ? 'º ano' : 'ª série') . ' ' .
            $studentsClass->name;
    }

    public function getStudentsWithoutClass()
    {
        return User::query()
            ->whereNotIn('id', function (Builder $query) {
                $query->select('student_id')
                      ->from('student_students_class');
            })
            ->where('type_of_user_id', TypeOfUsers::STUDENT)
            ->get();
    }
}
