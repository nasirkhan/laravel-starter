@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}}'s Profile @endsection

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="col-span-1">
        <div class="text-center mb-8 md:mb-0">
            <img class="w-48 h-48 object-cover rounded-lg mx-auto -mb-24" src="{{asset($$module_name_singular->avatar)}}" alt="{{$$module_name_singular->name}}" />
            <div class="bg-white shadow-lg rounded-lg px-8 pt-32 pb-10 text-gray-400">
                <h3 class="font-title text-gray-800 text-xl mb-3">
                    {{$$module_name_singular->name}}
                </h3>
                <p>
                    {{$$module_name_singular->address}}
                </p>
                @if($userprofile->url_website)
                <a class="text-blue-800 hover:text-gray-800" target="_blank" href="{{$userprofile->url_website}}">
                    {{$userprofile->url_website}}
                </a>
                @else
                <a class="text-blue-800 hover:text-gray-800" href="{{route('frontend.users.profile', encode_id($$module_name_singular->id))}}">
                    {{route('frontend.users.profile', encode_id($$module_name_singular->id))}}
                </a>
                @endif
                <div class="mt-5 pt-5 flex border-t border-gray-200 w-40 mx-auto text-gray-500 items-center justify-between">

                    @if($userprofile->url_facebook)
                    <a href="{{$userprofile->url_facebook}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg>
                    </a>
                    @endif

                    @if($userprofile->url_twitter)
                    <a href="{{$userprofile->url_twitter}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                        </svg>
                    </a>
                    @endif

                    @if($userprofile->url_instagram)
                    <a href="{{$userprofile->url_instagram}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                        </svg>
                    </a>
                    @endif

                    @if($userprofile->url_linkedin)
                    <a href="{{$userprofile->url_linkedin}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />
                        </svg>
                    </a>
                    @endif
                </div>

                @auth
                @if (auth()->user()->id == $$module_name_singular->id)
                <div class="mt-8">
                    <a href="{{ route("frontend.users.profileEdit", encode_id($$module_name_singular->id)) }}">
                        <div class="w-full text-sm px-6 py-2 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none">
                            Edit
                        </div>
                    </a>
                </div>
                @endif
                @endauth

            </div>
        </div>
    </div>
    <div class="col-span-2">
        <div class="bg-white shadow-lg rounded-lg px-8 md:mt-16 pb-10 text-gray-400">
            {{ $userprofile->bio }}
        </div>
    </div>
</div>


<!-- 
<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    {{$$module_name_singular->name}}
                    @auth
                    @if(auth()->user()->id == $$module_name_singular->id)
                    <small>
                        <a href="{{ route('frontend.users.profileEdit', $$module_name_singular->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    </small>
                    @endif
                    @endauth
                </h1>
                <p class="lead">
                    Username: {{$$module_name_singular->username}}
                </p>
                @if ($$module_name_singular->email_verified_at == null)
                <p class="lead">
                    <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
                </p>
                @endif

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>
<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
            <div class="col-lg-12 mb-5">
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                    <div class="col-md-6 col-lg-4">
                        <img class="img-fluid img-thumbnail" src="{{asset($user->avatar)}}" alt="{{$$module_name_singular->name}}">
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">

                        @if($userprofile->bio)
                        <h5 class="description">
                            {{$userprofile->bio}}
                        </h5>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <?php $fields_array = [
                                        ['name' => 'first_name'],
                                        ['name' => 'last_name'],
                                        // [ 'name' => 'email' ],
                                        // [ 'name' => 'mobile' ],
                                        ['name' => 'username'],
                                        ['name' => 'gender'],
                                        // [ 'name' => 'date_of_birth', 'type' => 'date'],
                                        ['name' => 'url_website', 'type' => 'url'],
                                        // [ 'name' => 'url_facebook', 'type' => 'url' ],
                                        // [ 'name' => 'url_twitter', 'type' => 'url' ],
                                        // [ 'name' => 'url_linkedin', 'type' => 'url' ],
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
                                            {{ $userprofile->$field_name->isoFormat('LL') }}
                                            @else
                                            {{ $userprofile->$field_name->format('jS \\of F') }}
                                            @endif
                                        </td>
                                        @elseif ($field_type == 'date' && $userprofile->$field_name != '')
                                        <td>
                                            {{ $userprofile->$field_name->isoFormat('LL') }}
                                        </td>
                                        @elseif ($field_type == 'datetime' && $userprofile->$field_name != '')
                                        <td>
                                            {{ $userprofile->$field_name->isoFormat('llll') }}
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
            </div>
        </div>

        <div class="row justify-content-sm-center align-items-center py-3 mt-3">
            <div class="col-12 col-lg-8">
                <div class="row">
                    <div class="col-9 col-md-6">
                        <h6 class="font-weight-bolder d-inline mb-0 mr-3">Share:</h6>

                        @php $title_text = $$module_name_singular->name; @endphp

                        <button class="btn btn-sm mr-3 btn-icon-only btn-pill btn-twitter d-inline" data-sharer="twitter" data-via="LaravelStarter" data-title="{{$title_text}}" data-hashtags="LaravelStarter" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter">
                            <span class="btn-inner-icon"><i class="fab fa-twitter"></i></span>
                        </button>

                        <button class="btn btn-sm mr-3 btn-icon-only btn-pill btn-facebook d-inline" data-sharer="facebook" data-hashtag="LaravelStarter" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook">
                            <span class="btn-inner-icon"><i class="fab fa-facebook-f"></i></span>
                        </button>
                    </div>

                    <div class="col-3 col-md-6 text-end"><i class="far fa-bookmark text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Bookmark story"></i></div>
                </div>
            </div>
        </div>
    </div>
</section> -->

@endsection

@push ("after-scripts")
<script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
@endpush