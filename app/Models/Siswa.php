<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table ='siswa';

    protected $fillable = [
            'uuid',
            'nama',
            'nis',
            'id_kelas',
            'alamat',
            'nama_ayah',
            'nama_ibu',
            'no_hp',
            'remark',
            'created_by',
            'updated_by',
    ];
}
