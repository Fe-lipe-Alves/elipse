<?php

namespace App\Http\Controllers;

use App\Models\StudentsClass;
use App\Models\Work;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use App\Support\Consts\TypeOfUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    private $repository;

    public function __construct(WorkRepositoryInterface $workRepository)
    {
        $this->repository = $workRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $works = $this->repository->getWorks();

        return view('works.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        /** @var StudentsClassInterface $students_class_repository */
        $students_class_repository = app(StudentsClassInterface::class);
        $studentsClasses = $students_class_repository->getAll();

        return view('works.form', compact('studentsClasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $response = $this->repository->store($request->all());

        if ($response['success']) {
            $response = array_merge($response, ['route' => route('works.index')]);
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Work $work
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Work $work)
    {
        /** @var StudentsClassInterface $students_class_repository */
        $students_class_repository = app(StudentsClassInterface::class);
        $studentsClasses = $students_class_repository->getAll();

        $studentsClassID = $work->studentsClass()->first();

        $lessons = $work->studentsClass()->first()->lessons()->with('subject')->get();

        return view('works.form', compact('studentsClasses', 'work', 'studentsClassID', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Work $work)
    {
        $response = $this->repository->store($request->all(), $work);

        if ($response['success']) {
            $response = array_merge($response, ['route' => route('works.index')]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Work $work)
    {
        $this->repository->delete($work);

        return redirect()->route('works.index');
    }

    public function getTeachers(StudentsClass $studentsClass)
    {
        return response()->json($studentsClass->teachers);
    }
}
