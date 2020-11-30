@if(env('FACEBOOK_ACTIVE') || env('GITHUB_ACTIVE') || env('GOOGLE_ACTIVE'))
<div class="card-header bg-transparent pb-4">
    <div class="text-muted text-center mt-2 mb-4">
        <small>Sign in with social profiles</small>
    </div>

    <div class="text-center">
        @if(env('FACEBOOK_ACTIVE'))
        <a href="{{route('social.login', 'facebook')}}" class="btn btn-neutral btn-icon mb-2">
            <span class="btn-inner--icon"> <i class="fab fa-facebook"></i> </span>
            <span class="btn-inner--text">Facebook</span>
        </a>
        @endif

        @if(env('GITHUB_ACTIVE'))
        <a href="{{route('social.login', 'github')}}" class="btn btn-neutral btn-icon mb-2">
            <span class="btn-inner--icon"><i class="fab fa-github"></i> </span>
            <span class="btn-inner--text">Github</span>
        </a>
        @endif

        @if(env('GOOGLE_ACTIVE'))
        <a href="{{route('social.login', 'google')}}" class="btn btn-neutral btn-icon mb-2">
            <span class="btn-inner--icon"><i class="fab fa-google"></i> </span>
            <span class="btn-inner--text">Google</span>
        </a>
        @endif
    </div>
</div>
@endif
