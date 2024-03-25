<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\adm_menu;
use App\Helper\menu;
use Illuminate\Support\Facades\Session;


class AdmMenuController extends Controller
{

    

    function index (){
        $data = adm_menu::all();
        $menu = menu::getMenu(Session::get('role'));
        return view('page.AdmMenu.index',compact('data','menu'));
        // return collect($data)->pluck('nama_menu')->toArray();

    }

    function store(Request $request){
        $data = adm_menu::create([
            'induk' => $request->induk,
            'uuid' => uniqid(),
            'kode_menu' => $request->kode,
            'icon' => "",
            'urut' => "",
            'nama_menu' => $request->nama,
            'route' => $request->route,
            'remark' => $request->remark,
            // 'update_by'=> Auth::user()->id,
            'create_by' => session::get('nama')
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

    function edit ($id){
        $data = adm_menu::where('uuid',$id)->first();
        $menu = $this->getHeadMenu();
        return view('page.AdmMenu.edit',compact('data','menu'));

    }

    function show($id){
        $data = adm_menu::where('uuid',$id)->get();
        return response()->json($data, 200);
        // return adm_menu::findOrFail($id);

    }
    function update($id, Request $request){
        $data = adm_menu::where('uuid',$id)->update([
            'induk' => $request->induk,
            'kode_menu' => $request->kode,
            'nama_menu' => $request->nama,
            'route' => $request->route,
            'remark' => $request->remark,
            'update_by'=> session::get('nama')
            ]
        );

          if (!$data){
             return response()->json([
                "mesage" => "Gagal diedit",
                'data' => $data
                ]
            );
        }else{
            return response()->json([
                "mesage" => "berhasil diedit",
                'data' => $data
                ]
                );
    }}
    function destroy($id){
        $data = adm_menu::where('uuid',$id)->first();

        if ( $data->induk == 'head' )
        {
            adm_menu::where('induk', $data->nama_menu)->delete();
        }
        $data->delete();
        if($data){
            return redirect()->back()->with('success','Menu Behasil dihapus');
        }else{
            return redirect()->back()->with('fail','Menu Gagal dihapus');
        }
    }
}