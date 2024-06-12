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

        // Fetch data from the database
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
        // Find the doctor record by ID
        $doctor = doctor::findOrFail($id);

$specialitie=specialities::all();
        // Update the doctor fields with the request input
        $doctor->docname = $request->input('docname');
        $doctor->docemail = $request->input('docemail');
        $doctor->docnic = $request->input('docnic');
        $doctor->doctel = $request->input('doctel');
        //$doctor->specialities = $request->input('specialities');

        // Save the updated doctor record
        $doctor->save();

        // Redirect to the doctors index page with a success message
        return redirect()->route('admin_doctors');

    }
    public function delete(Doctor $doctor)
{
    // Fetch the schedule related to the doctor
    $schedule = Schedule::where("docid", $doctor->docid)->first();

    if ($schedule) {
        // Fetch appointments related to the schedule
        $appointment = Appointment::where("scheduleid", $schedule->scheduleid);

        // Fetch the user related to the doctor
        $user = User::where("email", $doctor->docemail)->first();

        // Delete related records
        $appointment->delete();
        if ($user) {
            $user->delete();
        }
        $schedule->delete();
    }

    // Delete the doctor record
    $doctor->delete();

    // Redirect to the admin doctors route
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
       /* User::create([
            'name' => $request->input('docname'),
        'email' => $request->input('docemail'),
        'role' => 'd',
    ]);*/
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
       // $filteredAppointments=Doctor::all();
        $appointments = appointment::orderBy('appid', 'desc')->get();
        //$patient=$appointments->patient->get();
        //$schedule=$appointments->schedule()->get();
        $appointments = Appointment::with(['patient', 'schedule'])->orderBy('appid', 'desc')->get();
        return view("admin.appointments", compact(["appointments", "today","doctors"]));
    }
    public function filterAppointments(Request $request)
    {
        $doctors=Doctor::all();
        $search=request('search');
        $doctor = doctor::where('docname','LIKE' ,$request->input("docname"))->first();
        // Logic to filter appointments based on date and doctor
        if($search)
        {
            $schedule=schedule::where('scheduledate', 'LIKE', "%{$search}%")
            ->orWhere('scheduledate',  $search)->get();
            $scheduleId=$doctor->schedule()->pluck('scheduleid');
            $appointments=appointment::whereIn('scheduleid',$scheduleId)->get();
        }
        else
        {
            $scheduleId=$doctor->schedule()->pluck('scheduleid');
            $appointments=appointment::whereIn('scheduleid',$scheduleId)->get();
        }

        //return view('admin.appointments', ['appointments' => $appointments,'doctors' => $doctors]);
        return $appointments;
    }



    public function deleteAppointment($id)
    {
        // Logic to delete a specific appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('admin_appointments')->with('success', 'Appointment deleted successfully');
    }
    public function schedule(){
    return view ("admin.schedule");
 }
}


