@extends ('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>

    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<x-backend.layouts.show :data="$user">

    <x-backend.section-header>
        <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

        <x-slot name="toolbar">
            <x-backend.buttons.return-back />
            <a href="{{ route('backend.users.index') }}" class="btn btn-primary m-1" data-toggle="tooltip" title="List"><i class="fas fa-list"></i> List</a>
            <x-buttons.edit route='{!!route("backend.$module_name.edit", $$module_name_singular)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" />
        </x-slot>
    </x-backend.section-header>

    <div class="row mb-4">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>{{ __('labels.backend.users.fields.avatar') }}</th>
                        <td><img src="{{asset($$module_name_singular->avatar)}}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" /></td>
                    </tr>

                    @php
                    $fields_array = [
                        ['name' => 'username', 'type' => 'text'],
                        ['name' => 'name', 'type' => 'text'],
                        ['name' => 'email', 'type' => 'text'],
                        ['name' => 'mobile', 'type' => 'text'],
                        ['name' => 'gender', 'type' => 'text'],
                        ['name' => 'date_of_birth', 'type' => 'date'],
                        ['name' => 'address', 'type' => 'text'],
                        ['name' => 'bio', 'type' => 'text'],
                        ['name' => 'last_ip', 'type' => 'text'],
                        ['name' => 'login_count', 'type' => 'text'],
                        ['name' => 'last_login', 'type' => 'datetime'],
                    ]
                    @endphp

                    @foreach ($fields_array as $item)
                    @php
                        $field_name = $item['name'];
                    @endphp
                        <tr>
                            <th>{{ __(label_case($field_name)) }}</th>
                            <td>{{ $user->$field_name }}</td>
                        </tr>
                    @endforeach

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
                        <td>{{ $user->created_at }} by User:{{ $user->created_by }}<br><small>({{ $user->created_at->diffForHumans() }})</small></td>
                    </tr>

                    <tr>
                        <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                        <td>{{ $user->updated_at }} by User:{{ $user->updated_by }}<br /><small>({{ $user->updated_at->diffForHumans() }})</small></td>
                    </tr>

                    <tr>
                        <th>{{ __('Deleted At') }}</th>
                        <td>{{ $user->deleted_at }} by User:{{ $user->deleted_by }}<br /><small>({{ $user->updated_at->diffForHumans() }})</small></td>
                    </tr>
                </table>
            </div>

            <div class="py-4 text-end">
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
    </div>
</x-backend.layouts.show>
@endsection