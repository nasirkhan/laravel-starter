@props(["data"=>""])
<div class="card">
    <div class="card-body">
        {{ $slot }}
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                @if ($data != "")
                <small class="float-end text-muted">
                    @lang('Updated at'): {{$data->updated_at->diffForHumans()}},
                    @lang('Created at'): {{$data->created_at->isoFormat('LLLL')}}
                </small>
                @endif
            </div>
        </div>
    </div>
</div>