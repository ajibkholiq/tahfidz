@extends('layout.master')
@section('main')
    @push('css')
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
        <!--datatable responsive css-->
    @endpush
    <div class="row" style="margin-top:10px">
        @if (session('success'))
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <a class="alert-link" href="#">Berhasil.! </a>{{ session('success') }}
                </div>
            </div>
        @endif

        <div class="col-md-12" style="display: flex; justify-content:end">
            <a href="{{url()->previous()}}" class="btn btn-primary" style="justify-items: end"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>

        <div class="col-lg-12 " style="margin-top: 10px ;margin-bottom: 30px">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <style>
                            th {
                                text-align: center
                            }

                            td {
                                text-transform: capitalize
                            }
                        </style>
                        <table id="data-table" class="table table-striped cell-border">
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
                                    <th>Action</th>


                                </tr>
                            </thead>
                        </table>
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
                        <div class="form-group"><label class="col-sm-3 control-label" >Nama</label>
                            <div class="col-sm-9"><input disabled type="text" id="nama" required
                                    class="form-control"></div>
                        </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Kefasihan</label>
                                <div class="col-sm-9"><input type="number" placeholder="Kefasihan" id="kefasihan" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Tajwid</label>
                                <div class="col-sm-9"><input type="number" placeholder="Tajwid" id="tajwid" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Kelancaran</label>
                                <div class="col-sm-9"><input type="number" placeholder="kelancaran" id="kelancaran"
                                        required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Catatan</label>
                                <div class="col-sm-9"><input type="text" placeholder="Catatan" id="catatan" required
                                        class="form-control"></div>
                            </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                            <button class="btn btn-primary" id="save">Save</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    <script src="{{ URL::asset('assets/injs/siswanilai.js') }}"></script>
    
@endpush
