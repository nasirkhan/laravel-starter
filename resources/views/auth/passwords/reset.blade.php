@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('/img/cover-1.jpg')"></div>

<div class="container">
    @if ($errors->has('email'))
    <div class="row justify-content-center">
        <div class="col-md-8 align-self-center">
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <div class="alert-icon">
                        <i class="fas fa-bolt"></i>
                    </div>

                    <strong>{{ $errors->first('email') }}</strong>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->has('password'))
    <div class="row justify-content-center">
        <div class="col-md-8 align-self-center">
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <div class="alert-icon">
                        <i class="fas fa-bolt"></i>
                    </div>

                    <strong>{{ $errors->first('password') }}</strong>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-4 content-center">
        <div class="card card-login card-plain">
            <form class="form" method="POST" action="{{ route('frontend.auth.password.reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="header header-primary text-center">
                    <div class="logo-container">
                        <img src="img/login-logo.png" alt="">
                    </div>
                    <h5>
                        Login to Account
                    </h5>
                </div>
                <div class="content">

                    <div class="input-group form-group-no-border input-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <span class="input-group-addon">
                            <i class="fas fa-at"></i>
                        </span>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                    </div>
                    <div class="input-group form-group-no-border input-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <span class="input-group-addon">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password" type="password" class="form-control" name="password"  placeholder="Password" required>
                    </div>
                    <div class="input-group form-group-no-border input-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <span class="input-group-addon">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="Confirm Password" required>
                    </div>
                </div>
                <div class="footer text-center">
                    <button type="submit" class="btn btn-primary btn-round btn-block">Reset Password</button>
                </div>
                <div class="pull-left">
                    <h6>
                        <a href="{{ route('frontend.auth.register') }}" class="link">Create Account</a>
                    </h6>
                </div>
                <div class="pull-right">
                    <h6>
                        <a href="{{route('frontend.auth.password.email')}}" class="link">Need Help?</a>
                    </h6>
                </div>
            </form>
        </div>
    </div>
</div>
<!--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('frontend.auth.password.reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
