@extends ("backend.layouts.app")

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
            <x-backend.buttons.show class="ms-1" title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                route='{!! route("backend.$module_name.show", $$module_name_singular) !!}' />
            <x-backend.buttons.return-back />
        </x-slot>

        <div class="row">
            <div class="col">
                {{ html()->modelForm($$module_name_singular, 'PATCH', route("backend.$module_name.update", $$module_name_singular->id))->class('form-horizontal')->open() }}

                <div class="row mb-3">
                    <?php
                    $field_name = 'name';
                    $required = 'required';
                    $field_lable = __('labels.backend.roles.fields.name');
                    $field_placeholder = $field_lable;
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable.field_required($required), $field_name)->class('form-label') }}
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
                                        {{ html()->label(html()->checkbox('permissions[]', in_array($permission->name, $$module_name_singular->permissions->pluck('name')->all()), $permission->name)->id('permission-' . $permission->id) .' ' .$permission->name)->for('permission-' . $permission->id) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <x-backend.buttons.save />
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="float-end">
                            <a class="btn btn-outline-danger m-1" data-method="DELETE" data-token="{{ csrf_token() }}"
                                data-bs-toggle="tooltip"
                                href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}"
                                title="{{ __('labels.backend.delete') }}"><i class="fas fa-trash-alt"></i></a>
                            <x-backend.buttons.return-back>Cancel</x-backend.buttons.return-back>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>

        <x-slot name="footer">
            <div class="row">
                <div class="col">
                    <small class="float-end text-muted">
                        Updated: {{ $$module_name_singular->updated_at->diffForHumans() }},
                        Created at: {{ $$module_name_singular->created_at->isoFormat('LLLL') }}
                    </small>
                </div>
            </div>
        </x-slot>
    </x-backend.page-wrapper>

@endsection
