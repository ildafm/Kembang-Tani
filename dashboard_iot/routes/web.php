<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\DashboardController;
use App\Http\Controllers\Firebase\ZoneOneController;
use App\Http\Controllers\Firebase\ZoneTwoController;

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

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('dashboard/getrealtime', [DashboardController::class, 'getRealtimeData'])->name('dashboard_getrealtime');

Route::get('monitoring/zone-one', [ZoneOneController::class, 'index']);
Route::get('monitoring/zone-two', [ZoneTwoController::class, 'index']);
Route::get('monitoring/zone-one/getrealtime', [ZoneOneController::class, 'getRealtimeData'])->name('zone1_getrealtime');
Route::get('monitoring/zone-two/getrealtime', [ZoneTwoController::class, 'getRealtimeData'])->name('zone2_getrealtime');
