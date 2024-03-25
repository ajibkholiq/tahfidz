<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adm_menu extends Model
{
    use HasFactory;

    protected $table = "adm_menu";
    protected $fillable =[
        "uuid",
        "induk",
        "kode_menu",
        "nama_menu",
        "icon",
        "urut",
        "route",
        "remark",
        "create_by",
        "update_by"
    ];
    
}