<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            "pemail" => 'required|string|unique:patients,pemail',
            "fname" => 'required|alpha',
            "lname" => 'required|alpha',
            "ppassword" => 'required|string|min:8',
            "paddress" => 'required|string',
            "pnic" => 'required|string|unique:patients,pnic',
            "pdob" => 'required|date',
            'ptel' => 'required|min:10'
        ]);

        $patient = new patient();
        $patient->pemail = $request->input('pemail');
        $patient->pname = $request->input('fname') . ' ' . $request->input('lname');
        $patient->ppassword = Hash::make($request->input('ppassword'));
        $patient->paddress = $request->input('paddress');
        $patient->pnic = $request->input('pnic');
        $patient->pdob = $request->input('pdob');
        $patient->ptel = $request->input('ptel');
        $patient->save();

        $user = new User();
        $user->name = $patient->pname;
        $user->email = $patient->pemail;
        $user->password = Hash::make($request->input('ppassword'));
        $user->role = 'p';
        $user->save();

        return redirect()->route('login');
    }

    public function connecter(Request $request)
    {
        $request->validate([
            'useremail' => 'required|string|email',
            'userpassword' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $request->input('useremail'), 'password' => $request->input('userpassword')])) {
            $user = Auth::user(); 

            if ($user->role == 'p') {
                return redirect()->route('patient_index', ['id' => $user->id]);
            } elseif ($user->role == 'd') {
                return redirect()->route('doctors_index', ['id' => $user->id]);
            } elseif ($user->role == 'a') {
                return redirect()->route('admin_index');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Wrong credentials: Invalid email or password.']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

}
