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
<x-backend.layouts.edit :data="$$module_name_singular">
    <x-backend.section-header>
        <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

        <x-slot name="toolbar">
            <x-backend.buttons.return-back small="true" />
            <x-buttons.show route='{!!route("backend.$module_name.show", $$module_name_singular)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" class="ms-1" small="true" />
        </x-slot>
    </x-backend.section-header>

    <hr>

    <div class="row mt-4">
        <div class="col">
            {{ html()->modelForm($$module_name_singular, 'PATCH', route("backend.$module_name.update", $$module_name_singular))->class('form')->open() }}

            @include ("article::backend.$module_name.form")

            <div class="row">
                <div class="col-4">
                    <x-backend.buttons.save />
                </div>

                <div class="col-8">
                    <div class="float-end">
                        @can('delete_'.$module_name)
                        <a href='{{route("backend.$module_name.destroy", $$module_name_singular)}}' class="btn btn-danger" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}"><i class="fas fa-trash-alt"></i></a>
                        @endcan
                        <x-backend.buttons.cancel />
                    </div>
                </div>
            </div>

            {{ html()->form()->close() }}
        </div>
    </div>
</x-backend.layouts.edit>
@endsection