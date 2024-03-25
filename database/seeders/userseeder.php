<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'uuid' => uniqid(),
        'nama' => 'admin',
        'username' => 'admin',
        'password' => md5('admin'),
        'email' => 'admin@admin',
        'nohp' => '00000',
        'alamat'  => 'indonesia',
        'role' => 'admin',
        'foto' => 'um.png'
        ]);
        User::create([
            'uuid' => uniqid(),
            'nama' => 'ajib',
            'username' => 'admina',
            'password' => md5('admin'),
            'email' => 'admin2@admin',
            'nohp' => '00000',
            'alamat'  => 'indonesia',
            'role' => 'wali kelas',
            'foto' => 'um.png'
            ]);
    }
}
