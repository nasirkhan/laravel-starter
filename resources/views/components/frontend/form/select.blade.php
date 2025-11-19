@props(["value" => "", "name" => $attributes->whereStartsWith("wire:model")->first(), "disabled" => false, "required" => false, "options" => "", "placeholder" => "-- Select an option --"])

<?php
$field_name = $name;
$field_lable = $label == "" ? label_case($field_name) : $label;
$field_placeholder = $placeholder == "" ? label_case($field_lable) : $placeholder;
?>

<select
    wire:model="{{ $field_name }}"
    {{ $disabled ? "disabled" : "" }}
    {{ $required ? "required" : "" }}
    {!! $attributes->merge(["class" => "border-0 border-b-2 border-b-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 py-1 mt-2"]) !!}
>
    <option value="">{{ $field_placeholder }}</option>
    @foreach ($options as $k => $v)
        <option value="{{ $k }}" {{ $value == $k ? "selected" : "" }}>{{ $v }}</option>
    @endforeach
</select>
