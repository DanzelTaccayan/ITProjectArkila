<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    
    <title>Ban Trans | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @section('links')
        @include('layouts.partials.stylesheets')
    @show
    <style> 
    /*.control-sidebar-bg, .control-sidebar {
        right: -500px;
        width: 500px;
    }*/
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        @include('layouts.partials.header')

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.partials.main_sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-image">
            <!-- Main content -->
            <section class="content">
              @yield('content')
            </section>
            <!--/ .content -->
        </div>


        <!-- /.content-wrapper -->
        @include('layouts.partials.footer')

        <!-- Van Queue Sidebar -->
        @include('layouts.partials.queue_sidebar')
        <!-- /.queue-sidebar -->
        
    </div>

    @section('scripts')
     @include('layouts.partials.scripts')
     @include('message.success')
     @include('message.error')
    @show
    <div id="confirmBoxModal"></div>
</body>

</html>