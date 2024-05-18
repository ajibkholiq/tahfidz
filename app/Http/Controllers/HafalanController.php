<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\Kelas;
use App\Models\hafalan;
use App\Models\Siswa;
use App\Models\surat;
use App\Models\SMSTR;
use App\Models\pelajaran;
use Session;

class HafalanController extends Controller
{
    function index(){
        $this->getCapaian($this->getKategori(80),$this->getKategori(80),$this->getKategori(80));
        $menu = menu::getMenu(Session::get('role'));
        $tingkat = Kelas::all();
        return view('page.MasterData.hafalan',compact(['menu','tingkat']));
    }
    function store(Request $request){
        $suratId = surat::where('no_surat',$request->surat)->first();
        $siswaId = Siswa::where('nama',$request->siswa)->first();
        $tahun_ajar = pelajaran::where('status','AKTIF')->first();
        $semester = SMSTR::where('status','AKTIF')->first();
        if ($tahun_ajar == [] || $semester == []) return response()->json(['message'=>'Tahun Pelajaran / Semester tidak ada yang aktif'], 200);

        $capaian = $this->getCapaian($this->getKategori($request->kefasihan),$this->getKategori($request->tajwid),$this->getKategori($request->kelancaran));

        $data = hafalan::create([
            'uuid' => uniqid(),
            'id_surat' => $suratId->id,
            'id_siswa' => $siswaId->id,
            'ayat' => "-",
            'tahun_pelajaran' => $tahun_ajar->tahun_pelajaran,
            'semester' => $semester->semester,
            'kefasihan' => $request->kefasihan,
            'tajwid' => $request->tajwid,
            'kelancaran' => $request->kelancaran,
            'capaian' => $capaian,
            'audio' => $request->audio,
            'remark' => $request->remark,
        ]);

        if($data){
            return response()->json(["message" => "Berhasil disimpan"], 200);
        }
        return response()->json(["message" => "failed"], 200);
       
    }
    function show($id){
        $data = hafalan::where('uuid',$id)->first();
        return response()->json($data, 200);
    }
    function update($id,Request $request){
        $capaian = $this->getCapaian($this->getKategori($request->kefasihan),$this->getKategori($request->tajwid),$this->getKategori($request->kelancaran));

        $data = hafalan::where('uuid',$id);

        $data->update([
            'kefasihan' => $request->kefasihan,
            'tajwid' => $request->tajwid,
            'kelancaran' => $request->kelancaran,
            'capaian' => $capaian,
            'remark' => $request->remark,
        ]);

        if($data){
            return response()->json(["message" => "Berhasil disimpan"], 200);
        }
        return response()->json(["message" => "failed"], 200);
    }
    function getCapaian($kefasihan,$tajwid,$kelancaran){
        if(($tajwid == "Kurang Baik" && $kefasihan == "Cukup Baik")
        ||( $tajwid == "Cukup Baik" && $kefasihan == "Kurang Baik" && ($kelancaran == "Kurang Baik" || $kelancaran == "Cukup Baik"))
        ||( $tajwid == "Kurang Baik" && $kefasihan == "Kurang Baik" && ($kelancaran == "Kurang Baik" || $kelancaran == "Cukup Baik"))){
            return "Belum Tercapai";
        }
        else return "Tercapai";
    }
    function getKategori($nilai){
        return $nilai >= 83.67 ? "Baik" : ($nilai <= 79.2 ? "Kurang Baik" : "Cukup Baik"); 
    }
}
