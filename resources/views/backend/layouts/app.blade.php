@extends('admin::layouts.admin')

@section('title')
    @yield('title')
@endsection

@section('content')
    @hasSection('breadcrumbs')
        @yield('breadcrumbs')
    @endif
    @yield('content')
@endsection
