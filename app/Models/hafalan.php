<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hafalan extends Model
{
    use HasFactory;
   protected $fillable = [
            'uuid',
            'id_surat',
            'id_siswa',
            'tahun_pelajaran',
            'semester',
            'kefasihan',
            'tajwid',
            'kelancaran',
            'capaian',
            'audio',
            'remark',
    ];
}
