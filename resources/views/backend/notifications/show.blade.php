@extends('backend.layouts.app')

@section('title')
{{ $module_action }} {{ $module_title }} | {{ app_name() }}
@stop

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{!!route('backend.dashboard')!!}"><i class="icon-speedometer"></i> Dashboard</a></li>
<li class="breadcrumb-item"><a href='{!!route("backend.$module_name.index")!!}'><i class="{{ $module_icon }}"></i> {{ $module_title }}</a></li>
<li class="breadcrumb-item active"> {{ $module_action }}</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ ucwords($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary mt-1 btn-sm" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                            @if($data->url_backend != '')
                            <tr>
                                <th>URL Backend</th>
                                <td>
                                    Backend: <a href="{{$data->url_backend}}">{{$data->url_backend}}</a>
                                </td>
                            </tr>
                            @endif
                            @if($data->url_frontend != '')
                            <tr>
                                <th>URL Frontend</th>
                                <td>
                                    Frontend: <a href="{{$data->url_frontend}}">{{$data->url_frontend}}</a>
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
                <small class="float-right text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>

@stop
