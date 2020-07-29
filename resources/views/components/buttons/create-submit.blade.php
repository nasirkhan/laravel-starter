@props(["title"=>"Create", "small"=>""])

<button type="submit" class="btn btn-success {{($small=='true')? 'btn-sm' : ''}}"><i class='fas fa-plus-circle'></i>&nbsp;{{__($title)}}</button>
