@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('img/cover-01.jpg')"></div>

<div class="container">
    <div class="col-md-4 content-center">
        <div class="card card-login card-plain">
            <form class="form" method="POST" action="{{ route('frontend.auth.register.post') }}">
                {{ csrf_field() }}

                <div class="header header-primary text-center">
                    <div class="logo-container">
                        <img src="img/login-logo.png" alt="">
                    </div>
                    <h5>
                        Create an Account
                    </h5>
                </div>
                <div class="content">

                    <div class="input-group form-group-no-border input-lg">
                        <span class="input-group-addon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="name" type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="input-group form-group-no-border input-lg">
                        <span class="input-group-addon">
                            <i class="fas fa-at"></i>
                        </span>
                        <input id="email" type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="input-group form-group-no-border input-lg">
                        <span class="input-group-addon">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="input-group form-group-no-border input-lg">
                        <span class="input-group-addon">
                            <i class="fas fa-key"></i>
                        </span>
                        <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                    </div>
                </div>
                <div class="footer text-center">
                    <button type="submit" class="btn btn-primary btn-round btn-block">Create Account</button>
                </div>
                <div class="pull-left">
                    <h6>
                        <a href="{{ route('frontend.auth.login') }}" class="link">Login to Account</a>
                    </h6>
                </div>
                <div class="float-right">
                    <h6>
                        <a href="{{route('frontend.auth.password.email')}}" class="link">Need Help?</a>
                    </h6>
                </div>
            </form>
        </div>

        @include('auth.social_login_buttons')
    </div>
</div>


<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('frontend.auth.register.post') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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
