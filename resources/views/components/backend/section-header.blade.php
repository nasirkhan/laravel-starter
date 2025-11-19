@props([
    "data" => "",
    "toolbar" => "",
    "title" => "",
    "subtitle" => "",
    "module_name" => "",
    "module_title" => "",
    "module_icon" => "",
    "module_action" => "",
])

<div class="d-flex justify-content-between">
    <div class="align-self-center">
        @if ($slot != "")
            <h4 class="card-title mb-0">
                {{ $slot }}
            </h4>
        @else
            <h4 class="card-title mb-0">
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>
            </h4>
        @endif

        @if ($subtitle)
            <div class="small text-medium-emphasis">
                {{ $subtitle }}
            </div>
        @endif
    </div>
    @if ($toolbar)
        <div class="btn-toolbar d-block text-end" role="toolbar" aria-label="Toolbar with buttons">
            {{ $toolbar }}
        </div>
    @else
        <div class="btn-toolbar d-block text-end" role="toolbar" aria-label="Toolbar with buttons">
            @if (Str::endsWith(Route::currentRouteName(), "index"))
                <x-backend.buttons.return-back />

                @if (auth()->user()->can("add_" . $module_name) && Route::has("backend." . $module_name . ".create"))
                    <x-backend.buttons.create
                        title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                        small="true"
                        route='{{ route("backend.$module_name.create") }}'
                    />
                @endif

                @if (auth()->user()->can("restore_" . $module_name) && Route::has("backend." . $module_name . ".create"))
                    <div class="btn-group">
                        <button
                            class="btn btn-secondary btn-sm dropdown-toggle"
                            data-coreui-toggle="dropdown"
                            type="button"
                            aria-expanded="false"
                        >
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                    <i class="fas fa-eye-slash"></i>
                                    @lang("View trash")
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @elseif (Str::endsWith(Route::currentRouteName(), "create"))
                <a
                    class="btn btn-secondary btn-sm ms-1"
                    data-toggle="tooltip"
                    href="{{ route("backend.$module_name.index") }}"
                    title="{{ __($module_title) }} List"
                >
                    <i class="fas fa-list-ul"></i>
                    List
                </a>
            @elseif (Str::endsWith(Route::currentRouteName(), "edit"))
                <x-buttons.show
                    class="ms-1"
                    title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.show", $data) !!}'
                    small="true"
                />
            @elseif (Str::endsWith(Route::currentRouteName(), "show"))
                @if (Route::has("frontend.$module_name.show"))
                    <x-backend.buttons.public
                        class=""
                        title="{{ __('Public') }}"
                        route='{!! route("frontend.$module_name.show", encode_id($data->id)) !!}'
                        small="true"
                    />
                @endif

                @if (auth()->user()->can("edit_" . $module_name) && Route::has("backend." . $module_name . ".edit"))
                    <x-buttons.edit
                        class="m-1"
                        title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                        route='{!! route("backend.$module_name.edit", $data) !!}'
                        small="true"
                    />
                @endif

                <a
                    class="btn btn-secondary btn-sm"
                    data-toggle="tooltip"
                    href="{{ route("backend.$module_name.index") }}"
                    title="{{ ucwords($module_name) }} List"
                >
                    <i class="fas fa-list"></i>
                    {{ __("List") }}
                </a>
            @endif
        </div>
    @endif
</div>

<hr />
