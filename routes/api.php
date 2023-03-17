<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/newfingerprint', [PatientController::class, 'RegisterFingerprint']);

Route::post('/registerfingerprint', [PatientController::class, 'RegisterNewFingerprint']);
Route::post('/savefingerprint', [PatientController::class, 'savefingerprint']);



Route::post('/generate-ids', [ClientController::class, 'generateIds']);
Route::post('/save-status', [ClientController::class, 'saving']);
