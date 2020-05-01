@if(env('FACEBOOK_ACTIVE') || env('GITHUB_ACTIVE'))
<div class="row">
    <div class="col-12">
        Login with social profiles <br>
        @if(env('FACEBOOK_ACTIVE'))
        <a href="{{route('social.login', 'facebook')}}" class="btn btn-neutral btn-facebook btn-round">
            <i class="fab fa-facebook-square"></i>&nbsp; Facebook
        </a>
        @endif

        @if(env('GITHUB_ACTIVE'))
        <a href="{{route('social.login', 'github')}}" class="btn btn-neutral btn-github btn-round">
            <i class="fab fa-github-square"></i>&nbsp; Github
        </a>
        @endif
    </div>
</div>
@endif
