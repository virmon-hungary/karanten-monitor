<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use App\Patient;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirstLoginController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::PATIENTHOME;

    public function login(Request $request)
    {
        $patient = Patient::find($request->route('id'));

        if ( !is_null($patient->email_verified_at) ) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($patient->getEmail()))) {
            throw new AuthorizationException;
        }

        $this->guard()->login($patient);

        return view('patient.auth.passwords.first');

    }

    public function password(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|confirmed|min:8'
            ]
        );

        $request->user()->firstPasswordSave($data['password']);

        return redirect($this->redirectPath());
    }

    protected function guard()
    {
        return Auth::guard();
    }

}