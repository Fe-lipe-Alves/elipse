<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Repositories\Contracts\StudentsClassInterface;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LessonController extends Controller
{
    private $repository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->repository = $lessonRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $lessons = $this->repository->getAll();

        return view('lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $teachers = $userRepository->getTechers();

        /** @var StudentsClassInterface $studentsClassRepository */
        $studentsClassRepository = app(StudentsClassInterface::class);
        $studentsClasses = $studentsClassRepository->getAll();

        /** @var SubjectRepositoryInterface $subjectRepository */
        $subjectRepository = app(SubjectRepositoryInterface::class);
        $subjects = $subjectRepository->getAll();

        $busySchedule = [];

        return view('lessons.form', compact(
            'teachers',
            'studentsClasses',
            'subjects',
            'busySchedule')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->repository->store($request->all());
        if ($response['success']) {
            return redirect()->route('lessons.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Lesson $lesson)
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $teachers = $userRepository->getTechers();

        /** @var StudentsClassInterface $studentsClassRepository */
        $studentsClassRepository = app(StudentsClassInterface::class);
        $studentsClasses = $studentsClassRepository->getAll();

        /** @var SubjectRepositoryInterface $subjectRepository */
        $subjectRepository = app(SubjectRepositoryInterface::class);
        $subjects = $subjectRepository->getAll();

        $schedules = $lesson->schedules()->select('value')->get()->toArray();
        $schedules = Arr::flatten($schedules);

        $busySchedule = $this->repository->getScheduleAvailable($lesson->toArray());

        return view('lessons.form', compact(
            'teachers',
            'studentsClasses',
            'subjects',
            'lesson',
            'schedules',
            'busySchedule',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lesson $lesson)
    {
        $response = $this->repository->store($request->all(), $lesson);
        if ($response['success']) {
            return redirect()->route('lessons.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lesson $lesson)
    {
        $this->repository->destroy($lesson);

        return redirect()->route('lessons.index');
    }

    /**
     * Obtém o cronograma disponível para a turma e professor informados
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultSchedule(Request $request)
    {
        $response = $this->repository->getScheduleAvailable($request->all());

        return response()->json($response);
    }
}
