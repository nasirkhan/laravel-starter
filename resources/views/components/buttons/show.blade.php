@props(["route"=>"", "icon"=>"fas fa-tv", "title", "small"=>""])

@if($route)
<a href='{{$route}}'
    class='btn btn-success {{($small=='false')? '' : 'btn-sm'}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="submit"
    class='btn btn-success {{($small=='false')? '' : 'btn-sm'}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
