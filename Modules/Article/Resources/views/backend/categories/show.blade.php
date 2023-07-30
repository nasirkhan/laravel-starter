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

<x-backend.layouts.show :data="$$module_name_singular" :module_name="$module_name" :module_path="$module_path" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action">

    <x-backend.section-header :data="$$module_name_singular" :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />

    <div class="row mt-4">
        <div class="col-12 col-sm-5">

            @include('backend.includes.show')

        </div>
        <div class="col-12 col-sm-7">

            <div class="text-center">
                <a href='{{route("frontend.$module_name.show", [encode_id($$module_name_singular->id), $$module_name_singular->slug])}}' class="btn btn-success" target="_blank"><i class="fas fa-link"></i> Public View</a>
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
                            <span class="fa-li"><i class="fas fa-check-square {{$text_class}}"></i></span> <a href="{{route('backend.posts.show', $row->id)}}">{{$row->name}}</a> <a href="{{route('frontend.posts.show', [encode_id($row->id), $row->slug])}}" class="btn btn-sm btn-outline-primary" target="_blank" data-toggle="tooltip" title="Public View"> <i class="fas fa-external-link-square-alt"></i> </a>
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
</x-backend.layouts.show>
@endsection