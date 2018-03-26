@extends('layouts.customer_non_user')
@section('content')
<section id="mainSection" style="background-image: url('{{ URL::asset('img/background.jpg') }}');">
        <div class="container">
            <div class="heading text-center">
                <h2>Sign In</h2>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4" id="boxContainer">
                    <form class="contact100-form">
                        <div class="wrap-input100">
                            <input id="customerUsername" class="input100" type="text" name="Customer Username" placeholder="Username">
                            <span class="focus-input100"></span>
                        </div><!-- wrap-input100-->
                        <div class="wrap-input100">
                            <input id="customerPassword" class="input100" type="password" name="Customer Password" placeholder="Password">
                            <span class="focus-input100"></span>
                        </div><!-- wrap-input100-->
                        <div class="container-contact100-form-btn">
                            <button type="submit" class="contact100-form-btn"><strong>Log In</strong></button>
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