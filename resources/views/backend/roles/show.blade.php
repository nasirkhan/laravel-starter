@extends ('backend.layouts.app')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __("labels.backend.access.$module_name.management") . ' | ' . __("labels.backend.access.$module_name.view"))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __("labels.backend.$module_name.index.title") }}
                    <small class="text-muted">{{ __("labels.backend.$module_name.show.action") }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __("labels.backend.$module_name.index.sub-title") }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fa fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true">
                            <i class="fa fa-user"></i> {{ __("labels.backend.$module_name.show.profile") }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive">
                                <tr>
                                    <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                                    <td>{{ $$module_name_singular->name }}</td>
                                </tr>

                                <tr>
                                    <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                                    <td>
                                        @if($$module_name_singular->permissions()->count() > 0)
                                            <ul>
                                                @foreach ($$module_name_singular->permissions as $permission)
                                                <li>{{ $permission->name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.created_at') }}</th>
                                    <td>{{ $$module_name_singular->created_at }}<br><small>({{ $$module_name_singular->created_at->diffForHumans() }})</small></td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                                    <td>{{ $$module_name_singular->updated_at }}<br/><small>({{ $$module_name_singular->updated_at->diffForHumans() }})</small></td>
                                </tr>

                            </table>
                        </div><!--table-responsive-->

                    </div><!--tab-->

                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
