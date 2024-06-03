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
            <div class="col-md-12">
                <a data-toggle="modal"href="#modal" class="btn btn-primary" style="justify-items: end"><i
                        class="fa fa-plus"></i> Nilai</a>
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
                                    <th>Action</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Pengetahuan</th>
                                    <th>Sikap</th>
                                    <th>Keterampilan</th>
                                    <th></th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal" class="modal modal-large in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h4>Nilai Sikap</h4>
                    <div class="form-horizontal">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9"> <select name="siswa" id="siswa" class="form-control">
                                    @foreach ($siswa as $item)
                                        <option value="{{ $item->uuid }}" class="form-control">{{ $item->nama }}
                                        </option>
                                    @endforeach

                                </select></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Pengetahuan</label>
                            <div class="col-sm-9"><select name="pengetahuan" id="pengetahuan" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Sikap</label>
                            <div class="col-sm-9"><select name="sikap" id="sikap" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Kelancaran</label>
                            <div class="col-sm-9">
                                <select name="keterampilan" id="keterampilan" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
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
    <div id="modal-p" class="modal modal-large in" aria-hidden="true">
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
                            <div class="col-sm-9"> <input type="text" id="siswap" class="form-control" disabled></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Pengetahuan</label>
                            <div class="col-sm-9"><select name="pengetahuan" id="pengetahuanp" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Sikap</label>
                            <div class="col-sm-9"><select name="sikap" id="sikapp" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select></div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Kelancaran</label>
                            <div class="col-sm-9">
                                <select name="keterampilan" id="keterampilanp" required class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-3 control-label">Catatan</label>
                            <div class="col-sm-9"><input type="text" placeholder="Catatan" id="catatanp" required
                                    class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3" style="text-align: end">
                                <button class="btn btn-primary" id="save-p">Save</button>

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
        <script src="{{ URL::asset('assets/injs/siswasikap.js') }}"></script>
        <script>
            let table;
            document.addEventListener("DOMContentLoaded", function() {
                var path = window.location.pathname;
                var segments = path.split('/');
                table = new DataTable("#data-table", {
                    columnDefs: [{
                        width: "250px",
                        targets: 7
                    }, 
                
                ],
                    dom: "ftipl",
                    processing: false,
                    ordering: true,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"],
                    ],
                    language: {
                        emptyTable: "Tidak ada data! pastikan semester dan tahun pelajaran ada yang aktif",
                    },
                    ajax: {
                        url: "/api/nilai/" + segments[2] + "/sikap",
                        type: "GET",
                    },
                    columns: [{
                            title: "No",
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Mengembalikan nomor baris, dimulai dari 1
                            },
                        },
                        {
                            title: "Action",
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <div style="display:flex; gap:8px; justify-content: center">
                    <button id="perbaikan" class="btn btn-outline btn-sm btn-primary fa fa-pencil" data-id="${data.uuid}" data-nama="${data.nama}"> Perbaikan</button> 
                   `;
                            },
                        },
                        {
                            title: "Nama",
                            data: "nama"
                        },
                        {
                            title: "Kelas",
                            data: "kelas"
                        },
                        {
                            title: "Pengetahuan",
                            data: "pengetahuan"
                        }, {
                            title: "Sikap",
                            data: "sikap"
                        }, {
                            title: "Keterampilan",
                            data: "keterampilan"
                        },
                        {
                            title: "Catatan",
                            data: "remark"

                        },
                        {
                            title: "Semester/Tahun",
                            data: null,
                            render : function (data){
                                return data.semester+"/"+data.tahun_pelajaran
                            }

                        }
                        

                    ],
                });


            });
            let uuid;
            $(document).on("click", "#perbaikan", function() {
                uuid = $(this).data("id");
                $.ajax({
                    url: "/api/nilai/sikap/" + uuid,
                    type: "get",
                    success: (data) => {
                        $("#siswap").val($(this).data('nama'));
                        $("#pengetahuanp").val(data.pengetahuan);
                        $("#sikapp").val(data.sikap);
                        $("#keterampilanp").val(data.keterampilan);
                        $("#catatan").val(data.remark);
                        $('#modal-p').modal('show');

                        // console.log
                        // toastr.success("Berhasil dihapus!", "Data Kelas");
                    },
                });
            });
            $(document).on("click", "#save", function() {
                $.ajax({
                    url: "/api/nilai/sikap",
                    type: "post",
                    data: {
                        siswa: $("#siswa").val(),
                        pengetahuan: $("#pengetahuan").val(),
                        sikap: $("#sikap").val(),
                        keterampilan: $("#keterampilan").val(),
                        remark: $("#catatan").val(),
                    },
                    success: (data) => {
                        $('#modal').modal('hide');
                        table.ajax.reload();
                        toastr.success("Berhasil disimpan!", "Success");
                    },
                });
            });
            $(document).on("click", "#save-p", function() {
                $.ajax({
                    url: "/api/nilai/sikap/"+uuid,
                    type: "Put",
                    data: {
                        pengetahuan: $("#pengetahuanp").val(),
                        sikap: $("#sikapp").val(),
                        keterampilan: $("#keterampilanp").val(),
                        remark: $("#catatanp").val(),
                        
                    },
                    success: (data) => {
                        $('#modal-p').modal('hide');

                        table.ajax.reload();
                        toastr.success("Berhasil disimpan!", "Perbaikan");
                    },
                });
            });
        </script>
    @endpush
