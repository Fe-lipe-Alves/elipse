<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Support\Traits\HasModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectRepository implements Contracts\SubjectRepositoryInterface
{
    use HasModel;

    private $modelClass = Subject::class;

    /**
     * Obtém todas as disciplinas cadastradas
     *
     * @return Subject[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Subject::all();
    }

    /**
     * Valida, atualiza ou cria um novo registro de disciplina
     *
     * @param array $data
     * @param Subject|null $subject
     * @return array
     */
    public function store(array $data, Subject $subject = null)
    {
        $validator = $this->validate($data);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        if (is_null($subject)) {
            $subject = new Subject();
        }

        $subject->fill($data)->save();

        return [
            'success' => true,
            'subject' => $subject
        ];
    }

    /**
     * Aplica regra de validações nos dados recebidos
     *
     * @param array $data
     * @param Subject|null $subject
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Subject $subject = null)
    {
        $unique = Rule::unique('subjects', 'description');
        if (!is_null($subject)) {
            $unique->ignoreModel($subject);
        }

        return Validator::make(
            $data,
            [
                'description' => [
                    'required',
                    $unique
                ]
            ],
            [
                'description.required' => 'O campo descrição é obrigatório',
                'description.unique' => 'Já existe uma disciplina com esta descrição',
            ]
        );
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
    }
}
