@extends('layout.master')



@section('main')

   {{-- membuat profile tampilan  --}}
   <div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
       @if ( session('success'))
               <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <a class="alert-link" href="#">Berhasil.! </a>{{session('success')}} 
                </div>
            </div> 
          @endif
        <div class="col-md-3">
            <div class="ibox float-e-margins" style="border: 2px solid #1AB394; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); border-radius:2px " >
              <style>
                /* Untuk layar dengan lebar 768 piksel atau kurang (misalnya tampilan ponsel) */
                @media screen and (max-width: 788px) {
                  .image {
                    width: 100px; /* Sesuaikan lebar gambar sesuai kebutuhan */
                    height: 100px; /* Sesuaikan tinggi gambar sesuai kebutuhan */
                    border-radius: 50%;
                    padding:10px;
                    display: block; /* Atur elemen menjadi blok agar dapat menggunakan margin */
                    margin-left: auto; /* Pusatkan gambar secara horizontal */
                    margin-right: auto; /* Pusatkan gambar secara horizontal */
                  }
                }
              
                /* Untuk layar dengan lebar lebih dari 768 piksel (misalnya tampilan desktop) */
                @media screen and (min-width: 769px) {
                  .image {
                    width: 150px; /* Sesuaikan lebar gambar sesuai kebutuhan */
                    height: 150px; /* Sesuaikan tinggi gambar sesuai kebutuhan */
                    border-radius: 50%;
                    padding: 10px;
                    display: block; /* Atur elemen menjadi blok agar dapat menggunakan margin */
      margin-left: auto; /* Pusatkan gambar secara horizontal */
      margin-right: auto; /* Pusatkan gambar secara horizontal */
                  }
                }

                .form-control{
                  border-radius: 8px;
                }

                @media screen and (max-width: 788px) {
                  .buttom{
                    width: 100px; /* Sesuaikan lebar gambar sesuai kebutuhan */
                    height: 100px; /* Sesuaikan tinggi gambar sesuai kebutuhan */
                    border-radius: 50%;
                    display: block; /* Atur elemen menjadi blok agar dapat menggunakan margin */
                    margin-left: auto; /* Pusatkan gambar secara horizontal */
                    margin-right: auto; /* Pusatkan gambar secara horizontal */
                  }

                }
              </style>
                <div>
                  <div class="ibox-content no-padding border-left-right">
                    <img src="{{ URL:: asset ('assets/img/user')}}/{{$data->foto? : 'profile_small.png' }}" class="image" style="cursor: pointer;" alt="profile">
                    <!-- Modal untuk mengganti foto -->
                    <div class="modal fade" id="changePhotoModal" tabindex="-1" role="dialog" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="changePhotoModalLabel">Change Photo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <!-- Input file untuk mengganti foto -->
                            <form action="{{ route('updatePhoto', $data->uuid) }}" method="POST"method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="form-group">
                                  <label for="photoInput">Upload Photo:</label>
                                  <input type="file" id="photoInput" name="photo" class="form-control">
                              </div>
                          
                              <button type="submit" class="btn btn-primary">Upload</button>
                          </form>
                          </div>                          
                          
                        </div>
                      </div>
                    </div>
                    
                    
                    <script>
                      // Tangkap elemen gambar dengan kelas "image"
                      var image = document.querySelector('.image');
                    
                      // Tambahkan event listener untuk aksi klik pada gambar
                      image.addEventListener('click', function() {
                        // Munculkan modal ketika gambar di klik
                        $('#changePhotoModal').modal('show');
                      });
                    </script>
                </div>
            
                    <div class="ibox-content profile-content">
                        <h4 style="text-align: center"><strong>{{session('nama')}}</strong></h4>
                        <p style="text-align: center"><i class="fa fa-user-circle-o"></i> {{session('role')}}</p>
                        <div class="user-button">
                            <div class="row">
                              <label class="btn btn-primary btn-rounded" style="margin-right: 20px; margin-left: 20px; display: block; align-items: center; cursor: pointer; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" data-toggle="modal" data-target="#changePasswordModal">
                                <i class="fa fa-info-circle"></i> Password
                              </label>
                              <img id="previewImage" src="#" alt="Preview" style="display: none; max-width: 200px; margin: 20px;">
                                {{-- <div class="col-md-6">
                                    <button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                  @include('page.user.password')
            </div>
        </div>
            </div>
        <div class="col-md-8">
            <div class="ibox float-e-margins" style="border:2px dashed #1AB394; border-radius:2px">
           @include('page.user.update')
                </div>
            </div>

        </div>
    </div>


@endsection
   
  
  




    

