<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\NilaiSikap;
use App\Models\Siswa;
use App\Models\SMSTR;
use App\Models\pelajaran;
use Session;
use DB;

class NilaiSikapController extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        return view('page.MasterData.kelasSikap',compact('menu'));
        // return $tingkat;
    }
    function nilaisikap($kelas){
        $menu = menu::getMenu(Session::get('role'));
     
        $siswa = Siswa::join('kelas','id_kelas','kelas.id')
                        ->where('kelas.kelas',$kelas)->select("siswa.uuid","siswa.nama")
                        ->whereNotExists(function($query) {
                            $tahun_ajar = pelajaran::where('status','AKTIF')->first();
                            $semester = SMSTR::where('status','AKTIF')->first();
                            $query->select(DB::raw(1))
                                  ->from('nilai_sikaps')
                                  ->whereRaw('siswa.id = nilai_sikaps.id_siswa')
                                  ->where('nilai_sikaps.semester',$semester->semester)
                                  ->where('nilai_sikaps.tahun_pelajaran',$tahun_ajar->tahun_pelajaran);
                        })->get();
        return view('page.MasterData.siswaSikap',compact('menu','siswa'));
    }
    function store(Request $request){
        $siswaId = Siswa::where('uuid',$request->siswa)->first();
        $tahun_ajar = pelajaran::where('status','AKTIF')->first();
        $semester = SMSTR::where('status','AKTIF')->first();
      
        if ($tahun_ajar == [] || $semester == []) return response()->json(['message'=>'Tahun Pelajaran / Semester tidak ada yang aktif'], 200);

        $data = NilaiSikap::create([
            'uuid' => uniqid(),
            'id_siswa' => $siswaId->id,
            'tahun_pelajaran' => $tahun_ajar->tahun_pelajaran,
            'semester' => $semester->semester,
            'pengetahuan' => $request->pengetahuan,
            'sikap' => $request->sikap,
            'keterampilan' => $request->keterampilan,
            'remark' => $request->remark,
        ]);

        if($data){
            return response()->json(["message" => "Berhasil disimpan"], 200);
        }
        return response()->json(["message" => "failed"], 200);
       
    }
    function show($id){
        $data = NilaiSikap::where('uuid',$id)->first();
        return response()->json($data, 200);
    }
    function update($id,Request $request){
        $data = NilaiSikap::where('uuid',$id);
        $data->update([
            'pengetahuan' => $request->pengetahuan,
            'sikap' => $request->sikap,
            'keterampilan' => $request->keterampilan,
            'remark' => $request->remark,
        ]);

        if($data){
            return response()->json(["message" => "Berhasil disimpan"], 200);
        }
        return response()->json(["message" => "failed"], 200);
    }
    function getNilaiSikap($kelas){
        $tahun_ajar = pelajaran::where('status','AKTIF')->first();
        $semester = SMSTR::where('status','AKTIF')->first();
        return response()->json([
            "data" => NilaiSikap::join('siswa','id_siswa','siswa.id')
                                ->join('kelas','id_kelas','kelas.id')
                                ->where('kelas.kelas',$kelas)
                                ->where('nilai_sikaps.semester',$semester->semester)
                                ->where('nilai_sikaps.tahun_pelajaran',$tahun_ajar->tahun_pelajaran)
                                ->select('nilai_sikaps.uuid','siswa.nama','kelas.kelas','pengetahuan','sikap','keterampilan','semester','tahun_pelajaran','nilai_sikaps.remark')
                                ->get()
        ], 200);
    }

}
