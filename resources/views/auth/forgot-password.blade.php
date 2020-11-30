@extends('auth.layout')

@section('title') @lang('Forgot your password?') @endsection

@section('content')

<div class="main-content">

    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-6">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">
                            @lang('Forgot your password?')
                        </h1>
                        <p class="text-lead text-white">
                            Please enter your email here and details instructions will be sent to your email inbox.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--9 pb-5">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary border border-soft">

                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>Enter your email address</small>
                        </div>

                        @include('flash::message')

                        @if (Session::has('status'))
                        <!-- Session Status -->
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <p>
                                <i class="fas fa-bolt"></i> {{ Session::get('status') }}
                            </p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <!-- Validation Errors -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>
                                <i class="fas fa-exclamation-triangle"></i> @lang('Please fix the following errors & try again!')
                            </p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" aria-label="email" aria-describedby="email" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    @if (Route::has('register'))
                    <div class="col-6 text-left">
                        <a href="{{ route('register') }}" class="text-gray">
                            <small>Create new account</small>
                        </a>
                    </div>
                    @endif

                    <div class="col-6 text-right">
                        <a href="{{ route('login') }}" class="text-gray">
                            <small>Login to account</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
