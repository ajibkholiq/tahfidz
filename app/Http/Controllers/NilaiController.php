<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\hafalan;
use App\Models\SMSTR;
use App\Models\pelajaran;
use Session;

class NilaiController extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        return view('page.MasterData.kelasNilai',compact('menu'));
        // return $tingkat;
    }
    function nilaiKelas($kelas){
        $menu = menu::getMenu(Session::get('role'));
        return view('page.MasterData.siswaNilai',compact('menu'));
        
    }
    function getNilai($kelas){
        $semester = SMSTR::where('status','AKTIF')->first();
        $pelajaran = pelajaran::where('status','AKTIF')->first();
        if ($pelajaran == [] || $semester == []) return response()->json(['messege'=>'Tahun Pelajaran / Semester tidak ada yang aktif', 'data' => []], 200);;

        $data = hafalan::join('siswa','id_siswa','siswa.id')
                        ->join('kelas','id_kelas','kelas.id')
                        ->join('surats','id_surat','surats.id')
                        ->where('kelas.kelas',$kelas)->where('tahun_pelajaran',$pelajaran->tahun_pelajaran)->where('semester',$semester->semester)
                        ->select('hafalans.uuid','nis','siswa.nama','kelas.kelas','surats.nama as surat','kefasihan','tajwid','kelancaran','capaian')->get();
        return response()->json(["data" =>$data], 200);
    }
}


