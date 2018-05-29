<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ban Trans | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
        @include('layouts.partials.stylesheets_form')
    @show
</head>
<body background>
	<div class="content-wrapper bgform-image">
            <div class="container">
            	<section class="content">
            		@yield('content')
            	</section>
            </div>
        </div>
@section('scripts')
    @include('layouts.partials.scripts_form')
    @include('message.error')
@show
</body>
</html>