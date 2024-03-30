<?php

namespace App\Http\Controllers;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Section;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\NilaiSikap;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\hafalan;
use App\Models\pelajaran;
use App\Models\SMSTR;
use Session;
use Str;


class RaportController extends Controller
{
    function index(){
        $menu = menu::getMenu(Session::get('role'));
        return view('page.MasterData.raportKelas',compact('menu'));
    }
    function getRaportKelas(){
        $data = Kelas::select('kelas','tingkat')->get();
        $tahun_ajar = pelajaran::where('status','AKTIF')->first();
        $semester = SMSTR::where('status','AKTIF')->first();
        $hasilArray = [];
        foreach ($data as $key => $value) {
            $hasilArray[$key]['kelas'] = $value['kelas'];
            $hasilArray[$key]['tingkat'] = $value['tingkat'];
            $hasilArray[$key]['tahun_ajaran'] = $tahun_ajar->tahun_pelajaran ?? null;
            $hasilArray[$key]['semester'] = $semester->semester ?? null;
        }
        return response()->json(['data' => $hasilArray], 200);

    }

    function cetak($kelas){
        
        $templatePath = storage_path('template/raport1.docx');
        // Membuat objek TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);
        // $data = [
        //     [
        //         'smtr' => 'genap',
        //         'thn' => '2022-2023',
        //         'pengetahuan' => 'A',
        //         'sikap' => 'A',
        //         'trampil' => 'A',
        //         'nama' => 'Ajib',
        //         'kelas' => '1A',
        //         'nilai'=> [
        //             [
        //             'surat' => 'al-ikhlas',
        //             'ayat' => '1-3',
        //             'fasih' => '80',
        //             'tajwid' => '80',
        //             'lancar' => '80',
        //             'catatan' => ""
        //         ],
        //           [
        //             'surat' => 'al-falaq',
        //             'ayat' => '1-4',
        //             'fasih' => '80',
        //             'tajwid' => '80',
        //             'lancar' => '80',
        //             'catatan' => ""
        //         ],
        //         ]
        //     ],
        //     [
        //         'smtr' => 'genap',
        //         'thn' => '2022-2023',
        //         'pengetahuan' => 'B',
        //         'sikap' => 'B',
        //         'trampil' => 'B',
        //         'nama' => 'Ajib aaa',
        //         'kelas' => '1A',
        //         'nilai'=> [
        //             [
        //             'surat' => 'al-ikhlas',
        //             'ayat' => '1-3',
        //             'fasih' => '80',
        //             'tajwid' => '80',
        //             'lancar' => '80',
        //             'rata' => '80',
                    
        //         ],
        //           [
        //             'surat' => 'al-falaq',
        //             'ayat' => '1-4',
        //             'fasih' => '80',
        //             'tajwid' => '80',
        //             'lancar' => '80',
        //             'rata' => '80',
        //          ],
        //         ]
        //     ],
        //     // Tambahkan data lainnya...
        // ];
        $data = $this->getDataRaport($kelas);
    
        $templateProcessor->cloneBlock('page',count($data),true,true);

        foreach ($data as $key => $data){
        $key+=1;
        $templateProcessor->cloneRow('no#'.$key, count($data['nilai']) );
        $templateProcessor->setValue('smtr#'.$key, Str::upper($data['smtr']));
        $templateProcessor->setValue('thn#'.$key, $data['thn']);
        $templateProcessor->setValue('pengetahuan#'.$key, $data['pengetahuan']);
        $templateProcessor->setValue('sikap#'.$key, $data['sikap']);
        $templateProcessor->setValue('trampil#'.$key, $data['trampil']);
        $templateProcessor->setValue('nama#'.$key, $data['nama']);
        $templateProcessor->setValue('kelas#'.$key, $data['kelas']);
        $templateProcessor->setValue('np#'.$key, $data['pengetahuan'] == "A"? "sangat baik" : ($data['pengetahuan'] == "B"? "baik" : "kurang baik") );


        foreach ($data['nilai'] as $key1 => $nilai){
            $key1+=1;
        $templateProcessor->setValue('no#'.$key.'#'.$key1, $key1);
        $templateProcessor->setValue('surat#'.$key.'#'.$key1, $nilai['nama']);
        $templateProcessor->setValue('ayat#'.$key.'#'.$key1, "1-".$nilai['ayat']);
        $templateProcessor->setValue('fasih#'.$key.'#'.$key1, $nilai['kefasihan']);
        $templateProcessor->setValue('tajwid#'.$key.'#'.$key1, $nilai['tajwid']);
        $templateProcessor->setValue('lancar#'.$key.'#'.$key1, $nilai['kelancaran']);
        $templateProcessor->setValue('rata#'.$key.'#'.$key1, intval(($nilai['kefasihan']+$nilai['tajwid']+$nilai['kelancaran'])/3));

        }
        }
        // Simpan file yang dihasilkan
        $outputFilePath = storage_path('app/public/exported_document.docx');
        $templateProcessor->saveAs($outputFilePath);

        // Unduh file yang dihasilkan
        return response()->download($outputFilePath)->deleteFileAfterSend(true);
    }

   private function getDataRaport($kelas){
    $tahun_ajar = pelajaran::where('status','AKTIF')->first();
    $semester = SMSTR::where('status','AKTIF')->first();
    $siswas = Siswa::join('kelas','id_kelas','kelas.id')
                        ->where('kelas.kelas',$kelas)
                        ->select('siswa.id',"siswa.nama",'kelas.kelas')->get();
    $arr = [];
   
    foreach ($siswas as $siswa){
        $nilai = hafalan::join('surats','id_surat','surats.id')
                        ->where('id_siswa',$siswa->id)
                        ->where('semester',$semester->semester)
                        ->where('tahun_pelajaran',$tahun_ajar->tahun_pelajaran)
                        ->select('surats.nama','ayat','kefasihan','tajwid','kelancaran')
                        ->get();
        $sikap = NilaiSikap::where('id_siswa',$siswa->id)
                        ->where('nilai_sikaps.semester',$semester->semester)
                        ->where('nilai_sikaps.tahun_pelajaran',$tahun_ajar->tahun_pelajaran)->first();

        $data = [
                'smtr' =>  $semester->semester,
                'thn' =>   $tahun_ajar->tahun_pelajaran,
                'pengetahuan' => $sikap->pengetahuan,
                'sikap' => $sikap->sikap,
                'trampil' => $sikap->keterampilan,
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas,
                'nilai'=> $nilai
        ];
        array_push($arr,$data);
     }
    return $arr;
    }
}
      
