@props(["toolbar"=>"", "subtitle"=>""])

<div class="d-flex justify-content-between">
    <div>
        <h4 class="card-title mb-0">
            {{ $slot }}
        </h4>
        @if($subtitle != "")
        <div class="small text-medium-emphasis">
            {{ $subtitle }}
        </div>
        @endif
    </div>
    @if($toolbar != "")
    <div class="btn-toolbar d-block" role="toolbar" aria-label="Toolbar with buttons">
        {{ $toolbar }}
    </div>
    @endif
</div>