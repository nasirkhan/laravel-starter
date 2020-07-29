@props(["route"=>"", "icon"=>"fas fa-plus-circle", "title", "small"=>""])

@if($route)
<a href='{{$route}}'
    class='btn btn-success {{($small=='true')? 'btn-sm' : ''}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="submit"
    class='btn btn-success {{($small=='true')? 'btn-sm' : ''}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
