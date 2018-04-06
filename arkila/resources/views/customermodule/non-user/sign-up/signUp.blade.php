@extends('layouts.customer_non_user')
@section('content')
<section id="mainSection" style="background-image: url('{{ URL::asset('img/background.jpg') }}');">
        <div class="container">
            <div class="heading text-center">
                <h2>Sign Up</h2>
            </div>
            <div class="col-md-4 mx-auto" id="boxContainer">
                <form class="contact100-form" action="{{route('register')}}" method="POST" data-parsley-validate="">
                    {{csrf_field()}}
                    <div class="wrap-input100" >
                        <input id="customerName" class="input100" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"  val-name required>
                    </div><!-- wrap-input100-->
                    <div class="wrap-input100">
                        <input id="customerUsername" class="input100" type="text" name="username" value="{{ old('username') }}" placeholder="Username" val-name required>

                    </div><!-- wrap-input100-->
                    <div class="wrap-input100">
                        <input id="customerEmail" class="input100" type="text" name="email" value="{{ old('email') }}" placeholder="Email Address">

                    </div><!-- wrap-input100-->
                    <div class="wrap-input100">
                        <input id="customerPassword" class="input100" type="password" name="password" placeholder="Password" required>

                    </div><!-- wrap-input100-->
                    <div class="wrap-input100">
                        <input id="customerRepeatPassword" class="input100" type="password" name="password_confirmation" placeholder="Repeat Password" required>
                        <span class="focus-input100"></span>
                    </div><!-- wrap-input100-->
                    <div class="container-contact100-form-btn">
                        <button type="submit" class="contact100-form-btn"><strong>Sign Up</strong></button>
                    </div><!-- container-contact100-form-btn-->
                </form>
                <!-- contact100-form-->
            </div>
            <!-- boxContainer-->
        </div>
        <!-- container-->
    </section>
    <!--    main section-->

@stop