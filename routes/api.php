<?php

use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaContoller;
use App\Http\Controllers\UserController;
use App\Models\MataPelajaran;
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

Route::post('/login', [UserController::class, 'postLoginSiswa']);
Route::post('/logout', [UserController::class, 'postLogout']);


Route::get('/dashboard', [SiswaContoller::class, 'getDataSiswa']);
Route::get('/getMapelSiswa/{id}', [SiswaContoller::class, 'getDataMapelSiswa']);
Route::get('/getDetailMapel/{id}', [SiswaContoller::class, 'detailMapel']);
Route::get('/getMateriMapel/{id}', [SiswaContoller::class, 'materiMapel']);
Route::get('/getTugasKu/{id}', [SiswaContoller::class, 'getTugasKu']);
Route::get('/getDetailTugas/{id}', [SiswaContoller::class, 'detailTugas']);
Route::get('/getDetailKuis/{id}', [SiswaContoller::class, 'detailKuis']);
Route::get('/getDetailMateri/{id}', [SiswaContoller::class, 'detailMateri']);
Route::get('/getKuisSiswa/{id}', [SiswaContoller::class, 'daftarKuis']);
Route::get('/getTugasSiswa/{id}', [SiswaContoller::class, 'getTugasSiswa']);
Route::get('/getDaftarSiswa/{id}', [SiswaContoller::class, 'daftarSiswa']);
Route::get('/getJadwalku/{id}', [SiswaContoller::class, 'jadwalku']);
Route::get('/getDateRange', [SiswaContoller::class, 'dateRange']);
Route::get('/getListChatbot/{id}', [SiswaContoller::class, 'listChatbot']);

Route::get('matapelajaran', [MapelController::class, 'index']);
Route::post('matapelajaran/store', [MapelController::class, 'store']);
Route::get('matapelajaran/store/{id}', [MapelController::class, 'show']);
Route::post('matapelajaran/update/{id}', [MapelController::class, 'update']);
Route::delete('matapelajaran/delete/{id}', [MapelController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
