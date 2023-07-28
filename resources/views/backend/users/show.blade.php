@extends ('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<x-backend.layouts.show :data="$user">

    <x-backend.section-header>
        <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

        <x-slot name="subtitle">
            @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
        </x-slot>
        <x-slot name="toolbar">
            <x-backend.buttons.return-back />
            <a href="{{ route('backend.users.index') }}" class="btn btn-primary m-1" data-toggle="tooltip" title="List"><i class="fas fa-list"></i> List</a>
            <a href="{{ route('backend.users.profile', $user->id) }}" class="btn btn-primary m-1" data-toggle="tooltip" title="Profile"><i class="fas fa-user"></i> Profile</a>
            <x-buttons.edit route='{!!route("backend.$module_name.edit", $$module_name_singular)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" />
        </x-slot>
    </x-backend.section-header>

    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('labels.backend.users.fields.avatar') }}</th>
                        <td><img src="{{asset($$module_name_singular->avatar)}}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" /></td>
                    </tr>

                    <tr>
                        <th>{{ __('labels.backend.users.fields.first_name') }}</th>
                        <td>{{ $user->first_name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('labels.backend.users.fields.last_name') }}</th>
                        <td>{{ $user->last_name }}</td>
                    </tr>

                    <tr>
                        <th>{{ __('labels.backend.users.fields.email') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <th>{{ __('labels.backend.users.fields.mobile') }}</th>
                        <td>{{ $user->mobile }}</td>
                    </tr>

                    <tr>
                        <th>{{ __('labels.backend.users.fields.password') }}</th>
                        <td>
                            <a href="{{ route('backend.users.changePassword', $user->id) }}" class="btn btn-outline-primary btn-sm">Change password</a>
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
                        <td>
                            {!! $user->confirmed_label !!}
                            @if ($user->email_verified_at == null)
                            <a href="{{route('backend.users.emailConfirmationResend', $user->id)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i> Send Confirmation Reminder</a>
                            @endif
                        </td>
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
                        <td>{{ $user->updated_at }}<br /><small>({{ $user->updated_at->diffForHumans() }})</small></td>
                    </tr>

                </table>
            </div>

            <div class="py-4 text-center">
                @if ($user->status != 2)
                <a href="{{route('backend.users.block', $user)}}" class="btn btn-danger mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.block')}}" data-confirm="Are you sure?"><i class="fas fa-ban"></i> Block</a>
                @endif
                @if ($user->status == 2)
                <a href="{{route('backend.users.unblock', $user)}}" class="btn btn-info mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.unblock')}}" data-confirm="Are you sure?"><i class="fas fa-check"></i> Unblock</a>
                @endif
                <a href="{{route('backend.users.destroy', $user)}}" class="btn btn-danger mt-1" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}" data-confirm="Are you sure?"><i class="fas fa-trash-alt"></i> Delete</a>
                @if ($user->email_verified_at == null)
                <a href="{{route('backend.users.emailConfirmationResend', $user->id)}}" class="btn btn-primary mt-1" data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i> Email Confirmation</a>
                @endif
            </div>
        </div>

        <div class="col">
            <h4>
                User Profile
            </h4>
            <div class="table-responsive">
                <table class="table table-responsive-sm table-hover table-bordered">
                    <?php
                    $all_columns = $userprofile->getTableColumns();
                    ?>
                    <thead>
                        <tr>
                            <th scope="col">
                                <strong>
                                    Name
                                </strong>
                            </th>
                            <th scope="col">
                                <strong>
                                    Value
                                </strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_columns as $column)
                        <tr>
                            <td>
                                <strong>
                                    {{ label_case($column->Field) }}
                                </strong>
                            </td>
                            <td>
                                {!! show_column_value($$module_name_singular, $column) !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-backend.layouts.show>
@endsection