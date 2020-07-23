<div class="text-right">
    @can('edit_'.$module_name)
    <x-buttons.edit route='{!!route("backend.$module_name.edit", $data)!!}' title="Edit {{ ucwords(Str::singular($module_name)) }}"/>
    @endcan
    <x-buttons.show route='{!!route("backend.$module_name.show", $data)!!}' title="Show {{ ucwords(Str::singular($module_name)) }}"/>
</div>