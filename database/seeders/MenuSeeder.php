<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\adm_menu;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        adm_menu::create([
            'induk' => 'head',
            'uuid' => uniqid(),
            'kode_menu' => 'A',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Dashboard',
            'route' => 'dashboard',
            'remark' => 'Rekapan Data dan Grafis',
        ]);
     
        adm_menu::create([
            'induk' => 'head',
            'uuid' => uniqid(),
            'kode_menu' => 'B',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Master Data',
            'route' => '',
            'remark' => 'Master Data',
        ]);
         adm_menu::create([
            'induk' => 'Master Data',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Kelas',
            'route' => 'kelas',
            'remark' => 'Master Data Kelas',
        ]);
        adm_menu::create([
            'induk' => 'Master Data',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Surat',
            'route' => 'surat',
            'remark' => 'Master Data Surat',
        ]);
       
        adm_menu::create([
            'induk' => 'Master Data',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Tahun Pelajaran',
            'route' => 'tahun_pelajaran',
            'remark' => 'Master Tahun Pelajaran',
        ]);
         adm_menu::create([
            'induk' => 'Master Data',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Semester',
            'route' => 'semester',
            'remark' => 'Master Data Semester',
        ]);
        adm_menu::create([
            'induk' => 'head',
            'uuid' => uniqid(),
            'kode_menu' => 'C',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Ziyadah',
            'route' => 'hafalan',
            'remark' => 'Rekapan Data',
        ]);
        adm_menu::create([
            'induk' => 'head',
            'uuid' => uniqid(),
            'kode_menu' => 'D',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Nilai',
            'route' => '',
            'remark' => 'Rekapan Data',
        ]);
        adm_menu::create([
            'induk' => 'Nilai',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Kelas',
            'route' => 'kelas/nilai',
            'remark' => 'Rekapan Data',
        ]);

        adm_menu::create([
            'induk' => 'Nilai',
            'uuid' => uniqid(),
            'kode_menu' => '',
            'icon' => "",
            'urut' => "",
            'nama_menu' =>'Siswa',
            'route' =>  '',
            'remark' => 'Rekapan Data',
        ]);
        // adm_menu::create([
        //     'induk' => 'Nilai',
        //     'uuid' => uniqid(),
        //     'kode_menu' => '',
        //     'icon' => "",
        //     'urut' => "",
        //     'nama_menu' =>'Sikap',
        //     'route' =>  'nilai/sikap',
        //     'remark' => 'Rekapan Data',
        // ]);
      
     
    }
}
