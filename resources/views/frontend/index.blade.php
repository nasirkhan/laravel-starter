@extends('frontend.layouts.app')

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
                An awesome starter project based on Laravel
            </h3>

            @include('flash::message')

            @can('view_backend')
            <a href="{{ route('backend.dashboard') }}" class="btn btn-primary btn-lg btn-round">Dashboard</a>
            @endcan
            <div class="text-center">
                <a href="#" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-facebook-square"></i>
                </a>
                <a href="#" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-google-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
