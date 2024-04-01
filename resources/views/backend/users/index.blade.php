@extends ('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('content')
    <x-backend.page-wrapper>
        <x-slot name="breadcrumbs">
            <x-backend.breadcrumbs>
                <x-backend.breadcrumb-item type="active"
                    icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
            </x-backend.breadcrumbs>
        </x-slot>
        <x-slot name="title">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small
                class="text-muted">{{ __($module_action) }}</small>
        </x-slot>
        <x-slot name="toolbar">
            @can('add_' . $module_name)
                <x-backend.buttons.create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{{ route("backend.$module_name.create") }}' />
            @endcan

            @can('restore_' . $module_name)
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-toggle" data-coreui-toggle="dropdown" type="button"
                        aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                <i class="fas fa-eye-slash"></i> View trash
                            </a>
                        </li>
                    </ul>
                </div>
            @endcan
        </x-slot>

        <livewire:users-index />
    </x-backend.page-wrapper>

    
@endsection
