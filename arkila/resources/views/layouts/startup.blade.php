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
<script>
    var submitStatus = false;
</script>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="layout-top-nav bgform-image hidden">
    <div id="loader">
        <div id="shadow"></div>
        <div id="box"></div>
    </div>
    <div id="startup">
        <form id="@yield('form-id')" class="parsley-form" action="@yield('form-action')" method="POST" data-parsley-validate="" enctype="multipart/form-data">
        {{csrf_field()}}
        @yield('method_field')
                <section class="content" style="padding: 0% 15%">
                @yield('form-body')

                </section>
        </form>
    </div>
    @include('layouts.partials.preloader_div')

    <!-- jQuery 3 -->
    @section('scripts')
        @include('layouts.partials.scripts_form')
        @include('message.error')

        <script>
            $(document).ready(function(){
                $("form").on('submit', function(e){
                    if(submitStatus) {
                        e.preventDefault();
                    } else {

                        var form = $(this);

                        if (form.parsley().isValid()){
                            submitStatus = true;
                            $('#submit-loader').removeClass('hidden');
                            $('#submit-loader').css("display","block");
                            $(this).find('button[type="submit"]').prop('disabled',true);
                        }
                    }

                });
                    $("#loader").hide();
                    $("#startup").show();
                    $("body").removeClass('hidden');
            });


        </script>
        <script>
            document.querySelector("input[type='number']").addEventListener("keypress", function (evt) {
                if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
                {
                    evt.preventDefault();
                }
            });
        </script>
    @show
</body>

</html>
