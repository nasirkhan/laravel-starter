<div class="text-end">
    <a
        href="{{ route("backend.users.show", $data) }}"
        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 m-0.5"
        title="{{ __("labels.backend.show") }}"
    >
        <i class="fas fa-desktop"></i>
    </a>
    <a
        href="{{ route("backend.users.edit", $data) }}"
        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 m-0.5"
        title="{{ __("labels.backend.edit") }}"
    >
        <i class="fas fa-wrench"></i>
    </a>
    <a
        href="{{ route("backend.users.changePassword", $data) }}"
        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600 m-0.5"
        title="{{ __("labels.backend.changePassword") }}"
    >
        <i class="fas fa-key"></i>
    </a>

    @if ($data->status != 2 && $data->id != 1)
        <a
            href="{{ route("backend.users.block", $data) }}"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 m-0.5"
            data-method="PATCH"
            data-token="{{ csrf_token() }}"
            title="{{ __("labels.backend.block") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="fas fa-ban"></i>
        </a>
    @endif

    @if ($data->status == 2)
        <a
            href="{{ route("backend.users.unblock", $data) }}"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600 m-0.5"
            data-method="PATCH"
            data-token="{{ csrf_token() }}"
            title="{{ __("labels.backend.unblock") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="fas fa-check"></i>
        </a>
    @endif

    @if ($data->id != 1)
        <a
            href="{{ route("backend.users.destroy", $data) }}"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 m-0.5"
            data-method="DELETE"
            data-token="{{ csrf_token() }}"
            title="{{ __("labels.backend.delete") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="fas fa-trash-alt"></i>
        </a>
    @endif

    @if ($data->email_verified_at == null)
        <a
            href="{{ route("backend.users.emailConfirmationResend", $data->id) }}"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 m-0.5"
            title="@lang("Send confirmation email")"
        >
            <i class="fas fa-envelope"></i>
        </a>
    @endif
</div>
