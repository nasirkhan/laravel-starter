@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

@include('frontend.includes.contact1')

<section class="bg-gray-100 mb-20">
    <div class="container mx-auto flex px-1 sm:px-20 py-20 md:flex-row flex-col items-center">

        <div
            class="lg:flex-grow md:w-1/2 px-4 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">


            @include('frontend.includes.messages')

        </div>
    </div>
</section>





@endsection