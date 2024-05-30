<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
  public function index(){
    $today =now()->format('Y-m-d');

        // Fetch data from the database
        $doctors = DB::table('doctor')->get();
        $patients = DB::table('patients')->get();
        $appointments = DB::table('appointment')
            ->where('appdate', '>=', $today)
            ->get();
        $schedules = DB::table('schedule')
            ->where('scheduledate', $today)
            ->get();

        $nextWeek =now()->addWeek()->format('Y-m-d');
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

        return view('admin.index', compact('doctors', 'patients', 'appointments', 'schedules', 'upcomingAppointments', 'upcomingSessions', 'today',"nextWeek"));
    }
}
