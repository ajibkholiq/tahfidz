<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SIM keuangan</title>

    <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{URL::asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="animated fadeInDow">
        <div class="row" style="padding-top: 20px">
              <div class="col-md-12">
                <h3 class="logo-name text-center" style="font-size: 65pt ">Welcome</h3>
            </div>
        </div>
        <div class="row " style=" justify-content: center; display:flex;">

            <div class="col-md-4">
                <hr>
                <div class="ibox-content"  style="padding: 50px 40px; border-radius:10px; box-shadow: 4px 5px 1px rgb(222, 221, 221)">
                    <h3 class="text-center">Login</h3>
                    @if (session('fail'))
                        <h4 class="text-warning text-center text-capitalize">{{session('fail')}}</h4>
                    @endif
               
                    <form class="m-t" role="form" action="{{route('validate')}} " method="POST">
                       @csrf
                        <div class="form-group">
                            <input type="tex" class="form-control" placeholder="Username" name="username" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password"  name="password">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                    </form>
                   
                </div>
            </div>
        </div>
       
    </div>

</body>

</html>