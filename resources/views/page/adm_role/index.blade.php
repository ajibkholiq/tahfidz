@extends('layout.master')

@section('main')
    <div class="row" style="margin-top:10px">
        <div class="col-md-12">
            @if (session('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <a class="alert-link" href="#">Berhasil.! </a>, {{ session('success') }}
                    </div>

                </div>
            @endif
        </div>
        <div class="col-md-12">
            <a href="#" class="btn btn-primary float-right" style="margin-top: 10px" data-toggle="modal"
                data-target="#addRoleModal"><i class="fa fa-plus"></i> Add Role</a>
        </div>
        <!-- Modal -->

        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content" style="margin-top: 10px">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <style>
                                    th {
                                        text-align: center;
                                        font-size: 10pt;
                                    }
                                </style>
                                <tr>
                                    <th>Nama Role</th>
                                    <th>Remark</th>
                                    <th>Create_by</th>
                                    <th>Update_by</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                @foreach ($adm_roles as $adm_role)
                                    <tr>
                                        <td>{{ $adm_role->nama_role }}</td>
                                        <td>{{ $adm_role->remark }}</td>
                                        <td>{{ $adm_role->create_by }}</td>
                                        <td>{{ $adm_role->update_by }}</td>

                                        <td>
                                            <button class="btn btn-warning btn-outline  fa fa-pencil"
                                                data-id="{{ $adm_role->uuid }}" id="btn-edit"></button>
                                            <form action="{{ route('adm-role.destroy', $adm_role->uuid) }}" method="POST"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-outline fa fa-trash-o "
                                                    onclick="return confirm('Are you sure?')"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulir tambah role -->
                            <form action="{{ route('adm-role.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_role">Nama Role:</label>
                                    <input type="text" name="nama_role" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="remark">Remark:</label>
                                    <input type="text" name="remark" required class="form-control">
                                </div>
                                <!-- Tambahkan elemen input lainnya sesuai dengan kebutuhan Anda -->
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit-form" class="modal in" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h4>Edit Menu</h4>
                            <div class="hr-line-dashed"></div>

                            <div class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="uuid">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="nama_role">Nama Role:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_role" id="nama" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="remark">Remark:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="remark" id="remark" required class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <!-- Tambahkan elemen input lainnya sesuai dengan kebutuhan Anda -->
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2" style="text-align: end">
                                        <button class="btn btn-primary" id="edit" type="submit">
                                            Edit
                                        </button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>
            $('body').on('click', '#btn-edit', function() {

                let post_id = $(this).data('id');
                //fetch detail post with ajax
                $.ajax({
                    url: "/adm-role/" + post_id,
                    type: "GET",
                    success: function(data) {
                        $('#uuid').val(data.uuid);
                        $('#nama').val(data.nama_role);
                        $('#remark').val(data.remark);
                        $('#edit-form').modal('show');
                    }
                });
            });

            $('#edit').on('click', function() {
                console.log($('#uuid').val());
                $.ajax({
                    url: '/adm-role/' + $('#uuid').val(),
                    type: 'PUT',
                    data: {
                        'nama': $('#nama').val(),
                        'remark': $('#remark').val(),
                        '_token': $("input[name='_token']").val(),
                        '_method': 'PUT',
                    },
                    success: function(response) {
                        console.log(response);
                        $('#edit-form').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 100);
                    }
                })


            })
        </script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>  --}}
    @endpush
