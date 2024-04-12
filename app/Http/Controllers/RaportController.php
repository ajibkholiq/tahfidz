<?php

namespace App\Http\Controllers;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Section;

use Illuminate\Http\Request;
use App\Helper\menu;
use App\Models\NilaiSikap;
use App\Models\Kelas;
use App\Models\surat;
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
        $tahun_ajar = pelajaran::where('status','AKTIF')->first();
        $semester = SMSTR::where('status','AKTIF')->first();
        $templatePath = storage_path('template/raport1.docx');
        // Membuat objek TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);
        $data = $this->getDataRaport($kelas);
        $templateProcessor->cloneBlock('page',count($data),true,true);
        foreach ($data as $key => $data){
            $key+=1;
            $templateProcessor->cloneRow('no#'.$key, count($data['surat']));
            $templateProcessor->setValue('smtr#'.$key, Str::upper($data['smtr']));
            $templateProcessor->setValue('thn#'.$key, $data['thn']);
            $templateProcessor->setValue('pengetahuan#'.$key, $data['pengetahuan']);
            $templateProcessor->setValue('sikap#'.$key, $data['sikap']);
            $templateProcessor->setValue('trampil#'.$key, $data['trampil']);
            $templateProcessor->setValue('nama#'.$key, ucwords($data['nama']));
            $templateProcessor->setValue('kelas#'.$key, $data['kelas']);
            $templateProcessor->setValue('np#'.$key, $data['pengetahuan'] == "A"? "sangat baik" : ($data['pengetahuan'] == "B"? "baik" : "kurang baik") );
            $templateProcessor->setValue('nd#'.$key,explode(' ',trim($data['nama']))[0] );
            $templateProcessor->setValue('totalsurat#'.$key, count($data['surat']) );
            $templateProcessor->setValue('surat_tercapai#'.$key, count($data['nilai']));


            foreach ($data['surat'] as $key1 => $surat){
                $key1+=1;
                $templateProcessor->setValue('no#'.$key.'#'.$key1, $key1);
                $templateProcessor->setValue('surat#'.$key.'#'.$key1, $surat['nama']);
                $templateProcessor->setValue('ayat#'.$key.'#'.$key1, "1-".$surat['ayat']);
                if (count($data['nilai']) == null ){
                    $templateProcessor->setValue('fasih#'.$key.'#'.$key1, '');
                    $templateProcessor->setValue('tajwid#'.$key.'#'.$key1, '');
                    $templateProcessor->setValue('lancar#'.$key.'#'.$key1, '');
                    $templateProcessor->setValue('rata#'.$key.'#'.$key1, '');
                }
                else{
                foreach($data['nilai'] as $nilai){
                    if ($surat['id'] == $nilai['id']){
                        $templateProcessor->setValue('fasih#'.$key.'#'.$key1, $nilai['kefasihan']);
                        $templateProcessor->setValue('tajwid#'.$key.'#'.$key1, $nilai['tajwid']);
                        $templateProcessor->setValue('lancar#'.$key.'#'.$key1, $nilai['kelancaran']);
                        $templateProcessor->setValue('rata#'.$key.'#'.$key1, intval(($nilai['kefasihan']+$nilai['tajwid']+$nilai['kelancaran'])/3));
                   }
                        $templateProcessor->setValue('fasih#'.$key.'#'.$key1, '');
                        $templateProcessor->setValue('tajwid#'.$key.'#'.$key1, '');
                        $templateProcessor->setValue('lancar#'.$key.'#'.$key1, '');
                        $templateProcessor->setValue('rata#'.$key.'#'.$key1, '');
                        
                }
            }
        }
    }
    
        $outputFilePath = storage_path('app/public/Raport_'.$kelas.'_'.$semester->semester.'_'.$tahun_ajar->tahun_pelajaran.'.docx');
        $templateProcessor->saveAs($outputFilePath);
        return response()->download($outputFilePath)->deleteFileAfterSend(true);
    }

   private function getDataRaport($kelas){
    $tahun_ajar = pelajaran::where('status','AKTIF')->first();
    $semester = SMSTR::where('status','AKTIF')->first();
    $siswas = Siswa::join('kelas','id_kelas','kelas.id')
                        ->where('kelas.kelas',$kelas)
                        ->select('siswa.id',"siswa.nama",'kelas.kelas')->get();
    $arr = [];
    $tingkat = kelas::where('kelas.kelas',$kelas)->first();
    $surat = surat::where('kelas',$tingkat->tingkat)
                    ->select('id','surats.nama','ayat')->get();
   
    foreach ($siswas as $siswa){
        $nilai = hafalan::join('surats','surats.id','hafalans.id_surat')
                        ->where('id_siswa',$siswa->id)
                        ->where('tahun_pelajaran',$tahun_ajar->tahun_pelajaran)
                        ->select('surats.id','kefasihan','tajwid','kelancaran')
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
                'surat' => $surat,
                'nilai'=> $nilai
        ];
        array_push($arr,$data);
     }
    return $arr;
    }
}
      
