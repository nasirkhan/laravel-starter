@foreach (session('flash_notification', collect())->toArray() as $message)

@if ($message['level'] == "success")
<div class="p-4 my-4 text-sm font-semibold border border-green-800 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    {!! $message['message'] !!}
</div>
@elseif ($message['level'] == "danger")
<div class="p-4 my-4 text-sm font-semibold border border-red-800 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    {!! $message['message'] !!}
</div>
@elseif ($message['level'] == "warning")
<div class="p-4 my-4 text-sm font-semibold border border-yellow-800 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
    {!! $message['message'] !!}
</div>
@elseif ($message['level'] == "info")
<div class="p-4 my-4 text-sm font-semibold border border-blue-800 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
    {!! $message['message'] !!}
</div>
@else
<div class="p-4 my-4 text-sm font-semibold border border-gray-800 text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
    {!! $message['message'] !!}

    {{ $message['level'] }}
</div>
@endif

@endforeach

{{ session()->forget('flash_notification') }}