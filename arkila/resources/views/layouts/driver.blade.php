<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ URL::asset('img/apple-touch-icon.png') }}">
    <title>Ban Trans | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @section('links') 
    @include('layouts.partials.stylesheets') 
    @show
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        @include('layouts.partials.header_5')
        <!-- Left side column. contains the logo and sidebar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-image-driver">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('content-header')
                </h1>
            </section>
            <!-- / .content-header -->
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!--/ .content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.partials.footer')
    </div>
    <!-- ./wrapper -->

    @section('scripts') 
    @parent 
    @include('layouts.partials.scripts') 
    @include('message.error') 
    @include('message.success') 
    @show
</body>

</html>