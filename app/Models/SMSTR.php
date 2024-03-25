<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSTR extends Model
{
    use HasFactory;
    protected $table = 'semester';
    protected $fillable = [
            'uuid',
            'semester',
            'status',
            'remark',
            'created_by',
            'updated_by'
    ];
}
