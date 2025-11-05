<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signUp(Request $request){
        return view('auth/register');
     }

    public function signIn(Request $request){
        return view('auth/login');
     }

    public function register(Request $request) {
        //Validação
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/');
    }

    public function login(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6'
            ]);

            if (Auth::attempt($credentials)) {
                //Se o login for bem sucedido, redireciona para a página inicianl
                $request->session()->regenerate();
                return redirect('/');
            }

            return back()->withErrors([
                'email' => 'Email ou senha inválidos',
            ])->onlyInput('email');

        } catch (\Illuminate\Validation\ValidationException $e) {
            //throw $th;
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        redirect('/login');
    }
}
