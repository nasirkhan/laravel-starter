@extends('frontend.layouts.app')

@section('content')

<div class="page-header page-header-small" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="container">
        <div class="content-center">
            <div class="photo-container">
                <img src="{{asset('photos/avatars/'.auth()->user()->avatar)}}" alt="">
            </div>
            <h3 class="title">{{auth()->user()->name}}</h3>
            <p class="category">{{auth()->user()->email}}</p>
            <div class="content">
                <div class="social-description">
                    <h2>26</h2>
                    <p>Comments</p>
                </div>
                <div class="social-description">
                    <h2>26</h2>
                    <p>Comments</p>
                </div>
                <div class="social-description">
                    <h2>48</h2>
                    <p>Bookmarks</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
