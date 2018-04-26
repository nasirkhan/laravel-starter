<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="/">
                                {{ config('app.name', 'Laravel Starter') }}
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                About Us
                            </a>
                        </li>
                        @guest
                        <li>
                            <a href="{{ route('frontend.auth.login') }}">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.auth.register') }}">
                                Register
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="#">
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.auth.logout') }}">
                                Logout
                            </a>
                        </li>
                        @endguest
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-md-5">
                <div class="copyright float-right">
                    &copy;
                    <script> document.write(new Date().getFullYear()) </script> {{ config('app.name', 'Laravel Starter') }}, Developed by
                    <a href="https://nasirkhn.com" target="_blank">Nasir Khan Saikat</a>
                </div></div>
            </div>
        </div>
    </footer>
