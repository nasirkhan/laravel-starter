@extends ('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('content')
    <x-backend.page-wrapper>
        <x-slot name="breadcrumbs">
            <x-backend.breadcrumbs>
                <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon='{{ $module_icon }}'>
                    {{ __($module_title) }}
                </x-backend.breadcrumb-item>

                <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
            </x-backend.breadcrumbs>
        </x-slot>

        <x-slot name="title">
            <i class="ti ti-layout-dashboard"></i> {{ __('Admin Dashboard') }}
        </x-slot>
        <x-slot name="toolbar">
            <x-backend.buttons.return-back />
            <a class="btn btn-primary m-1" data-bs-toggle="tooltip" href="{{ route('backend.users.index') }}" title="List"><i
                    class="fas fa-list"></i> List</a>
            <a class="btn btn-primary m-1" data-bs-toggle="tooltip" href="{{ route('backend.users.profile', $user->id) }}"
                title="Profile"><i class="fas fa-user"></i>
                Profile</a>
            <x-backend.buttons.edit title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                route='{!! route("backend.$module_name.edit", $$module_name_singular) !!}' />
        </x-slot>

        <div class="row mb-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table-hover table">
                        <tr>
                            <th>{{ __('labels.backend.users.fields.avatar') }}</th>
                            <td><img class="user-profile-image img-fluid img-thumbnail"
                                    src="{{ asset($$module_name_singular->avatar) }}"
                                    style="max-height:200px; max-width:200px;" /></td>
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
                                <a class="btn btn-outline-primary btn-sm"
                                    href="{{ route('backend.users.changePassword', $user->id) }}">Change password</a>
                            </td>
                        </tr>

                        <tr>
                            <th>{{ __('labels.backend.users.fields.social') }}</th>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($user->providers as $provider)
                                        <li>
                                            <i class="fab fa-{{ $provider->provider }}"></i>
                                            {{ label_case($provider->provider) }}
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
                                    <a class="btn btn-primary btn-sm mt-1" data-bs-toggle="tooltip"
                                        href="{{ route('backend.users.emailConfirmationResend', $user->id) }}"
                                        title="Send Confirmation Email"><i class="fas fa-envelope"></i> Send Confirmation
                                        Reminder</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('labels.backend.users.fields.roles') }}</th>
                            <td>
                                @if ($user->getRoleNames()->count() > 0)
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
                                @if ($user->getAllPermissions()->count() > 0)
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
                            <td>{{ $user->updated_at }}<br /><small>({{ $user->updated_at->diffForHumans() }})</small>
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="py-4 text-center">
                    @if ($user->status != 2)
                        <a class="btn btn-danger mt-1" data-method="PATCH" data-token="{{ csrf_token() }}"
                            data-bs-toggle="tooltip" data-confirm="Are you sure?"
                            href="{{ route('backend.users.block', $user) }}" title="{{ __('labels.backend.block') }}"><i
                                class="fas fa-ban"></i> Block</a>
                    @endif
                    @if ($user->status == 2)
                        <a class="btn btn-info mt-1" data-method="PATCH" data-token="{{ csrf_token() }}"
                            data-bs-toggle="tooltip" data-confirm="Are you sure?"
                            href="{{ route('backend.users.unblock', $user) }}"
                            title="{{ __('labels.backend.unblock') }}"><i class="fas fa-check"></i> Unblock</a>
                    @endif
                    <a class="btn btn-danger mt-1" data-method="DELETE" data-token="{{ csrf_token() }}"
                        data-bs-toggle="tooltip" data-confirm="Are you sure?"
                        href="{{ route('backend.users.destroy', $user) }}" title="{{ __('labels.backend.delete') }}"><i
                            class="fas fa-trash-alt"></i> Delete</a>
                    @if ($user->email_verified_at == null)
                        <a class="btn btn-primary mt-1" data-bs-toggle="tooltip"
                            href="{{ route('backend.users.emailConfirmationResend', $user->id) }}"
                            title="Send Confirmation Email"><i class="fas fa-envelope"></i> Email Confirmation</a>
                    @endif
                </div>
            </div>

            <div class="col">
                <h4>
                    User Profile
                </h4>
                <div class="table-responsive">
                    <table class="table-responsive-sm table-hover table-bordered table">
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

        <x-slot name="footer">
            <div class="row">
                <div class="col">
                    <small class="float-end text-muted">
                        Updated: {{ $$module_name_singular->updated_at->diffForHumans() }},
                        Created at: {{ $$module_name_singular->created_at->isoFormat('LLLL') }}
                    </small>
                </div>
            </div>
        </x-slot>
    </x-backend.page-wrapper>
@endsection
