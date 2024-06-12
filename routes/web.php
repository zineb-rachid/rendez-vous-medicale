<?php

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/signup', function () {
    return view('signup');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', [signupController::class,'logout'])->name('logout');

Route::post('/register', [signupController::class, 'signup'])->name('register');

Route::post('/connecter', [signupController::class, 'connecter'])->name('connecter');

Route::get('/patient/{id}', [PatientController::class, 'index'])->name('patient_index');

Route::get('/patient/{id}/doctors', [PatientController::class, 'doctors'])->name('patient_doctors');

Route::get('/patient/{id}/doctors', [PatientController::class, 'doctors'])->name('patient_doctors_search');

Route::get('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments');

Route::post('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments_search');
Route::get('/admin',[adminController::class,'index'])->name('admin_index');

Route::get('/admin/doctors', [adminController::class, 'doctors'])->name('admin_doctors');

Route::get('/admin/doctors/search', [adminController::class, 'index'])->name('admin_doctors_search');

Route::put('/admin/doctors/{id}', [adminController::class, 'update'])->name('admin_doctors_update');

Route::get('/admin/doctors/{doctor}', [adminController::class, 'delete'])->name('admin_doctors_delete');

Route::post('/admin/storedoctor', [adminController::class, 'store'])->name('doctors.store');

Route::get('/admin/schedule', [adminController::class, 'index'])->name('admin_schedule');

Route::get('/admin/appointments',[adminController::class,'index'])->name('admin_appointments');

Route::get('/admin/patient/{id}', [adminController::class, 'patients'])->name('admin_patients');

Route::get('/admin/patients', [adminController::class, 'patients'])->name('admin_patients');

Route::get('/admin/patients/search', [adminController::class, 'searchPatients'])->name('admin_patients_search');

Route::get('/admin/appointment', [adminController::class, 'appointment'])->name('admin_appointments');
Route::GET('/admin/appointment/filter', [adminController::class, 'filterAppointments'])->name('appointments.filter');
Route::get('/admin/appointment/delete/{id}', [adminController::class, 'deleteAppointment'])->name('appointments.delete');
