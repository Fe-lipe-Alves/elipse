<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Registra sessão de autenticação
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ToDo // logar com RA ou CPF
        // ToDo // logar apenas users ativos
        if (Auth::attempt($credentials, $request->remember_me)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Email ou senhas inválidos.',
        ]);
    }
}
