@php
$required = (Str::contains($field['rules'], 'required')) ? "required" : "";
$required_mark = ($required != "") ? '<span class="text-danger"> <strong>*</strong> </span>' : '';
@endphp

<div class="form-group mb-3 {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <div class="checkbox">
        <label>
            <input type='hidden' value='0' name='{{ $field['name'] }}' class='form-label'>
            <input name=" {{ $field['name'] }}" value="{{ \Illuminate\Support\Arr::get($field, 'value', '1') }}" type="checkbox" @if(old($field['name'], setting($field['name']))) checked="checked" @endif>
            {{ $field['label'] }}
        </label> {!! $required_mark !!}

        @if ($errors->has($field['name'])) <small class="help-block">{{ $errors->first($field['name']) }}</small> @endif
    </div>
</div>