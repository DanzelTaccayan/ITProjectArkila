@extends('layouts.landing')
@section('content')
<section id="mainSection">
        <div class="container">
                <div class="heading text-center">
                    <h2>Sign Up</h2>
                </div>
                <div class="row">
                    <div class="col-md-4 mx-auto" id="boxContainer">
                        <form class="contact100-form" action="{{route('register')}}" method="POST" data-parsley-validate="">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">First name: <span class="text-red">*</span></label>    
                                <input id="first_name" class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" val-name required>
                            </div>
                            <div class="form-group">
                                <label for="">Last name: <span class="text-red">*</span></label>    
                               <input id="last_name" class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" val-name required>
                            </div>
                            <div class="form-group">
                                <label for="">Username: <span class="text-red">*</span></label>    
                                <input id="customerUsername" class="form-control" type="text" name="username" value="{{ old('username') }}" val-username required>
                            </div>
                            <div class="form-group">
                                <label for="">Email: <span class="text-red">*</span></label>    
                                <input id="customerEmail" class="form-control" type="text" name="email" value="{{ old('email') }}" required>   
                            </div>
                            <div class="form-group">
                                <label for="">Password: <span class="text-red">*</span></label>    
                                <input id="customerPassword" class="form-control" type="password" name="password" val-password pw-letter pw-number required>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm Password: <span class="text-red">*</span></label>    
                                <input id="customerRepeatPassword" class="form-control" type="password" name="password_confirmation" required>
                            </div>
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