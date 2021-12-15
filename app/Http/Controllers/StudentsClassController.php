<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use App\Repositories\Contracts\GradeRepositoryInterface;
use App\Repositories\Contracts\GradeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Consts\TypeOfUsers;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StudentsClassController extends Controller
{
    protected $repository;

    public function __construct(StudentsClassInterface $studentsClass)
    {
        $this->repository = $studentsClass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $studentsClass = $this->repository->getAll();

        return view('students-classes.index', compact('studentsClass'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        // Declara os repositórios que serão usados
        /** @var GradeRepositoryInterface $gradeRepository */
        $gradeRepository = app(GradeRepositoryInterface::class);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        /** @var SubjectRepositoryInterface $subjectRepository */
        $subjectRepository = app(SubjectRepositoryInterface::class);

        // Obtém os dados das tabelas auxiliares
        $grade = $gradeRepository->getAll(true)->map(function($item) {
            $type = $item->gradeType->id == 1 ? 'ano' : 'série';

            return [
                'value' => $item->id,
                'description' => $item->year . ' ' . $type . ' / Ensino ' . $item->gradeType->description
            ];
        });

        $students = $this->repository->getStudentsWithoutClass();
        $teachers = $userRepository->getActiveUser(TypeOfUsers::TEACHER);

        $subjects= $subjectRepository->getAll();

        return view('students-classes.form', compact('grade', 'students', 'subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->repository->create($request->all());

        if ($response['success']){
            return redirect()->route('students_class.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentsClass  $studentsClass
     * @return \Illuminate\Http\Response
     */
    public function show(StudentsClass $studentsClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentsClass  $studentsClass
     * @return
     */
    public function edit(StudentsClass $studentsClass)
    {
        // Declara os repositórios que serão usados
        /** @var GradeRepositoryInterface $gradeRepository */
        $gradeRepository = app(GradeRepositoryInterface::class);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        /** @var SubjectRepositoryInterface $subjectRepository */
        $subjectRepository = app(SubjectRepositoryInterface::class);

        // Obtém os dados das tabelas auxiliares
        $grade = $gradeRepository->getAll(true)->map(function($item) {
            $type = $item->gradeType->id == 1 ? 'ano' : 'série';

            return [
                'value' => $item->id,
                'description' => $item->year . ' ' . $type . ' / Ensino ' . $item->gradeType->description
            ];
        });

        $students = $userRepository->getActiveUser(TypeOfUsers::STUDENT);
        $teachers = $userRepository->getActiveUser(TypeOfUsers::TEACHER);

        $subjects= $subjectRepository->getAll();

        return view('students-classes.form', compact('studentsClass', 'grade', 'students', 'subjects', 'teachers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StudentsClass $studentsClass
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StudentsClass $studentsClass)
    {
        $response = $this->repository->create($request->all(), $studentsClass);

        if ($response['success']){
            return redirect()->route('students_class.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentsClass  $studentsClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentsClass $studentsClass)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        $studentsClass->delete();
        return redirect()->route('students_class.index');
    }

    public function checkName(Request $request)
    {
        $exists = StudentsClass::query()->where('name', $request->name)->where('active', true)->exists();
        if ($exists) {
            return response()->json(['exists'=> true]);
        }
        return response()
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->json(['exists'=> false]);
    }

    public function teachers(StudentsClass $studentsClass)
    {
        return [
            'success' => true,
            'lessons' => $studentsClass->lessons()->with('subject')->get()
        ];
    }
}
