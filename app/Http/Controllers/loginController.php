<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class loginController extends Controller
{
    function index(){
        return view('page.auth.login');
    }

    function validasi (Request $request) {
         $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $user = User::where('username',$request->username)->first();
        if( $user != null){
        if($user->password == md5($request->password)){
            Session::put('uuid', $user->uuid);
            Session::put('role', $user->role);
            Session::put('nama', $user->nama);
            Session::put('photo', $user->foto);
            if($request->session()->get('_previous')['url'] == url('login')){
                $request->session()->get('_previous')['url']; 
            return redirect('/dashboard');
            }
            return redirect()->back();
            // return Session::get('role');
        }
        return redirect()->back()->with('fail' , 'password salah!');
    }
    return redirect()->back()->with('fail','username dan password tidak ditemukan!');
     
    }

    function logout(){
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/login');
    }
}
