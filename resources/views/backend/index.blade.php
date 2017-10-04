@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @auth
                    Welcome to Admin Dashboard.
                    @endauth

                    @guest
                    You have to <a href="{{ route('frontend.auth.login') }}">Login</a> first to access dashboard!
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
