<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="6000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="text-transform:uppercase" >{{ Request::segment(count(Request::segments())) ?: 'Welcome' }} | SITahfidz</title>
    @stack('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/animate.css" rel="stylesheet') }}">
    <link href="{{ URL::asset('assets/css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/plugins/codemirror/ambiance.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
</head>

<body class="fixed-sidebar no-skin-config full-height-layout">
    <div id="wrapper">
        @include('layout.sidebar')
        <div id="page-wrapper" class="gray-bg" style="height:auto">
            @include('layout.topbar')
            @include('layout.breadcrumb')
            @yield('main')
            @include('layout.footer')
        </div>
    </div>
      
    <script src="{{ URL::asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    @stack('js')
    <script src="{{ URL::asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ URL::asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  
    
</body>

</html>
