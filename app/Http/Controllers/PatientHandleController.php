<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

class PatientHandleController extends Controller
{

    public function showCreate()
    {
        return view('createpatient');
    }

    public function create(Request $request)
    {
        $patientAttributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'taj' => 'required',
            'phone' => ''
        ]);

        $patientAttributes['password'] = bcrypt(bin2hex(openssl_random_pseudo_bytes(12)));

        Patient::create($patientAttributes);

        return back()->with('status',__('Successful user create!'));
    }
}
