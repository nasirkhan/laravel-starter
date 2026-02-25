<div class="text-end">
    @can("edit_" . $module_name)
        <x-cube::backend-button-edit
            route='{!! route("backend.$module_name.edit", $data) !!}'
            title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
            small="true"
        />
    @endcan

    <x-cube::backend-button-show
        route='{!! route("backend.$module_name.show", $data) !!}'
        title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
        small="true"
    />
</div>
