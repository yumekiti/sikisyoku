<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//認証
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use App\User;

class UserController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        return $user;
    }

    public function signin(Request $request)
    {
        if (Auth::attempt($request->all())) {
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => ['メールアドレスまたはパスワードが違います。'],
        ]);
    }

    public function signup(Request $req){
        User::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'email_verified_at' => now(),
            'password' => bcrypt($req->input('password')),
            'remember_token' => Str::random(10),
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
    }

}
