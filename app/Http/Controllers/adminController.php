<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\doctor;
use App\Models\patient;
use App\Models\scheduel;
use App\Models\schedule;
use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\specialities;

class adminController extends Controller
{
    public function index(){
        $today = now()->format('Y-m-d');


        $doctorsCount = DB::table('doctor')->get();
        $patients = DB::table('patients')->get();
        $appointments = DB::table('appointment')
            ->where('appdate', '>=', $today)
            ->get();
        $schedules = DB::table('schedule')
            ->where('scheduledate', $today)
            ->get();

        $nextWeek = now()->addWeek()->format('Y-m-d');

        $search = request('search');

        if ($search) {
            $doctors = doctor::where('docemail', 'LIKE', "%{$search}%")
                ->orWhere('docname', $search)
                ->get();
            $upcomingAppointments = DB::table('appointment')
                ->join('schedule', 'schedule.scheduleid', '=', 'appointment.scheduleid')
                ->join('patients', 'patients.pid', '=', 'appointment.pid')
                ->join('doctor', 'doctor.docid', '=', 'schedule.docid')
                ->where('doctor.docname', $search)
                ->orWhere('doctor.docemail', "LIKE", "%{$search}%")
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->orderBy('schedule.scheduledate', 'desc')
                ->select('appointment.appid', 'schedule.scheduleid', 'schedule.title', 'doctor.docname', 'patients.pname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.appnum', 'appointment.appdate')
                ->get();

            $upcomingSessions = DB::table('schedule')
                ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->where('doctor.docname', $search)
                ->orWhere('doctor.docemail', "LIKE", "%{$search}%")
                ->orderBy('schedule.scheduledate', 'desc')
                ->select('schedule.scheduleid', 'schedule.title', 'doctor.docname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop')
                ->get();
        } else {
            $doctors = doctor::orderBy('docid', 'desc')->get();
            $upcomingAppointments = DB::table('appointment')
                ->join('schedule', 'schedule.scheduleid', '=', 'appointment.scheduleid')
                ->join('patients', 'patients.pid', '=', 'appointment.pid')
                ->join('doctor', 'doctor.docid', '=', 'schedule.docid')
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->orderBy('schedule.scheduledate', 'desc')
                ->select('appointment.appid', 'schedule.scheduleid', 'schedule.title', 'doctor.docname', 'patients.pname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.appnum', 'appointment.appdate')
                ->get();

            $upcomingSessions = DB::table('schedule')
                ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->orderBy('schedule.scheduledate', 'desc')
                ->select('schedule.scheduleid', 'schedule.title', 'doctor.docname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop')
                ->get();
        }

        return view('admin.index', compact('doctorsCount', 'doctors', 'patients', 'appointments', 'schedules', 'upcomingAppointments', 'upcomingSessions', 'today', "nextWeek"));
    }

    public function doctors(){
        $today = now()->format('Y-m-d');
        $specialities=specialities::all();
        $doctors = doctor::orderBy('docid', 'desc')->get();
        return view("admin.doctors", compact(["doctors", "today","specialities"]));
    }
    public function update(Request $request, $id)
    {

        $doctor = doctor::findOrFail($id);

$specialitie=specialities::all();

        $doctor->docname = $request->input('docname');
        $doctor->docemail = $request->input('docemail');
        $doctor->docnic = $request->input('docnic');
        $doctor->doctel = $request->input('doctel');
        $doctor->save();
        return redirect()->route('admin_doctors');

    }
    public function delete(Doctor $doctor)
{

    $schedule = Schedule::where("docid", $doctor->docid)->first();

    if ($schedule) {
        $appointment = Appointment::where("scheduleid", $schedule->scheduleid);

        $user = User::where("email", $doctor->docemail)->first();

        $appointment->delete();
        if ($user) {
            $user->delete();
        }
        $schedule->delete();
    }

    $doctor->delete();

    return redirect()->route('admin_doctors');
}

public function store (Request $request){
    $doctor = new doctor();
    $specialitie= specialities::where("sname","=",$request->input('speciality'));
    $doctor->docname = $request->input('docname');
    $doctor->docemail = $request->input('docemail');
    $doctor->docnic = $request->input('docnic');
    $doctor->doctel = $request->input('doctel');
    $doctor->docpassword = $request->input('docpassword');
    $doctor->docspecialitie = 1;
    $doctor->save();
    $user=new User();
    $user->name=$request->input('docname');
    $user->email=$request->input('docemail');
    $user->role='d';
    $user->password=$request->input('docpassword');
    $user->save();
   return redirect()->route('admin_doctors');
}
    public function patients(){
        $today = now()->format('Y-m-d');
        $patients = patient::orderBy('pid', 'desc')->get();
        return view("admin.patients", compact(["patients", "today"]));
    }

    public function searchPatients(Request $request){
        $today = now()->format('Y-m-d');
        $search = $request->input('search');

        if ($search) {
            $patients = patient::where('pname', 'LIKE', "%{$search}%")
                ->orWhere('pemail', 'LIKE', "%{$search}%")
                ->orderBy('pid', 'desc')
                ->get();
        } else {
            $patients = patient::orderBy('pid', 'desc')->get();
        }

        return view("admin.patients", compact(["patients", "today"]));
    }
    public function appointment(){
        $today = now()->format('Y-m-d');
        $doctors=Doctor::all();
        $appointments = appointment::orderBy('appid', 'desc')->get();
        $appointments = Appointment::with(['patient', 'schedule'])->orderBy('appid', 'desc')->get();
        return view("admin.appointments", compact(["appointments", "today","doctors"]));
    }
    public function filterAppointments(Request $request)
    {

        $request->validate(
            [
                'docname' => 'required',
                'search' => 'required',
            ]
        );


        $doctors = Doctor::all();
        $apps = Appointment::all();
        $filtereddoctor = $request->input("docname");
        $search = $request->input('search');


        $doctor = Doctor::where('docname', '=', $filtereddoctor)->first();


        $filttredappointment = collect();

        if ($doctor) {

            $schedules = Schedule::where('scheduledate', 'LIKE', "%{$search}%")
                                ->orWhere('scheduledate', $search)
                                ->where('docid',"=",$doctor->docid)
                                ->pluck('scheduleid');

            $filttredappointment = Appointment::whereIn('scheduleid', $schedules)->get();
        }


        return view('admin.appointments', [
            'filttredappointment' => $filttredappointment,
            'doctors' => $doctors,
            'apps' => $apps
        ]);
    }





    public function deleteAppointment($id)
    {

        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('admin_appointments')->with('success', 'Appointment deleted successfully');
    }
}
 public function schedule(){
         return view ("admin.schedule");
    }
