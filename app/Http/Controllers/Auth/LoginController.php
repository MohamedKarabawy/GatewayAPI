<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users\Auth\Login;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->auth = new Login();
    }

    public function login(Request $request)
    {
        return $this->auth->login($request);
    }
}
