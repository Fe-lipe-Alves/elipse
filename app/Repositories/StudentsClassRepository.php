<?php


namespace App\Repositories;


use App\Models\StudentsClass;
use App\Repositories\Contracts\StudentsClassInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function create($data)
    {
        $validate = Validator::make(
            $data,
            [
                'name' => 'required', Rule::unique('students_class', 'name')->ignore(false, 'active'),
                'grade_id' => 'required',
            ],
            [
                'name.required' => 'Nome é obrigatório',
                'name.unique' => 'Nome é obrigatório',
            ]
        );

        $exists = StudentsClass::query()->where('name', $data['name'])->where('active', true)->exists();
        if ($exists) {
            return response()->json(['error'=>['name' => 'Esta turma já existe']]);
        }

        if ($validate->fails()) {
            return response()->json(false);
        }

        $studentsClass = new StudentsClass([
            'grade_id' => $data['grade_id'],
            'name' => $data['name'],
            'active' => !!$data['active']
        ]);
        $studentsClass->save();

        $studentsClass->students()->sync($data['listClassStudents']);
    }

    public function validate()
    {

    }
}
