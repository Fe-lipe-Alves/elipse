<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use App\Repositories\Contracts\GradeRepositoryInterface;
use App\Repositories\Contracts\GradeTypeRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Validated;
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
     * @return \Inertia\Response
     */
    public function index()
    {
        $studentsClass = $this->repository->getAll();

        return Inertia::render('StudentsClass/Index', [
            'studentsClass' => $studentsClass
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Declara os repositórios que serão usados
        /** @var GradeRepositoryInterface $gradeRepository */
        $gradeRepository = app(GradeRepositoryInterface::class);
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        // Obtém os dados das tabelas auxiliares
        $grade = $gradeRepository->getAll(true)->map(function($item) {
            $type = $item->gradeType->id == 1 ? 'ano' : 'série';

            return [
                'value' => $item->id,
                'description' => $item->year . ' ' . $type . ' / Ensino ' . $item->gradeType->description
            ];
        });

        $students = $userRepository->getActiveUser(2);

        return Inertia::render('StudentsClass/Create', [
            'grade' => $grade,
            'students' => $students
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('students_class.index');
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
     * @return \Inertia\Response
     */
    public function edit(StudentsClass $studentsClass)
    {
        // Declara os repositórios que serão usados
        /** @var GradeRepositoryInterface $gradeRepository */
        $gradeRepository = app(GradeRepositoryInterface::class);
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        // Obtém os dados das tabelas auxiliares
        $grade = $gradeRepository->getAll(true)->map(function($item) {
            $type = $item->gradeType->id == 1 ? 'ano' : 'série';

            return [
                'value' => $item->id,
                'description' => $item->year . ' ' . $type . ' / Ensino ' . $item->gradeType->description
            ];
        });

        $listStudents = $studentsClass->students->toArray();
        $listStudentsID = $studentsClass->students()->select('student_id')->get()->map(function ($item) {
            return $item->student_id;
        })->toArray();

        $students = $userRepository->getActiveUser(2)->filter(function ($item) use ($listStudentsID) {
            return !in_array($item->id, $listStudentsID);
        })->toArray();


        return Inertia::render('StudentsClass/Create', [
            'grade' => $grade,
            'studentsClass' => $studentsClass,
            'students' => $students,
            'listStudents' => $listStudents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentsClass  $studentsClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentsClass $studentsClass)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'grade_id' => 'required',
            ]
        );

        if ($validate->fails()) {
            return response()->json(false);
        }

        $studentsClass->fill($request->all());
        $studentsClass->save();

        $studentsClass->students()->sync($request->listClassStudents);







        return redirect()->route('students_class.index');
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
        $studentsClass->teachers();
    }
}
