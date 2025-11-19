@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <p>
            <i class="fa fa-exclamation-triangle"></i>
            {{ __("Please fix the following errors & try again!") }}
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-frontend.flash-message />

@if (session("status"))
    <p class="alert alert-success">{{ session("status") }}</p>
@endif
