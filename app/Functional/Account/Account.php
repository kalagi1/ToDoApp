<?php 

namespace App\Functional\Account;

use App\Functional\Account\Services\Login;
use App\Functional\Account\Services\Register;
use Illuminate\Support\Facades\Auth;

class Account implements IAccount {
    use Login,Register;
    public $_account;

    public function __construct()
    {
        $this->_account = Auth::guard('api')->user();
    }

    public function userDetail(){
        return Auth::guard('api')->user();
    }

    

    
}