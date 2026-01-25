@php
    $required = Str::contains($field["rules"], "required") ? "required" : "";
    $required_mark = $required != "" ? '<span class="text-danger"> <strong>*</strong> </span>' : "";
@endphp

<div class="form-group {{ $errors->has($field["name"]) ? " has-error" : "" }} mt-3">
    <div class="radio-group">
        <label class="form-label" for="{{ $field["name"] }}">
            <strong>{{ __($field["label"]) }}</strong>
            ({{ $field["name"] }})
        </label>
        {!! $required_mark !!}
        <br />

        @foreach ($field["options"] as $value => $label)
            <div class="form-check">
                <label class="form-check-label">
                    <input
                        class="form-check-input"
                        name="{{ $field["name"] }}"
                        type="radio"
                        value="{{ $value }}"
                        @if(old($field['name'], setting($field['name'])) == $value) checked="checked" @endif
                    />
                    {{ __($label) }}
                </label>
            </div>
        @endforeach

        @if ($errors->has($field["name"]))
            <small class="help-block">{{ $errors->first($field["name"]) }}</small>
        @endif
    </div>
</div>