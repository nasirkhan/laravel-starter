@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{route("backend.menus.index")}}' icon="fa-solid fa-list">
            {{ __('Menus') }}
        </x-backend.breadcrumb-item>
        @if($$module_name_singular->menu_id)
            <x-backend.breadcrumb-item route='{{route("backend.menus.show", $$module_name_singular->menu_id)}}' icon="fa-solid fa-list">
                {{ __('Menu Details') }}
            </x-backend.breadcrumb-item>
        @endif
        <x-backend.breadcrumb-item type="active">{{ __($module_action) }} {{ __($module_title) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
@php
    $data = $$module_name_singular;
@endphp
    <div class="card">
        <div class="card-body">
            <x-backend.section-header
                :data="$data"
                :module_name="$module_name"
                :module_title="$module_title"
                :module_icon="$module_icon"
                :module_action="$module_action"
            />

            <div class="row mt-4">
                <div class="col">
                    @livewire("menu-item-component", ["menuItem" => $data ?? null])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    @if ($data != "")
                        <small class="text-muted float-end text-end">
                            @lang("Updated at")
                            : {{ $data->updated_at->diffForHumans() }},
                            <br class="d-block d-sm-none" />
                            @lang("Created at")
                            : {{ $data->created_at->isoFormat("LLLL") }}
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
