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
<body class="bg-gray">          
    <section class="content">
    @yield('content')

    </section>               
           
    <!-- jQuery 3 -->
    @section('scripts')
        @include('layouts.partials.scripts_form')
        @include('message.error')
    @show

    <script type="text/javascript">
        $(window).height();   // returns height of browser viewport
        $(document).height(); // returns height of HTML document (same as pageHeight in screenshot)
        $(window).width();   // returns width of browser viewport
        $(document).width(); // returns width of HTML document (same as pageWidth in screenshot)
    </script>

</body>

</html>
