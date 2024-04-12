@props(["small"=>""])
{{ html()->submit($text = icon('fas fa-save fa-fw')." Save")->class('btn btn-success m-1'.(($small=='true')? ' btn-sm' : '')) }}