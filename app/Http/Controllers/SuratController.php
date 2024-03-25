<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Helper\menu;
use App\Models\surat;
use Session;


class SuratController extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        $tingkat = Kelas::distinct()->pluck('tingkat');
        return view('page.MasterData.surat',compact(['menu','tingkat']));
        // return $tingkat;
    }

    function store(Request $request){
        if (!surat::create([
            'uuid' => uniqid(),
            'nama' => $request->surat,
            'no_surat' => $request->no_surat,
            'ayat' => $request->ayat,
            'kelas' => $request->tingkat,
            'remark'=> $request->remark,
            
        ])){
             return response()->json([
                "mesage" => "Gagal ditambahkan",
                ]
            );
        }
        return redirect()->back()->with('success','Surat Behasil ditambahkan');
    
    }
    function update($uuid ,Request $request){
        $data = surat::where('uuid',$uuid)->update([
                'nama' => $request->nama,
                'no_surat' => $request->no_surat,
                'ayat' => $request->ayat,
                'kelas' => $request->tingkat,
                'remark'=> $request->remark,
            ]);
        return response()->json($data, 200);
    }
   function show ($uuid){
        return response()->json(surat::where('uuid',$uuid)->first(), 200);
    }
    function destroy($id){
        $data = surat::where('uuid',$id)->first();
        $data->delete();
        if($data->delete()){
            return response()->json(['succsess' => 'Surat berhasil dihapus', 'data' => $id]);
        }
        return response()->json(['fail' => 'Surat gagal dihapus', 'data' => $id]);
}
}
