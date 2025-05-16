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
        $user=User::where('role','a')->first();

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
                ->orderBy('schedule.scheduletime', 'asc')
                ->select('appointment.appid', 'schedule.scheduleid', 'schedule.title', 'doctor.docname', 'patients.pname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.appnum', 'appointment.appdate')
                ->get();

            $upcomingSessions = DB::table('schedule')
                ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->where('doctor.docname', $search)
                ->orWhere('doctor.docemail', "LIKE", "%{$search}%")
                ->orderBy('schedule.scheduledate', 'desc')
                ->orderBy('schedule.scheduletime', 'asc')
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
                ->orderBy('schedule.scheduletime', 'asc')
                ->select('appointment.appid', 'schedule.scheduleid', 'schedule.title', 'doctor.docname', 'patients.pname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.appnum', 'appointment.appdate')
                ->get();

            $upcomingSessions = DB::table('schedule')
                ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
                ->whereBetween('schedule.scheduledate', [$today, $nextWeek])
                ->orderBy('schedule.scheduledate', 'desc')
                ->orderBy('schedule.scheduletime', 'asc')
                ->select('schedule.scheduleid', 'schedule.title', 'doctor.docname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop')
                ->get();
        }

        return view('admin.index', compact('doctorsCount','user', 'doctors', 'patients', 'appointments', 'schedules', 'upcomingAppointments', 'upcomingSessions', 'today', "nextWeek"));
    }

    public function doctors(){
        $today = now()->format('Y-m-d');
        $specialities=specialities::all();
        $user=User::where('role','a')->first();
        $doctors = doctor::orderBy('docid', 'desc')->get();
        return view("admin.doctors", compact(["doctors", "today","specialities","user"]));
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
    $user = User::where('email', 'LIKE' ,value: "%{$doctor->docemail}")->first();

    if ($schedule) {
        $appointment = Appointment::where("scheduleid", $schedule->scheduleid);
        $appointment->delete();

        $schedule->delete();
    }
    if ($user) {
        $user->delete();
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
        $user=User::where('role','a')->first();
        $today = now()->format('Y-m-d');
        $patients = patient::orderBy('pid', 'desc')->get();
        return view("admin.patients", compact(["patients", "today","user"]));
    }

    public function searchPatients(Request $request){
        $user=User::where('role','a')->first();
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

        return view("admin.patients", compact(["patients", "today",'user']));
    }
    public function appointment(Request $request) {
        $today = now()->format('Y-m-d');
        $user = User::where('role', 'a')->first();
        $docname = $request->input('docname');
        $date = $request->input('search');

        if ($docname) {
            $doctor = Doctor::where('docname', $docname)->first();
            $schedules = Schedule::where('docid', $doctor->docid)->get();
            $scheduleIds = $schedules->pluck('scheduleid');
            $appointments = Appointment::whereIn('scheduleid', $scheduleIds)->get();
        } elseif (strtotime($date) !== false) {
            $schedules = Schedule::where('scheduledate', 'LIKE', "%{$date}%")->get();
            $scheduleIds = $schedules->pluck('scheduleid');
            $appointments = Appointment::whereIn('scheduleid', $scheduleIds)->get();
        } else {
            $doctors = Doctor::all();
            $appointments = Appointment::with(['patient', 'schedule'])->orderBy('appid', 'desc')->get();
        }

        $doctors = $doctors ?? Doctor::all();

        return view("admin.appointments", compact("user", "appointments", "today", "doctors"));
    }

    public function deleteAppointment($id)
    {

        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('admin_appointment')->with('success', 'Appointment deleted successfully');
    }
    public function schedule(Request $request) {
        $today = now()->format('Y-m-d');
        $user=User::where('role','a')->first();
        $searchDocId = $request->input('docid');
        $searchDate = $request->input('sheduledate');

        $query = schedule::query();

        if ($searchDocId && $searchDocId != "0") {
            $query->where('docid', $searchDocId);
        }

        if ($searchDate) {
            $query->whereDate('scheduledate', $searchDate);
        }

        $schedule = $query->with(['doctor', 'appointment.patient'])->get();
        $doctors = doctor::all();

        return view("admin.schedule", compact('today', 'schedule', 'doctors',"user"));
    }

    public function deleteSchedule($id){
        $schedule=schedule::where('scheduleid',$id)->first();
        $appointments=appointment::where('scheduleid',$schedule->scheduleid)->get();
        foreach($appointments as $app){
            $app->delete();
        }
        $schedule->delete();
        return redirect()->route("admin_schedule");
    }
    public function addSchedule(){
        $schedule= new schedule();
        $schedule->title=request('title');
        $schedule->docid=request('docid');
        $schedule->nop=request('nop');
        $schedule->scheduledate=request('scheduledate');
        $schedule->scheduletime=request('scheduletime');
        $schedule->save();
        return redirect()->route("admin_schedule");
    }
}
