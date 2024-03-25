<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    use HasFactory;
    protected $fillable =[
        'uuid',
        'no_surat',
        'nama',
        'ayat',
        'kelas',
        'remark'
];

}
