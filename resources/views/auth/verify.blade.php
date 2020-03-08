@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('/img/cover-01.jpg')"></div>

<div class="content-center">

    <div class="container">

        <div class="col-md-4 content-center">

            <div class="card card-login card-plain">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="header header-primary text-center">
                        <h5>
                            Login to Account
                        </h5>

                        @include('flash::message')

                        @if ($errors->any())
                        <div class="row justify-content-center">
                            <div class="col-12 align-self-center">
                                <div class="alert alert-danger" role="alert">
                                    <div class="container">
                                        <div class="alert-icon">
                                            <i class="fas fa-bolt"></i>
                                        </div>
                                        <p>
                                            <i class="fa fa-exclamation-triangle"></i> Please fix the following errors and submit again!
                                        </p>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>

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
                    </div>
                    <div class="content">
                        <div class="form-check">
                            <input type="hidden" name="redirectTo" value="{{request('redirectTo')}}">
                            <div class="input-group mb-3 input-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="input-email"><i class="now-ui-icons users_single-02"></i></span>
                                </div>
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" aria-label="email" aria-describedby="input-email" required>
                            </div>
                        </div>
                        
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-primary btn-round btn-block">Submit</button>
                        </div>
                    </div>

                    @if (Route::has('register'))
                    <div class="pull-left">
                        <h6>
                            <a href="{{ route('register') }}" class="link">Create Account</a>
                        </h6>
                    </div>
                    @endif
                    @if (Route::has('password.request'))
                        <div class="float-right">
                            <h6>
                                <a class="link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </h6>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
