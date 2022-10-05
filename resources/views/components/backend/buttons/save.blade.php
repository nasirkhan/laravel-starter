@props(["small"=>""])
{{ html()->submit($text = icon('fas fa-save')." Save")->class('btn btn-success'.(($small=='true')? ' btn-sm' : '')) }}