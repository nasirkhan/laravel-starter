@extends('backend.layouts.app')

@section('title')
{{ $module_action }} {{ $module_title }} | {{ app_name() }}
@stop

@section('page_heading')
<h1>
    <i class="{{ $module_icon }}"></i> {{ $module_title }}
    <small>{{ $module_action }}</small>
</h1>
@stop

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{!!route('backend.dashboard')!!}"><i class="icon-speedometer"></i> Dashboard</a></li>
<li class="breadcrumb-item"><a href='{!!route("backend.$module_name.index")!!}'><i class="{{ $module_icon }}"></i> {{ $module_title }}</a></li>
<li class="breadcrumb-item active"> {{ $module_action }}</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ ucwords($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary mt-1 btn-sm" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
                    @can('edit_'.$module_name)
                    <a href="{{ route("backend.$module_name.edit", $$module_name_singular) }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ Str::singular($module_name) }} "><i class="fas fa-wrench"></i> Edit</a>
                    @endcan
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col-12 col-sm-5">

                @include('backend.includes.show')

            </div>
            <div class="col-12 col-sm-7">

                <div class="text-center">
                    <a href="{{route("frontend.$module_name.show", [encode_id($$module_name_singular->id), $$module_name_singular->slug])}}" class="btn btn-success" target="_blank"><i class="fas fa-link"></i> Public View</a>
                </div>
                <hr>

                <div class="card">
                    <div class="card-header">
                        Posts
                    </div>

                    <div class="card-body">
                        <ul class="fa-ul">
                            @forelse($posts as $row)
                            @php
                            switch ($row->status) {
                                case 0:
                                    // Unpublished
                                    $text_class = 'text-danger';
                                    break;

                                case 1:
                                    // Published
                                    $text_class = 'text-success';
                                    break;

                                case 2:
                                    // Draft
                                    $text_class = 'text-warning';
                                    break;

                                default:
                                    // Default
                                    $text_class = 'text-primary';
                                    break;
                            }
                            @endphp
                            <li>
                                <span class="fa-li"><i class="fas fa-check-square {{$text_class}}"></i></span> <a href="{{route('backend.posts.show', $row->id)}}">{{$row->name}}</a> <a href="{{route('frontend.posts.show', [encode_id($row->id), $row->slug])}}" class="btn btn-sm btn-outline-primary" target="_blank" data-toggle="tooltip" title="Public View" > <i class="fas fa-external-link-square-alt"></i> </a>
                            </li>
                            @empty
                            <p class="text-center">
                                No post found.
                            </p>
                            @endforelse
                        </ul>
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>

@stop
