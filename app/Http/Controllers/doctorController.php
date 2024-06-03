<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\patient;
use App\Models\schedule;
use App\Models\appointment;
use Illuminate\Http\Request;

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
}
