<?php 

namespace App\Functional\Account\Services;

use Illuminate\Support\Facades\Auth;

trait Login{
    public static function login(){
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['user_id'] = $user->id;
            $success['email'] = $user->email;
            $success['name'] = $user->name;
            return response()->success("Başarıyla giriş yaptınız",$success,200);
        } else {
            return response()->error('Email veya şifre yanlış.',[],401);
        }
    }
}