@extends ('backend.layouts.app')

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{!!route('backend.dashboard')!!}"><i class="icon-speedometer"></i> Dashboard</a></li>
<li class="breadcrumb-item"><a href='{!!route("backend.$module_name.index")!!}'><i class="{{ $module_icon }}"></i> {{ $module_title }}</a></li>
<li class="breadcrumb-item active"> Profile</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> Profile
                    <small class="text-muted">{{ __('labels.backend.users.show.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.users.profileEdit", $user->id) }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ str_singular($module_name) }} Profile"><i class="fas fa-wrench"></i> Edit</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>{{ __('labels.backend.users.fields.avatar') }}</th>
                            <td><img src="{{asset($user->avatar)}}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" /></td>
                        </tr>

                        <?php $fields_array = [
                            'name',
                            'email',
                            'mobile',
                            'gender',
                            'date_of_birth',
                            'url_website',
                            'url_facebook',
                            'url_twitter',
                            'url_googleplus',
                            'url_linkedin',
                            'url_1',
                            'url_2',
                            'url_3',
                            'profile_privecy',
                            'address',
                            'bio',
                            'logins_count',
                            'last_login',
                        ]; ?>
                        <?php foreach ($fields_array as $field): ?>
                        <tr>
                            @if (starts_with($field, 'url_'))
                            <th>{{ __('labels.backend.users.fields.'.$field) }}</th>
                            <td><a href="{{ $userprofile->$field }}" target="_blank">{{ $userprofile->$field }}</a></td>
                            @else
                            <th>{{ __('labels.backend.users.fields.'.$field) }}</th>
                            <td>{{ $userprofile->$field }}</td>
                            @endif
                        </tr>
                        <?php endforeach; ?>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.password') }}</th>
                            <td>
                                <a href="{{ route('backend.users.changeProfilePassword', $user->id) }}" class="btn btn-outline-primary btn-sm">Change password</a>
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.social') }}</th>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($user->providers as $provider)
                                    <li>
                                        <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.status') }}</th>
                            <td>{!! $user->status_label !!}</td>
                        </tr>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.confirmed') }}</th>
                            <td>{!! $user->confirmed_label !!}</td>
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
