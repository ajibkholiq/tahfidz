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
    {{-- <script src="{{ URL::asset('assets/modal.js') }}"></script> --}}
    <script>
        let table;
        document.addEventListener("DOMContentLoaded", function() {
            var path = window.location.pathname;
            var segments = path.split('/');
            table = new DataTable("#data-table", {
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
                    url: "/api/nilai/" + segments[2],
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
                        title: "Surat",
                        data: "surat"
                    },
                    {
                        title: "Kefasihan",
                        data: "kefasihan"
                    },{
                        title: "Tajwid",
                        data: "tajwid"
                    },{
                        title: "Kelancaran",
                        data: "kelancaran"
                    },{
                        title: "Capaian",
                        data: "capaian"
                    },

                ],
            });
        });
        let uuid;
        $(document).on("click", "#perbaikan", function() {
            uuid = $(this).data("id");
            $.ajax({
                url: "/api/hafalan/" + uuid,
                type: "get",
                success: (data) => {
                    $("#nama").val($(this).data('nama'));
                    $("#kefasihan").val(data.kefasihan);
                    $("#tajwid").val(data.tajwid);
                    $("#kelancaran").val(data.kelancaran);
                    $("#catatan").val(data.remark);
                    $('#modal-manual').modal('show');
                    console.log(data);  
                    
                    // console.log
                    // toastr.success("Berhasil dihapus!", "Data Kelas");
                },
            });
        });
        $(document).on("click", "#save", function() {
            $.ajax({
                url: "/api/hafalan/" + uuid,
                type: "PUT",
                data :{
                    kefasihan : $("#kefasihan").val(),
                    tajwid : $("#tajwid").val(),
                    kelancaran :$("#kelancaran").val(),
                    remark : $("#catatan").val(),
                },
                success: (data) => {
                    $('#modal-manual').modal('hide');      
                    table.ajax.reload();
                    toastr.success("Berhasil disimpan!", "Perbaikan");
                },
            });
        });

    </script>
@endpush
