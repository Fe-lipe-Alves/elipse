<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

        if (Auth::attempt($credentials, $request->remember_me)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email ou senhas inválidos.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function resetPasswordSendEmail(Request $request)
    {
        if (!$request->has('email')) {
            return redirect()->back()->withErrors(['email' => 'Este campo é obrigatório']);
        }

        $user = User::query()->where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Usuário não encontrado']);
        }

        $token = Hash::make($request->email);

        $user->remember_token = $token;
        $user->save();

        Mail::send(new ResetPassword($user));

        return view('auth.feedback', ['message' => 'Acesse o link enviado para seu e-mail']);
    }

    public function resetPasswordReturn(Request $request)
    {
        if (!$request->has('token')) {
            return view('auth.feedback', ['message' => 'Erro ao redefinir senha']);
        }

        $user = User::query()->where('remember_token', $request->token)->first();
        if ($user) {
            return view('auth.reset_password', [
                'token' => $request->token,
            ]);
        }

        return view('auth.feedback', ['message' => 'Erro ao redefinir senha']);
    }

    public function resetPasswordSave(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'password' => 'required|confirmed|min:6',
                'token' => 'required',
            ],
            [
                'password.required' => 'Preencha todos os campos',
                'password.confirmed' => 'Senha e confirmação não correspondem',
                'password.min' => 'Senha deve conter 6 caracteres',
                'token' => 'Erro ao salvar senha',
            ]
        )->validate();

        $user = User::query()->where('remember_token', $request->token)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->remember_token = null;
            $user->save();
            return redirect()->route('login');
        }
        return view('auth.feedback', ['message' => 'Erro ao redefinir senha']);
    }
}
