<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Arkila - Ban Trans</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
@section('links')
 @include('layouts.partials.customer_stylesheets')
 @show

</head>

<body style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}'); background-size: cover;">
        @include('layouts.partials.landing_header')

            <!-- Main content -->
              @yield('content')
            <!--/ .content -->


    <!-- ./wrapper -->
    @section('scripts')
	    @include('layouts.partials.customer_scripts')
		@include('message.error')
		@include('message.success')

	@show
</body>

</html>