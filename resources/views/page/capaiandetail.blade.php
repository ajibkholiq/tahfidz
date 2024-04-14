<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capaian | SITahfidz</title>
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
         #audio {
                width:120px;
                height:50px
            }
        @media (min-width: 1000px) {
            #audio {
                width:150px;
                height:30px
            }
        }
    </style>

</head>

<body class="gray-bg">
 @if (!$capaian == null )
    <div class="row"  style="display:flex; justify-content: center ;margin-top:20px">
        <div class="col-sm-10 col-xs-12"style="margin: 0;padding:0" >
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Capaian</h3>
                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 20px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="col-xs-4 col-lg-2 control-label">Nis</label>
                                    <label class="col-xs-8 col-lg-10 control-label">{{ $capaian['nis'] }} </label>
                                </div>
                                <div class="col-lg-12">
                                    <label class="col-xs-4 col-lg-2 control-label">Nama</label>
                                    <label class="col-xs-8 col-lg-10 control-label">{{ $capaian['nama'] }} </label>
                                </div>
                                <div class="col-lg-12">
                                    <label class="col-xs-4 col-lg-2 control-label">Kelas</label>
                                    <label class="col-xs-8 col-lg-10 control-label">{{ $capaian['kelas'] }} </label>
                                </div> 
                              
                            </div>
                        </div>
                        <div class="col-lg-12" style="margin-top: 10px; margin-bottom:30px">
                            <div class="row">
                                <div class="col-sm-12" >
                                    <div class="table-responsive" style="margin: 0 10px " >
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Surat</th>
                                                    <th>Ayat</th>
                                                    <th>Kefasihan</th>
                                                    <th>Tajwid</th>
                                                    <th>Kelancaran</th>
                                                    <th>Audio</th>

                                                </tr>
                                            </thead>
                                            @php
                                                function getKategori($nilai)
                                                {
                                                    return $nilai >= 83.67
                                                        ? 'Sangat Baik'
                                                        : ($nilai <= 79.2
                                                            ? 'Cukup Baik'
                                                            : 'Baik');
                                                }

                                            @endphp
                                            <tbody>
                                                @foreach ($capaian['surat'] as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ '1 - ' . $item->ayat }}</td>
                                                        <td>{{ getKategori($item->kefasihan) }}</td>
                                                        <td>{{ getKategori($item->tajwid) }}</td>
                                                        <td>{{ getKategori($item->kelancaran) }}</td>
                                                        <td style="width: 160px">
                                                            @if ($item->audio == null)
                                                                "Tidak ada"
                                                            @else
                                                                <audio id="audio"
                                                                    src="{{ '/audio/siswa/' . $item->audio }}"
                                                                    style="" controls></audio>
                                                            @endif

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else 
    <h4> Data Tidak ditemukan.!  </h4>

    @endif
</body>


</html>
