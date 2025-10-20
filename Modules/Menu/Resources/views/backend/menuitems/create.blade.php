@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{route("backend.menus.index")}}' icon="fa-solid fa-list">
            {{ __('Menus') }}
        </x-backend.breadcrumb-item>
        @if(request('menu_id'))
            <x-backend.breadcrumb-item route='{{route("backend.menus.show", request("menu_id"))}}' icon="{{ $module_icon }}">
                {{ __('Menu Details') }}
            </x-backend.breadcrumb-item>
        @endif
        <x-backend.breadcrumb-item type="active">{{ __($module_action) }} {{ __($module_title) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <x-backend.section-header
                :module_name="$module_name"
                :module_title="$module_title"
                :module_icon="$module_icon"
                :module_action="$module_action"
            />

            <div class="row mt-4">
                <div class="col">
                    @livewire('menu-item-component', ['menu_id' => request('menu_id')])
                </div>
            </div>
        </div>
    </div>
@endsection
