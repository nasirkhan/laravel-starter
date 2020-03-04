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
        <h3 class="title">{{$$module_name_singular->name}} <br>Username:{{$$module_name_singular->username}}</h3>
        <p class="category">
            @if ($$module_name_singular->email_verified_at == null)
            <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
            @endif
        </p>
    </div>
</div>

<div class="section">
    <div class="container">
        <h3 class="title">প্রোফাইল</h3>
        <h5 class="description">
            {{$userprofile->bio}}
        </h5>

        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <?php $fields_array = [
                        [ 'name' => 'first_name' ],
                        [ 'name' => 'last_name' ],
                        // [ 'name' => 'email' ],
                        // [ 'name' => 'mobile' ],
                        [ 'name' => 'gender' ],
                        [ 'name' => 'institute_name' ],
                        [ 'name' => 'class' ],
                        // [ 'name' => 'date_of_birth', 'type' => 'date'],
                        // [ 'name' => 'url_website', 'type' => 'url' ],
                        // [ 'name' => 'url_facebook', 'type' => 'url' ],
                        // [ 'name' => 'url_twitter', 'type' => 'url' ],
                        // [ 'name' => 'url_linkedin', 'type' => 'url' ],
                        // [ 'name' => 'url_1', 'type' => 'url' ],
                        // [ 'name' => 'url_2', 'type' => 'url' ],
                        // [ 'name' => 'url_3', 'type' => 'url' ],
                        // [ 'name' => 'profile_privecy' ],
                        // [ 'name' => 'address' ],
                        // [ 'name' => 'bio' ],
                        // [ 'name' => 'login_count' ],
                        // [ 'name' => 'last_login', 'type' => 'datetime' ],
                        // [ 'name' => 'last_ip' ],
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
