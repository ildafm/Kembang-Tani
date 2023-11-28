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
    return redirect('dashboard');
});

Route::get('/x', function () {
    return view('monitoring.cuaca_monitor');
});

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('dashboard/getrealtime', [DashboardController::class, 'getRealtimeData'])->name('dashboard_getrealtime');

Route::get('monitoring/zone-one', [ZoneOneController::class, 'index']);
Route::get('monitoring/zone-two', [ZoneTwoController::class, 'index']);

Route::get('monitoring/zone-one/getrealtimedata', [ZoneOneController::class, 'getRealTimeData'])->name('zone1_getrealtimedata');
Route::get('monitoring/zone-two/getrealtimedata', [ZoneTwoController::class, 'getRealtimeData'])->name('zone2_getrealtimedata');
