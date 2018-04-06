<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ban Trans</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
@section('links')
@parent
 @include('layouts.partials.customer_stylesheets')
 @show

</head>

<body style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}'); background-size: cover;">
        @include('layouts.partials.customer_header_non_user')


            <!-- Main content -->
              @yield('content')
            <!--/ .content -->

        @include('layouts.partials.customer_footer')


    <!-- ./wrapper -->
    @section('scripts')
    @parent
	    @include('layouts.partials.customer_scripts')
		@include('message.error')
		@include('message.success')

	@show
</body>

</html>