@extends('layout.master')
@section('main')
    <div class="row">
        <div class="col-lg-12 " style="margin-top: 10px; margin-bottom:30px">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 20px">
                            <div class="form-group">
                                <label class="col-sm-1 control-label" style="padding-top:8px">Kelas</label>
                                <div class="col-sm-4">
                                    <select name="kelas" id="kelas" class="form-control">
                                        <option value="" readonly>~Kelas~</option>
                                        @foreach ($tingkat as $kelas)
                                            <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <style>
                                     @media (max-width: 767px) {
                                    #scan {
                                        margin-top: 30px;
                                        width: auto;
                                                                        }
                                }
                                </style>
                            
                                <div class="col-md-4 m-sm-t-sm">
                                    <button class="btn btn-primary  btn-lg fa fa-qrcode" id="scan"> Scan QR</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 " style="margin-top: 10px; margin-bottom:30px">
                            <div class="row">
                                <div class="col-sm-12 mt-3">
                                    <div class="table-responsive">
                                        <table id="data-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nis</th>
                                                    <th>Nama</th>
                                                    <th>Kelas</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-7 " style="margin-top: 10px ;margin-bottom: 30px">
                            <div class="table-responsive">
                                <style>
                                    th {
                                        text-align: center
                                    }

                                    td {
                                        text-transform: capitalize
                                    }
                                </style>
                                <table id="data-nilai" class="table table-bordered cell-border">
                                    <thead>

                                        <tr style="">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Surat</th>
                                            <th>Kefasihan</th>
                                            <th>Tajwid</th>
                                            <th>kelancaran</th>
                                            <th>Capaian</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-dengar" class="modal modal-large in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h4>Dengarkan Surat</h4>
                    <div class="form-horizontal">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9"><input disabled type="text" id="nama" required
                                    class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Surat</label>
                            <div class="col-sm-9">
                                <select name="surat" id="surat" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div id="nilai" style="display: none">
                            <div class="form-group"><label class="col-sm-3 control-label">Kefasihan</label>
                                <div class="col-sm-9"><input type="number" placeholder="Kefasihan" name="kefasihan"
                                        id="kefasihan" required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Tajwid</label>
                                <div class="col-sm-9"><input type="number" placeholder="Tajwid" name="tajwid"
                                        id="tajwid" required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Kelancaran</label>
                                <div class="col-sm-9"><input type="number" placeholder="kelancaran" id="kelancaran"
                                        name="kelancaran" required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Catatan</label>
                                <div class="col-sm-9"><input type="text" placeholder="Catatan" id="Catatan"
                                        name="catatan" class="form-control"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <center "><div style="border: 1px dashed rgb(155, 151, 151); margin-bottom:20px;font-size:1.5rem" id="text"></div>
                                                <audio id="audio" src="" style="display: none" controls></audio></center>
                                                <div class="hr-line-dashed">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                                        <div id="output"></div>
                                                        <button class="btn btn-primary" id="start">Mulai Merekam</button>
                                                        <button class="btn btn-primary" id="stop" disabled>Berhenti Merekam </button>
                                                        <button class="btn btn-primary" style ="display: none"id=" save">
                            Save</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div id="modal-manual" class="modal modal-large in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h4>Nilai Hafalan</h4>
                    <div class="form-horizontal">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9"><input disabled type="text" id="namam" required
                                    class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Surat</label>
                            <div class="col-sm-9">
                                <select name="surat" id="suratm" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Kefasihan</label>
                            <div class="col-sm-9"><input type="number" placeholder="Kefasihan" id="kefasihanm" required
                                    class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Tajwid</label>
                            <div class="col-sm-9"><input type="number" placeholder="Tajwid" id="tajwidm" required
                                    class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Kelancaran</label>
                            <div class="col-sm-9"><input type="number" placeholder="kelancaran" id="kelancaranm"
                                    required class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Catatan</label>
                            <div class="col-sm-9"><input type="text" placeholder="Catatan" id="catatanm" required
                                    class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                <button id="auto" class="btn btn-outline btn-sm btn-primary "
                                    data-nama="">Dengarkan</button>
                                <button class="btn btn-primary" id="save-manual">Save</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="scan-qr" data-url="{{ url('') }}" class="modal modal-large in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h4>Scan QR code Siswa</h4>
                    <div class="form-horizontal">
                        <div class="hr-line-dashed"></div>
                        <div>
                            <video id="video" width="100%" height="auto"></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                <button class="btn btn-primary" id="close">Close</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush
@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> // export pdf --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> // export pdf --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> {{-- print --}}
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    <script src="{{ URL::asset('assets/injs/hafalan.js') }}"></script>
@endpush
