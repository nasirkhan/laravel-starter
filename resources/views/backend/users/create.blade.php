@extends ('backend.layouts.app')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> {{ __('labels.backend.users.index.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.create.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4 mb-4">
            <div class="col">

                {{ html()->form('POST', route('backend.users.store'))->class('form-horizontal')->open() }}
                    {{ csrf_field() }}

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.name'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.email'))->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.email'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            {{ html()->password('password')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password'))
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.password_confirmation'))->class('col-md-2 form-control-label')->for('password_confirmation') }}

                        <div class="col-md-10">
                            {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.password_confirmation'))
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.active'))->class('col-md-2 form-control-label')->for('active') }}

                        <div class="col-md-10">
                            {{ html()->checkbox('active', true, '1') }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.confirmed'))->class('col-md-2 form-control-label')->for('confirmed') }}

                        <div class="col-md-10">
                            {{ html()->checkbox('confirmed', true, '1') }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Abilities')->class('col-md-2 form-control-label') }}

                        <div class="col-md-10">
                        <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                        <th>Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @if ($roles->count())
                                                @foreach($roles as $role)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="checkbox">
                                                                {{ html()->label(html()->checkbox('roles[]', old('roles') && in_array($role->name, old('roles')) ? true : false, $role->name)->id('role-'.$role->id) . ' ' . ucwords($role->name))->for('role-'.$role->id) }}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            @if ($role->id != 1)
                                                                @if ($role->permissions->count())
                                                                    @foreach ($role->permissions as $permission)
                                                                        <i class="fa fa-dot-circle-o"></i> {{ ucwords($permission->name) }}
                                                                    @endforeach
                                                                @else
                                                                    None
                                                                @endif
                                                            @else
                                                                All Permissions
                                                            @endif
                                                        </div>
                                                    </div><!--card-->
                                                @endforeach
                                            @endif
                                        </td>
                                       <td>
                                           @if ($permissions->count())
                                               @foreach($permissions as $permission)
                                                   <div class="checkbox">
                                                       {{ html()->label(html()->checkbox('permissions[]', old('permissions') && in_array($permission->name, old('permissions')) ? true : false, $permission->name)->id('permission-'.$permission->id) . ' ' . ucwords($permission->name))->for('permission-'.$permission->id) }}
                                                   </div>
                                               @endforeach
                                           @endif
                                       </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--form-group-->

                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('backend.users.index'), __('labels.buttons.general.cancel')) }}
                            {{ form_submit(__('labels.buttons.general.create')) }}
                        </div>
                    </div>
                {{ html()->form()->close() }}

            </div>
        </div>

    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">

                </small>
            </div>
        </div>
    </div>
</div>

@endsection
