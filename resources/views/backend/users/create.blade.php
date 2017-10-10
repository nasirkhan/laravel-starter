@extends ('backend.layouts.app')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.users.index.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.show.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fa fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>
        <div class="row mt-4 mb-4">
            <div class="col">
                <form method="POST" action="{{ route('backend.users.index') }}" class="form-horizontal">

                {!! csrf_field() !!}

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            {!! Form::label('name', 'Name' , ['class' => 'control-label']) !!}
                        </strong>
                    </div>
                    <div class="col-9">
                        {!! Form::text('name', old('name') , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            {!! Form::label('email', 'Email' , ['class' => 'control-label']) !!}
                        </strong>
                    </div>

                    <div class="col-9">
                        {!! Form::text('email', old('email') , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            Ablities
                        </strong>
                    </div>

                    <div class="col-9">
                        {!! Form::select('roles_list[]', $roles, null, ['class' => 'form-control', 'multiple']) !!}
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <a href="{{route('backend.users.index')}}" class="btn btn-danger"><i class="fa fa-reply"></i> {{__('labels.buttons.general.cancel')}}</a>

                        <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> {{__('labels.buttons.general.create')}}</button>
                    </div>
                </div>


                {!! Form::close() !!}

            </div>
            <!--/.col-->
        </div>

        <div class="row mt-4 mb-4">
            <div class="col">

                <form action="{{ route('backend.users.store') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="first_name">
                            {{ __('validation.attributes.backend.access.users.first_name') }}
                        </label>

                        <div class="col-md-10">
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.first_name') }}" maxlength="191" required="required" autofocus="autofocus">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="last_name">
                            {{ __('validation.attributes.backend.access.users.last_name') }}
                        </label>

                        <div class="col-md-10">
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.last_name') }}" maxlength="191" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="email">
                            {{ __('validation.attributes.backend.access.users.email') }}
                        </label>

                        <div class="col-md-10">
                            <input type="email" id="email" name="email" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.email') }}" maxlength="191" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="password">
                            {{ __('validation.attributes.backend.access.users.password') }}
                        </label>

                        <div class="col-md-10">
                            <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.password') }}" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="password_confirmation">
                            {{ __('validation.attributes.backend.access.users.password_confirmation') }}
                        </label>

                        <div class="col-md-10">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.password_confirmation') }}" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="active">
                            {{ __('validation.attributes.backend.access.users.active') }}
                        </label>

                        <div class="col-md-10">
                            <input type="checkbox" name="active" value="1" id="active" checked="checked" />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="confirmed">
                            {{ __('validation.attributes.backend.access.users.confirmed') }}
                        </label>

                        <div class="col-md-10">
                            <input type="checkbox" name="confirmed" value="1" id="confirmed" checked="checked" />
                        </div>
                    </div><!--form-group-->

                    @if (! config('access.users.requires_approval'))
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="confirmation_email">
                                {{ __('validation.attributes.backend.access.users.send_confirmation_email') }}<br/>
                                <small>{{ __('strings.backend.access.users.if_confirmed_off') }}</small>
                            </label>

                            <div class="col-md-10">
                                <input type="checkbox" name="confirmation_email" value="1" id="confirmation_email" />
                            </div>
                        </div><!--form-group-->
                    @endif

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">
                            Abilities
                        </label>

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
                                            @if (!$roles->count())
                                                @foreach($roles as $role)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="checkbox">
                                                                <label for="role-{{ $role->id }}">
                                                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ old('roles') && in_array($role->name, old('roles')) ? 'checked="checked"' : '' }} id="role-{{ $role->id }}" />
                                                                    {{ ucfirst($role->name) }}
                                                                </label>
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--form-group-->

                    <div class="row">
                        <div class="col">
                            <a href="{{route('backend.users.index')}}" class="btn btn-danger"><i class="fa fa-reply"></i> {{__('labels.buttons.general.cancel')}}</a>

                            <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> {{__('labels.buttons.general.create')}}</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
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
