<!DOCTYPE html>
<html>
    <head>
        <title>Bukti Pembayaran</title>
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
                    <h3 style="text-align: center; text-transform:uppercase ;position: absolute; left:250px" >BUKTI PEMBAYARAN</h3>
                    <hr>
                    <div class="row justify-content-start">
                         <style>
                                .col-md-6 td {
                                    width: 300px;
                                }
                            </style>
                        <div class="col-md-6">
                           
                            <table>
                                
                                <tr>
                                    <td><strong>Tanggal Pembayaran</strong></td>
                                    <td> : {{date('d F Y', strtotime($head->tanggal))}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Siswa</strong></td>
                                    <td class="text-capitalize">: {{$head->nama}}</td>
                                </tr>
                                 <tr>
                                    <td><strong>NIS</strong></td>
                                    <td class="text-capitalize">: {{$head->nis}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kelas</strong></td>
                                    <td class="text-capitalize">: {{$head->kelas}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Metode Pembayaran</strong></td>
                                    <td class="text-uppercase">: {{$head->akun}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <img src="" alt="">
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
                    <table class="table table-striped mt-5">
                        <thead>
                            <tr style="font-weight:bolder" >
                                <td>Rincian Pembayaran</td>
                                <td>Jumlah</td>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @foreach ($detail as $i)
                            <tr>
                                <td>{{$i->nama}}</td>
                                <td>Rp. {{number_format($i->nominal,2,',','.')}}-</td>
                            </tr>
                            @endforeach
                            
                            <tr style="">
                                <td><strong>Total Pembayaran:</strong></td>
                                <td><strong>Rp. {{number_format($head->masuk,2,',','.')}}-</strong></td>
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

    </body>
</html>
