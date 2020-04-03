<?php

namespace App\Http\Controllers;

use App\Events\PatientRegistration;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $patientAttributes['password'] = Hash::make(bin2hex(openssl_random_pseudo_bytes(12)));

        $patient = Patient::create($patientAttributes);

        event(new PatientRegistration($patient));

        return back()->with('status',__('Successful user create!'));
    }

    public function resendVerificationEmail(Request $request)
    {
        $data = $request->validate(['patientId' => 'required']);

        $patient = Patient::find($data['patientId']);

        if ($patient === null) {
            return back()->with('status', __('Patient not exists'));
        }

        if (is_null($patient->email_verified_at)) {
            return back()->with('status', __('Verified patient, can not send verification!'));
        }

        $patient->sendVerificationEmail();

        return back()->with('status', __('Verification email sent!'));
    }

    public function list()
    {

    }
}
