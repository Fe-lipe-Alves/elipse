<?php

namespace App\Repositories;

use App\Mail\NewWork;
use App\Models\ResponseWork;
use App\Models\User;
use App\Models\Work;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Support\Traits\HasModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WorkRepository implements WorkRepositoryInterface
{
    use HasModel;

    private $modelClass = Work::class;

    /**
     * Obtém todos os trabalhos registrados
     *
     * @return Work[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getWorks()
    {
        return Work::query()->with(['lesson.subject', 'lesson.studentsClass.grade.gradeType'])->get();
    }

    /**
     * Obtém todos os trabalhos registrados para o professor
     *
     * @return Work[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getWorksByTeacher($teacher_id)
    {
        return Work::query()
            ->select('works.*')
            ->join('lessons', 'works.lesson_id', '=', 'lessons.id')
            ->where('teacher_id', $teacher_id)
            ->with(['lesson.subject', 'lesson.studentsClass.grade.gradeType'])
            ->get();
    }

    /**
     * Obtém todos os trabalhos registrados para o aluno
     *
     * @return Work[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getWorksByStudent($student_id)
    {
        return Work::query()
            ->select('works.*')
            ->join('lessons', 'works.lesson_id', '=', 'lessons.id')
            ->join('student_students_class', 'lessons.students_class_id', '=', 'student_students_class.id')
            ->where('student_id', $student_id)
            ->with(['lesson.subject', 'lesson.studentsClass.grade.gradeType'])
            ->get();
    }

    /**
     * Cria ou atualiza um registro de trabalho
     *
     * @param array $data
     * @param Work|null $work
     * @return array
     */
    public function store(array $data, Work $work = null): array
    {
        $validator = $this->validate($data, $work);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        $new = false;
        if (is_null($work)) {
            $work = new Work();
            $new = true;
        }

        DB::beginTransaction();

        try {
            $work->fill($data)->save();

            /** @var FileRepositoryInterface $fileRepository */
            $fileRepository = app(FileRepositoryInterface::class);

            if (isset($data['files'])) {
                $saved = $fileRepository->save($work, $data['files']);
                if (!$saved['success']){
                    return $saved;
                }
            }

            if (isset($data['deletefile'])){
                $fileRepository->deletedById($data['deletefile']);
            }

            DB::commit();

            if ($new) {
                $this->sendEmailStudentsClass($work);
            }

            return [
                'success' => true,
                'work' => $work,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return [
                'success' => false,
                'message' => 'Ocorreu um erro ao salvar',
            ];
        }
    }

    /**
     * Aplica regras de validação nos campos do formulário
     *
     * @param array $data
     * @param Work|null $work
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Work $work = null)
    {
        return Validator::make(
            $data,
            [
                'deadline' => ['required', 'date', 'after:now'],
                'lesson_id' => ['required', Rule::exists('lessons', 'id')],
                'description' => ['required'],
            ],
            [
                'deadline.required' => 'O campo prazo é obrigatório',
                'deadline.date' => 'O campo prazo está incorreto',
                'deadline.after' => 'O prazo dever ser uma data e hora futura',
                'lesson_id.required' => 'O campo aula é obrigatório',
                'lesson_id.exists' => 'Aula informada não encontrada',
                'description.required' => 'O campo descrição é obrigatório',
            ]
        );
    }

    /**
     * Deleta um registro de trabalho
     *
     * @param Work $work
     * @return array
     */
    public function delete(Work $work): array
    {
        /** @var FileRepositoryInterface $fileRepository */
        $fileRepository = app(FileRepositoryInterface::class);

        foreach ($work->files as $file) {
            $fileRepository->deletedById($file->id);
        }

        $deleted = $work->delete();

        return [
            'success' => $deleted
        ];
    }

    /**
     * Adiciona uma resposta para o aluno no trabalho recebido
     *
     * @param Work $work
     * @param User $user
     * @param array $data
     * @return bool[]|false[]
     */
    public function saveResponse(Work $work, User $user, array $data): array
    {
        $response = ResponseWork::query()
            ->where('student_id', $user->id)
            ->where('work_id', $work->id)
            ->first();
        if (!$response) {
            $response =  new ResponseWork();
            $response->student_id = $user->id;
            $response->work_id = $work->id;
            $response->save();
        }

        /** @var FileRepositoryInterface $fileRepository */
        $fileRepository = app(FileRepositoryInterface::class);

        if (isset($data['files'])) {
            $saved = $fileRepository->save($response, $data['files']);
            if (!$saved['success']) {
                return $saved;
            }
        }

        if (isset($data['deletefile'])){
            $fileRepository->deletedById($data['deletefile']);
        }

        return [
            'success' => true
        ];
    }

    public function sendEmailStudentsClass(Work $work)
    {
        $students = $work->studentsClass()->first()->students;

        foreach ($students as $student) {
            Mail::send(new NewWork($student, $work));
        }
    }
}
