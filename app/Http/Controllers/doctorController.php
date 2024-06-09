<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\patient;
use App\Models\schedule;
use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class doctorController extends Controller
{
    public function index($id)
    {
        $today = now()->format('Y-m-d');

        $user = User::find($id);
        $useremail=$user->email;
        $doctor = doctor::where('docemail','LIKE' ,"%{$useremail}%")->first();
        $docname=$doctor->docname;
        $docemail=$doctor->docemail;

        $doctorCount = doctor::count();
        $patientCount = patient::count();
        $appointmentCount = appointment::join('schedule','schedule.scheduleid','=','appointment.scheduleid')->
        join('doctor','doctor.docid','=','schedule.docid')->
        where('doctor.docid',$doctor->docid)->
        where('appdate', '>=', $today)->count();
        $scheduleCount = $doctor->schedule()->where('scheduledate', $today)->count();
        $schedule = $doctor->schedule()->get();

        return view('doctor.index',compact('today','doctor','docname','docemail','user','doctorCount', 'patientCount', 'appointmentCount', 'scheduleCount','schedule'));
    }
    public function appointment($id)
    {
        $today = now()->format('Y-m-d');
        $user = User::find($id);
        $useremail=$user->email;
        $doctor = doctor::where('docemail','LIKE' ,"%{$useremail}%")->first();
        $docname=$doctor->docname;
        $search=request('search');

        if($search)
        {
            $schedule=schedule::where('scheduledate', 'LIKE', "%{$search}%")
            ->orWhere('scheduledate',  $search)->get();
            $scheduleId=$doctor->schedule()->pluck('scheduleid');
            $appointment=appointment::whereIn('scheduleid',$scheduleId)->get();
        }
        else
        {
            $scheduleId=$doctor->schedule()->pluck('scheduleid');
            $appointment=appointment::whereIn('scheduleid',$scheduleId)->get();
        }

        $appcount=$appointment->count();
        return view('doctor.appointment',compact('user','docname','useremail','today','appointment','appcount'));
    }
    public function dropApp($id)
    {
        $app=appointment::find($id);
        $app->delete();
        return redirect()->back();
    }
    public function setting($id)
    {
        $today = now()->format('Y-m-d');
        $user = User::find($id);
        $useremail=$user->email;
        $doctor = doctor::where('docemail','LIKE' ,"%{$useremail}%")->first();
        $docname=$doctor->docname;
        $spec=$doctor->specialities->sname;
        return view('doctor.setting',compact('user','docname','useremail','today','doctor','spec'));
    }
    public function deleteAccount($email)
    {
        $user = User::where('email', 'LIKE' ,"%{$email}")->first();
        $doctor = doctor::where('docemail',$email)->first();
        $schedule=DB::table('schedule')->where('docid',$doctor->docid);
        $schedule->delete();
        $user->delete();
        $doctor->delete();
        return redirect()->route('logout') ;
    }
    public function accountUpdate($docid)
    {
        $doctor = Doctor::find($docid);
        if (!$doctor) {
            return redirect()->back()->withErrors(['error' => 'Doctor not found.']);
        }

        $doctoremail = $doctor->docemail;
        $user = User::where('email', $doctoremail)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Associated user not found.']);
        }

        $newEmail = request('docemail');
        if (User::where('email', $newEmail)->exists() && $newEmail != $doctoremail) {
            return redirect()->back()->withErrors(['error' => 'Email already exists, try another one.']);
        }

        $user->email = $newEmail;
        $doctor->docemail = $newEmail;
        $doctor->docname = request('docname');
        $doctor->docnic = request('docnic');
        $doctor->doctel = request('doctel');

        $pass = request('docpassword');
        $cpass = request('cpassword');
        if ($pass === $cpass) {
            $doctor->docpassword = Hash::make($pass);
            $user->password = Hash::make($pass);
            $doctor->save();
            $user->save();
            return redirect()->route('doctors_setting', ['id' => $user->id]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Password Confirmation Error! Reconfirm Password.']);
        }
    }



    public function schedule($id)
    {
        $today=now()->format('Y-m-d');
        $user=user::find($id);
        $useremail=$user->email;
        $doctor= doctor::where('docemail',$useremail)->first();
        $docid=$doctor->docid;
        $docname=$doctor->docname;
        $docemail=$doctor->docemail;
        $search=request('search');
        if($search)
        {
            $schedule=schedule::where('docid',$docid)->where('scheduledate',$search)->get();
        }
        else
        {
            $schedule=schedule::where('docid',$docid)->get();
        }
        $scheduleCount=$schedule->count();
        return view('doctor.schedule',compact('today','doctor','schedule','docname','docemail','user','scheduleCount'));
    }



    public function dropSchedule($scheduleid)
    {
        $schedule=schedule::find($scheduleid);
        $appointment=appointment::where('scheduleid',$scheduleid);
        $appointment->delete();
        $schedule->delete();
        return redirect()->back();
    }


    public function patient($id)
{
    $today = now()->format('Y-m-d');
    $user = User::find($id);
    $useremail = $user->email;
    $doctor = Doctor::where('docemail', $useremail)->first();
    $docname = $doctor->docname;
    $docemail = $doctor->docemail;
    $search = request('query');
    $showonly = request('showonly');
    $current = 'My patients Only';

    $scheduleIds = $doctor->schedule()->pluck('scheduleid');

    $appointments = Appointment::whereIn('scheduleid', $scheduleIds)->get();

    if ($search) {
        $patients = Patient::where('pname', 'like', "%{$search}%")
            ->orWhere('pemail', 'like', "%{$search}%")
            ->get();
    } else {
        if ($showonly)
        {
            if ($showonly == 'all')
            {
                $patients = Patient::all();
                $current='All Patients';
            }
            else
            {
                $patients = $appointments->map(function ($appointment) {
                    return $appointment->patient;
                });
            }
        }
        else
        {
            $patients = $appointments->map(function ($appointment) {
                return $appointment->patient;
            });
        }
    }

    $patientsCount = $patients->count();

    return view('doctor.patient', compact('today', 'user', 'docname', 'docemail', 'patients', 'patientsCount', 'current'));
}


}
