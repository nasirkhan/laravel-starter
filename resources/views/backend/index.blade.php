@extends('backend.layouts.app')

@section('title')
    @lang('Dashboard')
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs />
@endsection

@section('content')
    {{-- <div class="card mb-4 ">
    <div class="card-body">

        <x-backend.section-header>
            @lang("Welcome to", ['name'=>config('app.name')])

            <x-slot name="subtitle">
                {{ date_today() }}
            </x-slot>
            <x-slot name="toolbar">
                <button class="btn btn-outline-primary mb-1" type="button" data-toggle="tooltip" data-coreui-placement="top" title="Tooltip">
                    <i class="fa-solid fa-bullhorn"></i>
                </button>
            </x-slot>
        </x-backend.section-header>

        <!-- Dashboard Content Area -->
        
        <!-- / Dashboard Content Area -->

    </div>
</div> --}}

    <x-backend.page-wrapper>
        <x-slot name="title">
            <i class="ti ti-layout-dashboard"></i> Admin Dashboard
        </x-slot>
        
        <x-backend.includes.dashboard-demo />
    </x-backend.page-wrapper>
@endsection
