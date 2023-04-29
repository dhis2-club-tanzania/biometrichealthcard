<?php

use App\Http\Controllers\FingerprintController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhifMemberController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/generateid', function () {
    return view('client');
});

Route::resource('patients', PatientController::class)
->middleware(['auth', 'verified']);

Route::resource('nhifmembers', NhifMemberController::class)
->middleware(['auth', 'verified']);

Route::get('/nhifMember/{nhifMember}/details/create', [FingerprintController::class, 'create'])->name('nhifMember.details.create');


Route::resource('fingerprints', FingerprintController::class)
->only(['index', 'store', 'destroy'])
->middleware(['auth', 'verified']);

Route::post('/search', [PatientController::class, 'search'])->name('search');

Route::get('/searchget/{str}', [PatientController::class, 'searchget'])->name('searchget');

Route::post('/saving', [PatientController::class, 'savetodatabase'])->name('savetodatabase');

Route::get('/generateFingerprintId', [PatientController::class, 'generateFingerprintId'])->name('generateFingerprintId');

require __DIR__.'/auth.php';
