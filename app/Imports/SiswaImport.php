<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    
    */

    protected $kelas;

    public function __construct($kelas)
    {
        $this->kelas = $kelas;
    }
    public function model(array $row)
    {
        return new Siswa([
            'uuid' => uniqid(),
            'nama' => $row[3],
            'nis' => $row[2],
            'id_kelas' => $this->kelas,
            'alamat'=> $row[7],
            'nama_ayah'=> $row[4],
            'nama_ibu'=> $row[5],
            'no_hp'=> $row[6],
            'remark'=> $row[8],
        ]);
    }
    public function startRow(): int
    {
        return 3; 
    }
}
