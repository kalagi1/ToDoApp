<?php

namespace App\Http\Controllers;

use App\Functional\Account\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function login(){
        return Account::login();
    }

    public function register(){
        return Account::register();
    }
}
