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
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
