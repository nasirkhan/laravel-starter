@props([
    "type" => "text",
    "name" => $attributes->whereStartsWith("wire:model")->first(),
    "label" => "",
    "placeholder" => "",
    "label_show" => true,
    "disabled" => false,
    "required" => false,
    "value" => "",
])

<?php
$field_name = $name;
$field_lable = $label == "" ? label_case($field_name) : $label;
$field_placeholder = $placeholder == "" ? label_case($field_lable) : $placeholder;
?>

<div class="group w-full">
    @if ($label_show)
        {{ html()->label($field_lable, $field_name)->class("block-inline text-sm font-semibold tracking-widest text-gray-700") }}
        {!! field_required($required) !!}
    @endif

    @switch($type)
        @case("email")
            {{ html()->email($field_name)->placeholder($field_placeholder)->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required", $disabled, "wire:model" => $field_name]) }}

            @break
        @case("number")
            {{ html()->number($field_name)->placeholder($field_placeholder)->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required", $disabled, "wire:model" => $field_name]) }}

            @break
        @case("password")
            {{ html()->password($field_name)->placeholder($field_placeholder)->value("")->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required", $disabled, "wire:model" => $field_name]) }}

            @break
        @case("value")
            <div
                class="mt-1 w-full rounded border border-gray-300 bg-gray-100 px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:ring-2 focus:ring-blue-600 focus:outline-none"
                wire:model="{{ $field_name }}"
            >
                {{ $value }}&nbsp;
            </div>

            @break
        @default
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required", $disabled, "wire:model" => $field_name]) }}
    @endswitch

    @foreach ($errors->get($field_name) as $message)
        <div class="mt-2 text-sm text-red-600 dark:text-red-500">
            <span class="font-medium"><i class="fa fa-exclamation-triangle"></i></span>
            {{ $message }}
        </div>
    @endforeach
</div>
