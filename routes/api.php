<?php

use App\Http\Controllers\API\KeluarController;
use App\Http\Controllers\API\KendaraanController;
use App\Http\Controllers\API\MasukController;
use App\Http\Controllers\API\ParkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('kendaraan', [KendaraanController::class, 'index']);
Route::get('tersedia', [ParkirController::class, 'index']);
Route::get('parkir/masuk', [MasukController::class, 'index']);
Route::get('parkir/keluar', [KeluarController::class, 'index']);
Route::get('masuk', [MasukController::class, 'index']);
Route::post('parkir/store', [ParkirController::class, 'store']);
Route::post('masuk/store', [MasukController::class, 'store']);
Route::post('keluar/store', [KeluarController::class, 'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
