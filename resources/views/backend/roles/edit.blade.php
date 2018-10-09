@extends ("backend.layouts.app")

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section("content")
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> {{ __("labels.backend.$module_name.edit.title") }}
                    <small class="text-muted">{{ __("labels.backend.$module_name.edit.action") }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __("labels.backend.$module_name.edit.sub-title") }}
                </div>
            </div>
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i></button>
                    <a href="{{route("backend.$module_name.show", $$module_name_singular)}}" class="btn btn-primary ml-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fas fa-tv"></i></a>
                </div>
            </div>
        </div>

        <hr>
        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->modelForm($$module_name_singular, 'PATCH', route("backend.$module_name.update", $$module_name_singular->id))->class('form-horizontal')->open() }}

                    <div class="form-group row">
                        {{ html()->label(__("labels.backend.$module_name.fields.name"))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.roles.fields.name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            Permissions
                        </div>
                        <div class="col-md-10">
                            @if ($permissions->count())
                                @foreach($permissions as $permission)
                                    <div class="checkbox">
                                        {{ html()->label(html()->checkbox('permissions[]', in_array($permission->name, $$module_name_singular->permissions->pluck('name')->all()), $permission->name)->id('permission-'.$permission->id) . ' ' . ucwords($permission->name))->for('permission-'.$permission->id) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route("backend.$module_name.index"), __('labels.buttons.general.cancel')) }}
                            {{ form_submit(__('labels.buttons.general.update')) }}
                        </div>
                    </div>
                {{ html()->closeModelForm() }}
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

@endsection
