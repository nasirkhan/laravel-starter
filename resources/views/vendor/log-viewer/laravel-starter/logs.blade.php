@extends ('backend.layouts.app')

<?php
$module_icon = 'fa-solid fa-list-check';
?>
@section('title')
    {{ __('Logs by Date') }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route="{{ route('log-viewer::dashboard') }}" icon='{{ $module_icon }}'>
            {{ __('Log Dashboard') }}
        </x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active">@lang('Daily Log')</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <x-backend.section-header>
                @lang('Logs by Date')

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back />
                    <a class="btn btn-primary ms-1" type="button" href="{{ route('log-viewer::logs.list') }}">
                        <i class="fas fa-list-ol"></i> @lang('Daily Log')
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="table-responsive">
                <table class="table-sm table-hover table">
                    <thead>
                        <tr>
                            @foreach ($headers as $key => $header)
                                <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}" scope="col">
                                    @if ($key == 'date')
                                        <span class="badge text-bg-info">{{ $header }}</span>
                                    @else
                                        <span class="badge badge-level-{{ $key }}">
                                            {{ log_styler()->icon($key) }} {{ $header }}
                                        </span>
                                    @endif
                                </th>
                            @endforeach
                            <th class="text-end" scope="col">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $date => $row)
                            <tr>
                                @foreach ($row as $key => $value)
                                    <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                        @if ($key == 'date')
                                            <span class="badge text-bg-primary">{{ $value }}</span>
                                        @elseif ($value == 0)
                                            <span class="badge empty">{{ $value }}</span>
                                        @else
                                            <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                                <span
                                                    class="badge badge-level-{{ $key }}">{{ $value }}</span>
                                            </a>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-end">
                                    <a class="btn btn-sm btn-info" href="{{ route('log-viewer::logs.show', [$date]) }}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                    <a class="btn btn-sm btn-success"
                                        href="{{ route('log-viewer::logs.download', [$date]) }}">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" data-log-date="{{ $date }}"
                                        href="#delete-log-modal">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="11">
                                    <span class="badge text-bg-secondary">@lang('The list of logs is empty!')</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $rows->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="delete-log-modal" aria-labelledby="delete-log-modal-label" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <input name="date" type="hidden" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-log-modal-label">@lang('Delete log file')</h1>
                        <button class="btn-close" data-coreui-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p></p>
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
            let deleteLogModalElt = deleteLogModal._element
            let deleteLogForm = document.querySelector('form#delete-log-form')
            let submitBtn = new coreui.Button(deleteLogForm.querySelector('button[type=submit]'))

            document.querySelectorAll("a[href='#delete-log-modal']").forEach((elt) => {
                elt.addEventListener('click', (event) => {
                    event.preventDefault()

                    let date = event.currentTarget.getAttribute('data-log-date')
                    let message =
                        "{{ __('Are you sure you want to delete this log file: :date ?') }}"

                    deleteLogForm.querySelector('input[name=date]').value = date
                    deleteLogModalElt.querySelector('.modal-body p').innerHTML = message.replace(
                        ':date', date)

                    deleteLogModal.show()
                })
            })

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
                            deleteLogModal.hide()
                            location.reload()
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

            deleteLogModalElt.addEventListener('hidden.bs.modal', () => {
                deleteLogForm.querySelector('input[name=date]').value = ''
                deleteLogModalElt.querySelector('.modal-body p').innerHTML = ''
            })
        })
    </script>
@endpush
