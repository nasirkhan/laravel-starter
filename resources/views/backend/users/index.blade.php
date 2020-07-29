@extends ('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ $module_title }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> {{ __('labels.backend.users.index.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.index.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>

            <div class="col-4">
                <div class="float-right">
                    <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}"/>
                    
                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <div class="btn-group" role="group">
                            <button id="btnGroupToolbar" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                                <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                    <i class="fas fa-eye-slash"></i> View trash
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>{{ __('labels.backend.users.fields.name') }}</th>
                            <th>{{ __('labels.backend.users.fields.email') }}</th>
                            <th>{{ __('labels.backend.users.fields.status') }}</th>
                            <th>{{ __('labels.backend.users.fields.roles') }}</th>
                            <th>{{ __('labels.backend.users.fields.permissions') }}</th>
                            <th>{{ __('labels.backend.users.fields.social') }}</th>
                            <th>{{ __('labels.backend.users.fields.updated_at') }}</th>
                            <th class="text-right">{{ __('labels.backend.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {!! $user->status_label !!}
                                {!! $user->confirmed_label !!}
                            </td>
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
                                        @foreach ($user->getDirectPermissions() as $permission)
                                        <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($user->providers as $provider)
                                    <li>
                                        <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                            <td class="text-right">
                                <a href="{{route('backend.users.show', $user)}}" class="btn btn-success btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fas fa-desktop"></i></a>
                                <a href="{{route('backend.users.edit', $user)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.edit')}}"><i class="fas fa-wrench"></i></a>
                                <a href="{{route('backend.users.changePassword', $user)}}" class="btn btn-info btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.changePassword')}}"><i class="fas fa-key"></i></a>
                                @if ($user->status != 2)
                                <a href="{{route('backend.users.block', $user)}}" class="btn btn-danger btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.block')}}" data-confirm="Are you sure?"><i class="fas fa-ban"></i></a>
                                @endif
                                @if ($user->status == 2)
                                <a href="{{route('backend.users.unblock', $user)}}" class="btn btn-info btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.unblock')}}" data-confirm="Are you sure?"><i class="fas fa-check"></i></a>
                                @endif
                                <a href="{{route('backend.users.destroy', $user)}}" class="btn btn-danger btn-sm mt-1" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}" data-confirm="Are you sure?"><i class="fas fa-trash-alt"></i></a>
                                @if ($user->email_verified_at == null)
                                <a href="{{route('backend.users.emailConfirmationResend', $user->id)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i></a>
                                @endif
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
