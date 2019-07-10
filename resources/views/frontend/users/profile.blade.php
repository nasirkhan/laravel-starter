@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->name}}'s Profile  | {{ app_name() }}
@stop


@section('content')
<div class="page-header page-header-small clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="container">
        <div class="photo-container">
            <img src="{{asset($user->avatar)}}" alt="{{$$module_name_singular->name}}">
        </div>
        <h3 class="title">{{$$module_name_singular->name}}</h3>
        <p class="category">
            @if ($$module_name_singular->confirmed_at == null)
            <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
            @endif
        </p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="button-container">
            <a href="{{ route('frontend.users.profileEdit', $$module_name_singular->id) }}" class="btn btn-primary btn-round btn-lg">Edit Profile</a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <h3 class="title">About me</h3>
        <h5 class="description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in magna pharetra, varius nisi id, porta augue. Sed lobortis non enim vel cursus. Duis et massa vitae justo cursus finibus. In hac habitasse platea dictumst. Duis laoreet condimentum magna a tincidunt. Nullam in molestie nibh. Fusce lectus ipsum, feugiat non scelerisque bibendum, rutrum id sapien.
        </h5>

        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
