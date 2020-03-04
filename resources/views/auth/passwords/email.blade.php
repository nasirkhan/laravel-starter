@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('{{asset('img/cover-01.jpg')}}')"></div>

<div class="content-center">

    <div class="container">

        <div class="col-md-4 content-center">

            <div class="card card-login card-plain">

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="header header-primary text-center">
                        <h5>
                            {{ __('Reset Password') }}
                        </h5>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                <div class="container">
                                    <strong>{{ $message }}</strong>
                                </div>
                            </div>
                        @enderror

                    </div>
                    <div class="content">
                        <div class="form-check">
                            <div class="input-group mb-3 input-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="input-email"><i class="now-ui-icons users_single-02"></i></span>
                                </div>
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" aria-label="email" aria-describedby="input-email" required>
                            </div>
                        </div>

                        <div class="footer text-center">
                            <button type="submit" class="btn btn-primary btn-round btn-block"> <strong>Submit</strong> </button>
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
