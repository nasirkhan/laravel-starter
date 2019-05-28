<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <input type="{{ $field['type'] }}"
           name="{{ $field['name'] }}"
           value="{{ old($field['name'], setting($field['name'])) }}"
           class="form-control {{ array_get( $field, 'class') }} {{ $errors->has($field['name']) ? ' is-invalid' : '' }}"
           id="{{ $field['name'] }}"
           placeholder="{{ $field['label'] }}">

    @if ($errors->has($field['name'])) <small class="invalid-feedback">{{ $errors->first($field['name']) }}</small> @endif
</div>
