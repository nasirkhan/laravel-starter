@extends('backend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs />
@endsection

@section('content')
<div class="card mb-4 ">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">@lang("Welcome to", ['name'=>config('app.name')])</h4>
                <div class="small text-medium-emphasis">{{ date_today() }}</div>
            </div>
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with buttons">
                <button class="btn btn-primary" type="button">
                    <i class="c-icon cil-bullhorn"></i>
                </button>
            </div>
        </div>
        <hr>

        <!-- Dashboard Content Area -->

        <!-- / Dashboard Content Area -->

    </div>
</div>
<!-- / card -->

@include("backend.includes.dashboard_demo_data")

@endsection