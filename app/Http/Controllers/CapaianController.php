<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\hafalan;
class CapaianController extends Controller
{
    function index(){
        $tingkat = Kelas::all();
        return view('page.capaian',compact(['tingkat']));

    }
    function show($nama){
        $capaian = $this->getCapaian($nama);
        return view('page.capaiandetail',compact(['capaian']));

    }

    private function getCapaian($nama){
            $siswa = Siswa::join('kelas','id_kelas','kelas.id')
                        ->where('siswa.nama',$nama)
                        ->select('siswa.nis','siswa.id',"siswa.nama",'kelas.kelas')->first();
            if ($siswa == null ) return [];
            $nilai = hafalan::join('surats','id_surat','surats.id')
                            ->where('id_siswa',$siswa->id)
                            ->select('surats.nama','ayat','kefasihan','tajwid','kelancaran', 'tahun_pelajaran','semester','audio')
                            ->get();
            $data = [
                    'nama' => $siswa->nama,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas,
                    'surat'=> $nilai
            ];
        return $data;
        }
}
