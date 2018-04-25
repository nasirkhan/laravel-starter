@extends('frontend.layouts.app')

@section('content')

<div class="page-header">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="container">
        <div class="content-center">
            <h1 class="title text-center">
                {{ config('app.name', 'Laravel Starter') }}
            </h1>
            <h3 class="category">
                An awesome starter project based on Laravel
            </h3>
            @can('view_backend')
            <a href="{{ route('backend.dashboard') }}" class="btn btn-primary btn-lg btn-round">Dashboard</a>
            @endcan
        </div>
    </div>
</div>

@endsection
