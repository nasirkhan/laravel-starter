@extends ('backend.layouts.app')

<?php
$module_icon = "fa-solid fa-list-check";
?>
@section('title') {{ __('Log Viewer Dashboard') }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route="{{ route('log-viewer::dashboard') }}" icon='{{ $module_icon }}'>
        {{ __('Log Viewer Dashboard') }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __('Logs by Date') }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> {{ __('Logs by Date') }}
                    <small class="text-muted">List </small>
                </h4>
                <div class="small text-muted">
                    @lang('Log Viewer Module')
                </div>
            </div>

            <div class="col-4">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                    <x-backend.buttons.return-back />
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                @foreach($headers as $key => $header)
                                <th scope="col" class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                    @if ($key == 'date')
                                    {{ $header }}
                                    @else
                                    <span class="badge badge-level-{{ $key }}">
                                        {!! log_styler()->icon($key) . ' ' . $header !!}
                                    </span>
                                    @endif
                                </th>
                                @endforeach
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows->count() > 0)
                            @foreach($rows as $date => $row)
                            <tr>
                                @foreach($row as $key => $value)
                                <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                    @if ($key == 'date')
                                    <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-info">
                                        {{ $value }}
                                    </a>
                                    <span class="badge badge-primary"></span>
                                    @elseif ($value == 0)
                                    <span class="badge empty">{{ $value }}</span>
                                    @else
                                    <a href="{{ route('log-viewer::logs.filter', [$date, $key]) }}">
                                        <span class="badge badge-level-{{ $key }}">{{ $value }}</span>
                                    </a>
                                    @endif
                                </td>
                                @endforeach
                                <td class="text-end">
                                    <a href="{{ route('log-viewer::logs.show', [$date]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="#delete-log-modal" class="btn btn-sm btn-danger" data-log-date="{{ $date }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="11" class="text-center">
                                    <span class="badge badge-secondary">{{ trans('log-viewer::general.empty-logs') }}</span>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    @lang('Total') {!! $rows->total() !!}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $rows->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- DELETE MODAL --}}
<div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="date" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Log File')</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary mr-auto" data-coreui-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@push('after-scripts')
<script type="module">
    $(function() {
        var deleteLogModal = $('div#delete-log-modal'),
            deleteLogForm = $('form#delete-log-form'),
            submitBtn = deleteLogForm.find('button[type=submit]');

        $("a[href='#delete-log-modal']").on('click', function(event) {
            event.preventDefault();
            var date = $(this).data('log-date');
            deleteLogForm.find('input[name=date]').val(date);
            deleteLogModal.find('.modal-body p').html(
                'Are you sure you want to <span class="badge bg-danger">DELETE</span> this log file <span class="badge text-bg-warning">' + date + '</span> ?'
            );

            deleteLogModal.modal('show');
        });

        deleteLogForm.on('submit', function(event) {
            event.preventDefault();
            submitBtn.button('loading');

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                success: function(data) {
                    submitBtn.button('reset');
                    if (data.result === 'success') {
                        deleteLogModal.modal('hide');
                        location.reload();
                    } else {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(data);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('AJAX ERROR ! Check the console !');
                    console.error(errorThrown);
                    submitBtn.button('reset');
                }
            });

            return false;
        });

        deleteLogModal.on('hidden.bs.modal', function() {
            deleteLogForm.find('input[name=date]').val('');
            deleteLogModal.find('.modal-body p').html('');
        });
    });
</script>
@endpush

@push('after-styles')
@include('log-viewer::laravel-starter.partials.style')
@endpush