@extends('layouts.landing')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6" style="padding-top:7%;">
            <div class="panel panel-default">
                <div class="panel-heading text-center">RESET YOUR PASSWORD</div>

                <div class="panel-body" style=" border: 1px solid #e8dddd; padding: 10%;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label" style="color:black;">Enter your email address and we will send you a link to reset your password.</label>
                              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group  text-center">
                                <button type="submit" class="btn btn-info">
                                    Send Password Reset Link
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
