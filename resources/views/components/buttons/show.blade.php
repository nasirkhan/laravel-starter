@props(["route", "icon"=>"", "title", "small"=>""])

<a href='{{$route}}' 
    class='btn btn-success {{($small=='false')? '' : 'btn-sm'}}' 
    data-toggle="tooltip" 
    title="{{ $title }}">
    <i class="{{($icon)? $icon :'fas fa-tv'}}"></i>
    {{ $slot }}
</a>