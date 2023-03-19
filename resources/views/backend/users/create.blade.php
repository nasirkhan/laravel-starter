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
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="row mt-4">
            <div class="col">

                {{ html()->form('POST', route('backend.users.store'))->class('form-horizontal')->open() }}
                {{ csrf_field() }}

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.first_name'))->class('col-sm-2 form-control-label')->for('first_name') }}
                    <div class="col-sm-10">
                        {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.first_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.last_name'))->class('col-sm-2 form-control-label')->for('last_name') }}
                    <div class="col-sm-10">
                        {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.last_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.email'))->class('col-sm-2 form-control-label')->for('email') }}

                    <div class="col-sm-10">
                        {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.email'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password'))->class('col-sm-2 form-control-label')->for('password') }}

                    <div class="col-sm-10">
                        {{ html()->password('password')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password'))
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password_confirmation'))->class('col-sm-2 form-control-label')->for('password_confirmation') }}

                    <div class="col-sm-10">
                        {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password_confirmation'))
                                ->required() }}
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.status'))->class('col-6 col-sm-2 form-control-label')->for('status') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('status', true, '1') }} @lang('Active')
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.confirmed'))->class('col-6 col-sm-2 form-control-label')->for('confirmed') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('confirmed', true, '1') }} @lang('Email Confirmed')
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label(__('labels.backend.users.fields.email_credentials'))->class('col-6 col-sm-2 form-control-label')->for('confirmed') }}

                    <div class="col-6 col-sm-10">
                        {{ html()->checkbox('email_credentials', true, '1') }} @lang('Email Credentials')
                    </div>
                </div>

                <div class="form-group row  mb-3">
                    {{ html()->label('Abilities')->class('col-sm-2 form-control-label') }}

                    <div class="col">
                        <div class="row  mb-3">
                            <div class="col-12 col-sm-7">
                                <div class="card card-accent-info">
                                    <div class="card-header">
                                        @lang('Roles')
                                    </div>
                                    <div class="card-body">
                                        @if ($roles->count())
                                        @foreach($roles as $role)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <div class="checkbox">
                                                    {{ html()->label(html()->checkbox('roles[]', old('roles') && in_array($role->name, old('roles')) ? true : false, $role->name)->id('role-'.$role->id) . "&nbsp;" . ucwords($role->name). "&nbsp;(".$role->name.")")->for('role-'.$role->id) }}
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @if ($role->id != 1)
                                                @if ($role->permissions->count())
                                                @foreach ($role->permissions as $permission)
                                                <i class="far fa-check-circle mr-1"></i>&nbsp;{{ $permission->name }}&nbsp;
                                                @endforeach
                                                @else
                                                @lang('None')
                                                @endif
                                                @else
                                                @lang('All Permissions')
                                                @endif
                                            </div>
                                        </div>
                                        <!--card-->
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5">
                                <div class="card card-accent-primary">
                                    <div class="card-header">
                                        @lang('Permissions')
                                    </div>
                                    <div class="card-body">
                                        @if ($permissions->count())
                                        @foreach($permissions as $permission)
                                        <div class="checkbox">
                                            {{ html()->label(html()->checkbox('permissions[]', old('permissions') && in_array($permission->name, old('permissions')) ? true : false, $permission->name)->id('permission-'.$permission->id) . ' ' . $permission->name)->for('permission-'.$permission->id) }}
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--form-group-->

                <div class="row  mb-3">
                    <div class="col-6">
                        <div class="form-group">
                            <x-buttons.create title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}">
                                {{__('Create')}}
                            </x-buttons.create>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-end">
                            <div class="form-group">
                                <x-buttons.cancel />
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}

            </div>
        </div>

    </div>

    <div class="card-footer">
        <div class="row  mb-3">
            <div class="col">
                <small class="float-end text-muted">

                </small>
            </div>
        </div>
    </div>
</div>

@endsection