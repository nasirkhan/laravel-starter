@extends('backend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs />
@endsection

@section('content')
<div class="card mb-4 ">
    <div class="card-body">

        <x-backend.section-header>
            @lang("Welcome to", ['name'=>config('app.name')])

            <x-slot name="subtitle">
                {{ date_today() }}
            </x-slot>
            <x-slot name="toolbar">
                <button class="btn btn-outline-primary mb-1" type="button">
                    <i class="c-icon cil-bullhorn"></i>
                </button>
            </x-slot>
        </x-backend.section-header>
        
        <hr>

        <!-- Dashboard Content Area -->

        <!-- / Dashboard Content Area -->

    </div>
</div>
<!-- / card -->

@include("backend.includes.dashboard_demo_data")

@endsection