<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class UserController extends Controller
{
    public $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::query()->with('typeOfUser')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        return view('users.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        $response = $this->repository->store($request->all());

        if ($response['success']) {
            return redirect()->route('users.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        return view('users.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        $response = $this->repository->store($request->all(), $user);

        if ($response['success']) {
            return redirect()->route('users.index');
        }

        return redirect()->back()->withErrors($response['errors']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('users.index');
    }
}
