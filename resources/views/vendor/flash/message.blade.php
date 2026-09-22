@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        <x-cube::modal name="flash-overlay-{{ $loop->index }}" :show="true">
            <div class="p-6">
                <h5 id="flash-overlay-{{ $loop->index }}-title" class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $message['title'] }}</h5>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{!! $message['message'] !!}</p>
                <div class="mt-6 flex justify-end">
                    <x-cube::button
                        x-on:click="$dispatch('close-modal', '{{ 'flash-overlay-' . $loop->index }}')"
                    >{{ __('Close') }}</x-cube::button>
                </div>
            </div>
        </x-cube::modal>
    @else
        <x-cube::alert :type="$message['level']" :dismissible="$message['important']">
            {!! $message['message'] !!}
        </x-cube::alert>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
