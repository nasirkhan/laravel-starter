@extends ('backend.layouts.app')

<?php
$module_name_singular = \Illuminate\Support\Str::singular($module_name);
?>

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{__('Change Password')}}</x-backend-breadcrumb-item>
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

        <div class="row">
            <div class="col">
                <strong>
                    @lang('Name'):
                </strong>
                {{ $$module_name_singular->name }}
            </div>
            <div class="col">
                <strong>
                    @lang('Email'):
                </strong>
                {{ $$module_name_singular->email }}
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->form('PATCH', route('backend.users.changeProfilePasswordUpdate', $user->id))->class('form-horizontal')->open() }}

                <div class="form-group row mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                    <div class="col-md-10">
                        {{ html()->password('password')
                            ->class('form-control')
                            ->placeholder(__('labels.backend.users.fields.password'))
                            ->required() }}
                    </div>
                </div>

                <div class="form-group row mb-3">
                    {{ html()->label(__('labels.backend.users.fields.password_confirmation'))->class('col-md-2 form-control-label')->for('password_confirmation') }}

                    <div class="col-md-10">
                        {{ html()->password('password_confirmation')
                            ->class('form-control')
                            ->placeholder(__('labels.backend.users.fields.password_confirmation'))
                            ->required() }}
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-save'></i> Save", $type = 'submit')->class('btn btn-success') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->closeModelForm() }}
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    
    <div class="card-footer">
        <x-backend.section-footer>
            @lang('Updated'): {{$$module_name_singular->updated_at->diffForHumans()}},
            @lang('Created at'): {{$$module_name_singular->created_at->isoFormat('LLLL')}}
        </x-backend.section-footer>
    </div>
</div>

@endsection