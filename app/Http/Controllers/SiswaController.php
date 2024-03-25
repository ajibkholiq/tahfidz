<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Helper\menu;
use Session;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    function index($kelas){
        $menu = menu::getMenu(Session::get('role'));
        $kelas = Kelas::all();
        return view('page.MasterData.siswa',compact(['menu','kelas']));
    }
    function show($id){
        return response()->json(Siswa::where('uuid',$id)->first(), 200);
    }
    function store($kelas,Request $request){
        $kelasName = Kelas::where('kelas',$kelas)->first();
    if (!Siswa::create([
            'uuid' => uniqid(),
            'nama' => $request->nama,
            'nis' => $request->nis,
            'id_kelas' => $kelasName->id,
            'alamat' => $request->alamat,
            'nama_ayah'=> $request->ayah,
            'nama_ibu' => $request->ibu,
            'no_hp' => $request->nohp,
            'remark'=> $request->remark,
            'created_by' => Session::get('nama')
        ])){
             return response()->json([
                "mesage" => "Gagal ditambahkan",
                ]
            );
        }
        return redirect()->back()->with('success','Siswa Behasil ditambahkan');
    }
    function update($id,Request $request){
        if($request->kabupaten == '' && $request->kecamatan == '' && $request->kelurahan == ''){
            $data = Siswa::where('uuid',$id)->update([
            'nama' => $request->nama,
            'id_kelas' => $request->kelas,
            'nama_ayah'=> $request->ayah,
            'nama_ibu' => $request->ibu,
            'no_hp' => $request->nohp,
            'remark'=> $request->remark,
            'updated_by' => Session::get('nama')]);
        }else{
          $data = Siswa::where('uuid',$id)->update([
            'nama' => $request->nama,
            'id_kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'nama_ayah'=> $request->ayah,
            'nama_ibu' => $request->ibu,
            'no_hp' => $request->nohp,
            'remark'=> $request->remark,
            'updated_by' => Session::get('nama')
          ]);}

          if(!$data){
             return response()->json([
                "mesage" => "Gagal diubah",
                ]
            );
        }
        return response()->json(['succsess' => 'siswa berhasil ubah', 'data' => $request]);
    }
    function destroy($id){
        if(Siswa::where('uuid',$id)->delete()){
            return response()->json(['succsess' => 'siswa berhasil dihapus', 'data' => $id]);
        }
        return response()->json(['fail' => 'siswa gagal dihapus', 'data' => $id]);
    }
}
