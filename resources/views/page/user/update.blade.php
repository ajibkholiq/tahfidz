<form action="{{ route('updateUser', $data->uuid) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="ibox-content" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
        <div class="form-group">    
            <label for="nama_role">Nama:</label>
            <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
        </div>
        <div class="form-group">    
            <label for="nama_role">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $data->email }}">
        </div>
        <div class="form-group">    
            <label for="nama_role">Username:</label>
            <input type="text" name="username" class="form-control" value="{{ $data->username }}">
        </div>
        <div class="form-group">    
            <label for="nama_role">No HP:</label>
            <input type="text" name="nohp" class="form-control" value="{{ $data->nohp }}">
        </div>
        <div class="form-group">    
            <label for="nama_role">Alamat:</label>
            <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}">
        </div>

        <button type="submit" class="btn btn-primary" style="border-radius: 25px">Update</button>
    </div>
</form>