<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSikap extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'id_siswa',
        'tahun_pelajaran',
        'semester',
        'pengetahuan',
        'sikap',
        'keterampilan',
        'remark',
];

}
