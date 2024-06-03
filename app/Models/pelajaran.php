<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelajaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_pelajaran';
    protected $fillable = [
        'uuid',
        'tahun_pelajaran',
        'status',
        'remark',
        'created_by',
        'updated_by'
    ];
}
