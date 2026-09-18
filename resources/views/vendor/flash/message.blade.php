@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        <x-cube::modal framework="bootstrap" name="flash-overlay-{{ $loop->index }}">
            <div class="modal-header">
                <h5 class="modal-title">{{ $message['title'] }}</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <p>{!! $message['message'] !!}</p>
            </div>
            <div class="modal-footer">
                <x-cube::button framework="bootstrap" data-coreui-dismiss="modal">{{ __('Close') }}</x-cube::button>
            </div>
        </x-cube::modal>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('flash-overlay-{{ $loop->index }}');
                if (el) { new coreui.Modal(el).show(); }
            });
        </script>
    @else
        <x-cube::alert :type="$message['level']" :dismissible="$message['important']">
            {!! $message['message'] !!}
        </x-cube::alert>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
