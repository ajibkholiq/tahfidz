<h4>Tambah User</h4>
<form method="post" action="{{ URL::Route('pegawai.store') }}"class="form-horizontal">
    @csrf
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Nama</label>
        <div class="col-sm-10"><input type="text" placeholder="Nama" name="nama" required class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Username </label>

        <div class="col-sm-10"><input type="text" placeholder="Username" required name="username"
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Password</label>

        <div class="col-sm-10"><input type="password" placeholder="Password" required name="password"
                class="form-control"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10"><input type="email" placeholder="Email" name="email" required class="form-control">
        </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">No HP</label>
        <div class="col-sm-10"><input type="text" placeholder="HP" name="nohp" required class="form-control">
        </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
        <div class="col-sm-10"><input type="text" placeholder="Alamat" required name="alamat" class="form-control">
        </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Role</label>
        <div class="col-sm-10">
            <select name="role" id="" class="form-control">
                @foreach ($role as $item)
                    <option value="{{ $item->nama_role }}">{{ $item->nama_role }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2" style="text-align: end">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>
