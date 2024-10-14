@php
    $required = Str::contains($field["rules"], "required") ? "required" : "";
    $required_mark = $required != "" ? '<span class="text-danger"> <strong>*</strong> </span>' : "";
@endphp

<div class="form-group {{ $errors->has($field["name"]) ? " has-error" : "" }} mt-3">
    <div class="checkbox">
        <label class="form-label" for="{{ $field["name"] }}">
            <strong>{{ __($field["label"]) }}</strong>
            ({{ $field["name"] }})
        </label>
        {!! $required_mark !!}
        <br />

        <label>
            <input class="form-label" name="{{ $field["name"] }}" type="hidden" value="0" />
            <input
                name=" {{ $field["name"] }}"
                type="checkbox"
                value="{{ \Illuminate\Support\Arr::get($field, "value", "1") }}"
                @if (old($field['name'], setting($field['name']))) checked="checked" @endif
            />
            {{ $field["label"] }}
        </label>
        {!! $required_mark !!}

        @if ($errors->has($field["name"]))
            <small class="help-block">{{ $errors->first($field["name"]) }}</small>
        @endif
    </div>
</div>
