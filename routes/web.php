<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FingerprintController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhifMemberController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Models\Fingerprint;
use App\Models\NhifMember;
use Carbon\Carbon;

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
     $member = NhifMember::count();
    $fingerprint = Fingerprint::count();

    // Get the start and end dates of the last week
    $startDate = Carbon::now()->subWeek()->startOfWeek();
    $endDate = Carbon::now()->subWeek()->endOfWeek();

    // Get the count of records added in the last week
    $weeklyCount = Fingerprint::whereBetween('created_at', [$startDate, $endDate])->count();
    $percentage = $fingerprint > 0 ? round(($weeklyCount / $member) * 100, 2) : 0;

    // graph data
    $data = [
        'labels' => ['Weekly Fingerprint Registration', 'Total Members'],
        'datasets' => [
            [
                'label' => 'weekly Count',
                'data' => [$weeklyCount, $member],
                'backgroundColor' => ['#E4A11B', '#54B4D3'],
            ]
        ]
    ];

    // $member = NhifMember::count();
    return view('dashboard',  ['member' => $member, 'fingerprint' => $fingerprint, 'percentage' => $percentage, 'data' => $data]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {

    $member = NhifMember::count();
    $fingerprint = Fingerprint::count();

    // Get the start and end dates of the last week
    $startDate = Carbon::now()->subWeek()->startOfWeek();
    $endDate = Carbon::now()->subWeek()->endOfWeek();

    // Get the count of records added in the last week
    $weeklyCount = Fingerprint::whereBetween('created_at', [$startDate, $endDate])->count();
    $percentage = $fingerprint > 0 ? round(($weeklyCount / $member) * 100, 2) : 0;

    // graph data
    $data = [
        'labels' => ['Weekly Fingerprint Registration', 'Total Members'],
        'datasets' => [
            [
                'label' => 'weekly Count',
                'data' => [$weeklyCount, $member],
                'backgroundColor' => ['#E4A11B', '#54B4D3'],
            ]
        ]
    ];

    // $member = NhifMember::count();
    return view('dashboard',  ['member' => $member, 'fingerprint' => $fingerprint, 'percentage' => $percentage, 'data' => $data]);
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

Route::get('/nhifMember/report', [NhifMemberController::class, 'report'])->name('nhifMember.report');

Route::get('/fingerprint/report', [FingerprintController::class, 'report'])->name('fingerprint.report');

Route::get('/authentication/{authenticated_id}', [AuthenticationController::class, 'startvisitpage'])->name('authentication');

Route::resource('fingerprints', FingerprintController::class)
->only(['index', 'store', 'destroy'])
->middleware(['auth', 'verified']);

Route::resource('authentications', AuthenticationController::class)
->middleware(['auth', 'verified']);

Route::post('/search', [PatientController::class, 'search'])->name('search');

Route::get('/searchget/{str}', [PatientController::class, 'searchget'])->name('searchget');

Route::post('/saving', [PatientController::class, 'savetodatabase'])->name('savetodatabase');

Route::get('/generateFingerprintId', [PatientController::class, 'generateFingerprintId'])->name('generateFingerprintId');

require __DIR__.'/auth.php';
