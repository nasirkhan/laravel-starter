<div class="text-right">
    @can('edit_'.$module_name)
    <a href='{!!route("backend.$module_name.edit", $data)!!}' class='btn btn-sm btn-primary mt-1' data-toggle="tooltip" title="Edit {{ ucwords(Str::singular($module_name)) }}"><i class="fas fa-wrench"></i></a>
    @endcan
    <a href='{!!route("backend.$module_name.show", $data)!!}' class='btn btn-sm btn-success mt-1' data-toggle="tooltip" title="Show {{ ucwords(Str::singular($module_name)) }}"><i class="fas fa-tv"></i></a>
</div>
