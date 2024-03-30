<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\adm_menu;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\surat;
use App\Models\pelajaran;
use App\Models\SMSTR;
use App\Models\MasterTingkat;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/menu',function (){
        $data = adm_menu::where('uuid','=',$id)->first();
        return response()->json( $data, 200);
});
Route::get('surat', function (){
    return response()->json([
        "status" => "success",
        "data"=>surat::all()], 200);
});
Route::get('getsurat/{surat}', function ($surat){
    $kelas = Kelas::where('kelas',$surat)->first();
    return response()->json([
        "status" => "success",
        "data"=>surat::where('kelas',$kelas->tingkat)->select('uuid','no_surat','nama')->get()], 200);
});
Route::get('getSiswa', function()
{return ['data' => Siswa::join('kelas','id_kelas','kelas.id')->select('siswa.uuid','nis','nama','kelas.kelas','alamat','nama_ayah','nama_ibu','no_hp','siswa.remark',)->get()];});
Route::get('tingkat', function(){return ['data' => MasterTingkat::all()];});
Route::get('thn-ajar', function(){return ['data' => pelajaran::all()];});
Route::get('semester', function(){return ['data' => SMSTR::all()];});
Route::get('pegawai', function(){return ['data' => User::all()];});
Route::prefix('kelas')->group(function () {
    Route::get('/', function(){
        return ['data' => kelas::join('users','user_id','users.id')
                        ->select('kelas.id','kelas.uuid','kelas','tingkat', 'kelas.remark','users.nama')->get()];
    });
    Route::get('/{kelas}', function($kelas){
        return ['data' => Siswa::join('kelas','id_kelas','kelas.id')
                        ->where('kelas',$kelas)
                        ->select('siswa.uuid','nis','nama','kelas.kelas','alamat','nama_ayah','nama_ibu','no_hp','siswa.remark',)->get()];
    });   
    Route::resource('/', App\Http\Controllers\KelasController::class)->only('update','destroy','show');

});
Route::get('cetak/raport/', [App\Http\Controllers\RaportController::class,'getRaportKelas']);
Route::resource('hafalan',  App\Http\Controllers\HafalanController::class)->except('index');
Route::resource('surat',  App\Http\Controllers\SuratController::class)->except(['index','store']);
Route::resource('siswa', App\Http\Controllers\SiswaController::class)->only(['update','show','destroy']);
Route::resource('semester', App\Http\Controllers\SemesterController::class)->only('update','destroy');
Route::get('/siswa', function(){
    $data = Siswa::all();
    return response()->json($data);
});
Route::prefix('nilai')->group(function () {
    Route::get('{kelas}/sikap', [App\Http\Controllers\NilaiSikapController::class, 'getNilaiSikap'] );
    Route::get('/',[App\Http\Controllers\NilaiController::class, 'getNilaiSiswa'] );
    Route::get('/{kelas}', [App\Http\Controllers\NilaiController::class,'getNilai']);
    Route::resource('/sikap', App\Http\Controllers\NilaiSikapController::class)->only(['store','show','update']);

    
});
Route::post('evaluasi',[App\Http\Controllers\EvaluateController::class, 'getEvaluasi']);
