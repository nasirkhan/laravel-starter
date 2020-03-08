@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('{{asset('img/cover-01.jpg')}}')"></div>

<div class="content-center">

    <div class="container">

        <div class="col-md-4 content-center">

            <div class="card card-login card-plain">

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="header header-primary text-center">
                        <h5>
                            {{ __('Confirm Password') }}
                        </h5>
                        <p>{{ __('Please confirm your password before continuing.') }}</p>

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
                                    <span class="input-group-text" id="input-password"><i class="now-ui-icons users_single-02"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="{{ __('Password') }}" aria-label="password" aria-describedby="input-password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="footer text-center">
                            <button type="submit" class="btn btn-primary btn-round btn-block">
                                <strong>{{ __('Confirm Password') }}</strong>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
