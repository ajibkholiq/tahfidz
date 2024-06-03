<h4>Edit User</h4>
{{-- <form method="POST" class="form-horizontal"> --}}
<div class="form-horizontal">
    @csrf
    @method('PUT')
    <div class="hr-line-dashed"></div>
    <input type="hidden" id="id">
    <div class="form-group"><label class="col-sm-2 control-label">Nama</label>

        <div class="col-sm-10"><input type="text" placeholder="Nama" required name="nama" id="nama"
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Username </label>

        <div class="col-sm-10"><input type="text" placeholder="Username" required name="username" id="username"
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10"><input type="email" placeholder="Email" name="email" required id="email"
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">No HP</label>
        <div class="col-sm-10"><input type="text" placeholder="HP" name="nohp" id="nohp" required
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
        <div class="col-sm-10"><input type="text" placeholder="Alamat" name="alamat" id="alamat" required
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Role</label>
        <div class="col-sm-10">
            <select name="roleEdit" id="role" class="form-control">
                @foreach ($role as $item)
                    <option value="{{ $item->nama_role }}">{{ $item->nama_role }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2" style="text-align: end">
            <button class="btn btn-primary" id="save">Save</button>
        </div>
    </div>
</div>
{{-- </form> --}}
