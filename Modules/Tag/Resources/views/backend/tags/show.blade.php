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
                <a href='{{ route("backend.$module_name.index") }}' class="btn btn-secondary" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
                @can('edit_'.$module_name)
                <x-buttons.edit route='{!!route("backend.$module_name.edit", $$module_name_singular)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" class="ms-1" />
                @endcan
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="row mt-4">
            <div class="col-12 col-sm-5">

                @include('backend.includes.show')

            </div>
            <div class="col-12 col-sm-7">

                <div class="text-center mb-4">
                    <a href='{{route("frontend.$module_name.show", [encode_id($$module_name_singular->id), $$module_name_singular->slug])}}' class="btn btn-success" target="_blank"><i class="fas fa-link"></i> Public View</a>
                </div>

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
                                <span class="fa-li"><i class="fas fa-check-square {{$text_class}}"></i></span> <a href="{{route('backend.posts.show', $row->id)}}">{{$row->name}}</a> <a href="{{route('frontend.posts.show', [encode_id($row->id), $row->slug])}}" target="_blank" data-toggle="tooltip" title="Public View">&nbsp;<i class="fas fa-external-link-square-alt"></i> </a>
                            </li>
                            @empty
                            <p class="text-center">
                                No post found.
                            </p>
                            @endforelse
                        </ul>
                        {{$posts->links('pagination::bootstrap-5')}}
                    </div>
                </div>
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