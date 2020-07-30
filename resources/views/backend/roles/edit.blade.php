@extends ("backend.layouts.app")

@section('title') {{ __($module_action) }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

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
                    <x-buttons.return-back />
                    <x-buttons.show route='{!!route("backend.$module_name.show", $$module_name_singular)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" class="ml-1"/>
                </div>
            </div>
        </div>

        <hr>
        <div class="row mt-4">
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
                                        {{ html()->label(html()->checkbox('permissions[]', in_array($permission->name, $$module_name_singular->permissions->pluck('name')->all()), $permission->name)->id('permission-'.$permission->id) . ' ' . $permission->name)->for('permission-'.$permission->id) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                {{ html()->submit($text = icon('fas fa-save')." Save")->class('btn btn-success') }}
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="float-right">
                                <a href="{{route("backend.$module_name.destroy", $$module_name_singular)}}" class="btn btn-danger" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}"><i class="fas fa-trash-alt"></i></a>
                                <a href="{{ route("backend.$module_name.index") }}" class="btn btn-warning" data-toggle="tooltip" title="{{__('labels.backend.cancel')}}"><i class="fas fa-reply"></i> Cancel</a>
                            </div>
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
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>

@endsection
