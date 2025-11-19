@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <a
                        href="{{ route("backend.$module_name.index") }}"
                        class="btn btn-secondary btn-sm mt-1"
                        data-toggle="tooltip"
                        title="{{ __(ucwords($module_name)) }} List"
                    >
                        <i class="fas fa-list"></i>
                        List
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table-bordered table">
                            <?php $data = json_decode($$module_name_singular->data); ?>

                            <tbody>
                                <tr>
                                    <th>Title</th>
                                    <th>
                                        {{ $data->title }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Text</th>
                                    <td>
                                        {!! $data->text !!}
                                    </td>
                                </tr>
                                @if ($data->url_backend != "")
                                    <tr>
                                        <th>URL Backend</th>
                                        <td>
                                            Backend:
                                            <a href="{{ $data->url_backend }}">{{ $data->url_backend }}</a>
                                        </td>
                                    </tr>
                                @endif

                                @if ($data->url_frontend != "")
                                    <tr>
                                        <th>URL Frontend</th>
                                        <td>
                                            Frontend:
                                            <a href="{{ $data->url_frontend }}">{{ $data->url_frontend }}</a>
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
                <div class="col">
                    <small class="text-muted float-end">
                        Updated: {{ $$module_name_singular->updated_at->diffForHumans() }}, Created at:
                        {{ $$module_name_singular->created_at->isoFormat("LLLL") }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
