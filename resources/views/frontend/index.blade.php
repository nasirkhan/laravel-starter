@extends('frontend.layouts.app')

@section('title')
{{app_name()}}
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title text-center">
                {{ config('app.name', 'Laravel Starter') }}
            </h1>
            <h3 class="category">
                An awesome project based on Laravel!
            </h3>

            @include('flash::message')
            @if (session('status'))
            <p class="alert alert-success">{{ session('status') }}</p>
            @endif

            @guest
            <a href="{{ route('login') }}" class="btn btn-success btn-lg"><i class="now-ui-icons objects_key-25"></i>  Login </a>

            @if(user_registration())
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg"><i class="now-ui-icons business_badge"></i>  Register </a>
            @endif
            @endguest
        </div>
    </div>
</div>

@endsection
