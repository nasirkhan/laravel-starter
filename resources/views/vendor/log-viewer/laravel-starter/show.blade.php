@extends ('backend.layouts.app')

<?php
$module_icon = 'fa-solid fa-list-check';
?>

@section('title')
    {{ __('Log Viewer Dashboard') }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route="{{ route('log-viewer::dashboard') }}" icon='{{ $module_icon }}'>
            {{ __('Log Dashboard') }}
        </x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item
            route="{{ route('log-viewer::logs.list') }}">@lang('Daily Log')</x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active">@lang('Log') [{{ $log->date }}]</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <x-backend.section-header>
                @lang('Log Dashboard')

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back />
                    <a class="btn btn-primary ms-1" type="button" href="{{ route('log-viewer::logs.list') }}">
                        <i class="fa-solid fa-list-ol"></i> @lang('Daily Log')
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="row">
                <div class="col-lg-2">
                    {{-- Log Menu --}}
                    <div class="card mb-4">
                        <div class="card-header"><i class="fa-solid fa-flag"></i> @lang('Levels')</div>
                        <div class="list-group list-group-flush log-menu">
                            @foreach ($log->menu() as $levelKey => $item)
                                @if ($item['count'] === 0)
                                    <a
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                        <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                        <span class="badge empty">{{ $item['count'] }}</span>
                                    </a>
                                @else
                                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center level-{{ $levelKey }}{{ $level === $levelKey ? ' active' : '' }}"
                                        href="{{ $item['url'] }}">
                                        <span class="level-name">{!! $item['icon'] !!} {{ $item['name'] }}</span>
                                        <span class="badge badge-level-{{ $levelKey }}">{{ $item['count'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    {{-- Log Details --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            @lang('Log info') :
                            <div class="group-btns float-end">
                                <a class="btn btn-sm btn-success"
                                    href="{{ route('log-viewer::logs.download', [$log->date]) }}">
                                    <i class="fa-solid fa-download"></i> @lang('Download')
                                </a>
                                <button class="btn btn-sm btn-danger" data-coreui-toggle="modal"
                                    data-coreui-target="#delete-log-modal" type="button">
                                    <i class="fa-solid fa-trash"></i> @lang('Delete')
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table-condensed mb-0 table">
                                <tbody>
                                    <tr>
                                        <td>@lang('File path') :</td>
                                        <td colspan="7">{{ $log->getPath() }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('Log entries') :</td>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $entries->total() }}</span>
                                        </td>
                                        <td>@lang('Size') :</td>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $log->size() }}</span>
                                        </td>
                                        <td>@lang('Created at') :</td>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $log->createdAt() }}</span>
                                        </td>
                                        <td>@lang('Updated at') :</td>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $log->updatedAt() }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{-- Search --}}
                            <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" id="query" name="query" type="search"
                                            value="{{ $query }}" placeholder="@lang('Type here to search')">
                                        @unless (is_null($query))
                                            <a class="btn btn-light" href="{{ route('log-viewer::logs.show', [$log->date]) }}">
                                                (@lang(':count results', ['count' => $entries->count()])) <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        @endunless
                                        <button class="btn btn-primary" id="search-btn">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Log Entries --}}
                    <div class="card mb-4">
                        @if ($entries->hasPages())
                            <div class="card-header">
                                <span class="badge text-bg-info float-right">
                                    {{ __('Page :current of :last', ['current' => $entries->currentPage(), 'last' => $entries->lastPage()]) }}
                                </span>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="mb-0 table" id="entries">
                                <thead>
                                    <tr>
                                        <th>@lang('ENV')</th>
                                        <th style="width: 120px;">@lang('Level')</th>
                                        <th style="width: 65px;">@lang('Time')</th>
                                        <th>@lang('Header')</th>
                                        <th class="text-end">@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entries as $key => $entry)
                                        <?php /** @var  Arcanedev\LogViewer\Entities\LogEntry  $entry */ ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-env">{{ $entry->env }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-level-{{ $entry->level }}">
                                                    {!! $entry->level() !!}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge text-bg-secondary">
                                                    {{ $entry->datetime->format('H:i:s') }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $entry->header }}
                                            </td>
                                            <td class="text-end">
                                                @if ($entry->hasStack())
                                                    <a class="btn btn-sm btn-light" data-coreui-toggle="collapse"
                                                        href="#log-stack-{{ $key }}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="log-stack-{{ $key }}">
                                                        <i class="fa fa-toggle-on"></i> @lang('Stack')
                                                    </a>
                                                @endif

                                                @if ($entry->hasContext())
                                                    <a class="btn btn-sm btn-light" data-coreui-toggle="collapse"
                                                        href="#log-context-{{ $key }}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="log-context-{{ $key }}">
                                                        <i class="fa fa-toggle-on"></i> @lang('Context')
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($entry->hasStack() || $entry->hasContext())
                                            <tr>
                                                <td class="stack py-0" colspan="5">
                                                    @if ($entry->hasStack())
                                                        <div class="stack-content collapse"
                                                            id="log-stack-{{ $key }}">
                                                            {!! $entry->stack() !!}
                                                        </div>
                                                    @endif

                                                    @if ($entry->hasContext())
                                                        <div class="stack-content collapse"
                                                            id="log-context-{{ $key }}">
                                                            <pre>{{ $entry->context() }}</pre>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                <span class="badge text-bg-secondary">@lang('The list of logs is empty!')</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {!! $entries->appends(compact('query'))->render('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="delete-log-modal" aria-labelledby="delete-log-modal-label" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input name="date" type="hidden" value="{{ $log->date }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="delete-log-modal-label">@lang('Delete log file')</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to delete this log file: :date ?', ['date' => $log->date])</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-sm btn-light" data-coreui-dismiss="modal"
                            type="button">@lang('Cancel')</button>
                        <button class="btn btn-sm btn-danger" data-loading-text="@lang('Loading')&hellip;"
                            type="submit">@lang('Delete')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('after-styles')
@include('log-viewer::laravel-starter.style')
@endpush

@push('after-scripts')
    <script type="module">
        function ready(fn) {
            if (document.readyState !== 'loading') {
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }
        ready(() => {
            let deleteLogModal = new coreui.Modal('div#delete-log-modal')
            let deleteLogForm = document.querySelector('form#delete-log-form')
            let submitBtn = new coreui.Button(deleteLogForm.querySelector('button[type=submit]'))

            deleteLogForm.addEventListener('submit', (event) => {
                event.preventDefault()
                submitBtn.toggle('loading')

                fetch(event.currentTarget.getAttribute('action'), {
                        method: 'DELETE',
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            'Content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            date: event.currentTarget.querySelector("input[name='date']").value,
                            _token: event.currentTarget.querySelector("input[name='_token']").value,
                        })
                    })
                    .then((resp) => resp.json())
                    .then((resp) => {
                        if (resp.result === 'success') {
                            deleteLogModal.hide();
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        } else {
                            alert('AJAX ERROR ! Check the console !')
                            console.error(resp)
                        }
                    })
                    .catch((err) => {
                        alert('AJAX ERROR ! Check the console !')
                        console.error(err)
                    })

                return false
            })

            @unless (empty(log_styler()->toHighlight()))
                @php
                    $htmlHighlight = version_compare(PHP_VERSION, '7.4.0') >= 0 ? join('|', log_styler()->toHighlight()) : join(log_styler()->toHighlight(), '|');
                @endphp

                document.querySelectorAll('.stack-content').forEach((elt) => {
                    elt.innerHTML = elt.innerHTML.trim()
                        .replace(/({!! $htmlHighlight !!})/gm, '<strong>$1</strong>')
                })
            @endunless
        });
    </script>
@endpush
