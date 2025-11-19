@props(["small" => ""])
{{ html()->submit($text = icon("fa-solid fa-floppy-disk fa-fw") . " " . __("Save"))->class("btn btn-success m-1" . ($small == "true" ? " btn-sm" : "")) }}
