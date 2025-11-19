@props([
    "value" => "",
    "name" => $attributes->whereStartsWith("wire:model")->first(),
    "disabled" => false,
    "required" => false,
    "checked" => false,
    "label",
])

<?php
$field_name = $name;
$field_lable = $label == "" ? label_case($field_name) : $label;
?>

<fieldset>
    <legend class="sr-only">Checkbox</legend>

    <div class="flex items-center">
        <input
            wire:model="{{ $field_name }}"
            id="checkbox-2"
            type="checkbox"
            value=""
            class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
            {{ $disabled ? "disabled" : "" }}
            {{ $required ? "required" : "" }}
            {{ $attributes->merge(["wire:model" => $name]) }}
            {{ $checked ? "checked" : "" }}
        />
        <label for="checkbox-2" class="ms-2 text-sm font-semibold tracking-widest text-gray-900 dark:text-gray-300">
            {{ $label }}
        </label>
    </div>
</fieldset>
