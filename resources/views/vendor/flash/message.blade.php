@foreach (session('flash_notification', collect())->toArray() as $message)
    <?php
    $variable = $message['level'];
    
    switch ($variable) {
        case 'primary':
            $icon = '<i class="fa-solid fa-circle-info fa-fw"></i>';
            break;
        case 'secondary':
            $icon = '<i class="fa-solid fa-circle-info fa-fw"></i>';
            break;
        case 'success':
            $icon = '<i class="fa-solid fa-circle-check fa-fw"></i>';
            break;
        case 'danger':
            $icon = '<i class="fa-solid fa-triangle-exclamation fa-fw"></i>';
            break;
        case 'warning':
            $icon = '<i class="fa-solid fa-triangle-exclamation fa-fw"></i>';
            break;
        case 'info':
            $icon = '<i class="fa-solid fa-circle-info fa-fw"></i>';
            break;
        case 'light':
            $icon = '<i class="fa-solid fa-bullhorn fa-fw"></i>';
            break;
        case 'dark':
            $icon = '<i class="fa-solid fa-circle-question fa-fw"></i>';
            break;
        default:
            $icon = '<i class="fa-solid fa-bullhorn fa-fw"></i>';
            break;
    }
    ?>

    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title' => $message['title'],
            'body' => $message['message'],
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-dismissible' : '' }}"
            role="alert" fade show>

            {!! $icon !!}&nbsp;{!! $message['message'] !!}

            @if ($message['important'])
                <button class="btn-close" data-coreui-dismiss="alert" type="button" aria-label="Close"></button>
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
