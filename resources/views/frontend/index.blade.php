@extends('frontend.layouts.app')

@section('content')

<main role="main" class="inner cover">
    <h1 class="cover-heading">Welcome to Latavel Starter</h1>


    @auth
    <p class="lead">
        Hello {{Auth::user()->name}}!
    </p>
    @endauth

    <p class="lead">
        Visit the admin dashboard to find the features and functionalities of this starter project.
    </p>

    @guest
    <p class="lead">
        <a href="{{ route('frontend.auth.login') }}" class="btn btn-lg btn-secondary">Login</a>
    </p>
    @endguest

    @can('view_backend')
    <p class="lead">
        <a href="{{ route('backend.dashboard') }}" class="btn btn-lg btn-secondary">Dashboard</a>
    </p>
    @endcan
</main>

@endsection
