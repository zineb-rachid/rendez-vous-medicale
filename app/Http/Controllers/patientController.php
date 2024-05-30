<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\patient;
use App\Models\schedule;
use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index($id)
    {

        $today = now()->format('Y-m-d');

        $user = User::find($id);
        $useremail=$user->email;
        $patient = patient::where('pemail', $user->email)->first();
        $username = $patient->pname;

        $doctorCount = doctor::count();
        $patientCount = patient::count();
        $appointmentCount = appointment::where('appdate', '>=', $today)->count();
        $scheduleCount = schedule::where('scheduledate', $today)->count();

        $upcomingBookings = DB::table('schedule')
            ->join('appointment', 'schedule.scheduleid', '=', 'appointment.scheduleid')
            ->join('patients', 'patients.pid', '=', 'appointment.pid')
            ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
            ->where('patients.pid', $patient->pid)
            ->where('schedule.scheduledate', '>=', $today)
            ->orderBy('schedule.scheduledate', 'asc')
            ->get([
                'schedule.scheduleid',
                'schedule.title',
                'appointment.appnum',
                'doctor.docname',
                'schedule.scheduledate',
                'schedule.scheduletime'
            ]);
        return view('patient.index', compact('username', 'useremail', 'user', 'today', 'doctorCount', 'patientCount', 'appointmentCount', 'scheduleCount', 'upcomingBookings'));
    }
    public function doctors($id, Request $request)
    {
        $today = now()->format('Y-m-d');
        $user = user::find($id);
        $useremail = $user->email;
        $patient = patient::where('pemail', $user->email)->first();
        $username = $patient->pname;
        $search = request('search');

        if ($search) {
            $doctors = doctor::where('docemail', 'LIKE', "%{$search}%")
                ->orWhere('docname',  $search)
                ->get();
        } else {
            $doctors = Doctor::orderBy('docid', 'desc')->get();
        }

        return view('patient.doctors', compact('username', 'user', 'useremail', 'today', 'doctors'));
    }
    public function appointment($id)
    {
        $today = now()->format('Y-m-d');
        $user = user::find($id);
        $useremail = $user->email;
        $patient = patient::where('pemail', $user->email)->first();
        $username = $patient->pname;
        $search=request('search');

        if ($search) {
            $appointments = appointment::where('appdate', 'LIKE', "%{$search}%")
                ->orWhere('appdate',  $search)
                ->get();
        } 
        else {
            $appointments = appointment::orderBy('appdate', 'desc')->get();
        }

        return view('patient.appointment', compact('username', 'user', 'useremail', 'today','appointments'));
    }
}
