<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Arkila - Ban Trans</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <script>
        window.Laravel = @php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); @endphp
    </script>

    @if(!auth()->guest())
        <script>
            Laravel.userId = @php echo auth()->user()->id; @endphp
        </script>
    @endif
	@section('links')
 		@include('layouts.partials.customer_stylesheets')
	@show
</head>

<body style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}'); background-size: cover;">
        @include('layouts.partials.customer_header_user')


            <!-- Main content -->
              @yield('content')
            <!--/ .content -->

        @include('layouts.partials.customer_footer')

@include('layouts.partials.customer_notification')
    <!-- ./wrapper -->
    @section('scripts')
	    @include('layouts.partials.customer_scripts')
		@include('message.error')
		@include('message.success')
        
        <script type="text/javascript">
        $(document).ready(function(){
            if(Laravel.userId){
                $.get('/driverNotifications', function(response){
                    console.log(response);
                });
            }
        });
        </script>
	@show
</body>

</html>
