<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruLoginController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


// Get Route
Route::get('/addquizz', function () {
    return view('pages.addquizz');
});



//Routing Login
Route::get('/login', [UserController::class, 'getLogin']);
Route::get('/admin-login', [UserController::class, 'getAdminLogin']);
Route::post('createAccount', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'postLogin']);
Route::post('/logout', [UserController::class, 'postLogout']);


Route::group(['middleware' => 'auth'], function () {
    //Routing Get
    Route::get('/manajemenPelajaran', [PelajaranController::class, 'getAllData']);
    Route::get('/task', [PelajaranController::class, 'getTaskData']);
    Route::get('/detail/hasil/{id}', [PelajaranController::class, 'getSelectedReport']);
    Route::get('/detail/kuis/{id}', [PelajaranController::class, 'getSelectedKuis']);
    Route::get('/detail/kelas/{id}', [PelajaranController::class, 'getSelectionClass']);
    Route::get('/detail/tugas/{id}', [PelajaranController::class, 'getSelectedTask']);
    Route::get('/detail/modul/{id}', [PelajaranController::class, 'getSelectedModul']);
    Route::get('/detail/matapelajaran/{id}', [PelajaranController::class, 'getSelectedMapel']);
    Route::get('/get-pdf/{id}', [PDFController::class, 'generatePDF']);
    Route::get('/getPersonalMapel', [PelajaranController::class, 'getPersonalMapel']);
    Route::get('/addguru', [UserController::class, 'addGuru']);
    Route::get('/addmodul/{id}', [PelajaranController::class, 'getAddModul']);
    Route::get('/addtask/{id}', [PelajaranController::class, 'addTask']);
    Route::get('/addquiz/{id}', [PelajaranController::class, 'addQuiz']);
    Route::get('/addquizz/{id}', [PelajaranController::class, 'getAddIsiKuis']);
    Route::get('/pengguna', [PenggunaController::class, 'getPengguna']);
    Route::get('/dashboard', [DashboardController::class, 'getDashboard']);
    Route::get('/materi', [PelajaranController::class, 'getAllModul']);
    Route::get('/kuis', [PelajaranController::class, 'getKuis']);
    Route::get('/chatbot', [DashboardController::class, 'chatbotDashboard']);
    Route::get('/detail/chatbot/{id}', [DashboardController::class, 'detailChatbot']);
    Route::get('/botRingkasan', [DashboardController::class, 'botRingkas']);
    Route::get('/', [DashboardController::class, 'getDashboard']);
    Route::get('tes', [PelajaranController::class, 'getAllActivities']);
    Route::get('/addQuestion/{id}', [DashboardController::class, 'addQuestion']);
    Route::get('/addGroups', [DashboardController::class, 'addGroupSoal']);
    Route::get('/addOpsi/{id}', [DashboardController::class, 'addOpsi']);
    Route::get('/configQuiz/{id}', [DashboardController::class, 'configQuiz']);
    Route::get('/detailSoal/{id}', [DashboardController::class, 'detailSoal']);
    Route::get('/getNlp', [DashboardController::class, 'nLP']);
    Route::get('/profile/{id}', [DashboardController::class, 'getProfile']);

    //Routing Post
    Route::post('/addPeriod', [PelajaranController::class, 'addPeriod']);
    Route::post('/addKelas', [PelajaranController::class, 'addKelas']);
    Route::post('/storeSiswa', [PelajaranController::class, 'trialPost']);
    Route::post('/storeMapel', [PelajaranController::class, 'addMapel']);
    Route::post('/storeAddTugas/{id}', [PelajaranController::class, 'storeAddTugas']);
    Route::post('/storeAddModul/{id}', [PelajaranController::class, 'storeAddModul']);
    Route::post('/storeAddQuiz/{id}', [PelajaranController::class, 'storeAddKuis']);
    Route::post('/storeAddGuru', [PenggunaController::class, 'storeGuru']);
    Route::post('/storeBot', [DashboardController::class, 'createBot']);
    Route::post('/storeListChatbot', [DashboardController::class, 'createListChatbot']);
    Route::post('/storeGroup', [DashboardController::class, 'createGroups']);
    Route::post('/storeSoal', [DashboardController::class, 'createQuestion']);
    Route::post('/storeOpsi', [DashboardController::class, 'createOption']);
    Route::post('/storeNLP', [DashboardController::class, 'nLP']);
    Route::post('/changePassword/{id}', [UserController::class, 'changePassword']);

    //Routing Patch
    Route::patch('/editStatus/{id}', [PelajaranController::class, 'editStatus']);
    Route::patch('/kickOut/{id}', [PelajaranController::class, 'kickOutStudent']);
    Route::patch('updateKelas', [PelajaranController::class, 'updateKelas']);
    Route::patch('/setProgressMapel/{id}', [PelajaranController::class, 'setProgressMapel']);

    //Routing Delete
    Route::delete('/deletePeriod/{id}', [PelajaranController::class, 'deletePeriod']);
    Route::delete('/hapuskuis/{id}', [PelajaranController::class, 'deleteKuis']);
    Route::delete('/deleteModul/{id}', [PelajaranController::class, 'deleteModul']);
    Route::delete('/deleteBot/{id}', [DashboardController::class, 'deleteBot']);
});
