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
                    <a href="{{ route("backend.users.profileEdit", $user->id) }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ Str::singular($module_name) }} Profile"><i class="fas fa-wrench"></i> Edit</a>
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
                            [ 'name' => 'name' ],
                            [ 'name' => 'email' ],
                            [ 'name' => 'mobile' ],
                            [ 'name' => 'gender' ],
                            [ 'name' => 'date_of_birth', 'type' => 'date'],
                            [ 'name' => 'url_website', 'type' => 'url' ],
                            [ 'name' => 'url_facebook', 'type' => 'url' ],
                            [ 'name' => 'url_twitter', 'type' => 'url' ],
                            [ 'name' => 'url_linkedin', 'type' => 'url' ],
                            [ 'name' => 'url_1', 'type' => 'url' ],
                            [ 'name' => 'url_2', 'type' => 'url' ],
                            [ 'name' => 'url_3', 'type' => 'url' ],
                            [ 'name' => 'profile_privecy' ],
                            [ 'name' => 'address' ],
                            [ 'name' => 'bio' ],
                            [ 'name' => 'login_count' ],
                            [ 'name' => 'last_login', 'type' => 'datetime' ],
                            [ 'name' => 'last_ip' ],
                        ]; ?>
                        @foreach ($fields_array as $field)
                            <tr>
                                @php
                                $field_name = $field['name'];
                                $field_type = isset($field['type'])? $field['type'] : '';
                                @endphp

                                <th>{{ __("labels.backend.users.fields.".$field_name) }}</th>

                                @if ($field_name == 'date_of_birth' && $userprofile->$field_name != '')
                                <td>
                                    @if(auth()->user()->id == $userprofile->user_id)
                                    {{ $userprofile->$field_name->toFormattedDateString() }}
                                    @else
                                    {{ $userprofile->$field_name->format('jS \\of F') }}
                                    @endif
                                </td>
                                @elseif ($field_type == 'date' && $userprofile->$field_name != '')
                                <td>
                                    {{ $userprofile->$field_name->toFormattedDateString() }}
                                </td>
                                @elseif ($field_type == 'datetime' && $userprofile->$field_name != '')
                                <td>
                                    {{ $userprofile->$field_name->toDayDateTimeString() }}
                                </td>
                                @elseif ($field_type == 'url')
                                <td>
                                    <a href="{{ $userprofile->$field_name }}" target="_blank">{{ $userprofile->$field_name }}</a>
                                </td>
                                @else
                                <td>{{ $userprofile->$field_name }}</td>
                                @endif
                            </tr>
                        @endforeach

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
                            <td>{{ $user->created_at->toDayDateTimeString() }}<br><small>({{ $user->created_at->diffForHumans() }})</small></td>
                        </tr>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                            <td>{{ $user->updated_at->toDayDateTimeString() }}<br/><small>({{ $user->updated_at->diffForHumans() }})</small></td>
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
