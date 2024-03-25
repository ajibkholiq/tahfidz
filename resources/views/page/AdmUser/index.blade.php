@extends('layout.master')
@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!--datatable responsive css-->
@endpush
@section('main')
    <div class="row" style="margin-top:10px">
        @if (session('success'))
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <a class="alert-link" href="#">Berhasil.! </a>{{ session('success') }}
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <a data-toggle="modal"href="#add-form" class="btn btn-primary" style="justify-items: end"><i
                    class="fa fa-plus"></i> Add User</a>
        </div>

        <div class="col-lg-12 " style="margin-top: 10px ;margin-bottom: 30px">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <style>
                                        th {
                                            text-align: center;
                                        }

                                        td {
                                            text-transform: capitalize
                                        }
                                    </style>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Role</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="add-form" class="modal in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    @include('page.AdmUser.create')
                </div>
            </div>
        </div>
    </div>
    <div id="edit-form" class="modal in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    @include('page.AdmUser.edit')
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
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    >

    <script>
        let table
        document.addEventListener("DOMContentLoaded", function() {
            table = new DataTable("#data-table", {
                dom: "Bfrtipl",
                buttons: [{
                        extend: "excel",
                        title: "Data Siswa",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: "Excel",
                        autoFilter: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6],
                        },
                    },
                    {
                        extend: "print",
                        title: "Data Siswa",
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6],
                        },
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
                    url: "/api/pegawai",
                    type: "GET",
                },
                columns: [
                    {
                title: "No",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Mengembalikan nomor baris, dimulai dari 1
                },
            },
                    {
                        title: "Nama",
                        data: "nama"
                    },
                    {
                        title: "Username",
                        data: "username"
                    },
                    {
                        title: "Email",
                        data: "email"
                    },
                    {
                        title: "Alamat",
                        data: "alamat"
                    },
                    {
                        title: "No Hp",
                        data: "nohp"
                    },
                    {
                        title: "Role",
                        data: "role"
                    },
                    {
                        title: "Action",
                        data: null,
                        render: function(data, type, row) {
                            if (data.role !== 'admin') {
                                return `
                    <div style="display:flex; gap:8px; justify-content: start">
                   <button id="bt-hapus" class="btn btn-outline btn-sm btn-danger fa fa-trash-o" data-id="${data.uuid}"></button> 
                    <button id="bt-edit" class="btn btn-outline btn-sm btn-warning fa fa-pencil " data-uuid="${data.uuid}"></button></div>
                   `;
                            }
                            return '';
                        },
                    },
                ],
            });
        });
        $('body').on('click', '#bt-edit', function() {
            let uuid = $(this).data('uuid');
            $.ajax({
                url: '/pegawai/' + uuid,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.uuid);
                    $('#nama').val(data.nama);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#nohp').val(data.nohp);
                    $('#alamat').val(data.alamat);
                    $('#role').val(data.role);
                    $('#edit-form').modal('show');

                }
            });
        });

        $('#save').on('click', function() {
            let uuid = $('#id').val();
            console.log(uuid);

            $.ajax({
                url: '/pegawai/' + uuid,
                type: 'PUT',
                data: {
                    'nama': $('#nama').val(),
                    'username': $('#username').val(),
                    'email': $('#email').val(),
                    'nohp': $('#nohp').val(),
                    'alamat': $('#alamat').val(),
                    'role': $('#role').val(),
                    '_token': $("input[name='_token']").val(),
                    '_method': 'PUT'
                },
                success: function(response) {
                    console.log(response);
                    $('#edit-form').modal('hide');
                    toastr.success('Berhasil diubah!', 'Data Pegawai');
                    table.ajax.reload();
                },
            });
        });
        $(document).on("click", "#bt-hapus", function() {
            let uuid = $(this).data("id");
            $.ajax({
                url: "/pegawai/" + uuid,
                type: "DELETE",
                data: {
                    _token: $("input[name='_token']").val(),
                    _method: "DELETE",
                },
                success: () => {
                    toastr.success('Berhasil dihapus!', 'Data Pegawai');
                    table.ajax.reload();
                },
            });
        });
    </script>
@endpush
