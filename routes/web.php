<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmMenuController;
use App\Http\Controllers\AdmRoleMenu;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\Adm_RoleController;
use App\Http\Controllers\AdmUserController;
use App\Http\Controllers\ThnPljrnController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MasterTingkaCntrl;
use App\Models\adm_menu;
use App\Models\adm_role;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Carbon;




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

Route::get('/', [loginController::class , 'index' ])->name('login');
Route::get('/logout', [loginController::class , 'logout' ])->name('logout');
Route::post('/validate', [loginController::class , 'validasi' ])->name('validate');
Route::middleware('checklogin')->group(function () {
    Route::get('/profile',function(){
        $menu = menu::getMenu(Session::get('role'));
        $data = User::where('uuid', Session::get('uuid'))->first();
        return view('page.user.profile',compact('menu','data'));
    });
    Route::resource('surat',App\Http\Controllers\SuratController::class)->only('index','store');
    Route::get('/dashboard', [DashboardController::class ,'dashboard']);
    Route::post('/dashboard', [DashboardController::class ,'dashboard']);
    Route::resource('tahun_pelajaran', thnPljrnController::class)->except(['show','create','edit']);
    Route::resource('semester', SemesterController::class)->only(['index','store','destroy']);
    Route::put('/ubah/{id}', [AdmUserController::class, 'updateUser'])->name('updateUser');
    Route::put('/password/{id}', [AdmUserController::class, 'updatePassword'])->name('updatePassword');
    Route::put('/photo/{id}', [AdmUserController::class, 'updatePhoto'])->name('updatePhoto');
    Route::resource('hafalan', App\Http\Controllers\HafalanController::class)->only('index');
    Route::post('import', [SiswaController::class, 'import'])->name('import');
    Route::get('download', [SiswaController::class, 'downloadTemplate'])->name('download');
    Route::prefix('kelas')->group(function () {
        Route::resource('/', KelasController::class)->only(['index','store']);
        Route::resource('{kelas}/siswa', SiswaController::class)->only(['index','store']);
        Route::resource('nilai', App\Http\Controllers\NilaiController::class)->only('index');
        Route::resource('raport', App\Http\Controllers\RaportController::class)->only('index');
        Route::get('{kelas}/nilai', [App\Http\Controllers\NilaiController::class,'nilaiKelas']);
    });
    Route::prefix('nilai')->group(function () {
        Route::get('siswa',[App\Http\Controllers\NilaiController::class,'nilaisiswa']);
        Route::get('{kelas}/sikap',[App\Http\Controllers\NilaiSikapController::class,'nilaisikap']);
        Route::resource('sikap',App\Http\Controllers\NilaiSikapController::class)->only('index');
    });
    Route::get('cetak/{kelas}',[App\Http\Controllers\RaportController::class,'cetak'] );

    Route::middleware('role:admin')->group(function () {
        Route::resource('adm-role', Adm_roleController::class)->except(['create','edit']);
        Route::resource('adm-role-menu', AdmRoleMenu::class)->only(['index','store']);
        Route::resource('pegawai', AdmUserController::class);
    });
});

