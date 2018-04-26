@extends ('backend.layouts.app')

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="icon-people"></i> {{ __('labels.backend.users.index.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.show.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i></button>
                    <a href="{{route('backend.users.edit', $user)}}" class="btn btn-primary ml-1"><i class="fas fa-pencil-alt" data-toggle="tooltip" title="{{__('labels.backend.edit')}}"></i></a>
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
                                    <th>{{ __('labels.backend.users.fields.avatar') }}</th>
                                    <td><img src="{{ asset('photos/avatars/'.$user->avatar) }}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" /></td>
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
                                    <th>{{ __('labels.backend.users.fields.social') }}</th>
                                    <td>
                                        <ul class="list-group">
                                            @foreach ($user->providers as $provider)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col">

                                                        <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                                                    </div>
                                                    <div class="col">
                                                        <div class="float-right">
                                                            {{ html()->form('DELETE', route('backend.users.userProviderDestroy'))->class('form-inline')->open() }}

                                                            {{ html()->hidden('user_provider_id')->value($provider->id) }}
                                                            {{ html()->hidden('user_id')->value($user->id) }}

                                                            {{ html()->submit($text = '<i class="fas fa-unlink"></i> <span class="d-none d-md-inline ">Unlink ' . label_case($provider->provider) . '</span>', $type = 'button')->attributes(['class' => "btn btn-outline-danger btn-sm"]) }}

                                                            {{ html()->form()->close() }}
                                                        </div>

                                                    </div>
                                                </div>

                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
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
