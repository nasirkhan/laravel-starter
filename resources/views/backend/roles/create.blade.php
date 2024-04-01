@extends ('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon='{{ $module_icon }}'>
            {{ __($module_title) }}
        </x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <x-backend.page-wrapper>
        <x-slot name="breadcrumbs">
            <x-backend.breadcrumbs>
                <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon='{{ $module_icon }}'>
                    {{ __($module_title) }}
                </x-backend.breadcrumb-item>
                <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
            </x-backend.breadcrumbs>
        </x-slot>

        <x-slot name="title">
            <i class="ti ti-layout-dashboard"></i> {{ __('Admin Dashboard') }}
        </x-slot>
        <x-slot name="toolbar">
            <x-backend.buttons.return-back />
        </x-slot>

        <div class="row">
            <div class="col">
                {{ html()->form('POST', route('backend.roles.store'))->class('form-horizontal')->open() }}

                <div class="row mb-3">
                    <?php
                    $field_name = 'name';
                    $field_lable = __('labels.backend.roles.fields.name');
                    $field_placeholder = $field_lable;
                    $required = 'required';
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable . field_required($required), $field_name)->class('form-label') }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = 'name';
                    $field_lable = __('Abilities');
                    $field_placeholder = $field_lable;
                    $required = '';
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            {{ __('List of permissions') }}
                            <hr>
                            @if ($permissions->count())
                                @foreach ($permissions as $permission)
                                    <div class="checkbox">
                                        {{ html()->label(html()->checkbox('permissions[]', old('permissions') && in_array($permission->name, old('permissions')) ? true : false, $permission->name)->id('permission-' . $permission->id) .' ' .$permission->name)->for('permission-' . $permission->id) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <x-backend.buttons.create
                                title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}">
                                {{ __('Create') }}
                            </x-backend.buttons.create>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-end">
                            <div class="form-group">
                                <x-backend.buttons.cancel />
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </x-backend.page-wrapper>

@endsection
