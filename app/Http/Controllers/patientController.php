<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\patient;
use App\Models\schedule;
use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function doctors($id)
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
            $appointments = appointment::where('pid',$patient->pid)
                ->where('appdate', 'LIKE', "%{$search}%")
                ->Where('appdate',  $search)
                ->get();
        }
        else
        {
            $appointments = appointment::orderBy('appdate', 'desc')
            ->where('pid',$patient->pid)
            ->get();
        }
        return view('patient.appointment', compact('username', 'user', 'useremail', 'today','appointments'));
    }




    public function deleteAppointment($id)
    {
        if($id){
            $appointment = appointment::find($id);
            $appointment->delete();
        }
        else 'no appointment ';
        return redirect()->back();
    }




    public function settings($id)
    {
        $today = now()->format('Y-m-d');
        $user = user::find($id);
        $patient=patient::find($id);
        $useremail = $user->email;
        $patient = patient::where('pemail', $user->email)->first();
        $username = $patient->pname;

        return view('patient.settings',compact('today' ,'user' ,'useremail' , 'username','patient'));
    }



    public function update($pid)
    {
        $patient = Patient::find($pid);
        $patientemail=$patient->pemail;
        $user=user::where("email",$patientemail)->first();

        $user->email=request('pemail');

        $patient->pname = request('pname');
        $patient->pemail = request('pemail');
        $patient->pnic = request('pnic');
        $patient->paddress = request('paddress');
        $patient->ptel = request('ptel');

        $pass = request('ppassword');
        $cpass = request('cpassword');

        if ($pass === $cpass)
        {
            $patient->ppassword = Hash::make($pass);
            $user->password = Hash::make($pass);
        }
        else
        {
            return redirect()->back()->withErrors(['error' => 'Password confirmation error! Reconfirm password.']);
        }

        $patient->save();
        $user->save();

        return redirect()->route('patient-settings',['id'=>$user->id]);
    }


    public function deleteAccount($email)
    {
        $user = User::where('email', 'LIKE' ,"%{$email}")->first();
        $patient=patient::where('pemail',$email)->first();
        $app=DB::table('appointment')->where('pid',$patient->pid);
        $app->delete();
        $user->delete();
        $patient->delete();
        return redirect()->route('logout');
    }

    
    public function schedule($id)
    {
        $today = now()->format('Y-m-d');
        $user = User::find($id);
        $username = $user->name;
        $useremail = $user->email;
        $search = request('search');

        if ($search) {
            $doctor = doctor::where('docname', $search)
                            ->orWhere('docemail', 'LIKE', "%{$search}%")
                            ->first();

            if ($doctor) {
                $schedule = schedule::where('docid', $doctor->docid)
                                    ->orWhere('scheduledate', 'LIKE', "%{$search}%")
                                    ->get();
            }
            elseif (strtotime($search) !== false)
            {
                $schedule = schedule::where('scheduledate', 'LIKE', "%{$search}%")->get();
            }
            else {
                $schedule = schedule::where('title', 'LIKE', "%{$search}%")->get();
            }
        }
        else
        {
            $schedule = schedule::all();
        }

        $countS = $schedule->count();

        return view('patient.schedule', compact('today', 'user', 'username', 'useremail', 'schedule', 'countS'));
    }
    public function booking($id,$schedule,$time)
    {
        $user=user::find($id);
        $useremail=$user->email;
        $patient=patient::where('pemail',$useremail)->first();
        $maxAppNum=appointment::max('appnum');
        $Fschedule=schedule::find($schedule);
        $scheduledate=$Fschedule->scheduledate;
        if (is_null($maxAppNum)) {
            $maxAppNum = 0;
        }
        $appointment=new appointment();
        $appointment->pid=$patient->pid;
        $appointment->appnum=$maxAppNum + 1;
        $appointment->scheduleid=$schedule;
        $appointment->appdate=$scheduledate;
        $appointment->apptime=$time;
        $appointment->save();
        return redirect()->route('patient-schedule',['id'=>$id]);
    }
}
