<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <div class="checkbox">
        <label>
            <input name="{{ $field['name'] }}" value="1" type="checkbox" @if(old($field['name'], \setting($field['name']))) checked="checked" @endif >
            {{ $field['label'] }}
        </label>

        @if ($errors->has($field['name'])) <small class="help-block">{{ $errors->first($field['name']) }}</small> @endif
    </div>
</div>