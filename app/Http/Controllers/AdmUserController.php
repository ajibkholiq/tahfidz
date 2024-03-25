<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\adm_menu;
use App\Models\adm_role;
use File;
use App\Helper\menu;
use Session;
use Illuminate\Validation\Rules\Unique;



class AdmUserController extends Controller
{
    function index(){
      
       $role = adm_role::all();
        $menu = menu::getMenu(Session::get('role'));
        return view('page.AdmUser.index',compact('menu','role'));
    }
     function store(Request $request){
        $data = User::create([
        'uuid' => uniqid(),
        'nama' => $request->nama,
        'username' => $request->username,
        'password' => md5($request->password),
        'email' => $request->email,
        'nohp' => $request->nohp,
        'alamat'  => $request->alamat,
        'role' => $request->role,
        'foto' => '',
        'create_by' => $request->session()->get('id')
        ]);
        // return $request;
        if (!$data){
             return response()->json([
                "mesage" => "Gagal ditambahkan",
                'data' => $data
                ]
            );
        }
        return redirect()->back()->with('success','User Behasil ditambahkan');
        
    }

    function show ($uuid){
        return response()->json(User::where('uuid',$uuid)->first(), 200,);
    }

    function update($id, Request $request){
        $data = User::where('uuid',$id)->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'role' => $request->role
        ]);
        if ($data){
         return response()->json(['success' => 'data berhasil dirubah', 'data'=> $data]);
        }
         return response()->json(['success' => 'data gagal dirubah', 'data'=> $data]);

    }

     function destroy($id){
        $data = User::where('uuid',$id)->first();
        File::delete('assets/img/user/'.$data->foto);
        $data->delete();
        if($data->delete()){
            return response()->json(['succsess' => 'Unit berhasil dihapus', 'data' => $id]);
        }
        return response()->json(['fail' => 'Unit gagal dihapus', 'data' => $id]);

    }

    function updateUser($id, Request $request){
        $data = User::where('uuid',$id)->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
           
        ]);
        if($data){
            return redirect()->back()->with('success','Menu Behasil dihapus');
        }else{
            return redirect()->back()->with('fail','Menu Gagal dihapus');
        }
    }
    function updatePassword($id, Request $request){

        $data = User::where('uuid',$id)->first();
        if(md5($request->current_password) == $data->password ){
            $data->update([
                'password' => md5($request->new_password)
            ]);
        }
        if($data){
            return redirect()->back()->with('success','Sandi Behasil diubah');
        }else{
            return redirect()->back()->with('fail','gagal Gagal diubah');
        }
    }
    public function updatePhoto($id, Request $request)
    {
        // Validasi bahwa file yang diunggah adalah foto (opsional, jika diperlukan)
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Contoh untuk gambar JPEG, PNG, JPG, atau GIF
        ]);

        // Mengambil file photo dari request
        $photo = $request->file('photo');

        $imagename = uniqid().'.'.$photo->getClientOriginalExtension();

        // Menyimpan file photo ke folder public/photos (pastikan folder sudah ada dan writable)
        $photoPath = $photo->move(public_path('assets/img/user'),$imagename);

        // Mengupdate data user dengan informasi foto baru
        $user = User::where('uuid', $id)->first();
        if (!is_int(strpos($user->foto, 'profile_small')) && file_exists(public_path('assets/img/user/'.$user->foto))){
            File::delete('assets/img/user/'.$user->foto);
        }
        $user->foto = $imagename;
        $user->save();
        Session::put('photo',$imagename);

        return redirect()->back()->with('success', 'Photo updated successfully!');
    }
}