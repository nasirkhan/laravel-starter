<div>
    @if(Auth::user() && Auth::user()->email_verified_at === null)
        <div class="rounded-lg border-2 border-yellow-400 bg-yellow-50 p-4 dark:bg-yellow-100">
            <div class="flex items-start">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800">
                        @lang('Email Not Verified')
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            @lang('Your email address has not been verified. Please check your inbox for the verification email.')
                        </p>
                    </div>
                    <div class="mt-4">
                        <button
                            type="button"
                            wire:click="resend"
                            wire:loading.attr="disabled"
                            class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-medium text-yellow-800 hover:bg-yellow-100 focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:outline-hidden disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="resend">
                                @lang('Resend Verification Email')
                            </span>
                            <span wire:loading wire:target="resend">
                                @lang('Sending...')
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
