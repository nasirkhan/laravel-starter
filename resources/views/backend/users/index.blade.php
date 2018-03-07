@extends ('backend.layouts.app')

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.users.index.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.index.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{route('backend.users.create')}}" class="btn btn-success ml-1" data-toggle="tooltip" title="Create New"><i class="fa fa-plus-circle"></i></a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('labels.backend.users.fields.name') }}</th>
                            <th>{{ __('labels.backend.users.fields.email') }}</th>
                            <th>{{ __('labels.backend.users.fields.confirmed') }}</th>
                            <th>{{ __('labels.backend.users.fields.roles') }}</th>
                            <th>{{ __('labels.backend.users.fields.permissions') }}</th>
                            <th>{{ __('labels.backend.users.fields.social') }}</th>
                            <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                            <th>{{ __('labels.backend.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{!! $user->confirmed_label !!}</td>
                            <td>
                                @if($user->getRoleNames()->count() > 0)
                                    <ul>
                                        @foreach ($user->getRoleNames() as $role)
                                        <li>{{ ucwords($role) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                @if($user->getAllPermissions()->count() > 0)
                                    <ul>
                                        @foreach ($user->getAllPermissions() as $permission)
                                        <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{!! $user->social_buttons !!}</td>
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{route('backend.users.show', $user)}}" class="btn btn-success"><i class="fas fa-desktop" data-toggle="tooltip" title="{{__('labels.backend.show')}}"></i></a>
                                <a href="{{route('backend.users.edit', $user)}}" class="btn btn-primary"><i class="fas fa-pencil-alt" data-toggle="tooltip" title="{{__('labels.backend.edit')}}"></i></a>
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
                    {!! $users->total() !!} {{ __('labels.backend.total') }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
