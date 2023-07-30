@props(["data"=>"", "toolbar"=>"", "title"=>"", "subtitle"=>"", "module_name"=>"", "module_title"=>"", "module_icon"=>"", "module_action"=>""])

<div class="d-flex justify-content-between">
    <div>
        @if($slot != "")
        <h4 class="card-title mb-0">
            {{ $slot }}
        </h4>
        @else
        <h4 class="card-title mb-0">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
        </h4>
        @endif

        @if($subtitle)
        <div class="small text-medium-emphasis">
            {{ $subtitle }}
        </div>
        @else
        <div class="small text-medium-emphasis">
            @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
        </div>
        @endif
    </div>
    @if($toolbar)
    <div class="btn-toolbar d-block text-end" role="toolbar" aria-label="Toolbar with buttons">
        {{ $toolbar }}
    </div>
    @else
    <div class="btn-toolbar d-block text-end" role="toolbar" aria-label="Toolbar with buttons">
        @if (Str::endsWith(Route::currentRouteName(), 'create'))
        <x-backend.buttons.return-back small="true" />
        <a href='{{ route("backend.$module_name.index") }}' class="btn btn-secondary btn-sm ms-1" data-toggle="tooltip" title="{{ __($module_title) }} List"><i class="fas fa-list-ul"></i> List</a>

        @elseif (Str::endsWith(Route::currentRouteName(), 'edit'))
        <x-backend.buttons.return-back small="true" />
        <x-buttons.show route='{!!route("backend.$module_name.show", $data)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" class="ms-1" small="true" />

        @elseif (Str::endsWith(Route::currentRouteName(), 'show'))
        <x-backend.buttons.return-back small="true" />
        @can('edit_'.$module_name)
        <x-buttons.edit route='{!!route("backend.$module_name.edit", $data)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" class="m-1" small="true" />
        @endcan
        <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
        @endif
    </div>
    @endif
</div>

<hr>