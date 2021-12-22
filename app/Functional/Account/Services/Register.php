<?php 

namespace App\Functional\Account\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

trait Register{
    public static function register(){
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->error('Invalid paramaters',$validator->errors(), 400);
        }
        $input = request()->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if ($user->save()) {
            return response()->success('User added successfully.', [] , 200);
        } else {
            return response()->error('There was a problem while registering the user.', 400);
        }
    }
}