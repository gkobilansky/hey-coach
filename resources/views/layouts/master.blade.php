<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hey Coach</title>
    <link href="{{ URL::asset('css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/dropzone.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('css/jquery.atwho.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{--  <meta name="csrf-token" content="{{ csrf_token() }}"/>  --}}
    <script>
     window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>
<body>

<div id="wrapper">

        
        {{--  <button type="button" id="mobile-toggle" class="navbar-toggle mobile-toggle" data-toggle="offcanvas" data-target="#myNavmenu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>  --}}

<el-menu theme="dark" mode="horizontal">
    <el-menu-item index="1" class="logo-container"><a href="{{route('dashboard', \Auth::id())}}"><img src="{{url('images/heycoach-logo-small.png')}}" alt="Hey Coach Logo"></a></el-menu-item>
    {{--  <el-menu-item index="3"><a href="{{ route('tasks.index')}}"><i class="glyphicon glyphicon-hourglass"></i> Tasks</a></el-menu-item>      --}}
    {{--  <el-menu-item index="4"><a href="{{ route('athletes.index')}}"><i class="glyphicon glyphicon-user"></i> Contacts</a></el-menu-item>  --}}
  <div class="dropdown" id="nav-toggle">
                <a id="notification-clock" role="button" >
                    <i class="glyphicon glyphicon-bell"><span id="notifycount"></span></i>
                </a>
        
                    <i class="el-icon-info"></i>
                
  </div>      
</el-menu>
   


    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
    
       
                    @yield('heading')
                    @yield('content')
            

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>

        @endif
        @if(Session::has('flash_message_warning'))
             <message message="{{ Session::get('flash_message_warning') }}" type="warning"></message>
        @endif
        @if(Session::has('flash_message'))
            <message message="{{ Session::get('flash_message') }}" type="success"></message>
        @endif
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.caret.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.atwho.min.js') }}"></script>
@stack('scripts')
</body>

</html>