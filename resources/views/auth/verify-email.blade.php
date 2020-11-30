@extends('auth.layout')

@section('title') @lang('Email verification') @endsection

@section('content')

<div class="main-content">

    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-6">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">
                            @lang('Email verification')
                        </h1>
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
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                        <!-- Session Status -->
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <p>
                                <i class="fas fa-bolt"></i> {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-sm-8 mb-3">
                                <form role="form" method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Resend Verification Email') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-sm-4 mb-3">
                                <form role="form" method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline-danger">
                                            {{ __('Logout') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
