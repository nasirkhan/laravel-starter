@extends ('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('breadcrumbs')
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
            <x-backend.buttons.edit class="ms-1" title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                route='{!! route("backend.$module_name.edit", $$module_name_singular) !!}' />
            <x-backend.buttons.return-back />
        </x-slot>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table-hover table">
                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                            <td>{{ $$module_name_singular->name }}</td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                            <td>
                                @if ($$module_name_singular->permissions()->count() > 0)
                                    <ul>
                                        @foreach ($$module_name_singular->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.created_at") }}</th>
                            <td>{{ $$module_name_singular->created_at }}<br><small>({{ $$module_name_singular->created_at->diffForHumans() }})</small>
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.updated_at") }}</th>
                            <td>{{ $$module_name_singular->updated_at }}<br /><small>({{ $$module_name_singular->updated_at->diffForHumans() }})</small>
                            </td>
                        </tr>

                    </table>
                </div>
                <!--table-responsive-->
            </div>
            <!--/.col-->
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
