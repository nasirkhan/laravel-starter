<footer class="py-5 bg-white" id="footer-main">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6">
                <div class="copyright text-center text-xl-left text-muted">
                    &copy; {{ config('app.name') }}, {!! setting('footer_text') !!}
                </div>
            </div>
            <div class="col-xl-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="https://nasirkhn.com" class="nav-link" target="_blank">Nasir Khan</a>
                    </li>
                    <li class="nav-item">
                        <a href="htps://bluecube.com.bd" class="nav-link" target="_blank">Blue Cube</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                    @endif
                    @endguest
                    <li class="nav-item">
                        <a href="#" class="nav-link">License</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
