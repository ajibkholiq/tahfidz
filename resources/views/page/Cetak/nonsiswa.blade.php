<!DOCTYPE html>
<html>
    <head>
        <title>Bukti {{ Request::segment(1) }}</title>
        {{-- <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        /> --}}
    </head>
    <body>
        <div class="container">
            <div class="card my-5" >
                <div class="card-body">
                    <img src="assets/img/unit/Universitas_Mandiri_120823.png" style="width:100px; position:relative" >
                    <h3 style="text-align: center; text-transform:uppercase ;position: absolute; left:250px">BUKTI {{ Request::segment(1) }}</h3>
                    <hr>
                    <div class="row justify-content-start">
                         <style>
                                .col-md-6 td {
                                    width: 200px;
                                }
                            </style>
                        <div class="col-md-6">
                           
                            <table>
                                
                                <tr>
                                    <td><strong>Tanggal {{$head->masuk ? 'penerimaan':'pengeluaran' }}</strong></td>
                                    <td> : {{date('d F Y', strtotime($head->tanggal))}}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{$head->masuk ? 'Diterima Dari':'Dikeluarkan Kepada' }}</strong></td>
                                    <td style="text-transform: capitalize">: {{$head->nama}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Metode Pembayaran</strong></td>
                                    <td style="text-transform: uppercase">: {{$head->akun}}</td>
                                </tr>
                            </table>
                        </div>
                        
                    </div>
                    <hr>
                    <style>
                        td {
                            width: 485px;
                            height: 20px;
                           
                        }
                        tr{
                             border: 1px black solid
                        }
                        .nom{
                            width: 200px
                        }
                    </style>
                    <table class="table table-striped mt-5" style="">
                        <thead>
                            <tr style="font-weight:bolder">
                                <td >Rincian {{ Request::segment(1) }}</td>
                                <td class="nom" >Jumlah</td>
                            </tr>
                        
                        </thead>
                        <tbody>
                            @foreach ($detail as $i)
                            <tr>
                                <td>{{$i->kode_tagihan}}</td>
                                <td class="nom"  >Rp. {{number_format($i->nominal,0,',','.')}},-</td>
                            </tr>
                            @endforeach
                           
                            <tr>
                                <td><strong>Total Diterima:</strong></td>
                                <td  class="nom" ><strong>Rp. {{$head->masuk ? number_format($head->masuk,0,',','.') : number_format($head->keluar,0,',','.') }},-</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr />
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <style>
                            .col-md-5 td{
                                width: 250px;
                            }
                            </style>
                            <table>
                            <tr>
                                <td style="padding-bottom:75px;padding-top:20px;text-align:center">Terima kasih atas Transaksi Anda.</td>
                                
                            </tr>

                            <tr>
                                <td style="text-align: center; text-transform:capitalize">{{Session::get('nama')}}</td>
                                
                            </tr>
                            <tr>
                                <td style="text-align: center; text-transform:capitalize; border-top:1px dotted black ">{{Session::get('role')}}</td>
                                
                            </tr>
                            </table>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>

        {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    --}}
    </body> 
</html>
