@props(["route", "icon"=>"", "title", "small"=>""])

<a href='{{$route}}' 
    class='btn btn-primary {{($small=='false')? '' : 'btn-sm'}}' 
    data-toggle="tooltip" 
    title="{{ $title }}">
    <i class="{{($icon)? $icon :'fas fa-wrench'}}"></i>
    {{ $slot }}
</a>