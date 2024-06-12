<?php

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\doctorController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('welcome');});

Route::get('/signup', function () {return view('signup');});

Route::get('/login', function () { return view('login');})->name('login');

Route::get('/logout', [signupController::class,'logout'])->name('logout');

Route::post('/register', [signupController::class, 'signup'])->name('register');

Route::post('/connecter', [signupController::class, 'connecter'])->name('connecter');

Route::get('/patient/{id}', [PatientController::class, 'index'])->name('patient_index');

Route::get('/patient/{id}/doctors', [PatientController::class, 'doctors'])->name('patient_doctors');

Route::post('/patient/{id}/doctors', [PatientController::class, 'doctors'])->name('patient_doctors_search');

Route::get('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments');

Route::post('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments_search');

Route::get('/patient/{id}/Deleteappointments',[PatientController::class,'deleteAppointment'])->name('patient-appointments-delete');

Route::get('/patient/{id}/settings',[PatientController::class,'settings'])->name('patient-settings');

Route::put('/patient/settings/update/{pid}', [PatientController::class, 'update'])->name('patient-settings-update');

Route::get('/patient/setting/deleteAccount/{email}', [PatientController::class, 'deleteAccount'])->name('patient-delete-account');

Route::get('/patient/{id}/schedules',[PatientController::class,'schedule'])->name('patient-schedule');

Route::post('/patient/{id}/schedules',[PatientController::class,'schedule'])->name('patient-schedule_search');

Route::get('/patient/{id}/schedules/{schedule}/{time}',[PatientController::class,'booking'])->name('patient-schedule-booking');

Route::get('/doctors/{id}', [doctorController::class, 'index'])->name('doctors_index');

Route::get('/doctors/appointment/{id}', [doctorController::class, 'appointment'])->name('doctors_appointment');

Route::post('/doctors/appointment/{id}', [doctorController::class, 'appointment'])->name('doctors_appointment_search');

Route::get('/doctors/dropAppointment/{id}', [doctorController::class, 'dropApp'])->name('doctors_appointment_delete');

Route::get('/doctors/schedule/{id}', [doctorController::class, 'schedule'])->name('doctors_schedule');

Route::post('/doctors/schedule/{id}/',[doctorController::class,'schedule'])->name('doctors_schedule_search');

Route::get('/doctors/schedule/delete/{scheduleid}',[doctorController::class,'dropSchedule'])->name('doctors_schedule_delete');

Route::get('/doctors/patient/{id}', [doctorController::class, 'patient'])->name('doctors_patient');

Route::post('/doctors/patient/{id}', [doctorController::class, 'patient'])->name('doctors_patient_search');

Route::get('/doctors/setting/{id}', [doctorController::class, 'setting'])->name('doctors_setting');

Route::get('/doctors/deleteAccount/{email}', [doctorController::class, 'deleteAccount'])->name('doctors_delete-account');

Route::put('/doctors/settings/update/{docid}',[doctorController::class,'accountUpdate'])->name('doctors_setting_update');

Route::get('/admin',[adminController::class,'index'])->name('admin_index');

Route::get('/admin/doctors', [adminController::class, 'doctors'])->name('admin_doctors');

Route::get('/admin/doctors/search', [adminController::class, 'index'])->name('admin_doctors_search');

Route::put('/admin/doctors/{id}', [adminController::class, 'update'])->name('admin_doctors_update');

Route::get('/admin/doctors/{doctor}', [adminController::class, 'delete'])->name('admin_doctors_delete');

Route::post('/admin/storedoctor', [adminController::class, 'store'])->name('doctors.store');

Route::get('/admin/schedule', [adminController::class, 'schedule'])->name('admin_schedule');

Route::get('/admin/appointments',[adminController::class,'index'])->name('admin_appointments');

Route::get('/admin/patient/{id}', [adminController::class, 'patients'])->name('admin_patients');

Route::get('/admin/patients', [adminController::class, 'patients'])->name('admin_patients');

Route::get('/admin/patients/search', [adminController::class, 'searchPatients'])->name('admin_patients_search');

Route::get('/admin/appointment', [adminController::class, 'appointment'])->name('admin_appointments');

Route::GET('/admin/appointment/filter', [adminController::class, 'filterAppointments'])->name('appointments.filter');

Route::get('/admin/appointment/delete/{id}', [adminController::class, 'deleteAppointment'])->name('appointments.delete');

Route::get('/admin/schedule', [adminController::class, 'schedule'])->name('admin_schedule');
