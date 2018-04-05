@extends('layouts.customer_non_user')
@section('content')
<section id="mainSection" style="background-image: url('{{ URL::asset('img/background.jpg') }}');">
        <div class="container">
            <div class="heading text-center">
                <h2>Sign Up</h2>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4" id="boxContainer">
                    <form class="contact100-form" action="{{route('register')}}" method="POST">
                        {{csrf_field()}}
                        <div class="wrap-input100" >
                            <input id="first_name" class="input100" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                        </div><!-- wrap-input100-->
                        <div class="wrap-input100">
                            <input id="middle_name" class="input100" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle Name" required>
                            
                        </div><!-- wrap-input100-->
                        <div class="wrap-input100">
                           <input id="last_name" class="input100" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                        </div><!-- wrap-input100-->
                        <div class="wrap-input100">
                            <input id="customerUsername" class="input100" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required>
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
            <!-- row-->
        </div>
        <!-- container-->
    </section>
    <!--    main section-->

@stop