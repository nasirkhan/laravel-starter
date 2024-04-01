@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('content')
    <x-backend.page-wrapper>
        <x-slot name="breadcrumbs">
            <x-backend.breadcrumbs>
                <x-backend.breadcrumb-item type="active"
                    icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
            </x-backend.breadcrumbs>
        </x-slot>

        <x-slot name="title">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }}
            (@lang(':count unread', ['count' => $unread_notifications_count]))
            <small class="text-muted">{{ __($module_action) }}</small>
        </x-slot>
        <x-slot name="toolbar">
            <a class="btn btn-outline-success mb-1" data-bs-toggle="tooltip"
                href="{{ route("backend.$module_name.markAllAsRead") }}" title="@lang('Mark all as read')"><i
                    class="fas fa-check-square"></i>&nbsp;@lang('Mark all as read')</a>
            <a class="btn btn-outline-danger mb-1" data-method="DELETE" data-token="{{ csrf_token() }}"
                data-bs-toggle="tooltip" href="{{ route("backend.$module_name.deleteAll") }}" title="@lang('Delete all notifications')"><i
                    class="fas fa-trash-alt"></i></a>
        </x-slot>

        <div class="row">
            <div class="col">
                <table class="table-bordered table-hover table-responsive-sm table" id="datatable">
                    <thead>
                        <tr>
                            <th>
                                @lang('Text')
                            </th>
                            <th>
                                @lang('Module')
                            </th>
                            <th>
                                @lang('Updated At')
                            </th>
                            <th class="text-end">
                                @lang('Action')
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($$module_name as $module_name_singular)
                            <?php
                            $row_class = '';
                            $span_class = '';
                            if ($module_name_singular->read_at == '') {
                                $row_class = 'table-info';
                                $span_class = 'font-weight-bold';
                            }
                            ?>
                            <tr class="{{ $row_class }}">
                                <td>
                                    <a href="{{ route("backend.$module_name.show", $module_name_singular->id) }}">
                                        <span class="{{ $span_class }}">
                                            {{ $module_name_singular->data['title'] }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    {{ $module_name_singular->data['module'] }}
                                </td>
                                <td>
                                    {{ $module_name_singular->updated_at->diffForHumans() }}
                                </td>
                                <td class="text-end">
                                    <a class='btn btn-sm btn-success mt-1' data-bs-toggle="tooltip"
                                        href='{!! route("backend.$module_name.show", $module_name_singular) !!}'
                                        title="@lang('Show') {{ ucwords(Str::singular($module_name)) }}"><i
                                            class="fas fa-tv"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <x-slot name="footer">
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        @lang('Total') {{ $$module_name->total() }} {{ ucwords($module_name) }}
                    </div>
                </div>
                <div class="col-5">
                    <div class="float-end">
                        {!! $$module_name->render() !!}
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.page-wrapper>
@endsection
