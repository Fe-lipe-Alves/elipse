<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::query()->with('typeOfUser')->get();

        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }
        return Inertia::render('Auth/Register');
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
        (new CreateNewUser())->create($request->all());

        return redirect()->route('users.index');
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
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }
        return Inertia::render('Auth/Register', ['user_t' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->type_of_user_id !== 1 && Auth::user()->type_of_user_id !== 4) {
            abort(403);
        }

        $save = (new UserRepository())->update($user, $request->all());
        if ($save instanceof MessageBag) {
            dd($save);
        }
        return redirect()->route('users.index');
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
