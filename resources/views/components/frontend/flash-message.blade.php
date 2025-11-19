@foreach (session("flash_notification", collect())->toArray() as $message)
    @if ($message["level"] == "success")
        <div
            class="my-4 rounded-lg border border-green-800 bg-green-50 p-4 text-sm font-semibold text-green-800 dark:bg-gray-800 dark:text-green-400"
            role="alert"
        >
            {!! $message["message"] !!}
        </div>
    @elseif ($message["level"] == "danger")
        <div
            class="my-4 rounded-lg border border-red-800 bg-red-50 p-4 text-sm font-semibold text-red-800 dark:bg-gray-800 dark:text-red-400"
            role="alert"
        >
            {!! $message["message"] !!}
        </div>
    @elseif ($message["level"] == "warning")
        <div
            class="my-4 rounded-lg border border-yellow-800 bg-yellow-50 p-4 text-sm font-semibold text-yellow-800 dark:bg-gray-800 dark:text-yellow-300"
            role="alert"
        >
            {!! $message["message"] !!}
        </div>
    @elseif ($message["level"] == "info")
        <div
            class="my-4 rounded-lg border border-blue-800 bg-blue-50 p-4 text-sm font-semibold text-blue-800 dark:bg-gray-800 dark:text-blue-400"
            role="alert"
        >
            {!! $message["message"] !!}
        </div>
    @else
        <div
            class="my-4 rounded-lg border border-gray-800 bg-gray-50 p-4 text-sm font-semibold text-gray-800 dark:bg-gray-800 dark:text-gray-300"
            role="alert"
        >
            {!! $message["message"] !!}

            {{ $message["level"] }}
        </div>
    @endif
@endforeach

{{ session()->forget("flash_notification") }}
