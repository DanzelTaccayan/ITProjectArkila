<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ban Trans | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @section('links')
        @include('layouts.partials.stylesheets_form')
    @show
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav bgform-image">
   
    <form id="@yield('form-id')" class="parsley-form" action="@yield('form-action')" method="POST" data-parsley-validate="" enctype="multipart/form-data">
    {{csrf_field()}}
    @yield('method_field')

    <section class="content" style="padding: 0% 15%">
    @yield('form-body')

    </section>
    </form>
        
    @include('layouts.partials.footer')

    @include('layouts.partials.queue_sidebar')
   

    <!-- jQuery 3 -->
    @section('scripts')
        @include('layouts.partials.scripts_form')
        @include('message.error')
    @show
</body>

</html>
