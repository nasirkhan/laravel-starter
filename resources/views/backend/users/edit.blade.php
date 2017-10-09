@extends ('backend.layouts.app')

@section ('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.users.edit.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.edit.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.edit.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fa fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        <hr>
        <div class="row mt-4 mb-4">
            <div class="col">
                <form action="{{ route('backend.users.update', $user->id) }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="first_name">
                            {{ __('validation.attributes.backend.access.users.first_name') }}
                        </label>

                        <div class="col-md-10">
                            <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.first_name') }}" value="{{ $user->name }}" maxlength="191" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="email">
                            {{ __('validation.attributes.backend.access.users.email') }}
                        </label>

                        <div class="col-md-10">
                            <input type="email" id="email" name="email" class="form-control" placeholder="{{ __('validation.attributes.backend.access.users.email') }}" value="{{ $user->email }}" maxlength="191" required="required">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label class="col-md-2 form-control-label">
                            Abilities
                        </label>

                        <div class="col-md-10">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Roles</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--form-group-->
                    <!-- </div> -->

                    <div class="row">
                        <div class="col">
                            <a href="{{route('backend.users.index')}}" class="btn btn-danger"><i class="fa fa-reply"></i> {{__('labels.buttons.general.cancel')}}</a>

                            <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> {{__('labels.buttons.general.create')}}</button>
                        </div>
                    </div>
                    <!-- /.row -->
                </form>
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
