{{-- Component: UI Modal --}}
{{-- Description: Modal dialog with Alpine.js, keyboard navigation, and focus management --}}
{{-- Props: name (required), show, maxWidth, focusable --}}

@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl',
    'focusable' => false,
])

@php
    // Validate maxWidth
    $validWidths = ['sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl'];
    $maxWidth = in_array($maxWidth, $validWidths) ? $maxWidth : '2xl';
    
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
    ][$maxWidth];
    
    $show = filter_var($show, FILTER_VALIDATE_BOOLEAN);
    $focusable = filter_var($focusable, FILTER_VALIDATE_BOOLEAN);
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                .filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }"
    x-init="
        $watch('show', (value) => {
            if (value) {
                document.body.classList.add('overflow-y-hidden')
                @if($focusable)
                    setTimeout(() => firstFocusable()?.focus(), 100)
                @endif
            } else {
                document.body.classList.remove('overflow-y-hidden')
            }
        })
    "
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? (show = true) : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? (show = false) : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
    style="display: {{ $show ? 'block' : 'none' }}"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        aria-hidden="true"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
    </div>

    <!-- Modal Content -->
    <div
        x-show="show"
        class="{{ $maxWidthClass }} mb-6 transform overflow-hidden rounded-lg bg-white shadow-xl transition-all dark:bg-gray-800 sm:mx-auto sm:w-full"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
    >
        {{ $slot }}
    </div>
</div>

{{-- Usage:
<!-- Trigger Button -->
<x-ui.buttons.primary 
    x-on:click="$dispatch('open-modal', 'confirm-delete')">
    Delete User
</x-ui.buttons.primary>

<!-- Modal -->
<x-ui.modal name="confirm-delete" :show="$errors->isNotEmpty()" focusable maxWidth="md">
    <div class="p-6">
        <h2 id="modal-title" class="text-lg font-medium">
            Are you sure?
        </h2>
        
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            This action cannot be undone.
        </p>
        
        <div class="mt-6 flex justify-end gap-3">
            <x-ui.buttons.secondary 
                x-on:click="$dispatch('close-modal', 'confirm-delete')">
                Cancel
            </x-ui.buttons.secondary>
            
            <x-ui.buttons.danger type="submit">
                Delete
            </x-ui.buttons.danger>
        </div>
    </div>
</x-ui.modal>

Events:
- Open: $dispatch('open-modal', 'modal-name')
- Close: $dispatch('close-modal', 'modal-name')
- ESC key to close
- Click backdrop to close
- Tab/Shift+Tab for focus trap
--}}
