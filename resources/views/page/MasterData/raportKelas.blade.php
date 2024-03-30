@extends('layout.master')
@section('main')
    <div class="row" style="margin-top:10px">
        
        <div class="col-lg-12 " style="margin-top: 10px ;margin-bottom: 30px">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="data-table" class="table cell-border">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Kode Kelas</th>
                                    <th>Nama</th>
                                    <th>Tahun Ajaran</th>
                                    <th>semester</th>

                                </tr>
                            </thead>
                        </table>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            table = new DataTable("#data-table", {
                dom: "tpl",
                columnDefs: [{
                        width: "100px",
                        targets: 1
                    },
                    {
                        width: "20x",
                        targets: 0
                    },
                ],
                processing: false,
                ordering: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"],
                ],
                language: {
                    emptyTable: "Tidak ada data",
                },
                ajax: {
                    url: "/api/cetak/raport",
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
                    <div style="display: flex ; gap:5px;justify-content:center">
                    <a class="btn btn-outline btn-primary btn-sm" href='/cetak/${data.kelas}'>Export</button>
                    <div> `;
                        },
                    },
                    {
                        title: "Nama Kelas",
                        data: "kelas"
                    },
                    {
                        title: "Tingkat Kelas",
                        data: "tingkat"
                    },{
                        title: "Semester",
                        data: "semester"
                    },{
                        title: "Tahun Pelajaran",
                        data: "tahun_ajaran"
                    },


                ],
            });
        });
        $("body").on("click", "#bt-manage", function() {
            window.location.href = "/nilai/" + $(this).data("kelas")+"/sikap";
        });
      
    </script>
@endpush
