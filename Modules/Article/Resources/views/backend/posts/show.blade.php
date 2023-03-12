@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
                @can('edit_'.$module_name)
                <x-buttons.edit route='{!!route("backend.$module_name.edit", $$module_name_singular)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" class="ms-1" />
                @endcan
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="row mt-4">
            <div class="col-12 col-sm-6">

                @include('backend.includes.show')

            </div>
            <div class="col-12 col-sm-6">

                <div class="text-center">
                    <a href="{{route("frontend.$module_name.show", [encode_id($$module_name_singular->id), $$module_name_singular->slug])}}" class="btn btn-success" target="_blank"><i class="fas fa-link"></i> Public View</a>
                </div>
                <hr>

                <h4>Category</h4>
                <ul>
                    <li>
                        <a href="{{route('backend.categories.show', $$module_name_singular->category_id)}}">{{$$module_name_singular->category_name}}</a>
                    </li>
                </ul>
                <hr>

                <h4>Tags</h4>
                <ul>
                    @foreach($$module_name_singular->tags as $row)
                    <li>
                        <a href="{{route('backend.tags.show', $row->id)}}">{{$row->name}}</a>
                    </li>
                    @endforeach
                </ul>
                <hr>

                <h4>Comments</h4>
                <ul>
                    @foreach($$module_name_singular->comments as $row)
                    <li>
                        <a href="{{route('backend.comments.show', $row->id)}}">{{$row->name}}</a> by {{$row->user_name}}
                    </li>
                    @endforeach
                </ul>
                <hr>

                @include('article::backend.includes.activitylog')
                <hr>

            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-end text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>

@endsection