<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Helper\menu;

use Session;
use DB;


class DashboardController extends Controller
{
    function dashboard(Request $request){
         $menu = menu::getMenu(Session::get('role'));
         return view('page.dashboard',compact('menu'));
    }
}
