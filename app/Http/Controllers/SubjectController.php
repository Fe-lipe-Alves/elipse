<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $repository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->repository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $subjects = $this->repository->getAll();

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('subjects.form');
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
            return redirect()->route('subjects.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Subject $subject
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Subject $subject)
    {
        return view('subjects.form', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Subject $subject)
    {
        $response = $this->repository->store($request->all(), $subject);

        if ($response['success']) {
            return redirect()->route('subjects.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Subject $subject)
    {
        $this->repository->destroy($subject);

        return redirect()->route('subjects.index');
    }
}
