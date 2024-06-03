@extends('layout.master')
{{-- @push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
@endpush --}}
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
                    class="fa fa-plus"></i> Add Menu</a>
        </div>

        <div class="col-lg-12 " style="margin-top: 10px ;margin-bottom: 30px">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped "style="text-align: center;">
                            <thead>
                                <tr>
                                    <style>
                                        th {
                                            text-align: center;
                                        }
                                    </style>
                                    <th>ID</th>
                                    <th>Induk</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Route</th>
                                    <th>Remark</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                    <tr>

                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->induk }}</td>
                                        <td>{{ $data->kode_menu }}</td>
                                        <td>{{ $data->nama_menu }}</td>
                                        <td>{{ $data->route }}</td>
                                        <td>{{ $data->remark }}</td>

                                        <td style="display: flex; justify-content:center; gap: 10px">
                                            {{-- <a href="{{route('adm-menu.edit',$data->uuid)}}" class="btn btn-warning fa fa-pencil"></a> --}}
                                            {{-- <a data-toggle="modal"href="#edit" data-menu="$(menu)"class="btn btn-warning fa fa-pencil" ></a> --}}
                                            <button class="btn btn-warning btn-outline  fa fa-pencil"
                                                data-id="{{ $data->uuid }}" id="btn-edit"></button>
                                            <form action="{{ route('adm-menu.destroy', $data->uuid) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda Yakin ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-outline btn-danger fa fa-trash-o"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
                    @include('page.AdmMenu.create')
                </div>
            </div>
        </div>
    </div>
    <div id="edit-form" class="modal in" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Edit Menu</h4>
                    <div class="form-horizontal">
                        @csrf

                        <div class="hr-line-dashed"></div>
                        <input type="hidden" id="uuid">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Induk</label>

                            <div class="col-sm-10">
                                <select id="induk" name="induk" class="form-control">
                                    <option value="head">Head</option>
                                    @foreach ($menu as $item)
                                        @if ($item->induk == 'head' && $item->route == '')
                                            <option value="{{ $item->nama_menu }}" class="text-capitalize">
                                                {{ $item->kode_menu }}. {{ $item->nama_menu }}</option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Kode Menu" class="form-control" id="kode" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Nama Menu" class="form-control" id="nama" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Route </label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Route" id="route" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Remark</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Remark" id="remark" class="form-control" />
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
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
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $('body').on('click', '#btn-edit', function() {

            let post_id = $(this).data('id');
            //fetch detail post with ajax
            $.ajax({
                url: "/api/menu/" + post_id,
                type: "GET",
                success: function(data) {
                    $('#uuid').val(data.uuid);
                    $('#induk').val(data.induk);
                    $('#kode').val(data.kode_menu);
                    $('#nama').val(data.nama_menu);
                    $('#route').val(data.route);
                    $('#remark').val(data.remark);
                    $('#edit-form').modal('show');
                }
            });
        });

        $('#edit').on('click', function() {
            console.log($('#uuid').val());
            $.ajax({
                url: '/adm-menu/' + $('#uuid').val(),
                type: 'PUT',
                data: {
                    'induk': $('#induk').val(),
                    'kode': $('#kode').val(),
                    'nama': $('#nama').val(),
                    'route': $('#route').val(),
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
