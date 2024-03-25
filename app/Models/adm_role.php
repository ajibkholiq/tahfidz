<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adm_role extends Model
{
    use HasFactory;

    protected $table = 'adm_role';

    // protected $primaryKey = 'uuid';
    
    protected $fillable = [
        'uuid',
        'nama_role',
        'remark',
        'create_by',
        'update_by',
    ];
}