<div>
    <button
        type="button"
        wire:click="unlink"
        wire:loading.attr="disabled"
        wire:confirm="Are you sure you want to unlink this {{ $providerName }} account?"
        class="inline-flex items-center rounded-md border border-red-600 bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-50 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-hidden disabled:opacity-50"
        title="@lang('Unlink Provider')"
    >
        <span wire:loading.remove wire:target="unlink">
            <i class="fas fa-unlink me-1"></i>
            @lang('Unlink')
        </span>
        <span wire:loading wire:target="unlink">
            <i class="fas fa-spinner fa-spin me-1"></i>
            @lang('Unlinking...')
        </span>
    </button>
</div>
