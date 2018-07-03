<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <select name="{{ $field['name'] }}" class="form-control {{ array_get( $field, 'class') }}" id="{{ $field['name'] }}">
        @foreach(array_get($field, 'options', []) as $val => $label)
            <option @if( old($field['name'], \setting($field['name'])) == $val ) selected  @endif value="{{ $val }}">{{ $label }}</option>
        @endforeach
    </select>
    @if ($errors->has($field['name'])) <small class="help-block">{{ $errors->first($field['name']) }}</small> @endif
</div>