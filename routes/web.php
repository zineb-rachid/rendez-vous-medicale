<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\signupController;
use Illuminate\Auth\Events\Logout;

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

Route::post('/patient/{id}/doctors', [PatientController::class, 'doctors'])->name('patient_doctors_search');

Route::get('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments');

Route::post('/patient/{id}/appointments',[PatientController::class,'appointment'])->name('patient-appointments_search');