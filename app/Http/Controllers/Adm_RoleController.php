<?php

namespace App\Http\Controllers;

use App\Models\adm_role;
use App\Models\adm_menu;
use App\Helper\menu;
use Session;
use Illuminate\Http\Request;

class Adm_RoleController extends Controller
{
public function index(){
    $menu = menu::getMenu(Session::get('role'));
    $adm_roles = adm_role::get();
    return view('page.adm_role.index', compact('adm_roles','menu'));
    // return $adm_roles;
}
public function store(Request $request){
        // $request->validate([
        //     'uuid' => 'required|unique:adm_role|max:20',
        //     'nama_role' => 'required',
        //     'remark' => 'required|max:20',
        //     'create_by' => 'required|max:20',
        //     'update_by' => 'required|max:20', 
        // ]);

        $data = adm_role::create([
            'uuid' => uniqid(),
            'nama_role' => $request->nama_role,
            'remark' => $request->remark,
            'create_by' => $request->session()->get('nama'),
            
        ]);
        
        if (!$data){
            return response()->json([
               "mesage" => "Gagal ditambahkan",
               'data' => $data
               ]
           );
       }else{
       return redirect()->back()->with('success','Menu Behasil ditambahkan');
       }
}
function show($id){
        return response()->json(adm_role::where('uuid',$id)->first(), 200);
    }

    public function update(Request $request, $adm_role) 
    {
    $data = adm_role::where('uuid',$adm_role)->update([
       
        'nama_role' => $request->nama,
        'remark' => $request->remark,
        // 'create_by' => $request->create_by,
        'update_by' => $request->session()->get('nama'),
    ]);

    if (!$data) {
        return response()->json([
           "message" => "Gagal diedit",
           'data' => $data
        ]);
    } else {
         return response()->json([
           "message" => "berhasil diedit",
           'data' => $data
        ]);
    }
}
public function destroy($id){
    $data = adm_role::where('uuid', $id)->delete();

    if ($data) {
        if($data){
            return redirect()->back()->with('success','Menu Behasil dihapus');
        }else{
            return redirect()->back()->with('fail','Menu Gagal dihapus');
            }
        
        }
}
}