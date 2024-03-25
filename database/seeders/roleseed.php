<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\adm_role;

class roleseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        adm_role::create([
            'uuid' => uniqid(),
            'nama_role' => 'wali kelas',
            'remark' => '-',
        ]);
    }
}
