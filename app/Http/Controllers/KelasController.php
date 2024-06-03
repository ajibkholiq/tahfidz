<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Helper\menu;
use Session;

class KelasController extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        
        $user = User::where('role','wali kelas')->get();
         
        return view('page.MasterData.kelas',compact(['menu','user']));
        // return $tingkat;
    }
    function store(Request $request){
        $data = Kelas::create([
            'uuid' => uniqid(),
            'kelas' => $request->kelas,
            'tingkat' => $request->tingkat,
            'user_id' => $request->wali,
            'remark' => $request->remark,
            'created_by' => Session::get('nama')
        ]);
      

        if (!$data){
             return response()->json([
                "mesage" => "Gagal ditambahkan",
                'data' => $data
                ]
            );
        }
        return redirect()->back()->with('success','Tahun Pelajaran Behasil ditambahkan');
        
    }
    function update($uuid ,Request $request){
        $data = Kelas::where('uuid',$uuid)->update([
                'kelas' => $request->kelas,
                'tingkat' => $request->tingkat,
                'user_id' => $request->wali,
                'remark' => $request->remark,
                'updated_by' => Session::get('nama')
            ]);
        return response()->json($data, 200);
    }
   function show ($uuid){
        return response()->json(kelas::join('users','user_id','users.id')
            ->where('kelas.uuid',$uuid)
            ->select('kelas.id','kelas.uuid','kelas','tingkat', 'kelas.remark','user_id')->first(), 200);
    }
    function destroy($id){
        $data = Kelas::where('uuid',$id)->first();
        $data->delete();
        if($data->delete()){
            return response()->json(['succsess' => 'Unit berhasil dihapus', 'data' => $id]);
        }
        return response()->json(['fail' => 'Unit gagal dihapus', 'data' => $id]);
}}
