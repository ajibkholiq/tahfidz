<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\MasterTingkat;
use Session;

class MasterTingkaCntrl extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        return view('page.MasterData.tingkat',compact(['menu']));
    }
    function store(Request $request){
        $data = MasterTingkat::create([
            'uuid' => uniqid(),
            'id_tingkat' => $request->idtingkat,
            'nama_tingkat'  => $request->nama,
            'remark'  => $request->remark,
            'created_by'  => Session::get('nama'),
        ]);
        

          if (!$data){
             return response()->json([
                "mesage" => "Gagal ditambahkan",
                'data' => $data
                ]
            );
        }
        return redirect()->back()->with('success','Tingkat Behasil ditambahkan');
    
    }
    function show($id){
        return response()->json(MasterTingkat::where('uuid',$id)->first(), 200);
    }

    function update($id , Request $request){
      $data = MasterTingkat::where('uuid',$id)->update([
            'id_tingkat' => $request->id_tingkat,
            'nama_tingkat'  => $request->nama,
            'remark'  => $request->remark,
            'updated_by' => Session::get('nama')
          ]);

          if(!$data){
             return response()->json([
                "mesage" => "Gagal diubah",
                ]
            );
        }
        return response()->json(['succsess' => 'Tingkat berhasil ubah', 'data' => $request]);
    }
     function destroy($id){
        if(MasterTingkat::where('uuid',$id)->delete()){
            return response()->json(['succsess' => 'Tingkat berhasil dihapus', 'data' => $id]);
        }
        return response()->json(['fail' => 'Tingkat gagal dihapus', 'data' => $id]);
    }
}
 