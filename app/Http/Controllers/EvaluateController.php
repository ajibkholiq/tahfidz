<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Siswa;
class EvaluateController extends Controller
{
    function getEvaluasi(Request $request){
    //   $request->validate([
    //     'audio' => 'required|file|mimes:wav,mp3|max:20480', // Contoh untuk file audio WAV atau MP3 dengan ukuran maksimum 20MB
    // ]);
    
    // Mengambil file audio dari request
      
    $text = $request->text;
    $audio = $request->file('audio');
    $no_surat = $request->no_surat;
    $siswa = Siswa::where('nama',$request->siswa)->first();
    $audioName = $siswa->nama."_".$no_surat.'.'.$audio->getClientOriginalExtension();
    // Menyimpan file audio ke folder public/audio (pastikan folder sudah ada dan writable)
    $audioPath = $audio->move(public_path('audio/siswa'), $audioName);
    
        $suratPembanding = $this->replaceHarkat($this->getAyat($no_surat));
        $suratClient = $this->addHarakat($text);
        // $suratClient = $suratPembanding;
        return response()->json([
            "status"=> "success",
            "data" => [
            "nilai" => $this->evaluasi($suratPembanding, $suratClient),
            "surat" => [ "pembanding" => $suratPembanding ,"input" => $suratClient],
            "tajwid" => ["pembanding" => $this->vectTajwid($suratPembanding), "input"=> $this->vectTajwid($suratClient)],
            "audio" => $audioName,
            ]
        ], 200);
    }

    // mehapus tanda tidak diperlukan 
    function replaceHarkat($str){
     return preg_replace('/[\x{0600}-\x{061F}\x{067A}-\x{08FF}]/u','', $str); 
    }

    //menambahkan harakat dari user dengan memakai api 
    function addHarakat($surat){
      try {
        $response = Http::get('http://tahadz.com/mishkal/ajaxGet?text='.$surat."&action=TashkeelText");
        if ($response->successful()) {
            $res = $response->json();
            return $res["result"];}
        else {
            // Handle unsuccessful response
            return response()->json(['error' => 'Failed to fetch data from the API'], $response->status());
                }
        } 
      catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // mengambil aya pembanding dari api 
    function getAyat($surat){
      try {
        // Make an HTTP GET request to the API endpoint
        $response = Http::get('https://equran.id/api/v2/surat/'.$surat);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            $allAyat = "";
            $res = $response->json();
            foreach ($res["data"]["ayat"] as $key => $ayat){
              if($key == count($res["data"]["ayat"])-1){
                $allAyat .= $ayat["teksArab"];
              }
              else $allAyat .= $ayat["teksArab"]." ";
            }
            return $allAyat;
          
        } else {
            // Handle unsuccessful response
            return response()->json(['error' => 'Failed to fetch data from the API'], $response->status());
        }
        } catch (\Exception $e) {
        // Handle any exceptions that occur during the request
        return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    // evaluasi 
    function evaluasi($pembanding, $input) {
      $kefasihan = $this->cosineSimilarity($this->getVector($pembanding), $this->getVector($input));
      $kelancaran = $this->levenshteinDistance($pembanding, $input);
      $tajwid = $this->cosineSimilarity($this->vectTajwid($pembanding), $this->vectTajwid($input));
      return [
        'kefasihan' => intval(50 +($kefasihan * 38)),
        'kelancaran' => intval(50 + ($kelancaran * 38)),
        'tajwid' => intval(50 + ($tajwid * 38)),
      ];
    }

    // untuk mendapatkan vektor string
    function getVector($str) {
      $vec = [];
      $chars = preg_split('//u', $str, null, PREG_SPLIT_NO_EMPTY);
      foreach ($chars as $char) {
        if (!isset($vec[$char])) {
          $vec[$char] = 1;
        } else {
          $vec[$char]++;
        }
      }
      return $vec;
    }

    // untuk mendapatkan vektor tajwid
    function vectTajwid($string) {
      //hukum dengan harokat
      $hukumTajwidHarakat = [
        'idzhar' => '/(نْ|ً|ٌ|ٍ|نْ |ً |ٌ |ٍ)[حخعغهء]/u',
        'idghom' => '/(نْ|ً|ٌ|ٍ|نْ |ً |ٌ |ٍ)[يرملون]/u',
        'iqlab' =>  '/(نْ|ً|ٌ|ٍ|نْ |ً |ٌ |ٍ)[ب]/u',
        'ikhfa' =>  '/(نْ|ً|ٌ|ٍ|نْ |ً |ٌ |ٍ)[صضطظزكتسشدذجفقث]/u',
        'ikhfa safawi' => '/(مْ |مْ)ب/u',
        'idghom mitslain' => '/(مْ |مْ)م/u',
        'idzhar safawi' => '/(مْ |مْ)[صضطظزكتسشدذجفقثيرلونحخعغهء]/u',
        'mad thobii' => '/(وْ|َا|ِي)/u',
        'mad lin' => '/(َوْ|َيْ)/u',
        'gunnah' => '/(نّ|مّ)/u',
        'qolqolah' => '/(بْ|جْ|دْ|طْ|قْ)/u'
      ];
      $tajwid = [];
      foreach ($hukumTajwidHarakat as $key => $pattern) {
        preg_match_all($pattern, $string, $matches);
        $tajwid[$key] = isset($matches[0]) ? count($matches[0]) : 0;
      }
      return $tajwid;
    }

    // algoritma levenshtein Distance
    function levenshteinDistance($str1, $str2) {
      $len1 = mb_strlen($str1, 'UTF-8');
      $len2 = mb_strlen($str2, 'UTF-8');
      $matrix = [];
      // Inisialisasi matriks dengan nilai awal
      for ($i = 0; $i <= $len1; $i++) {
        $matrix[$i][0] = $i;
      }
      for ($j = 0; $j <= $len2; $j++) {
        $matrix[0][$j] = $j;
      }
      // Hitung jarak Levenshtein
      for ($i = 1; $i <= $len1; $i++) {
        for ($j = 1; $j <= $len2; $j++) {
          $cost = mb_substr($str1, $i - 1, 1, 'UTF-8') === mb_substr($str2, $j - 1, 1, 'UTF-8') ? 0 : 1;
          $matrix[$i][$j] = min(
            $matrix[$i - 1][$j] + 1,
            $matrix[$i][$j - 1] + 1,
            $matrix[$i - 1][$j - 1] + $cost
          );
        }
      }
      return ($len1 - $matrix[$len1][$len2]/4) / $len1;
    }

    // algoritma Cosine Similarity
    function cosineSimilarity($vec1, $vec2) {
      $dotProduct = 0;
      $mag1 = 0;
      $mag2 = 0;
      foreach (array_keys($vec1) as $char) {
        $mag1 += $vec1[$char] ** 2;
        if (isset($vec2[$char])) {
          $dotProduct += $vec1[$char] * $vec2[$char];
        }
      }
      foreach (array_keys($vec2) as $char) {
        $mag2 += $vec2[$char] ** 2;
      }
      $similarity = $dotProduct / (sqrt($mag1) * sqrt($mag2));
      return $similarity;
    }
    
}
