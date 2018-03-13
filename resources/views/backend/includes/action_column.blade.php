<?php $module_name_singular = str_singular($module_name); ?>

<div class="text-right">
    <a href='{!!route("backend.$module_name.edit", $module_name_singular)!!}' class='btn btn-sm btn-primary mt-1' data-toggle="tooltip" title="Edit {{ title_case(str_singular($module_name)) }}"><i class="fas fa-wrench"></i></a>
    <a href='{!!route("backend.$module_name.show", $module_name_singular)!!}' class='btn btn-sm btn-success mt-1' data-toggle="tooltip" title="Show {{ title_case(str_singular($module_name)) }}"><i class="fas fa-tv"></i></a>
</div>
