@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item type="active" icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <div class="card mb-4">
        <div class="card-body">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                @if ($unread_notifications_count)
                    (
                    @lang(":count unread", ["count" => $unread_notifications_count])
                    )
                @endif

                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <a
                        href="{{ route("backend.$module_name.markAllAsRead") }}"
                        class="btn btn-outline-success mb-1"
                        data-toggle="tooltip"
                        title="@lang("Mark all as read")"
                    >
                        <i class="fas fa-check-square"></i>
                        @lang("Mark all as read")
                    </a>
                    <a
                        href="{{ route("backend.$module_name.deleteAll") }}"
                        class="btn btn-outline-danger mb-1"
                        data-method="DELETE"
                        data-token="{{ csrf_token() }}"
                        data-toggle="tooltip"
                        title="@lang("Delete all notifications")"
                    >
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="row">
                <div class="col">
                    <table id="datatable" class="table-bordered table-hover table-responsive-sm table">
                        <thead>
                            <tr>
                                <th>
                                    @lang("Text")
                                </th>
                                <th>
                                    @lang("Module")
                                </th>
                                <th>
                                    @lang("Updated At")
                                </th>
                                <th class="text-end">
                                    @lang("Action")
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($$module_name as $module_name_singular)
                                <?php
                                $row_class = "";
                                $span_class = "";
                                if ($module_name_singular->read_at == "") {
                                    $row_class = "table-info";
                                    $span_class = "font-weight-bold";
                                }
                                ?>

                                <tr class="{{ $row_class }}">
                                    <td>
                                        <a href="{{ route("backend.$module_name.show", $module_name_singular->id) }}">
                                            <span class="{{ $span_class }}">
                                                {{ $module_name_singular->data["title"] }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $module_name_singular->data["module"] }}
                                    </td>
                                    <td>
                                        {{ $module_name_singular->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="text-end">
                                        <a
                                            href="{!! route("backend.$module_name.show", $module_name_singular) !!}"
                                            class="btn btn-sm btn-success mt-1"
                                            data-toggle="tooltip"
                                            title="@lang("Show") {{ ucwords(Str::singular($module_name)) }}"
                                        >
                                            <i class="fas fa-tv"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        @lang("Total")
                        {{ $$module_name->total() }} {{ ucwords($module_name) }}
                    </div>
                </div>
                <div class="col-5">
                    <div class="float-end">
                        {!! $$module_name->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
