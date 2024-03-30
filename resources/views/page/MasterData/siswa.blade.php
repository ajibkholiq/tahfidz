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
        <div class="col-md-12" style="display: flex; justify-content:space-between">
            <div class="col-md-3">
                <button id="btn-add" class="btn btn-primary" style="justify-items: end"><i class="fa fa-plus"></i>
                    Siswa</button>
                <button id="import" class="btn btn-primary" style="justify-items: end"><i class="fa fa-plus"></i>
                    Import</button>
            </div>
           
            <a href="{{ url()->previous() }}" class="btn btn-primary" style="justify-items: end"><i
                    class="fa fa-arrow-left"></i>
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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Nama Ayah</th>
                                    <th>Nama Ibu</th>
                                    <th>No Hp</th>
                                    <th>Alamat</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>


                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="import-modal" class="modal in" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>Import Siswa</h4>
                        <form method="post" action="{{route('import')}}"class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <input type="hidden" name="kelas" value="{{Request::segment(2)}}">
                            <div class="form-group"><label class="col-sm-3 control-label">File Excel</label>

                                <div class="col-sm-9"><input type="file" name="file"
                                        required class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                    <a class="btn btn-primary" href="{{route('download')}}">Download Template </a>
                                    <button class="btn btn-primary">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="add-siswa" class="modal in" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>Tambah Siswa</h4>
                        <form method="post" action=""class="form-horizontal">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-3 control-label">NIS</label>

                                <div class="col-sm-9"><input type="text" placeholder="Nomer Induk Siswa" name="nis"
                                        required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama</label>

                                <div class="col-sm-9"><input type="text" placeholder="Nama" name="nama" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama Ayah</label>
                                <div class="col-sm-9"><input type="text" placeholder="Nama Ayah" name="ayah" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama Ibu</label>
                                <div class="col-sm-9"><input type="text" placeholder="Nama Ibu" name="ibu" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">No Hp</label>
                                <div class="col-sm-9"><input type="text" placeholder="No Hp" name="nohp" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Alamat</label>
                                <div class="col-sm-9"><input type="text" placeholder="Alamat" name="alamat" required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9"><input type="text" placeholder="Keterangan" name="remark"
                                        class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit-siswa" class="modal in" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>Ubah Siswa</h4>
                        <div class="form-horizontal">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama</label>

                                <div class="col-sm-9"><input type="text" placeholder="Nama" name="nama"
                                        id="nama" required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Kelas</label>
                                <div class="col-sm-9">
                                    <select id="kelasEdit" class='form-control'>
                                        @foreach ($kelas as $kls)
                                            <option value="{{ $kls->id }}">{{ $kls->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama Ayah</label>
                                <div class="col-sm-9"><input type="text" placeholder="Nama Ayah" id="ayah"
                                        required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Nama Ibu</label>
                                <div class="col-sm-9"><input type="text" placeholder="Nama Ibu" id="ibu"
                                        required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">No Hp</label>
                                <div class="col-sm-9"><input type="text" placeholder="No Hp" id='nohp' required
                                        class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Alamat</label>
                                <div class="col-sm-9"><input type="text" placeholder="Alamat" id="alamat"
                                        name="alamat" required class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9"><input type="text" placeholder="Keterangan" id="remark"
                                        class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                    <button class="btn btn-primary" id="ubahsiswa">Ubah</button>
                                </div>
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
    <script src="{{ URL::asset('assets/modal.js') }}"></script>
@endpush
