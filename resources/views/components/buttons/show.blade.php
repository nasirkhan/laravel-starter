@props(["route"=>"", "icon"=>"", "title", "small"=>""])

@if($route)
<a href='{{$route}}' 
    class='btn btn-success {{($small=='false')? '' : 'btn-sm'}}' 
    data-toggle="tooltip" 
    title="{{ $title }}">
    <i class="{{($icon)? $icon :'fas fa-tv'}}"></i>
    {{ $slot }}
</a>
@else
<button type="submit" 
    class='btn btn-success {{($small=='false')? '' : 'btn-sm'}}' 
    data-toggle="tooltip" 
    title="{{ $title }}">
    <i class="{{($icon)? $icon :'fas fa-tv'}}"></i>
    {{ $slot }}
</button>
@endif
