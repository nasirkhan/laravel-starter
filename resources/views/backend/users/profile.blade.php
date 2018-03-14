@extends ('backend.layouts.app')

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    Profile
                    <small class="text-muted">{{ __('labels.backend.users.show.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="pull-right">
                    <a href="{{ route("backend.users.profileEdit") }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ str_singular($module_name) }} "><i class="fas fa-wrench"></i> Edit</a>
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
                            <i class="fas fa-user"></i> {{ __('labels.backend.users.show.profile') }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>{{ __('labels.backend.users.fields.picture') }}</th>
                                    <td><img src="{{ $user->picture }}" class="user-profile-image" /></td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.name') }}</th>
                                    <td>{{ $user->name }}</td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.email') }}</th>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.status') }}</th>
                                    <td>{!! $user->status !!}</td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.confirmed') }}</th>
                                    <td>{!! $user->confirmed !!}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.backend.users.fields.roles') }}</th>
                                    <td>
                                        @if($user->getRoleNames()->count() > 0)
                                            <ul>
                                                @foreach ($user->getRoleNames() as $role)
                                                <li>{{ ucwords($role) }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <th>{{ __('labels.backend.users.fields.permissions') }}</th>
                                    <!-- <td>{!! $user->permissions !!}</td> -->
                                    <td>
                                        @if($user->getAllPermissions()->count() > 0)
                                            <ul>
                                                @foreach ($user->getAllPermissions() as $permission)
                                                <li>{{ $permission->name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.created_at') }}</th>
                                    <td>{{ $user->created_at }}<br><small>({{ $user->created_at->diffForHumans() }})</small></td>
                                </tr>

                                <tr>
                                    <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                                    <td>{{ $user->updated_at }}<br/><small>({{ $user->updated_at->diffForHumans() }})</small></td>
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
                    Updated: {{$user->updated_at->diffForHumans()}},
                    Created at: {{$user->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
