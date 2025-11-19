@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ __($module_title) }} "{{ ${$module_name_singular}->name }}"
                    <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    {{ __('menu::text.updated_at') }} {{ ${$module_name_singular}->updated_at->diffForHumans() }}
                </div>
            </div>
            <div class="col-4">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                    <x-backend.buttons.return-back />
                    <x-backend.buttons.list 
                        route="{{ route("backend.$module_name.index") }}"
                        title="{{ __('menu::text.menu_list') }}"
                        icon="fas fa-list"
                        small="true"
                    />
                    <x-backend.buttons.create 
                        route="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}"
                        title="{{ __('menu::text.add_menu_item') }}"
                        icon="fas fa-plus-circle"
                        small="true"
                    />
                    <x-backend.buttons.edit route='{!!route("backend.$module_name.edit", ${$module_name_singular})!!}' title="{{__('Edit')}} {{ $module_title }}" small="true" />
                </div>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-12 col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('menu::text.name') }}</label>
                    <p class="form-control-plaintext">{{ ${$module_name_singular}->name }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('menu::text.location') }}</label>
                    <p class="form-control-plaintext">{{ ${$module_name_singular}->location }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('menu::text.locale') }}</label>
                    <p class="form-control-plaintext">{{ ${$module_name_singular}->locale ?? __('menu::text.all_locales') }}</p>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('menu::text.status') }}</label>
                    <p class="form-control-plaintext">
                        @if(${$module_name_singular}->is_active)
                            <span class="badge bg-success">{{ __('menu::text.active') }}</span>
                        @else
                            <span class="badge bg-warning">{{ __('menu::text.inactive') }}</span>
                        @endif
                        
                        @if(${$module_name_singular}->is_visible)
                            <span class="badge bg-primary">{{ __('menu::text.visible') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ __('menu::text.hidden') }}</span>
                        @endif
                        
                        @if(${$module_name_singular}->is_public)
                            <span class="badge bg-info">{{ __('menu::text.public') }}</span>
                        @else
                            <span class="badge bg-dark">{{ __('menu::text.private') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if(${$module_name_singular}->description)
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <label class="form-label">{{ __('menu::text.description') }}</label>
                    <p class="form-control-plaintext">{{ ${$module_name_singular}->description }}</p>
                </div>
            </div>
        </div>
        @endif

        <hr>

        <!-- Menu Items Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> {{ __('menu::text.menu_items') }}
                        <span class="badge bg-primary">{{ ${$module_name_singular}->allItems->count() }}</span>
                    </h5>
                    <x-backend.buttons.create 
                        route="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}"
                        title="{{ __('menu::text.add_item') }}"
                        icon="fas fa-plus-circle"
                        small="true"
                    />
                </div>

                @if(${$module_name_singular}->items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('menu::text.order') }}</th>
                                    <th>{{ __('menu::text.name') }}</th>
                                    <th>{{ __('menu::text.type') }}</th>
                                    <th>{{ __('menu::text.url_route') }}</th>
                                    <th>{{ __('menu::text.status') }}</th>
                                    <th class="text-center">{{ __('menu::text.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(${$module_name_singular}->items->sortBy('sort_order') as $item)
                                    @include('menu::backend.menus.partials.menu-item-row', ['item' => $item, 'level' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        {{ __('menu::text.no_menu_items') }}
                        <a href="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}" class="alert-link">
                            {{ __('menu::text.add_first_item') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="text-muted">
                    <strong>{{ __('menu::text.created_at') }}:</strong> {{ ${$module_name_singular}->created_at }} ({{ ${$module_name_singular}->created_at->diffForHumans() }}),
                    <strong>{{ __('menu::text.updated_at') }}:</strong> {{ ${$module_name_singular}->updated_at }} ({{ ${$module_name_singular}->updated_at->diffForHumans() }})
                    @if(${$module_name_singular}->deleted_at)
                        <strong>{{ __('menu::text.deleted_at') }}:</strong> {{ ${$module_name_singular}->deleted_at }} ({{ ${$module_name_singular}->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>
@endsection