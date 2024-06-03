<?php

namespace App\Helper;
use App\Models\adm_menu;
use Illuminate\Support\Facades\DB;


class menu {
    public static function getMenu($role){
    if ($role != 'admin'){
        return DB::select("select induk,kode_menu,nama_menu,route FROM `adm_menu`,`adm_role_menu`,`adm_role` WHERE `adm_menu`.`id`=`adm_role_menu`.`menu_id` AND `adm_role`.`id`=`adm_role_menu`.`role_id` and adm_role.nama_role = '$role' order by adm_menu.id asc");
        }
    else{
        return adm_menu::select('induk','kode_menu','nama_menu','route')->orderBy('id','asc')->get();
        } 
    }   
}
