<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::PATIENTHOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('signed')->only('firstLogin');
    }

    public function showLoginForm()
    {
        return view('patient.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('patient');
    }

}
