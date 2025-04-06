@props(['value'=>'', 'disabled' => false, 'required'=> false, 'options' => '', 'placeholder' => '-- Select an option --'])

<select {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {!! $attributes->merge(['class' => 'border-0 border-b-2 border-b-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 py-1 mt-2']) !!}>
    <option value="">{{$placeholder}}</option>
    @foreach ($options as $k=>$v)
    <option value="{{$k}}" {{($value == $k) ? 'selected' : ''}}>{{$v}}</option>
    @endforeach
</select>