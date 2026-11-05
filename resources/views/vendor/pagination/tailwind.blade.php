@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between gap-4 flex-wrap">

        {{-- Result count --}}
        <p class="text-sm text-gray-600 dark:text-gray-400">
            @if ($paginator->firstItem())
                {{ __('Showing') }}
                <span class="font-medium">{{ $paginator->firstItem() }}</span>–<span class="font-medium">{{ $paginator->lastItem() }}</span>
                {{ __('of') }}
                <span class="font-medium">{{ $paginator->total() }}</span>
            @else
                {{ $paginator->count() }} {{ __('results') }}
            @endif
        </p>

        {{-- Page links --}}
        <span class="inline-flex items-center gap-0.5 rounded-md text-sm">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-2 py-1 text-gray-400 border border-gray-300 rounded-l-md cursor-not-allowed bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600" aria-disabled="true">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2 py-1 text-gray-500 border border-gray-300 rounded-l-md bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center px-2 py-1 text-gray-500 border-y border-x border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 -ml-px">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex items-center px-3 py-1 font-semibold text-white bg-blue-600 border border-blue-600 -ml-px dark:bg-blue-700 dark:border-blue-700">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center px-3 py-1 text-gray-600 border border-gray-300 bg-white hover:bg-gray-50 -ml-px dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2 py-1 text-gray-500 border border-gray-300 rounded-r-md bg-white hover:bg-gray-50 -ml-px dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </a>
            @else
                <span class="inline-flex items-center px-2 py-1 text-gray-400 border border-gray-300 rounded-r-md cursor-not-allowed bg-white -ml-px dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600" aria-disabled="true">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </span>
            @endif

        </span>
    </nav>
@endif
