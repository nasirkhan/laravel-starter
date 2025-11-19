@props(["breadcrumbs" => "", "toolbar" => "", "footer" => ""])
<div class="page-wrapper">
    {{-- page header --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <!-- Errors block -->
            @include("flash::message")
            @include("backend.includes.errors")
            <!-- / Errors block -->

            <div class="row align-items-center mw-100">
                <div class="col">
                    <h1 class="page-title">
                        <span class="text-truncate">
                            {{ $title }}
                        </span>
                    </h1>

                    @if ($breadcrumbs)
                        <div class="mt-2">
                            <ol class="breadcrumb breadcrumb-bullets" aria-label="breadcrumbs">
                                {{ $breadcrumbs }}
                            </ol>
                        </div>
                    @endif
                </div>
                @if ($toolbar)
                    <div class="col-auto">
                        <div class="btn-list">
                            {{--
                                <a class="btn d-none d-md-inline-flex" href="#">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                                </svg>
                                Edit
                                </a>
                                <a class="btn btn-primary" href="#">
                                Publish
                                </a>
                            --}}
                            {{ $toolbar }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- page body --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    {{ $slot }}
                </div>
                @if ($footer)
                    <div class="card-footer">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- footer --}}
    <x-backend.includes.footer />
</div>
