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
                    <form class="contact100-form" method="POST" action="{{ route('login') }}">
                      {{csrf_field()}}
                        <div class="wrap-input100{{ $errors->has('username') ? ' has-error' : '' }}">
                            <input id="username" type="text" name="username" class="input100" type="text" name="Customer Username" placeholder="Username">
                            @if ($errors->has('username'))
                              <span class="focus-input100">
                                <strong>{{ $errors->first('email') }}</strong>
                              </span>
                            @endif
                        </div><!-- wrap-input100-->
                        <div class="wrap-input100{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" name="password" class="input100" type="password" name="Customer Password" placeholder="Password">
                            @if ($errors->has('password'))
                              <span class="focus-input100">
                                <strong>{{ $errors->first('password') }}</strong>
                              </span>
                            @endif
                        </div><!-- wrap-input100-->
                        <div class="checkbox">
                          <label>
                              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                          </label>
                        </div>
                        <div class="container-contact100-form-btn">
                          <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class="contact100-form-btn"><strong>Log In</strong></button>
                            </div>
                          </div>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
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


@include('layouts.partials.scripts')
